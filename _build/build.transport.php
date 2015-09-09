<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Ivan Klimchuk <ivan@klimchuk.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * mspBePaid package builder
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

set_time_limit(0);

require_once 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources = [
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'docs' => $root . 'docs/',
    'resolvers' => $root . '_build/resolvers/',
    'assets' => [
        'components/minishop2/payment/bepaid.php'
    ],
    'core' => [
        'components/minishop2/custom/payment/bepaid/',
        'components/minishop2/custom/payment/bepaid.class.php',
        'components/minishop2/lexicon/en/msp.bepaid.inc.php',
        'components/minishop2/lexicon/ru/msp.bepaid.inc.php',
    ],
];

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget();

$modx->loadClass('transport.xPDOTransport', XPDO_CORE_PATH, true, true);

$signature = join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE]);
$directory = MODX_CORE_PATH . 'packages/';
$filename = $directory . $signature . '.transport.zip';

/* remove the package if it's already been made */
if (file_exists($filename)) {
    unlink($filename);
}
if (file_exists($directory . $signature) && is_dir($directory . $signature)) {
    $cacheManager = $modx->getCacheManager();
    if ($cacheManager) {
        $cacheManager->deleteTree($directory . $signature, true, false, []);
    }
}

$package = new xPDOTransport($modx, $signature, $directory);

$modx->loadClass('transport.xPDOTransportVehicle', XPDO_CORE_PATH, true, true);

/* load system settings */
if (defined('BUILD_SETTING_UPDATE')) {
    $settings = include $sources['data'] . 'transport.settings.php';
    if (!is_array($settings)) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in settings.');
    } else {
        foreach ($settings as $setting) {
            $package->put($setting, [
                xPDOTransport::UNIQUE_KEY => 'key',
                xPDOTransport::PRESERVE_KEYS => true,
                xPDOTransport::UPDATE_OBJECT => BUILD_SETTING_UPDATE,
                'class' => 'modSystemSetting',
            ]);
        }
    }
}

$resolvers = [];
foreach ($sources['assets'] as $file) {
    $directory = dirname($file);
    array_push($resolvers, [
        'type' => 'file',
        'source' => $root . 'assets/' . $file,
        'target' => "return MODX_ASSETS_PATH . '$directory/';",
    ]);
}
foreach ($sources['core'] as $file) {
    $directory = dirname($file);
    array_push($resolvers, [
        'type' => 'file',
        'source' => $root . 'core/' . $file,
        'target' => "return MODX_CORE_PATH . '$directory/';"
    ]);
}
array_push($resolvers, [
    'type' => 'php',
    'source' => $sources['resolvers'] . 'resolve.settings.php'
]);

$payment = $modx->newObject('msPayment', [
    'name' => 'BePaid',
    'class' => 'BePaid',
    'active' => 0,
]);

$package->put($payment, [
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => false,
    'resolve' => $resolvers
]);

$package->setAttribute('changelog', file_get_contents($sources['docs'] . 'changelog.txt'));
$package->setAttribute('license', file_get_contents($sources['docs'] . 'license.txt'));
$package->setAttribute('readme', file_get_contents($sources['docs'] . 'readme.txt'));
$package->setAttribute('setup-options', [
    'source' => $sources['build'] . 'setup.options.php'
]);

if ($package->pack()) {
    $modx->log(modX::LOG_LEVEL_INFO, "Package built");
}

if (defined('PKG_AUTO_INSTALL') && PKG_AUTO_INSTALL) {
    if ($package->install()) {
        $modx->log(modX::LOG_LEVEL_INFO, "Package $package->signature successfully installed");
    } else {
        $modx->log(modX::LOG_LEVEL_ERROR, "Could not install package $package->signature");
    }
}
