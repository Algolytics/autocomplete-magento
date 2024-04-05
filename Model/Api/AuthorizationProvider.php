<?php
declare(strict_types=1);

/**
 * File: AuthorizationProvider.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\AuthorizationProviderInterface;
use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;

/**
 * Interface AuthorizationProvider
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class AuthorizationProvider implements AuthorizationProviderInterface
{
    /**
     * @var \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface
     */
    protected ConfigProviderInterface $config;

    /**
     * @param \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface $config
     */
    public function __construct(ConfigProviderInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param bool $oneField
     * @return array
     */
    public function getAuthorizationHeader(bool $oneField = false): array
    {
        $apiToken = $oneField ? $this->config->getOneFieldAPIToken() : $this->config->getAPIToken();
        $authorization = $oneField ? $this->config->getOneFieldAuthorizationHeaderName() : $this->config->getAuthorizationHeaderName();
        $basic = $oneField ? $this->config->getOneFieldAuthenticationScheme() : $this->config->getAuthenticationScheme();

        return [
            'authorization' => $authorization,
            'data' => $basic . ' ' . $apiToken
        ];
    }
}
