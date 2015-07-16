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
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

$exists = false;
$output = null;

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $exists = $modx->getCount('modSystemSetting', array('key:LIKE' => '%_bepaid_%'));
        break;

    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

if (!$exists) {
    if ($modx->getOption('manager_language') == 'ru') {
        $text = '
            Для полноценной работы оплаты bePaid необходимо заполнить параметры, выданные вам после заключения договора.
            <label for="bepaid-store-id">Идентификатор магазина:</label>
            <input type="text" name="bepaid-store-id" id="bepaid-store-id" width="300" value="" />

            <label for="bepaid-login">Логин в системе bePaid:</label>
            <input type="text" name="bepaid-login" id="bepaid-login" width="300" value="" />

            <label for="bepaid-password">Пароль в системе bePaid:</label>
            <input type="text" name="bepaid-password" id="bepaid-password" width="300" value="" />

            <label for="bepaid-secret-key">Секретный ключ:</label>
            <input type="text" name="bepaid-secret-key" id="bepaid-secret-key" width="300" value="" />

			<small>Вы можете пропустить этот шаг и заполнить эти поля позже в системных настройках.</small>';
    } else {
        $text = '
            To complete the work necessary to complete the payment bePaid options given to you after the conclusion of the contract.
            <label for="bepaid-store-id">Store ID:</label>
            <input type="text" name="bepaid-store-id" id="bepaid-store-id" width="300" value="" />

            <label for="bepaid-login">Login in WebPay System:</label>
            <input type="text" name="bepaid-login" id="bepaid-login" width="300" value="" />

            <label for="bepaid-password">Password in WebPay System:</label>
            <input type="text" name="bepaid-password" id="bepaid-password" width="300" value="" />

            <label for="bepaid-secret-key">Secret Key:</label>
            <input type="text" name="bepaid-secret-key" id="bepaid-secret-key" width="300" value="" />

			<small>You can skip this step and complete these fields later in the system settings.</small>';
    }

    $output = '
		<style>
			#setup_form_wrapper {font: normal 12px Arial;line-height:18px;}
			#setup_form_wrapper ul {margin-left: 5px; font-size: 10px; list-style: disc inside;}
			#setup_form_wrapper a {color: #08C;}
			#setup_form_wrapper small {font-size: 10px; color:#555; font-style:italic;}
			#setup_form_wrapper label {color: black; font-weight: bold;}
		</style>
		<div id="setup_form_wrapper">' . $text . '</div>
	';
}

return $output;
