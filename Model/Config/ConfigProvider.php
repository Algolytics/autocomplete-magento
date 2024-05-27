<?php
declare(strict_types=1);

/**
 * File: ConfigProvider.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Model\Config;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ConfigProvider
 * @package Algolytics\AlgoIntegration\Model\Config
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * general group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_IS_ACTIVE = 'algolytics_connector/general/active';

    /**
     * general group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_API_URL = 'algolytics_connector/general/api_url';

    /**
     * general group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_API_TOKEN = 'algolytics_connector/general/api_token';

    /**
     * general group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_AUTH_HEADER = 'algolytics_connector/general/authentication_header_name';

    /**
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_AUTH_SCHEME = 'algolytics_connector/general/authentication_scheme';

    /**
     * general group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_SESSION_HEADER = 'algolytics_connector/general/session_header_name';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_IS_ACTIVE = 'algolytics_connector/one_field/active';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_API_URL = 'algolytics_connector/one_field/api_url';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_API_TOKEN = 'algolytics_connector/one_field/api_token';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_AUTH_HEADER = 'algolytics_connector/one_field/authentication_header_name';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_AUTH_SCHEME = 'algolytics_connector/one_field/authentication_scheme';

    /**
     * one_field group
     * @var string
     */
    private const XML_PATH_ALGOLYTICS_ONE_FIELD_SESSION_HEADER = 'algolytics_connector/one_field/session_header_name';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly EncryptorInterface $encryptor
    ) {}

    /**
     * general group
     * ----------------------------------------------------------------------------------------------------------------
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ALGOLYTICS_IS_ACTIVE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getAPIUrl(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_API_URL, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getAPIToken(): ?string
    {
        $password = $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_API_TOKEN, ScopeInterface::SCOPE_STORE);

        return $password ? $this->encryptor->decrypt($password) : '';
    }

    /**
     * @return string|null
     */
    public function getAuthorizationHeaderName(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_AUTH_HEADER, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getAuthenticationScheme(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_AUTH_SCHEME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getSessionHeaderName(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_SESSION_HEADER, ScopeInterface::SCOPE_STORE);
    }

    /**
     * one_field group
     * ----------------------------------------------------------------------------------------------------------------
     *
     * @return bool
     */
    public function isOneFieldActive(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ALGOLYTICS_ONE_FIELD_IS_ACTIVE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getOneFieldAPIUrl(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_ONE_FIELD_API_URL, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getOneFieldAPIToken(): ?string
    {
        $password = $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_ONE_FIELD_API_TOKEN, ScopeInterface::SCOPE_STORE);

        return $password ? $this->encryptor->decrypt($password) : '';
    }

    /**
     * @return string|null
     */
    public function getOneFieldAuthorizationHeaderName(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_ONE_FIELD_AUTH_HEADER, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getOneFieldAuthenticationScheme(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_ONE_FIELD_AUTH_SCHEME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getOneFieldSessionHeaderName(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALGOLYTICS_ONE_FIELD_SESSION_HEADER, ScopeInterface::SCOPE_STORE);
    }
}
