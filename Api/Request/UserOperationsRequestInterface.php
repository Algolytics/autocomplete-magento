<?php
declare(strict_types=1);

/**
 * File: UserOperationsRequestInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api\Request;

/**
 * Interface UserOperationsRequestInterface
 * @package Algolytics\AlgoIntegration\Api\Request
 */
interface UserOperationsRequestInterface
{
    public const POSTAL_CODE = 'postal_code';

    /**
     * @return string
     */
    public function getPostCode(): string;

    /**
     * @param string $postalCode
     * @return UserOperationsRequestInterface
     */
    public function setPostCode(string $postalCode): UserOperationsRequestInterface;
}
