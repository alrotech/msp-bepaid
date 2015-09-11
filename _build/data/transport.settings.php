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

$settings = array();

$tmp = array(
    'store_id' => array(
        'xtype' => 'textfield',
        'value' => '361',
        'area' => 'ms2_payment_bepaid'
    ),
    'secret_key' => array(
        'xtype' => 'textfield',
        'value' => 'b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d',
        'area' => 'ms2_payment_bepaid'
    ),
    'login' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ms2_payment_bepaid'
    ),
    'password' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ms2_payment_bepaid'
    ),
    'checkout_url' => array(
        'xtype' => 'textfield',
        'value' => 'https://checkout.bepaid.by',
        'area' => 'ms2_payment_bepaid'
    ),
    'gate_url' => array(
        'xtype' => 'textfield',
        'value' => 'https://gateway.bepaid.by',
        'area' => 'ms2_payment_bepaid'
    ),
    'version' => array(
        'xtype' => 'numberfield',
        'value' => 2,
        'area' => 'ms2_payment_bepaid'
    ),
    'developer_mode' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'ms2_payment_bepaid'
    ),
    'language' => array(
        'xtype' => 'textfield',
        'value' => 'russian',
        'area' => 'ms2_payment_bepaid'
    ),
    'currency' => array(
        'xtype' => 'textfield',
        'value' => 'BYR',
        'area' => 'ms2_payment_bepaid'
    ),
    'success_id' => array(
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'ms2_payment_bepaid'
    ),
    'failure_id' => array(
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'ms2_payment_bepaid'
    ),
);

class modSystemSetting extends xPDOObject {}

foreach ($tmp as $k => $v) {
    $setting = new modSystemSetting($xpdo);
    $setting->fromArray(array_merge(
        array(
            'key' => 'ms2_payment_bepaid_' . $k,
            'namespace' => 'minishop2',
            'area' => 'ms2_payment',
            'editedon' => null,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}

return $settings;
