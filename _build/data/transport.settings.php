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
 * System settings for package
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package mspbepaid
 * @subpackage build
 */

$list = [
    'store_id' => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    'secret_key' => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    'checkout_url' => [
        'xtype' => 'textfield',
        'value' => 'https://checkout.bepaid.by/ctp/api/checkouts'
    ],
    'language' => [
        'xtype' => 'bepaid-combo-language',
        'value' => 'ru'
    ],
    'country' => [
        'xtype' => 'bepaid-combo-country',
        'value' => 'by'
    ],
    'readonly_fields' => [
//        'xtype' => 'bepaid-combo-readonly',
        'xtype' => 'textfield',
        'value' => 'email'
    ],
    'hidden_fields' => [
//        'xtype' => 'bepaid-combo-hidden',
        'xtype' => 'textfield',
        'value' => ''
    ],
    'currency' => [
        'xtype' => 'textfield',
        'value' => 'BYN'
    ],
    'test_mode' => [
        'xtype' => 'combo-boolean',
        'value' => true
    ],
    'success_status' => [
        'xtype' => 'bepaid-combo-status',
        'value' => 2
    ],
    'failure_status' => [
        'xtype' => 'bepaid-combo-status',
        'value' => 4
    ],
    'success_page' => [
        'xtype' => 'bepaid-combo-resource',
        'value' => 0
    ],
    'failure_page' => [
        'xtype' => 'bepaid-combo-resource',
        'value' => 0
    ],
    'api_version' => [
        'xtype' => 'textfield',
        'value' => 2
    ]
];

$settings = [];
foreach ($list as $k => $v) {
    $setting = new modSystemSetting($xpdo);
    $setting->fromArray(array_merge([
        'key' => 'ms2_payment_bepaid_' . $k,
        'namespace' => 'minishop2',
        'area' => 'ms2_payment_bepaid',
        'editedon' => null,
    ], $v), '', true, true);

    $settings[] = $setting;
}

return $settings;
