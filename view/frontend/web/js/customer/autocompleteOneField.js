/**
 * @copyright Copyright (C) 2023 Algomaps (https://algomaps.com)
 */
define([
    'Algolytics_AlgoIntegration/js/jqueryExtend',
    'Algolytics_AlgoIntegration/js/action/getOneFieldAddress',
    'jquery/ui'
], function ($, getOneFieldAddress) {
    'use strict';

    function updateElementValueWithLabel(event, ui) {
        let
            componentPostCode = document.querySelector('[name="postcode"]'),
            componentCity = document.querySelector('[name="city"]'),
            componentStreet = document.querySelector('[name="street[0]"]'),
            componentStreetNo = document.querySelector('[name="street[1]"]'),
            countryComponent = document.querySelector('[name="country_id"]'),
            oneFieldComponent = document.querySelector('[name="findAddress"]')
        ;
        event.preventDefault();
        oneFieldComponent.value = ui.item.label.replace(/<\/?[^>]+(>|$)/g, "");
        componentPostCode.value = ui.item.postal_code;
        componentCity.value = ui.item.city;
        componentStreet.value = ui.item.street;
        componentStreetNo.value = ui.item.street_number;
    }

    $.widget('algolytics.oneFieldAutocomplete', $.ui.autocomplete, {
        options: {
            html: true,
            source: function (request, response) {
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
            },
            focus: function (event, ui) {
                updateElementValueWithLabel(event, ui);
                $(".ui-helper-hidden-accessible").hide();
            },
            select: function (event, ui) {
                updateElementValueWithLabel(event, ui);
            }
        },
        _create: function () {
            let self = this,
                countryComponent = $('[name="country_id"]');
            this._super()
            countryComponent.on('change', function () {
                if ($(this).val() !== 'PL') {
                    self.element.closest('.findAddress').hide();
                } else {
                    self.element.closest('.findAddress').show();
                }
            });
            if (countryComponent.val() !== 'PL') {
                this.element.closest('.findAddress').hide();
            } else {
                this.element.closest('.findAddress').show();
            }
        },
    });

    return $.algolytics.oneFieldAutocomplete;
});
