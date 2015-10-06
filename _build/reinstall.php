<?php

define('MODX_API_MODE', true);

require_once __DIR__ . '/../../../index.php';

$modx->initialize('mgr');

$modx->setLogLevel(xPDO::LOG_LEVEL_FATAL);
$modx->setLogTarget();

$modx->runProcessor('workspace/packages/install',
    ['signature' => 'mspbepaid-1.0.8-beta']
);
