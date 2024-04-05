<?php
declare(strict_types=1);

/**
 * File: Hint.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\HintInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Hint
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class Hint extends AbstractModel implements HintInterface
{
    /**
     * @return string|null
     */
    public function getActualName(): ?string
    {
        return $this->getData(self::ACTUAL_NAME);
    }

    /**
     * @param string $actualName
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setActualName(string $actualName): HintInterface
    {
        return $this->setData(self::ACTUAL_NAME, $actualName);
    }

    /**
     * @return string|null
     */
    public function getLookedUpName(): ?string
    {
        return $this->getData(self::LOOKED_UP_NAME);
    }

    /**
     * @param string $lookedUpName
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setLookedUpName(string $lookedUpName): HintInterface
    {
        return $this->setData(self::LOOKED_UP_NAME, $lookedUpName);
    }

    /**
     * @return bool|null
     */
    public function getHasStreets(): ?bool
    {
        return $this->getData(self::HAS_STREETS);
    }

    /**
     * @param bool $hasStreets
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setHasStreets(bool $hasStreets): HintInterface
    {
        return $this->setData(self::HAS_STREETS, $hasStreets);
    }

    /**
     * @return string|null
     */
    public function getBuildingNumber(): ?string
    {
        return $this->getData(self::BUILDING_NUMBER);
    }

    /**
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setBuildingNumber(string $buildingNumber): HintInterface
    {
        return $this->setData(self::BUILDING_NUMBER, $buildingNumber);
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
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    public function setPostalCode(string $postalCode): HintInterface
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }
}
