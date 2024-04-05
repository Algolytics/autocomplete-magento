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
    private StoreManagerInterface $storeManager;
    private ConfigProviderInterface $configProvider;

    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigProviderInterface $configProvider
    ) {
        $this->storeManager = $storeManager;
        $this->configProvider = $configProvider;
    }

    public function getStoreCode(): string
    {
        return $this->storeManager->getStore()->getCode();
    }

    public function isOneFieldActive(): bool
    {
        return $this->configProvider->isOneFieldActive();
    }

    public function isActive(): bool
    {
        return $this->configProvider->isActive();
    }
}
