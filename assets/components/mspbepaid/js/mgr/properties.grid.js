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

BePaidPayment.grid.PaymentProperties = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url: BePaidPayment.ownConnector,
        baseParams: {
            action: 'mgr/properties/getlist',
            payment: config.payment
        },
        autoHeight: true,
        paging: true,
        remoteSort: false,
        stripeRows: true,
        pageSize: 5,
        tbar: this.getTopBar(),
        fields: ['key', 'value'],
        columns: [{
            header: _('property'),
            dataIndex: 'key',
            width: 55,
            editable: false,
            sortable: false,
            renderer: this.propertyKeyRenderer.createDelegate(this, [this], true),
        }, {
            header: _('value'),
            dataIndex: 'value',
            sortable: false,
            editable: true,
            width: 45
        }]
    });

    BePaidPayment.grid.PaymentProperties.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.grid.PaymentProperties, MODx.grid.Grid, {

    getTopBar: function getTopBar() {
        return [{
            cls: 'primary-button',
            text: '<i class="icon icon-large icon-wrench"></i>&nbsp;&nbsp;&nbsp;' + _('property_create'),
            handler: this.addProperty,
            scope: this
        }, '->', {
            text: '<i class="icon icon-large icon-remove"></i>&nbsp;&nbsp;&nbsp;' + _('ms2_menu_clear_all'),
            handler: this.clearAll,
            scope: this
        }];
    },

    propertyKeyRenderer: function propertyKeyRenderer(value, metaData, record) {

        record.data.human = _('setting_' + value);

        var tpl = '<div>' +
            '<span>{human}</span>' +
            '<br><small><b>{key}</b></small>' +
        '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    addProperty: function addProperty() {
        MODx.load({
            xtype: 'bepaid-window-payment-property',
            new: true,
            grid: this,
            payment: this.config.payment,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        }).show();
    },

    deleteProperty: function deleteProperty() {
        MODx.msg.confirm({
            title: _('ms2_payment_bepaid_remove_setting'),
            text: _('ms2_payment_bepaid_remove_setting_desc'),
            url: BePaidPayment.ownConnector,
            params: {
                action: 'mgr/properties/delete',
                payment: this.config.payment,
                key: this.menu.record.key
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(response.message);
                    }, scope: this
                }
            }
        });
    },

    editProperty: function editProperty(btn, e) {
        var window = MODx.load({
            xtype: 'bepaid-window-payment-property',
            grid: this,
            payment: this.config.payment,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });

        window.reset();
        window.setValues(this.menu.record);
        window.show(e.target);
    },

    getMenu: function getMenu() {
        this.addContextMenuItem([{
            text: String.format('<span><i class="x-menu-item-icon icon {0}"></i>{1}</span>',
                'icon-edit', _('edit')),
            handler: this.editProperty
        },'-',{
            text: String.format('<span><i class="x-menu-item-icon icon {0}"></i>{1}</span>',
                'icon-trash-o', _('delete')),
            handler: this.deleteProperty
        }]);
    },

    clearAll: function clearAll() {
        MODx.msg.confirm({
            title: _('ms2_payment_bepaid_remove_all'),
            text: _('ms2_payment_bepaid_remove_all_desc'),
            url: BePaidPayment.ownConnector,
            params: {
                action: 'mgr/properties/delete',
                payment: this.config.payment,
                key: 'all'
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(response.message);
                    }, scope: this
                }
            }
        });
    }

});
Ext.reg('bepaid-grid-payment-properties', BePaidPayment.grid.PaymentProperties);
