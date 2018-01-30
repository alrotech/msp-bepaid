/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2018 Ivan Klimchuk <ivan@klimchuk.com>
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

BePaidPayment.window.PaymentProperty = function (config) {
    config = config || { new: false };

    if (!config.id) {
        config.id = 'bepaid-window-payment-property'
    }

    Ext.applyIf(config, {
        url: BePaidPayment.ownConnector,
        layout: 'anchor',
        cls: 'modx-window',
        modal: true,
        width: 400,
        autoHeight: true,
        allowDrop: false,
        baseParams: {
            action: 'mgr/properties/' + (config.new ? 'create' : 'update'),
            payment: config.payment
        },
        fields: this.getFields(config),
        keys: this.getKeys(config),
        buttons: this.getButtons(config),
        closeAction: 'close'
    });

    BePaidPayment.window.PaymentProperty.superclass.constructor.call(this, config);

    this.on('hide', function () {
        var self = this;
        window.setTimeout(function () {
            self.close();
        }, 200);
    });
};

Ext.extend(BePaidPayment.window.PaymentProperty, MODx.Window, {

    getFields: function getFields(config) {
        return [{
            layout: 'form',
            defaults: { msgTarget: 'under', autoHeight: true },
            items: [{
                fieldLabel: _('parameter'),
                xtype: 'bepaid-combo-settings',
                name: 'key',
                anchor: '100%',
                readOnly: !config.new,
                listeners: {
                    select: function (combo, record) {
                        Ext.getCmp('bepaid-property-value').setValue(record.data.value);
                    }
                }
            }, {
                fieldLabel: _('value'),
                xtype: 'textarea',
                name: 'value',
                anchor: '100%',
                id: 'bepaid-property-value'
            }]
        }];
    },

    getKeys: function getKeys() {
        return [{
            key: Ext.EventObject.ENTER,
            shift: true,
            fn: function () {
                this.submit();
            }, scope: this
        }];
    },

    getButtons: function getButtons(config) {
        return [{
            scope: this,
            text: _('cancel'),
            handler: function () {
                config.closeAction !== 'close'
                    ? this.hide()
                    : this.close();
            }
        }, {
            scope: this,
            text: _('save'),
            handler: this.submit,
            cls: 'primary-button'
        }]
    }

});
Ext.reg('bepaid-window-payment-property', BePaidPayment.window.PaymentProperty);
