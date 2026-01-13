define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'custom_paymentmethod_offline',
            component: 'Pankaj_CustomPayment/js/view/payment/method-renderer/custompaymentoffline-method'
        }
    );

    return Component.extend({});
});