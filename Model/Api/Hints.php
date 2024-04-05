<?php
declare(strict_types=1);

/**
 * File: Hints.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\HintsInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Hints
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class Hints extends AbstractModel implements HintsInterface
{
    /**
     * @return \Algolytics\AlgoIntegration\Api\HintInterface[]
     */
    public function getHints(): array
    {
        return $this->getData(self::HINTS);
    }

    /**
     * @param \Algolytics\AlgoIntegration\Api\HintInterface[] $hints
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     */
    public function setHints(array $hints): HintsInterface
    {
        return $this->setData(self::HINTS, $hints);
    }
}
