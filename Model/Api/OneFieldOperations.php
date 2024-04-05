<?php
declare(strict_types=1);

/**
 * File: OneFieldOperations.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Api;

use Algolytics\AlgoIntegration\Api\AddressesInterface;
use Algolytics\AlgoIntegration\Api\AddressInterface;
use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Algolytics\AlgoIntegration\Api\MatchesInterface;
use Algolytics\AlgoIntegration\Api\OneFieldOperationsInterface;
use Algolytics\AlgoIntegration\Api\SessionProviderInterface;
use Algolytics\AlgoIntegration\Service\AbstractClient;
use Exception;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Webapi\Exception as WebapiException;
use Psr\Log\LoggerInterface;

/**
 * Class OneFieldOperations
 * @package Algolytics\AlgoIntegration\Model\Api
 */
class OneFieldOperations extends AbstractClient implements OneFieldOperationsInterface
{
    /**
     * Api path for check address
     */
    private const API_PATH_ADDRESS = '/api/autocomplete/address';

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\AddressesFactory
     */
    private AddressesFactory $addressesFactory;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\AddressFactory
     */
    private AddressFactory $addressFactory;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\MatchesFactory
     */
    private MatchesFactory $matchesFactory;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\MatchAttributesFactory
     */
    private MatchAttributesFactory $matchAttributesFactory;

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
     * @param \Algolytics\AlgoIntegration\Model\Api\AddressesFactory $addressesFactory
     * @param \Algolytics\AlgoIntegration\Model\Api\AddressFactory $addressFactory
     * @param \Algolytics\AlgoIntegration\Model\Api\MatchesFactory $matchesFactory
     * @param \Algolytics\AlgoIntegration\Model\Api\MatchAttributesFactory $matchAttributesFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider $authorizationProvider
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        ConfigProviderInterface $configProvider,
        Json $jsonSerializer,
        AddressesFactory $addressesFactory,
        AddressFactory $addressFactory,
        MatchesFactory $matchesFactory,
        MatchAttributesFactory $matchAttributesFactory,
        LoggerInterface $logger,
        AuthorizationProvider $authorizationProvider,
        SessionProviderInterface $sessionProvider
    ) {
        parent::__construct($clientFactory, $responseFactory, $configProvider, $jsonSerializer, $authorizationProvider, $sessionProvider);

        $this->addressesFactory = $addressesFactory;
        $this->addressFactory = $addressFactory;
        $this->matchesFactory = $matchesFactory;
        $this->matchAttributesFactory = $matchAttributesFactory;
        $this->logger = $logger;
    }

    /**
     * @param string $address
     * @return \Algolytics\AlgoIntegration\Api\AddressesInterface
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function autoCompleteAddress(string $address): AddressesInterface
    {
        if ($this->configProvider->isOneFieldActive() === false) {
            throw new WebapiException(__('The Algolytics module is turned off.'));
        }

        try {
            $addresses = [];

            $preparePostRequest = $this->doGetRequest(
                $this->configProvider->getOneFieldAPIUrl() . self::API_PATH_ADDRESS,
                ['input' => $address],
                true
            );

            $getPostContents = $preparePostRequest->getBody()->getContents();
            $response = $this->jsonSerializer->unserialize($getPostContents);

            if (!empty($response)) {
                foreach ($response as $item) {
                    $addresses[] = $this->getDataAsInterface($item);
                }
            }
        } catch (Exception $e) {
            $this->logger->critical($e);

            throw new WebapiException(__('An unexpected error has occurred. Please check the module configuration.'));
        }

        return $this->addressesFactory->create()->setItems($addresses);
    }

    /**
     * @param array $data
     * @return \Algolytics\AlgoIntegration\Api\AddressInterface
     */
    private function getDataAsInterface(array $data): AddressInterface
    {
        $matches = $this->matchesFactory->create();

        $matchName = MatchesInterface::STREET;
        if (!empty($data[$matchName]['matches'])) {
            $matches->setStreet($this->getMatches($data[$matchName]['matches']));
        }

        $matchName = MatchesInterface::STREET_NUMBER;
        if (!empty($data[$matchName]['matches'])) {
            $matches->setStreetNumber($this->getMatches($data[$matchName]['matches']));
        }

        $matchName = MatchesInterface::CITY;
        if (!empty($data[$matchName]['matches'])) {
            $matches->setCity($this->getMatches($data[$matchName]['matches']));
        }

        $matchName = MatchesInterface::POSTAL_CODE;
        if (!empty($data[$matchName]['matches'])) {
            $matches->setPostalCode($this->getMatches($data[$matchName]['matches']));
        }

        return $this->addressFactory->create()
            ->setStreet($data['street']['value'] ?? '')
            ->setStreetNumber($data['streetNumber']['value'] ?? '')
            ->setCity($data['city']['value'] ?? '')
            ->setPostalCode($data['postalCode']['value'] ?? '')
            ->setMatches($matches);
    }

    /**
     * @param array $data
     * @return array
     */
    private function getMatches(array $data): array
    {
        $result = [];
        foreach ($data as $match) {
            $result[] = $this->matchAttributesFactory->create()
                ->setOffset($match['offset'] ?? null)
                ->setLength($match['length'] ?? null);
        }

        return $result;
    }
}
