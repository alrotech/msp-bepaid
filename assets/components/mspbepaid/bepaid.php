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
require dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

$miniShop2 = $modx->getService('minishop2');
$miniShop2->loadCustomClasses('payment');

if (!class_exists('bePaid')) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[ms2::payment::bePaid] Could not load payment class "bePaid"', '', '', __FILE__, __LINE__);

    die('[ms2::payment::bePaid] Could not load payment class "bePaid".');
}

$orderId = intval($_GET['order']);
$order = $modx->getObject('msOrder', $orderId);

if (!$order || !$order instanceof msOrder) {
    BePaid::fail("Order with id '$orderId' not found. Exit.");
}

$handler = new BePaid($order);

switch ($_GET['action']) {
    case 'notify':
        $handler->notify($order);
        break;
    case 'cancel':
        $handler->log("Payment of order ($orderId) was canceled by user.");
        break;
    case 'fail':
    case 'decline':
    case 'success':
        $missed = [];
        foreach (['uid', 'token', 'status'] as $param) {
            if (empty($_GET[$param])) {
                $missed[] = $param;
            }
        }
        if (count($missed)) {
            $handler::fail(
                sprintf(
                    'Invalid response. Should contain uid, token and status parameters in GET request query. Following parameters are missed: %s',
                    implode(', ', $missed)
                )
            );
        }

        $handler->process($order, $_GET['token'], $_GET['uid'], $_GET['status']);

        break;
}

$success = $cancel = $modx->getOption('site_url'); // todo - возвращать на страницу корзины по умолчанию

if ($page = $handler->config[BePaid::OPTION_SUCCESS_PAGE]) {
    $success = $modx->makeUrl($page, '', ['msorder' => $orderId], 'full');
}

if ($page = $handler->config[BePaid::OPTION_FAILURE_PAGE]) {
    $cancel = $modx->makeUrl($page, '', ['msorder' => $orderId], 'full');
}

$redirect = !empty($_REQUEST['action']) && ($_REQUEST['action'] === 'success') ? $success : $cancel;

$modx->sendRedirect($redirect);
