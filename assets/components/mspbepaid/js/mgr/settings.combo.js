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

BePaidPayment.combo.Settings = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'key',
        hiddenName: 'key',
        displayField: 'name_trans',
        valueField: 'key',
        fields: ['key', 'value', 'name_trans', 'xtype'],
        pageSize: 20,
        typeAhead: false,
        preselectValue: false,
        allowBlank: true,
        emptyText: _('ms2_payment_bepaid_select_setting'),
        editable: false,
        hideMode: 'offsets',
        url: MODx.config.connector_url,
        baseParams: {
            action: 'system/settings/getList',
            namespace: 'minishop2',
            area: 'ms2_payment_bepaid'
        }
    });

    BePaidPayment.combo.Settings.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Settings, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-settings', BePaidPayment.combo.Settings);
