var BePaidPayment = function(config) {
    config = config || {};
    BePaidPayment.superclass.constructor.call(this, config);
};
Ext.extend(BePaidPayment, Ext.Component, {
    combo: {}
});
Ext.reg('bepaidpayment', BePaidPayment);

BePaidPayment = new BePaidPayment();
