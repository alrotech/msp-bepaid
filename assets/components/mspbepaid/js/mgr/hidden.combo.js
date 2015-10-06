BePaidPayment.combo.Hidden = function (config) {
    config = config || {};

    Ext.applyIf(config,{
        name: config.name
        ,fieldLabel: _('ms2_product_' + config.name)
        ,id: 'minishop2-product-' + config.name
        ,hiddenName: config.name
        ,displayField: config.name
        ,valueField: config.name
        ,anchor: '99%'
        ,fields: [config.name]
        //,pageSize: 20
        ,forceSelection: false
        ,url: BePaidPayment.ms2connector
        ,typeAhead: true
        ,editable: true
        ,allowBlank: true
        ,baseParams: {
            action: 'mgr/product/autocomplete'
            ,name: config.name
            ,combo:1
            ,limit: 0
        }
        ,hideTrigger: true
    });

    BePaidPayment.combo.Hidden.superclass.constructor.call(this, config);
};

Ext.extend(BePaidPayment.combo.Hidden, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-hidden', BePaidPayment.combo.Hidden);
