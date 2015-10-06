BePaidPayment.combo.Hidden = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'hidden',
        fieldLabel: 'hidden',
        hiddenName: 'hidden',
        displayField: 'k',
        valueField: 'v',
        anchor: '100%',
        fields: ['k', 'v'],
        forceSelection: false,
        typeAhead: true,
        editable: true
    });

    BePaidPayment.combo.Hidden.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Hidden, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-hidden', BePaidPayment.combo.Hidden);
