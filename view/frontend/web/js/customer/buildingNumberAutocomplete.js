/**
 * @copyright Copyright (C) 2023 Algomaps (https://algomaps.com)
 */
define([
    'jquery',
    'Algolytics_AlgoIntegration/js/action/getBuildingNumbers',
    'jquery/ui'
], function ($, getBuildingNumbers) {
    'use strict';

    $.widget('algolytics.buildingNumberAutocomplete', $.ui.autocomplete, {
        options: {
            source: function (request, response) {
                let cityComponent = document.querySelector('[name="city"]'),
                    streetComponent = document.querySelector('[name="street[0]"]'),
                    cityValue = cityComponent.value,
                    streetValue = streetComponent.value;

                if (!cityValue || !streetValue) {
                    return;
                }

                getBuildingNumbers(cityValue, streetValue, request.term, [function (data) {
                    let items = data.hints;
                    items = items.map(function (obj) {
                        obj['label'] = obj['building_number'];
                        delete obj['building_number'];
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
    return $.algolytics.buildingNumberAutocomplete;

});
