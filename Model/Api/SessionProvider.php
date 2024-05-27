<?php
declare(strict_types=1);

/**
 * File: AuthorizationProvider.php
 *
 * @copyright Copyright (C) 2023 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\AuthorizationProviderInterface;
use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Algolytics\AlgoIntegration\Api\SessionProviderInterface;
use Magento\Checkout\Model\Session;

/**
 * Interface AuthorizationProvider
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class SessionProvider implements SessionProviderInterface
{
    /**
     * @param ConfigProviderInterface $config
     */
    public function __construct(
        private readonly ConfigProviderInterface $config,
        private readonly Session $checkoutSession
    ) {}

    /**
     * @param bool $oneField
     * @return array
     */
    public function getHeader(bool $oneField = false): array
    {
        $headerName = $oneField ? $this->config->getOneFieldSessionHeaderName() : $this->config->getSessionHeaderName();
        return [
            'header' => $headerName,
            'data' => $this->checkoutSession->getSessionId()
        ];
    }
}
