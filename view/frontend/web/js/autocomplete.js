/**
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'mage/url',
    'ko',
    'jquery',
    'Algolytics_AlgoIntegration/js/action/getCities',
    'Algolytics_AlgoIntegration/js/action/getStreets',
    'Algolytics_AlgoIntegration/js/action/getBuildingNumbers',
    'Magento_Checkout/js/checkout-data',
    'uiRegistry',
    'jquery/ui'
], function (Abstract, url, ko, $, getCities,getStreets, getBuildingNumbers, checkoutData, registry) {
    'use strict';

    ko.bindingHandlers.algoAutoComplete = {

        init: function (element, valueAccessor) {

            let settings = valueAccessor(),
                selectedOption = settings.selected,
                options = settings.options,
                parentComponentName = settings.parentComponentName.replace('.street', '');

            let updateElementValueWithLabel = function (event, ui) {

                event.preventDefault();

                $(element).val(ui.item.label);

                if (ui.item.postal_code) {
                    let component = registry.get(parentComponentName + '.postcode');
                    component.value(ui.item.postal_code);
                }

                if (typeof ui.item !== "undefined") {
                    selectedOption(ui.item);
                }
            };

            $(element).autocomplete({
                source: options,
                select: function (event, ui) {
                    updateElementValueWithLabel(event, ui);
                },
                focus: function (event, ui) {
                    $(".ui-helper-hidden-accessible").hide();
                },
                parentComponentName: parentComponentName
            });

        }
    };

    return Abstract.extend({
        selectedCity: ko.observable(''),
        selectedStreet: ko.observable(''),
        selectedBuildingNumber: ko.observable(''),
        getBuildingNumber: function (request, response) {
            let cityComponent = registry.get(this.options.parentComponentName + '.city'),
                streetComponent = registry.get(this.options.parentComponentName + '.street.0'),
                cityValue = cityComponent.value(),
                streetValue = streetComponent.value();

            if (!cityValue || !streetValue) {
                return;
            }

            getBuildingNumbers(cityValue, streetValue, request.term, [function (data) {
                let items = data.hints;
                items = items.map(function (obj) {
                    obj['label'] = obj['building_number'] + ' (' + obj['postal_code'] + ')';
                    delete obj['building_number'];
                    return obj;
                });
                response(items);
            }]);
        },
        getStreets: function (request, response) {
            let cityComponent = registry.get(this.options.parentComponentName + '.city'),
                cityValue = cityComponent.value();

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
        getCities: function (request, response) {
            let countryComponent = registry.get(this.options.parentComponentName + '.country_id'),
                countryValue = countryComponent.value();
            if (countryValue !== 'PL') {
                return;
            }

            getCities(request.term, [function (data) {
                let items = data.hints;
                items = items.map(function (obj) {
                    obj['label'] = obj['actual_name'];
                    delete obj['actual_name'];
                    return obj;
                });
                response(items);
            }]);
        }
    });
});
