<?php
declare(strict_types=1);

/**
 * File: ConfigProviderInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api\Config;

/**
 * Interface ConfigProviderInterface
 * @package Algolytics\AlgoIntegration\Api\Config
 */
interface ConfigProviderInterface
{
    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @return string|null
     */
    public function getAPIUrl(): ?string;

    /**
     * @return string|null
     */
    public function getAPIToken(): ?string;

    /**
     * @return string|null
     */
    public function getAuthorizationHeaderName(): ?string;

    /**
     * @return string|null
     */
    public function getAuthenticationScheme(): ?string;

    /**
     * @return string|null
     */
    public function getSessionHeaderName(): ?string;

    /**
     * @return bool
     */
    public function isOneFieldActive(): bool;

    /**
     * @return string|null
     */
    public function getOneFieldAPIUrl(): ?string;

    /**
     * @return string|null
     */
    public function getOneFieldAPIToken(): ?string;

    /**
     * @return string|null
     */
    public function getOneFieldAuthorizationHeaderName(): ?string;

    /**
     * @return string|null
     */
    public function getOneFieldAuthenticationScheme(): ?string;

    /**
     * @return string|null
     */
    public function getOneFieldSessionHeaderName(): ?string;
}
