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

ini_set('date.timezone', 'Europe/Minsk');

define('PKG_NAME', 'mspBePaid');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION', '2.3.0');
define('PKG_RELEASE', 'pl');

require_once __DIR__ . '/xpdo/xpdo/xpdo.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdotransport.class.php';

$xpdo = xPDO::getInstance('db', [
    xPDO::OPT_CACHE_PATH => __DIR__ . '/../cache/',
    xPDO::OPT_HYDRATE_FIELDS => true,
    xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
    xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
    xPDO::OPT_CONNECTIONS => [
        [
            'dsn' => 'mysql:host=localhost;dbname=xpdotest;charset=utf8',
            'username' => 'test',
            'password' => 'test',
            'options' => [xPDO::OPT_CONN_MUTABLE => true],
            'driverOptions' => [],
        ]
    ]
]);

$xpdo->setLogLevel(xPDO::LOG_LEVEL_FATAL);
$xpdo->setLogTarget();

class modCategory extends xPDOObject {
    public function getFKDefinition($alias)
    {
        $aggregates = [
            'Plugins' => [
                'class' => 'modPlugin',
                'local' => 'id',
                'foreign' => 'category',
                'cardinality' => 'many',
                'owner' => 'local',
            ]
        ];

        return isset($aggregates[$alias]) ? $aggregates[$alias] : [];
    }
}
class modPlugin extends xPDOObject {
    public function getFKDefinition($alias)
    {
        $aggregates = [
            'PluginEvents' => [
                'class' => 'modPluginEvent',
                'local' => 'id',
                'foreign' => 'pluginid',
                'cardinality' => 'one',
                'owner' => 'local',
            ]
        ];

        return isset($aggregates[$alias]) ? $aggregates[$alias] : [];
    }
}
class modPluginEvent extends xPDOObject {}
class modSystemSetting extends xPDOObject {}
class msPayment extends xPDOObject {}

$root = dirname(dirname(__FILE__)) . '/';
$sources = [
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'docs' => $root . 'docs/',
    'resolvers' => $root . '_build/resolvers/',
    'validators' => $root . '_build/validators/',
    'plugins' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'assets' => [
        'components/mspbepaid/',
        'components/minishop2/payment/bepaid.php'
    ],
    'core' => [
        'components/mspbepaid/',
        'components/minishop2/custom/payment/bepaid.class.php',
        'components/minishop2/custom/payment/bepaiderip.class.php',
        'components/minishop2/custom/payment/bepaidhalva.class.php',
        'components/minishop2/lexicon/en/msp.bepaid.inc.php',
        'components/minishop2/lexicon/ru/msp.bepaid.inc.php',
        'components/minishop2/lexicon/be/msp.bepaid.inc.php',
    ],
];

$signature = join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE]);
//$directory = $root . '_packages/';
$directory = __DIR__ . '/../../../core/packages/'; // local place
$filename = $directory . $signature . '.transport.zip';

/* remove the package if it's already been made */
if (file_exists($filename)) {
    unlink($filename);
}
if (file_exists($directory . $signature) && is_dir($directory . $signature)) {
    $cacheManager = $xpdo->getCacheManager();
    if ($cacheManager) {
        $cacheManager->deleteTree($directory . $signature, true, false, []);
    }
}

$package = new xPDOTransport($xpdo, $signature, $directory);

$settings = include $sources['data'] . 'transport.settings.php';
foreach ($settings as $setting) {
    $package->put($setting, [
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => true,
        'class' => 'modSystemSetting',
        'resolve' => null,
        'validate' => null,
        'package' => 'modx',
    ]);
}

$validators = [];
array_push($validators,
    ['type' => 'php', 'source' => $sources['validators'] . 'validate.phpversion.php'],
    ['type' => 'php', 'source' => $sources['validators'] . 'validate.modxversion.php'],
    ['type' => 'php', 'source' => $sources['validators'] . 'validate.bcmath.php']
);

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

array_push($resolvers,
    ['type' => 'php', 'source' => $sources['resolvers'] . 'resolve.settings.php']
);

foreach (['Default', 'ERIP', 'Halva'] as $type) {
    $name = $class = 'BePaid';

    if ($type !== 'Default') {
        $name = 'BePaid – ' . $type;
        $class = join('', ['BePaid', ucfirst(strtolower($type))]);
    }

    $payment = new msPayment($xpdo);
    $payment->fromArray([
        'id' => null,
        'name' => $name,
        'description' => null,
        'price' => 0,
        'logo' => null,
        'rank' => 0,
        'active' => 0,
        'class' => $class,
        'properties' => null
    ]);
    $package->put($payment, [
        xPDOTransport::UNIQUE_KEY => 'class',
        xPDOTransport::PRESERVE_KEYS => false,
        xPDOTransport::UPDATE_OBJECT => false,
        'resolve' => null,
        'validate' => null,
        'package' => 'minishop2'
    ]);
}

$category = new modCategory($xpdo);
$category->fromArray([
    'id' => 1,
    'category' => PKG_NAME,
    'parent' => 0,
]);

$plugins = include $sources['data'] . 'transport.plugins.php';
if (is_array($plugins)) {
    $category->addMany($plugins, 'Plugins');
}

$package->put($category, [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::ABORT_INSTALL_ON_VEHICLE_FAIL => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Plugins' => [
            xPDOTransport::UNIQUE_KEY => 'name',
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::RELATED_OBJECTS => true
        ],
        'PluginEvents' => [
            xPDOTransport::UNIQUE_KEY => ['pluginid', 'event'],
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::RELATED_OBJECTS => true
        ]
    ],
    xPDOTransport::NATIVE_KEY => true,
    'package' => 'modx',
    'resolve' => $resolvers,
    'validate' => $validators
]);

$package->setAttribute('changelog', file_get_contents($sources['docs'] . 'changelog.txt'));
$package->setAttribute('license', file_get_contents($sources['docs'] . 'license.txt'));
$package->setAttribute('readme', file_get_contents($sources['docs'] . 'readme.txt'));
$package->setAttribute('requires', [
    'php' => '>=5.5',
    'modx' => '>=2.4',
    'miniShop2' => '>=2.4'
]);
$package->setAttribute('setup-options', ['source' => $sources['build'] . 'setup.options.php']);

if ($package->pack()) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Package built");
}
