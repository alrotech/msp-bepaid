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
require dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

$miniShop2 = $modx->getService('minishop2');
$miniShop2->loadCustomClasses('payment');

if (!class_exists('bePaid')) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load payment class "bePaid"', '', '', __FILE__, __LINE__);

    exit('Error: could not load payment class "bePaid".');
}

$handler = new BePaid($modx->newObject('msOrder'));


// TODO: переписать на новые обработчики, валидные для bepaid
switch ($_GET['action']) {
    //case 'decline':
    case 'notify':
        if (empty($_POST['site_order_id'])) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[miniShop2:bePaid] Returned empty order id.');
        }
        if ($order = $modx->getObject('msOrder', $_POST['site_order_id'])) {
            $_POST['action'] = $_GET['action'];
            $handler->receive($order, $_POST);
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR, '[miniShop2:bePaid] Could not retrieve order with id ' . $_POST['site_order_id']);
        }
        break;
    case 'success':
    case 'cancel':
        if (empty($_REQUEST['wsb_order_num'])) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[miniShop2:bePaid] Returned empty order id.');
        }
        if ($order = $modx->getObject('msOrder', $_REQUEST['wsb_order_num'])) {
            $handler->receive($order, $_REQUEST);
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR, '[miniShop2:bePaid] Could not retrieve order with id ' . $_REQUEST['wsb_order_num']);
        }
        break;
}

$success = $cancel = $modx->getOption('site_url');

if ($id = $modx->getOption('ms2_payment_bepaid_success_id', null, 0)) {
    $success = $modx->makeUrl($id, '', [], 'full');
}
if ($id = $modx->getOption('ms2_payment_bepaid_cancel_id', null, 0)) {
    $cancel = $modx->makeUrl($id, '', [], 'full');
}

$redirect = !empty($_REQUEST['action']) && ($_REQUEST['action'] == 'success') ? $success : $cancel;

$modx->sendRedirect($redirect);
