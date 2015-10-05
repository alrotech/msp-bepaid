miniShop2.combo.Autocomplete = function(config) {
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
        ,url: miniShop2.config.connector_url
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
    miniShop2.combo.Autocomplete.superclass.constructor.call(this,config);
};
Ext.extend(miniShop2.combo.Autocomplete,MODx.combo.ComboBox);
Ext.reg('bepaid-combo-hidden',miniShop2.combo.Autocomplete);
