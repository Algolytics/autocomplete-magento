<?php
declare(strict_types=1);

/**
 * File: HintsInterface.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Api;

/**
 * Interface HintsInterface
 * @package Algolytics\AlgoIntegration\Api
 */
interface HintsInterface
{
    public const HINTS = 'hints';

    /**
     * @return \Algolytics\AlgoIntegration\Api\HintInterface[]
     */
    public function getHints(): array;

    /**
     * @param \Algolytics\AlgoIntegration\Api\HintInterface[] $hints
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function setHints(array $hints): HintsInterface;
}
