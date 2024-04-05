<?php
declare(strict_types=1);

/**
 * File: AddressesInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface AddressesInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface AddressesInterface
{
    public const ITEMS = 'items';

    /**
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface[]
     */
    public function getItems(): array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\AddressInterface[] $items
     * @return \Algolytics\AlgoIntegration\Api\AddressesInterface
     */
    public function setItems(array $items): AddressesInterface;
}
