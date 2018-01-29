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
            header: _('key'),
            dataIndex: 'key',
            width: 45,
            editable: false,
            sortable: false
        }, {
            header: _('value'),
            dataIndex: 'value',
            sortable: false,
            editable: true,
            width: 65
        }]
    });

    BePaidPayment.grid.PaymentProperties.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.grid.PaymentProperties, MODx.grid.Grid, {

    getTopBar: function getTopBar() {
        var tb = [];

        tb.unshift({
            cls: 'primary-button',
            text: '<i class="icon icon-large icon-wrench"></i>&nbsp;&nbsp;&nbsp;' + _('property_create'),
            handler: this.addProperty,
            scope: this
        });

        return tb;
    },

    addProperty: function addProperty(config) {
        MODx.load({
            xtype: 'bepaid-window-payment-property',
            title: _('property_options'),
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

    getMenu: function getMenu() {
        this.addContextMenuItem([{
            text: 'Menu Item (should be implemented)',
            handler: null
        }]);
    },

});
Ext.reg('bepaid-grid-payment-properties', BePaidPayment.grid.PaymentProperties);
