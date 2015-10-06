BePaidPayment.combo.Languages = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['caption','key'],
            data: [
                [_('ms2_payment_bepaid_lang_english'), 'en'],
                [_('ms2_payment_bepaid_lang_spanish'), 'es'],
                [_('ms2_payment_bepaid_lang_turkish'), 'tr'],
                [_('ms2_payment_bepaid_lang_german'), 'de'],
                [_('ms2_payment_bepaid_lang_italian'), 'it'],
                [_('ms2_payment_bepaid_lang_russian'), 'ru'],
                [_('ms2_payment_bepaid_lang_chinese'), 'zh'],
                [_('ms2_payment_bepaid_lang_french'), 'fr'],
                [_('ms2_payment_bepaid_lang_danish'), 'da'],
                [_('ms2_payment_bepaid_lang_swedish'), 'sv'],
                [_('ms2_payment_bepaid_lang_norwegian'), 'no'],
                [_('ms2_payment_bepaid_lang_finnish'), 'fi']
            ]
        }),
        name: 'language',
        hiddenName: 'language',
        displayField: 'caption',
        valueField: 'key',
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
