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
     * @param \GuzzleHttp\ClientFactory $clientFactory
     * @param \GuzzleHttp\Psr7\ResponseFactory $responseFactory
     * @param \Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface $configProvider
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     * @param \Algolytics\AlgoIntegration\Model\Api\AuthorizationProvider $authorizationProvider
     */
    public function __construct(
        protected ClientFactory $clientFactory,
        protected ResponseFactory $responseFactory,
        protected ConfigProviderInterface $configProvider,
        protected Json $jsonSerializer,
        protected AuthorizationProvider $authorizationProvider,
        protected SessionProviderInterface $sessionProvider
    ) {}

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
