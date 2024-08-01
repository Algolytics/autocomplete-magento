/**
 * @copyright Copyright (C) 2024 Algomaps (https://algomaps.com)
 */
define([
    'mage/storage',
    'Magento_Checkout/js/model/url-builder',
    'jquery'
], function (storage, urlBuilder, $) {
    'use strict';

    return function (city, street, buildingNumber, postalCode, callbacks) {
        return storage.post(
            urlBuilder.createUrl('/algolytics/algo/autoCompletePostalCode', {}),
            JSON.stringify({
                city: city,
                street: street,
                buildingNumber: buildingNumber,
                postalCode: postalCode
            }),
            false
        ).done(function (response) {
            let proceed = true;
            if (callbacks.length > 0) {
                $.each(callbacks, function (index, callback) {
                    proceed = proceed && callback(response);
                });
            }
        }).fail(function (response) {
            console.log(response);
        });
    };
});
