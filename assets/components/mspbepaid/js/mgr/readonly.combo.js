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

BePaidPayment.combo.ReadOnly = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        xtype: 'superboxselect',
        allowBlank: true,
        allowAddNewData: false,
        forceFormValue: false,
        resizable: true,
        name: 'value',
        anchor: '100%',
        minChars: 1,
        mode: 'local',
        store: new Ext.data.SimpleStore({
            fields: ['value'],
            data: [
                ['email'],
                ['first_name'],
                ['last_name'],
                ['address'],
                ['city'],
                ['state'],
                ['zip'],
                ['phone'],
                ['country']
            ]
        }),
        hiddenName: 'value',
        displayField: 'value',
        valueField: 'value',
        triggerAction: 'all',
        extraItemCls: 'x-tag',
        expandBtnCls: 'x-form-trigger',
        clearBtnCls: 'x-form-trigger'
    });

    BePaidPayment.combo.ReadOnly.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.ReadOnly, Ext.ux.form.SuperBoxSelect, {

    getValue: function () {

        console.log('test', this);

        var ret = [];
        this.items.each(function(item){
            ret.push(item.value);
        });

        return ret.join(this.valueDelimiter);
    }

});
Ext.reg('bepaid-combo-readonly', BePaidPayment.combo.ReadOnly);
