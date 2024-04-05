/**
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'mage/url',
    'ko',
    'Algolytics_AlgoIntegration/js/jqueryExtend',
    'Algolytics_AlgoIntegration/js/action/getOneFieldAddress',
    'Magento_Checkout/js/checkout-data',
    'uiRegistry',
    'jquery/ui'
], function (Abstract, url, ko, $, getOneFieldAddress, checkoutData, registry) {
    'use strict';

    ko.bindingHandlers.algoOneFieldAutoComplete = {

        init: function (element, valueAccessor) {

            let settings = valueAccessor(),
                options = settings.options,
                parentComponentName = settings.parentComponentName.replace('.street', ''),
                componentPostCode = registry.get(parentComponentName + '.postcode'),
                componentCity = registry.get(parentComponentName + '.city'),
                componentStreet = registry.get(parentComponentName + '.street.0'),
                componentStreetNo = registry.get(parentComponentName + '.street.1'),
                countryComponent = registry.get(parentComponentName + '.country_id'),
                oneFieldComponent = registry.get(parentComponentName + '.one_field_autocomplete')
            ;

            let updateElementValueWithLabel = function (event, ui) {

                event.preventDefault();

                let label = ui.item.label.replace(/<\/?[^>]+(>|$)/g, "");

                $(element).val(label);
                componentPostCode.value(ui.item.postal_code);
                componentCity.value(ui.item.city);
                componentStreet.value(ui.item.street);
                componentStreetNo.value(ui.item.street_number);

            };

            let resolveOneFieldAddress = function (value) {
                if (value !== 'PL') {
                    oneFieldComponent.hide();
                } else {
                    oneFieldComponent.show();
                }
            }

            resolveOneFieldAddress(countryComponent.value());

            countryComponent.value.subscribe(function (value) {
                resolveOneFieldAddress(value);
            });


            $(element).autocomplete({
                html: true,
                source: options,
                select: function (event, ui) {
                    updateElementValueWithLabel(event, ui);
                },
                focus: function (event, ui) {
                    updateElementValueWithLabel(event, ui);
                    $(".ui-helper-hidden-accessible").hide();
                },
                parentComponentName: parentComponentName
            });

        }
    };

    return Abstract.extend({

        selectedOneFieldAddress: ko.observable(''),
        getOneFieldAddress: function (request, response) {
            getOneFieldAddress(request.term, [function (data) {
                let items = data.items;
                items = items.map(function (obj) {
                    let highlightsMatchesResolver = function (object, index) {
                        let valueTxt = object[index];
                        let matches = object['matches'][index];
                        if (matches instanceof Array) {
                            valueTxt = valueTxt.split('');
                            matches.forEach(function (item) {
                                let l = item['length'];
                                let i = item['offset'];
                                for (let k = i; k < l + i; k++) {
                                    valueTxt[k] = '<b>' + valueTxt[k] + '</b>';
                                }
                            });
                            valueTxt = valueTxt.join('');
                        }
                        return valueTxt;
                    };

                    obj['label'] =
                        highlightsMatchesResolver(obj, 'postal_code') +
                        ' ' +
                        highlightsMatchesResolver(obj, 'city') +
                        ' ' +
                        highlightsMatchesResolver(obj, 'street') +
                        ' ' +
                        highlightsMatchesResolver(obj, 'street_number');

                    delete obj['matches'];
                    return obj;
                });
                response(items);
            }]);
        }
    });
});
