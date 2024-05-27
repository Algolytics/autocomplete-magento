<?php

declare(strict_types=1);

/**
 * File: LayoutProcessor.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Algolytics\AlgoIntegration\Model\Config\ConfigProvider;
use Magento\Checkout\Helper\Data;

/**
 * Interface LayoutProcessor
 * @package Algolytics\AlgoIntegration\Block
 */
class LayoutProcessor implements LayoutProcessorInterface
{
    /**
     * @param ConfigProvider $configProvider
     * @param Data $checkoutDataHelper
     */
    public function __construct(
        private readonly ConfigProvider $configProvider,
        private readonly Data $checkoutDataHelper
    ) {}

    /**
     * Reposition postcode to be above city input, and country drop down to be above region
     *
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout): array
    {
        /**
         * Shipping form
         */
        if ($this->configProvider->isActive()) {
            $this->modifyShippingAddress($jsLayout);
        }

        if ($this->configProvider->isOneFieldActive()) {
            $this->addAddressOneFieldAutocomplete($jsLayout);
        }


        /**
         * Billing form
         */
        if ($this->configProvider->isActive() || $this->configProvider->isOneFieldActive()) {
            if ($this->checkoutDataHelper->isDisplayBillingOnPaymentMethodAvailable()) {
                $forms = &$jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']
                ['payments-list']['children'];
            } else {
                $forms = &$jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']
                ['afterMethods']['children'];
            }

            foreach ($forms as &$form) {
                $hasBillingAddressList = $form['children']['billingAddressList'] ?? false;
                if ($hasBillingAddressList === false) {
                    continue;
                }

                $field = &$form['children']['form-fields']['children'];

                if ($this->configProvider->isActive()) {
                    $this->modifyBillingAddress($field);
                }
                if ($this->configProvider->isOneFieldActive()) {
                    $this->addBillingOneFieldAutocomplete($field);
                }
            }
        }

        return $jsLayout;
    }

    /**
     * @param array $jsLayout
     * @return void
     */
    public function modifyShippingAddress(array &$jsLayout): void
    {
        $fields = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'];
        $this->setCustomSortOrder($fields);

        $cityField = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['city'];
        $this->modifyCityField($cityField);

        $streetField = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street'];
        $this->modifyStreetField($streetField);
    }

    /**
     * @param array $fields
     * @return void
     */
    public function modifyBillingAddress(array &$fields): void
    {
        $this->setCustomSortOrder($fields);

        $cityField = &$fields['city'];
        $this->modifyCityField($cityField);

        $streetField = &$fields['street'];
        $this->modifyStreetField($streetField);
    }

    /**
     * @param array $fields
     * @return void
     */
    private function setCustomSortOrder(array &$fields): void
    {
        $sortOrders = [
            'firstname' => 10,
            'lastname' => 20,
            'country_id' => 30,
            'region_id' => 40,
            'city' => 50,
            'street' => 55,
            'postcode' => 56,
        ];
        foreach ($sortOrders as $fieldName => $sortOrder) {
            $fields[$fieldName]['sortOrder'] = $sortOrder;
        }
    }

    /**
     * @param array $field
     * @return void
     */
    private function modifyCityField(array &$field): void
    {
        $field['component'] = 'Algolytics_AlgoIntegration/js/autocomplete';
        $field['config']['elementTmpl'] = 'Algolytics_AlgoIntegration/autocomplete/address/cityInput';
    }

    /**
     * @param array $field
     * @return void
     */
    private function modifyStreetField(array &$field): void
    {
        $field['additionalClasses'] = 'algo-checkout-address';
        $field['config']['template'] = 'Algolytics_AlgoIntegration/autocomplete/address/street-group';

        if (isset($field['children'][0])) {
            $field['children'][0]['label'] = __('Street');
            $field['children'][0]['component'] = 'Algolytics_AlgoIntegration/js/autocomplete';
            $field['children'][0]['config']['elementTmpl'] = 'Algolytics_AlgoIntegration/autocomplete/address/streetInput';
        }
        if (isset($field['children'][1])) {
            $field['children'][1]['label'] = __('Building Number');
            $field['children'][1]['component'] = 'Algolytics_AlgoIntegration/js/autocomplete';
            $field['children'][1]['config']['elementTmpl'] = 'Algolytics_AlgoIntegration/autocomplete/address/buildingNumberInput';
        }
        if (isset($field['children'][2])) {
            $field['children'][2]['label'] = __('Apartment Number');
        }
    }

    /**
     * @param array $jsLayout
     * @return array
     */
    protected function addAddressOneFieldAutocomplete(array &$jsLayout): array
    {
        /**
         * Shipping form
         */
        $jsLayout['components']['checkout']['children']
        ['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['one_field_autocomplete'] = $this->getOneFieldElement('shippingAddress');
        return $jsLayout;
    }

    /**
     * @param array $fields
     * @return void
     */
    protected function addBillingOneFieldAutocomplete(array &$fields): void
    {
        $fields['one_field_autocomplete'] = $this->getOneFieldElement('billingAddress');
    }

    /**
     * @param string $customScope
     * @return array
     */
    protected function getOneFieldElement(string $customScope): array
    {
        return [
            'component' => 'Algolytics_AlgoIntegration/js/autocompleteOneField',
            'config' => [
                'customScope' => $customScope,
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'Algolytics_AlgoIntegration/autocomplete/address/oneFieldAddressInput',
            ],
            'dataScope' => $customScope.'.one_field_autocomplete',
            'label' => __('Find address'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 45,
            'validation' => [
                'required-entry' => false
            ],
            'visible' => true,
            'value' => ''
        ];
    }
}
