<?php
declare(strict_types=1);

/**
 * File: Matches.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\MatchAttributesInterface;
use Algolytics\AlgoIntegration\Api\MatchesInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Address
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class Matches extends AbstractModel implements MatchesInterface
{
    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getStreet(): ?array
    {
        return $this->getData(self::STREET);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $street
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setStreet(array $street): MatchesInterface
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getStreetNumber(): ?array
    {
        return $this->getData(self::STREET_NUMBER);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $streetNumber
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setStreetNumber(array $streetNumber): MatchesInterface
    {
        return $this->setData(self::STREET_NUMBER, $streetNumber);
    }

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getCity(): ?array
    {
        return $this->getData(self::CITY);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $city
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setCity(array $city): MatchesInterface
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[]|null
     */
    public function getPostalCode(): ?array
    {
        return $this->getData(self::POSTAL_CODE);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\MatchAttributesInterface[] $postalCode
     * @return \Algolytics\AlgoIntegration\Api\MatchesInterface
     */
    public function setPostalCode(array $postalCode): MatchesInterface
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }
}
