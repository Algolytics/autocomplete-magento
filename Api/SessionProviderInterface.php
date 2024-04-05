<?php
declare(strict_types=1);

/**
 * File: AuthorizationProviderInterface.php
 *
 * @copyright Copyright (C) 2023 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface AuthorizationProviderInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface SessionProviderInterface
{
    public function getHeader(): array;
}
