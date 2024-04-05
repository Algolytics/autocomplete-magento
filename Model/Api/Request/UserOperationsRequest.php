<?php
declare(strict_types=1);

/**
 * File: UserOperationsRequest.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api\Request;

use Algolytics\AlgoIntegration\Api\Request\UserOperationsRequestInterface;
use Magento\Framework\DataObject;

/**
 * Class UserOperationsRequest
 * @package Algolytics\AlgoIntegration\Model\Api\Request
 */
class UserOperationsRequest extends DataObject implements UserOperationsRequestInterface
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
     * @return UserOperationsRequest
     */
    public function setPostCode($postalCode): UserOperationsRequest
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }
}
