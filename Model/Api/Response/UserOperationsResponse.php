<?php
declare(strict_types=1);

/**
 * File: UserOperationsRequest.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api\Response;

use Algolytics\AlgoIntegration\Api\Response\UserOperationsResponseInterface;
use Magento\Framework\DataObject;

/**
 * Class UserOperationsResponse
 * @package Algolytics\AlgoIntegration\Model\Api\Response
 */
class UserOperationsResponse extends DataObject implements UserOperationsResponseInterface
{
    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->getData(self::POSTAL_CODE);
    }

    /**
     * @param $postalCode
     * @return UserOperationsResponse
     */
    public function setPostCode($postalCode): UserOperationsResponse
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }
}
