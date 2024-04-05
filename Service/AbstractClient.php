<?php
declare(strict_types=1);

/**
 * File: AbstractClient.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Service;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Algolytics\AlgoIntegration\Api\SessionProviderInterface;
use Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractClient
 * @package Algolytics\AlgoIntegration\Service
 */
class AbstractClient
{
    /**
     * Content-Type
     */
    private const CONTENT_TYPE = 'application/json';

    /**
     * Accept
     */
    private const ACCEPT = 'application/json';

    /**
     * Default authorization header name value
     */
    private const AUTHENTICATION_HEADER = 'Authorization';

    /**
     * Default authentication scheme value
     */
    private const AUTHENTICATION_SCHEME = 'Basic';

    /**
     * @var \GuzzleHttp\ClientFactory
     */
    protected ClientFactory $clientFactory;

    /**
     * @var \GuzzleHttp\Psr7\ResponseFactory
     */
    protected ResponseFactory $responseFactory;

    /**
     * @var \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface
     */
    protected ConfigProviderInterface $configProvider;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected Json $jsonSerializer;

    /**
     * @var string
     */
    protected string $authorization;

    /**
     * @var string
     */
    protected string $basic;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider
     */
    protected AuthorizationProvider $authorizationProvider;

    /**
     * @var \Algolytics\AlgoIntegration\Model\Api\SessionProviderInterface
     */
    protected SessionProviderInterface $sessionProvider;

    /**
     * @param \GuzzleHttp\ClientFactory $clientFactory
     * @param \GuzzleHttp\Psr7\ResponseFactory $responseFactory
     * @param \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface $configProvider
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     * @param \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider $authorizationProvider
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        ConfigProviderInterface $configProvider,
        Json $jsonSerializer,
        AuthorizationProvider $authorizationProvider,
        SessionProviderInterface $sessionProvider
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->configProvider = $configProvider;
        $this->jsonSerializer = $jsonSerializer;
        $this->authorizationProvider = $authorizationProvider;
        $this->sessionProvider = $sessionProvider;
    }

    /**
     * @param string $requestUrl
     * @param array $query
     * @param bool $oneField
     * @return ResponseInterface
     */
    protected function doGetRequest(string $requestUrl, array $query = [], bool $oneField = false): ResponseInterface
    {
        $authorization = $this->authorizationProvider->getAuthorizationHeader($oneField);
        $session = $this->sessionProvider->getHeader();
        try {
            $client = $this->clientFactory->create();
            $response = $client->get(
                $requestUrl,
                [
                    'headers' => [
                        $authorization['authorization'] => $authorization['data'],
                        $session['header'] => $session['data'],
                        'Content-Type' => self::CONTENT_TYPE
                    ],
                    'query' => $query
                ]
            );
        } catch (RequestException $exception) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    /**
     * @param string $requestUrl
     * @param array $data
     * @return ResponseInterface
     */
    protected function doPostRequest(string $requestUrl, array $data): ResponseInterface
    {
        $authorization = $this->authorizationProvider->getAuthorizationHeader();
        $session = $this->sessionProvider->getHeader();
        try {
            $client = $this->clientFactory->create();
            $response = $client->post($requestUrl,
                [
                    'headers' => [
                        $authorization['authorization'] => $authorization['data'],
                        $session['header'] => $session['data'],
                        'Content-Type' => self::CONTENT_TYPE,
                        'Accept' => self::ACCEPT
                    ],
                    'body' => $this->jsonSerializer->serialize($data)
                ]
            );
        } catch (RequestException $exception) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    /**
     * @param string $requestUrl
     * @return string
     */
    protected function getRequestUrl(string $requestUrl): string
    {
        return $this->configProvider->getAPIUrl() . $requestUrl;
    }

    /**
     * @param string $city
     * @param string|null $street
     * @param string|null $buildingNumber
     * @return string[]
     */
    protected function preparePostData(string $city, ?string $street, ?string $buildingNumber): array
    {
        return [
            'city' => $city,
            'street' => $street,
            'buildingNumber' => $buildingNumber
        ];
    }
}
