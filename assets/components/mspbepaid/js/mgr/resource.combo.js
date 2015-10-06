BePaidPayment.combo.Resource = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'resource',
        hiddenName: 'resource',
        displayField: 'pagetitle',
        valueField: 'id',
        fields: ['id', 'pagetitle'],
        pageSize: 20,
        typeAhead: true,
        preselectValue: false,
        value: 0,
        editable: true,
        hideMode: 'offsets',
        url: BePaidPayment.ms2connector,
        baseParams: {
            action: 'mgr/system/element/resource/getlist',
            combo: true
        }
    });

    BePaidPayment.combo.Resource.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Resource, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-resource', BePaidPayment.combo.Resource);
