<?php
declare(strict_types=1);

/**
 * File: CustomerAddress.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\ViewModel;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class CustomerAddress implements ArgumentInterface
{
    public function __construct(
        private readonly StoreManagerInterface $storeManager,
        private readonly ConfigProviderInterface $configProvider
    ) {}

    /**
     * @return string
     */
    public function getStoreCode(): string
    {
        return $this->storeManager->getStore()->getCode();
    }

    /**
     * @return bool
     */
    public function isOneFieldActive(): bool
    {
        return $this->configProvider->isOneFieldActive();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->configProvider->isActive();
    }
}
