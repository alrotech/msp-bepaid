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
