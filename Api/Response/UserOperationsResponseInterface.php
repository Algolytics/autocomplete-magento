<?php
declare(strict_types=1);

/**
 * File: UserOperationsResponseInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api\Response;

/**
 * Interface UserOperationsResponseInterface
 * @package Algolytics\AlgoIntegration\Api\Response
 */
interface UserOperationsResponseInterface
{
    public const POSTAL_CODE = 'postal_code';

    /**
     * @return string
     */
    public function getPostCode(): string;

    /**
     * @param string $postalCode
     * @return $this
     */
    public function setPostCode(string $postalCode): UserOperationsResponseInterface;
}
