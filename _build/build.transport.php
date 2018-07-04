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
define('PKG_VERSION', '2.5.0');
define('PKG_RELEASE', 'pl');

require_once __DIR__ . '/xpdo/xpdo/xpdo.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdotransport.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdovehicle.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdofilevehicle.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdoscriptvehicle.class.php';
require_once __DIR__ . '/xpdo/xpdo/transport/xpdoobjectvehicle.class.php';

require_once __DIR__ . '/helpers/ArrayXMLConverter.php';
require_once __DIR__ . '/implants/encryptedvehicle.class.php';

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

class modNamespace extends xPDOObject {}
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
    'implants' => $root . '_build/implants/',
    'plugins' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'assets' => [
        'components/mspbepaid/'
    ],
    'core' => [
        'components/mspbepaid/',
        'components/minishop2/lexicon/en/msp.bepaid.inc.php',
        'components/minishop2/lexicon/ru/msp.bepaid.inc.php'
    ],
];

$signature = join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE]);
$directory = $root . '_packages/';
//$directory = __DIR__ . '/../../../core/packages/';
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

$credentials = file_get_contents(__DIR__ . '/../.encryption');
list($username, $key) = explode(':', $credentials);

if (empty($username) || empty($key)) {
    $xpdo->log(xPDO::LOG_LEVEL_ERROR, "Credentials not found.");
    exit;
}

$params = [
    'api_key' => $key,
    'username' => $username,
    'http_host' => 'anysite.docker',
    'package' => PKG_NAME,
    'version' => PKG_VERSION . '-' . PKG_RELEASE,
    'vehicle_version' => '2.0.0'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://modstore.pro/extras/package/encode');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/xml']);
curl_setopt($ch, CURLOPT_POSTFIELDS, ArrayXMLConverter::toXML($params,'request'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = trim(curl_exec($ch));
curl_close($ch);

$answer = ArrayXMLConverter::toArray($result);

if (isset($answer['message'])) {
    $xpdo->log(xPDO::LOG_LEVEL_ERROR, $answer['message']);
    echo $answer['message'];
    exit;
}

define('PKG_ENCODE_KEY', $answer['key']);

$package = new xPDOTransport($xpdo, $signature, $directory);

// insert class EncryptedVehicle
$package->put(new xPDOFileVehicle, [
    'vehicle_class' => 'xPDOFileVehicle',
    'object' => [
        'source' => $sources['implants'] . 'encryptedvehicle.class.php',
        'target' => "return MODX_CORE_PATH . 'components/" . PKG_NAME_LOWER . "/';"
    ]
]);

// load class EncryptedVehicle
$package->put(new xPDOScriptVehicle, [
    'vehicle_class' => 'xPDOScriptVehicle',
    'object' => [
        'source' => $sources['resolvers'] . 'resolve.encryption.php'
    ]
]);

$namespace = new modNamespace($xpdo);
$namespace->fromArray([
    'id' => PKG_NAME_LOWER,
    'name' => PKG_NAME_LOWER,
    'path' => '{core_path}components/' . PKG_NAME_LOWER . '/',
]);

$package->put($namespace, [
    'vehicle_class' => EncryptedVehicle::class,
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::NATIVE_KEY => PKG_NAME_LOWER,
    'namespace' => PKG_NAME_LOWER
]);

$settings = include $sources['data'] . 'transport.settings.php';
foreach ($settings as $setting) {
    $package->put($setting, [
        'vehicle_class' => EncryptedVehicle::class,
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => true,
        'class' => 'modSystemSetting',
        'namespace' => PKG_NAME_LOWER
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
    ['type' => 'php', 'source' => $sources['resolvers'] . 'resolve.settings.php'],
    ['type' => 'php', 'source' => $sources['resolvers'] . 'resolve.service.php']
);

// creating payment
$payment = new msPayment($xpdo);
$payment->fromArray([
    'id' => null,
    'name' => 'BePaid',
    'description' => null,
    'price' => 0,
    'logo' => null,
    'rank' => 0,
    'active' => 0,
    'class' => 'BePaid',
    'properties' => null
]);

$package->put($payment, [
    'vehicle_class' => EncryptedVehicle::class,
    xPDOTransport::UNIQUE_KEY => 'class',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => false,
    'resolve' => null,
    'validate' => null,
    'package' => 'minishop2'
]);

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
    'vehicle_class' => EncryptedVehicle::class,
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::ABORT_INSTALL_ON_VEHICLE_FAIL => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Plugins' => [
            xPDOTransport::UNIQUE_KEY => 'name',
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNINSTALL_OBJECT => true,
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
                'PluginEvents' => [
                    xPDOTransport::UNIQUE_KEY => ['pluginid', 'event'],
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNINSTALL_OBJECT => true,
                    xPDOTransport::RELATED_OBJECTS => false
                ]
            ]
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

if ($package->pack()) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Package built");
}
