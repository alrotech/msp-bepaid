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

interface msPaymentInterface {};
class msPaymentHandler {};
require_once dirname(dirname(dirname(__FILE__))) . '/core/components/mspbepaid/bepaid.class.php';

/**
 * System settings for package
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

$list = [
    BePaid::OPTION_STORE_ID => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    BePaid::OPTION_SECRET_KEY => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    BePaid::OPTION_CHECKOUT_URL => [
        'xtype' => 'textfield',
        'value' => 'https://checkout.bepaid.by/ctp/api/checkouts'
    ],
    BePaid::OPTION_LANGUAGE => [
        'xtype' => 'bepaid-combo-language',
        'value' => 'ru'
    ],
    BePaid::OPTION_COUNTRY => [
        'xtype' => 'bepaid-combo-country',
        'value' => 'by'
    ],
    BePaid::OPTION_READONLY_FIELDS => [
//        'xtype' => 'bepaid-combo-readonly',
        'xtype' => 'textfield',
        'value' => 'email'
    ],
    BePaid::OPTION_VISIBLE_FIELDS => [
//        'xtype' => 'bepaid-combo-visible',
        'xtype' => 'textfield',
        'value' => ''
    ],
    BePaid::OPTION_CURRENCY => [
        'xtype' => 'textfield',
        'value' => 'BYN'
    ],
    BePaid::OPTION_TEST_MODE => [
        'xtype' => 'combo-boolean',
        'value' => true
    ],
    BePaid::OPTION_SUCCESS_STATUS => [
        'xtype' => 'bepaid-combo-status',
        'value' => 2
    ],
    BePaid::OPTION_FAILURE_STATUS => [
        'xtype' => 'bepaid-combo-status',
        'value' => 4
    ],
    BePaid::OPTION_SUCCESS_PAGE => [
        'xtype' => 'bepaid-combo-resource',
        'value' => 0
    ],
    BePaid::OPTION_FAILURE_PAGE => [
        'xtype' => 'bepaid-combo-resource',
        'value' => 0
    ],
    BePaid::OPTION_API_VERSION => [
        'xtype' => 'textfield',
        'value' => '2.1'
    ],
    BePaid::OPTION_PAYMENT_TYPES => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    BePaid::OPTION_ERIP_SERVICE_ID => [
        'xtype' => 'textfield',
        'value' => '99999999'
    ]
];

$settings = [];
foreach ($list as $k => $v) {
    $setting = new modSystemSetting($xpdo);
    $setting->fromArray(array_merge([
        'key' => BePaid::PREFIX . '_' . $k,
        'namespace' => 'minishop2',
        'area' => BePaid::PREFIX,
        'editedon' => null,
    ], $v), '', true, true);

    $settings[] = $setting;
}

return $settings;
