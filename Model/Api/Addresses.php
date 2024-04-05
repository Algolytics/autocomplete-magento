<?php
declare(strict_types=1);

/**
 * File: Addresses.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\AddressesInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Addresses
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class Addresses extends AbstractModel implements AddressesInterface
{
    /**
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface[]
     */
    public function getItems(): array
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\AddressInterface[] $items
     * @return \Algolytics\AlgoIntegration\Api\AddressesInterface
     */
    public function setItems(array $items): AddressesInterface
    {
        return $this->setData(self::ITEMS, $items);
    }
}
