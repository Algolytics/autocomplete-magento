<?php
declare(strict_types=1);

/**
 * File: MatchAttributes.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\MatchAttributesInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class MatchAttributes
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class MatchAttributes extends AbstractModel implements MatchAttributesInterface
{
    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->getData(self::OFFSET);
    }

    /**
     * @param int $offset
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface
     */
    public function setOffset(int $offset): MatchAttributesInterface
    {
        return $this->setData(self::OFFSET, $offset);
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->getData(self::LENGTH);
    }

    /**
     * @param int $length
     * @return \Algolytics\AlgoIntegration\Api\MatchAttributesInterface
     */
    public function setLength(int $length): MatchAttributesInterface
    {
        return $this->setData(self::LENGTH, $length);
    }
}
