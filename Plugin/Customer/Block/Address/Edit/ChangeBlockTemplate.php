<?php
declare(strict_types=1);

/**
 * File: ChangeBlockTemplate.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Plugin\Customer\Block\Address\Edit;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Magento\Customer\Block\Address\Edit as EditAlias;

class ChangeBlockTemplate
{
    private ConfigProviderInterface $configProvider;

    public function __construct(ConfigProviderInterface $configProvider)
    {
        $this->configProvider = $configProvider;
    }
    public function beforeToHtml(EditAlias $subject): ?string
    {
        if ($this->configProvider->isActive() || $this->configProvider->isOneFieldActive()) {
            $subject->setTemplate('Algolytics_AlgoIntegration::customer/address/edit.phtml');
        }
        return null;
    }
}
