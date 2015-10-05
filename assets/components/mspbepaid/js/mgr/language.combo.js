BePaidPayment.combo.Languages = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['k','v'],
            data: [
                ['English', 'en'],
                ['Spanish', 'es'],
                ['Turkish', 'tr'],
                ['German', 'de'],
                ['Italian', 'it'],
                ['Russian', 'ru'],
                ['Chinese', 'zh'],
                ['French', 'fr'],
                ['Danish', 'da'],
                ['Swedish', 'sv'],
                ['Norwegian', 'no'],
                ['Finnish', 'fi']
            ]
        }),
        name: 'language',
        hiddenName: 'language',
        displayField: 'k',
        valueField: 'v',
        mode: 'local',
        triggerAction: 'all',
        editable: false,
        pageSize: 20,
        selectOnFocus: false,
        preventRender: true
    });
    BePaidPayment.combo.Languages.superclass.constructor.call(this, config);
};
Ext.extend(BePaidPayment.combo.Languages, MODx.combo.ComboBox);
Ext.reg('bepaid-combo-languages', BePaidPayment.combo.Languages);
