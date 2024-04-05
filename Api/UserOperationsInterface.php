<?php
declare(strict_types=1);

/**
 * File: UserOperationsInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface UserOperationsInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface UserOperationsInterface
{
    /**
     * @param string $postalCode
     * @return int
     */
    public function checkPostalCode(string $postalCode): int;

    /**
     * @param string $city
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function autoCompleteCity(string $city): HintsInterface;

    /**
     * @param string $city
     * @param string $street
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function autoCompleteStreet(string $city, string $street): HintsInterface;

    /**
     * @param string $city
     * @param string $street
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function autoCompleteBuildingNumber(string $city, string $street, string $buildingNumber): HintsInterface;

    /**
     * @param string $city
     * @param string $street
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function autoCompletePostalCode(string $city, string $street, string $buildingNumber): HintsInterface;
}
