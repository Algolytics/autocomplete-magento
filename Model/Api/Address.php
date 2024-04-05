<?php
declare(strict_types=1);

/**
 * File: Address.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\AddressInterface;
use Algolytics\AlgoIntegration\Api\MatchesInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Address
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class Address extends AbstractModel implements AddressInterface
{
    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->getData(self::STREET);
    }

    /**
     * @param string $street
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setStreet(string $street): AddressInterface
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * @return string|null
     */
    public function getStreetNumber(): ?string
    {
        return $this->getData(self::STREET_NUMBER);
    }

    /**
     * @param string $streetNumber
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setStreetNumber(string $streetNumber): AddressInterface
    {
        return $this->setData(self::STREET_NUMBER, $streetNumber);
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->getData(self::CITY);
    }

    /**
     * @param string $city
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setCity(string $city): AddressInterface
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->getData(self::POSTAL_CODE);
    }

    /**
     * @param string $postalCode
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setPostalCode(string $postalCode): AddressInterface
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function getMatches(): MatchesInterface
    {
        return $this->getData(self::MATCHES);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchesInterface $matches
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    public function setMatches(MatchesInterface $matches): AddressInterface
    {
        return $this->setData(self::MATCHES, $matches);
    }
}
