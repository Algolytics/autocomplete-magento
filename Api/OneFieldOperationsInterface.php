<?php
declare(strict_types=1);

/**
 * File: OneFieldOperationsInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface OneFieldOperationsInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface OneFieldOperationsInterface
{
    /**
     * @param string $address
     * @return \Algolytics\AlgoIntegration\Api\AddressesInterface
     */
    public function autoCompleteAddress(string $address): AddressesInterface;
}
