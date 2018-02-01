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

define('MODX_API_MODE', true);

require_once __DIR__ . '/../../../index.php';

$modx->initialize('mgr');

$modx->setLogLevel(xPDO::LOG_LEVEL_ERROR);
$modx->setLogTarget();

$answer = $modx->runProcessor('workspace/packages/install',
    ['signature' => 'mspbepaid-2.3.0-pl']
);

$response = $answer->getResponse();

echo $response['message'], PHP_EOL;

echo 'Need set system settings for work...', PHP_EOL;

// Shop without 3-D Secure
$id = 361;
$sc = 'b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d';

// Shop with 3-D Secure
//$id = 362;
//$sc = '9ad8ad735945919845b9a1996af72d886ab43d3375502256dbf8dd16bca59a4e';

$sid = $modx->getObject('modSystemSetting', 'ms2_payment_bepaid_store_id');
$sid->set('value', $id);
$sid->save();

$ssc = $modx->getObject('modSystemSetting', 'ms2_payment_bepaid_secret_key');
$ssc->set('value', $sc);
$ssc->save();

$modx->getCacheManager()->refresh(['system_settings' => []]);
$modx->reloadConfig();
