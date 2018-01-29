<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config.core.php';
// todo remove two dirname because on prod it won't work because symlink issue on local env
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->lexicon->load('mspbepaid:default');
$modx->request->handleRequest(['processors_path' => MODX_CORE_PATH . 'components/mspbepaid/processors/', 'location' => '']);
