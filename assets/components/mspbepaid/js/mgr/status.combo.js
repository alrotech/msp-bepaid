BePaidPayment.combo.Status = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'status',
        hiddenName: 'status',
        displayField: 'name',
        valueField: 'id',
        fields: ['id', 'name'],
        pageSize: 10,
        typeAhead: true,
        preselectValue: false,
        value: 0,
        editable: true,
        hideMode: 'offsets',
        url: BePaidPayment.ms2connector,
        baseParams: {
            action: 'mgr/settings/status/getlist',
            combo: true
        }
    });

    BePaidPayment.combo.Status.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Status, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-status', BePaidPayment.combo.Status);
