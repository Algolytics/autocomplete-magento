<?php
declare(strict_types=1);

/**
 * File: MatchAttributesInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface MatchAttributesInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface MatchAttributesInterface
{
    public const OFFSET = 'offset';
    public const LENGTH = 'length';

    /**
     * @return int|null
     */
    public function getOffset(): ?int;

    /**
     * @param int $offset
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface
     */
    public function setOffset(int $offset): MatchAttributesInterface;

    /**
     * @return int|null
     */
    public function getLength(): ?int;

    /**
     * @param int $length
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface
     */
    public function setLength(int $length): MatchAttributesInterface;
}
