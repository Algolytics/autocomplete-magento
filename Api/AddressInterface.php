<?php
declare(strict_types=1);

/**
 * File: AddressInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

use Algolytics\AlgoIntegration\Api\MatchesInterface;

/**
 * Interface AddressInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface AddressInterface
{
    public const STREET        = 'street';
    public const STREET_NUMBER = 'streetNumber';
    public const CITY          = 'city';
    public const POSTAL_CODE   = 'postalCode';
    public const MATCHES       = 'matches';

    /**
     * @return string|null
     */
    public function getStreet(): ?string;

    /**
     * @param string $street
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setStreet(string $street): AddressInterface;

    /**
     * @return string|null
     */
    public function getStreetNumber(): ?string;

    /**
     * @param string $streetNumber
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setStreetNumber(string $streetNumber): AddressInterface;

    /**
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * @param string $city
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setCity(string $city): AddressInterface;

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * @param string $postalCode
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setPostalCode(string $postalCode): AddressInterface;

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function getMatches(): MatchesInterface;

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchesInterface $matches
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setMatches(MatchesInterface $matches): AddressInterface;
}
