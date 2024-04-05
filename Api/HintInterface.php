<?php
declare(strict_types=1);

/**
 * File: HintInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface HintInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface HintInterface
{
    public const ACTUAL_NAME     = 'actualName';
    public const LOOKED_UP_NAME  = 'lookedUpName';
    public const HAS_STREETS     = 'hasStreets';
    public const BUILDING_NUMBER = 'buildingNumber';
    public const POSTAL_CODE     = 'postalCode';

    /**
     * @return string|null
     */
    public function getActualName(): ?string;

    /**
     * @param string $actualName
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setActualName(string $actualName): HintInterface;

    /**
     * @return string|null
     */
    public function getLookedUpName(): ?string;

    /**
     * @param string $lookedUpName
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setLookedUpName(string $lookedUpName): HintInterface;

    /**
     * @return bool|null
     */
    public function getHasStreets(): ?bool;

    /**
     * @param bool $hasStreets
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setHasStreets(bool $hasStreets): HintInterface;

    /**
     * @return string|null
     */
    public function getBuildingNumber(): ?string;

    /**
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setBuildingNumber(string $buildingNumber): HintInterface;

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * @param string $postalCode
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setPostalCode(string $postalCode): HintInterface;
}
