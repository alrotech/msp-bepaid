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

BePaidPayment.combo.Language = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['caption','key'],
            data: [
                [_('ms2_payment_bepaid_lang_english'), 'en'],
                [_('ms2_payment_bepaid_lang_spanish'), 'es'],
                [_('ms2_payment_bepaid_lang_turkish'), 'tr'],
                [_('ms2_payment_bepaid_lang_german'), 'de'],
                [_('ms2_payment_bepaid_lang_italian'), 'it'],
                [_('ms2_payment_bepaid_lang_russian'), 'ru'],
                [_('ms2_payment_bepaid_lang_chinese'), 'zh'],
                [_('ms2_payment_bepaid_lang_french'), 'fr'],
                [_('ms2_payment_bepaid_lang_danish'), 'da'],
                [_('ms2_payment_bepaid_lang_swedish'), 'sv'],
                [_('ms2_payment_bepaid_lang_norwegian'), 'no'],
                [_('ms2_payment_bepaid_lang_finnish'), 'fi']
            ]
        }),
        name: 'language',
        hiddenName: 'language',
        displayField: 'caption',
        valueField: 'key',
        mode: 'local',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true
    });

    BePaidPayment.combo.Language.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Language, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-language', BePaidPayment.combo.Language);
