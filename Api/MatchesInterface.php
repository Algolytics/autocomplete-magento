<?php
declare(strict_types=1);

/**
 * File: MatchesInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface MatchesInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface MatchesInterface
{
    public const STREET        = 'street';
    public const STREET_NUMBER = 'streetNumber';
    public const CITY          = 'city';
    public const POSTAL_CODE   = 'postalCode';

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getStreet(): ?array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $street
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setStreet(array $street): MatchesInterface;

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getStreetNumber(): ?array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $streetNumber
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setStreetNumber(array $streetNumber): MatchesInterface;

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getCity(): ?array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $city
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setCity(array $city): MatchesInterface;

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getPostalCode(): ?array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $postalCode
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setPostalCode(array $postalCode): MatchesInterface;
}
