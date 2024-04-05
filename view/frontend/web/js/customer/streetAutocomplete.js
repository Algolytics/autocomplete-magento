/**
 * @copyright Copyright (C) 2023 Algomaps (https://algomaps.com)
 */
define([
    'jquery',
    'Algolytics_AlgoIntegration/js/action/getStreets',
    'jquery/ui'
], function ($, getStreets) {
    'use strict';

    $.widget('algolytics.streetAutocomplete', $.ui.autocomplete, {
        options: {
            source: function (request, response) {
                let cityComponent = document.querySelector('[name="city"]'),
                    cityValue = cityComponent.value;

                if (!cityValue) {
                    return;
                }

                getStreets(cityValue, request.term, [function (data) {
                    let items = data.hints;
                    items = items.map(function (obj) {
                        obj['label'] = obj['actual_name'];
                        delete obj['actual_name'];
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
                if (ui.item.postal_code) {
                    let component = document.querySelector('[name="postcode"]');
                    component.value = ui.item.postal_code;
                }
            }
        }
    });
    return $.algolytics.streetAutocomplete;

});
