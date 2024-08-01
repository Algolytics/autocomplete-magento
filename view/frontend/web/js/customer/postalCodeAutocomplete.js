/**
 * @copyright Copyright (C) 2024 Algomaps (https://algomaps.com)
 */
define([
    'jquery',
    'Algolytics_AlgoIntegration/js/action/getPostalCodes',
    'jquery/ui'
], function ($, getPostalCodes) {
    'use strict';

    $.widget('algolytics.postalCodeAutocomplete', $.ui.autocomplete, {
        options: {
            source: function (request, response) {
                let cityComponent = document.querySelector('[name="city"]'),
                    streetComponent = document.querySelector('[name="street[0]"]'),
                    buildingNumberComponent = document.querySelector('[name="street[1]"]'),
                    cityValue = cityComponent.value,
                    streetValue = streetComponent.value,
                    builidingNumberValue = buildingNumberComponent.value;

                if (!cityValue) {
                    return;
                }

                getPostalCodes(cityValue, streetValue, builidingNumberValue, request.term, [function (data) {
                    let items = data.hints;
                    items = items.map(function (obj) {
                        obj['label'] = obj['postal_code'];
                        delete obj['postal_code'];
                        return obj;
                    });
                    response(items);
                }]);
            },
            focus: function (event, ui) {
                $(".ui-helper-hidden-accessible").hide();
            },
            select: function (event, ui) {
                event.preventDefault();
                $('#' + event.target.id).val(ui.item.label);
            }
        }
    });
    return $.algolytics.postalCodeAutocomplete;

});
