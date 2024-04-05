<?php
declare(strict_types=1);

/**
 * File: UserOperations.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Algolytics\AlgoIntegration\Api\HintInterface;
use Algolytics\AlgoIntegration\Api\HintsInterface;
use Algolytics\AlgoIntegration\Api\SessionProviderInterface;
use Algolytics\AlgoIntegration\Api\UserOperationsInterface;
use Algolytics\AlgoIntegration\Service\AbstractClient;
use Exception;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Webapi\Exception as WebapiException;
use Psr\Log\LoggerInterface;

/**
 * Class UserOperations
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class UserOperations extends AbstractClient implements UserOperationsInterface
{
    /**
     * Api path for autocomplete city
     */
    private const API_PATH_CITY = '/api/autocomplete/city/';

    /**
     * Api path for autocomplete street
     */
    private const API_PATH_STREET = '/api/autocomplete/street/';

    /**
     * Api path for autocomplete building
     */
    private const API_PATH_BUILDING = '/api/autocomplete/building/';

    /**
     * Api path for autocomplete postal code
     */
    private const API_PATH_POSTAL_CODE = '/api/autocomplete/postalcode/';

    /**
     * Api path for check postal code
     */
    private const API_PATH_CHECK_POSTAL_CODE = '/api/autocomplete/check/';

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\HintFactory
     */
    private HintFactory $hintFactory;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\HintsFactory
     */
    private HintsFactory $hintsFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider
     */
    protected AuthorizationProvider $authorizationProvider;

    /**
     * @param \GuzzleHttp\ClientFactory $clientFactory
     * @param \GuzzleHttp\Psr7\ResponseFactory $responseFactory
     * @param \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface $configProvider
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     * @param \Algolytics\AlgoIntegration\Model\Api\HintFactory $hintFactory
     * @param \Algolytics\AlgoIntegration\Model\Api\HintsFactory $hintsFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider $authorizationProvider
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        ConfigProviderInterface $configProvider,
        Json $jsonSerializer,
        HintFactory $hintFactory,
        HintsFactory $hintsFactory,
        LoggerInterface $logger,
        AuthorizationProvider $authorizationProvider,
        SessionProviderInterface $sessionProvider
    ) {
        parent::__construct($clientFactory, $responseFactory, $configProvider, $jsonSerializer, $authorizationProvider, $sessionProvider);

        $this->hintsFactory = $hintsFactory;
        $this->hintFactory = $hintFactory;
        $this->logger = $logger;
    }

    /**
     * @param string $postalCode
     * @return int
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function checkPostalCode(string $postalCode): int
    {
        $requestUrl = $this->getRequestUrl(self::API_PATH_CHECK_POSTAL_CODE . $postalCode);

        if ($this->configProvider->isActive() === false) {
            throw new WebapiException(__('The Algolytics module is turned off.'));
        }

        try {
            return $this->doGetRequest($requestUrl)->getStatusCode();
        } catch (Exception $e) {
            $this->logger->critical($e);

            throw new WebapiException(__('An unexpected error has occurred. Please check the module configuration.'));
        }
    }

    /**
     * @param string $city
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function autoCompleteCity(string $city): HintsInterface
    {
        $data = $this->preparePostData($city, null, null);

        return $this->getAutoCompleteData($data, self::API_PATH_CITY);
    }

    /**
     * @param string $city
     * @param string $street
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function autoCompleteStreet(string $city, string $street): HintsInterface
    {
        $data = $this->preparePostData($city, $street, null);

        return $this->getAutoCompleteData($data, self::API_PATH_STREET);
    }

    /**
     * @param string $city
     * @param string $street
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function autoCompleteBuildingNumber(string $city, string $street, string $buildingNumber): HintsInterface
    {
        $data = $this->preparePostData($city, $street, $buildingNumber);

        return $this->getAutoCompleteData($data, self::API_PATH_BUILDING);
    }

    /**
     * @param string $city
     * @param string $street
     * @param string $buildingNumber
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function autoCompletePostalCode(string $city, string $street, string $buildingNumber): HintsInterface
    {
        $data = $this->preparePostData($city, $street, $buildingNumber);

        return $this->getAutoCompleteData($data, self::API_PATH_POSTAL_CODE);
    }

    /**
     * @param array $data
     * @param string $apiPath
     * @return \Algolytics\AlgoIntegration\Api\HintsInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    private function getAutoCompleteData(array $data, string $apiPath): HintsInterface
    {
        if ($this->configProvider->isActive() === false) {
            throw new WebapiException(__('The Algolytics module is turned off.'));
        }

        try {
            $hints = [];
            $preparePostRequest = $this->doPostRequest($this->getRequestUrl($apiPath), $data);
            $getPostContents = $preparePostRequest->getBody()->getContents();

            $repsonse = $this->jsonSerializer->unserialize($getPostContents);

            if (!empty($repsonse['hints'])) {
                foreach ($repsonse['hints'] as $item) {
                    $hints[] = $this->getDataAsInterface($item);
                }
            }
        } catch (Exception $e) {
            $this->logger->critical($e);

            throw new WebapiException(__('An unexpected error has occurred. Please check the module configuration.'));
        }

        return $this->hintsFactory->create()->setHints($hints);
    }

    /**
     * @param array $data
     * @return \Algolytics\AlgoIntegration\Api\HintInterface
     */
    private function getDataAsInterface(array $data): HintInterface
    {
        $hintFactory = $this->hintFactory->create();

        if (isset($data['actualName'])) {
            $hintFactory->setActualName($data['actualName']);
        }

        if (isset($data['lookedUpName'])) {
            $hintFactory->setLookedUpName($data['lookedUpName']);
        }

        if (isset($data['hasStreets'])) {
            $hintFactory->setHasStreets((bool) $data['hasStreets']);
        }

        if (isset($data['buildingNumber'])) {
            $hintFactory->setBuildingNumber($data['buildingNumber']);
        }

        if (isset($data['postalCode'])) {
            $hintFactory->setPostalCode($data['postalCode']);
        }

        return $hintFactory;
    }
}
