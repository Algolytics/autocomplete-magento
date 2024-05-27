<?php

declare(strict_types=1);

/**
 * File: ConfigProvider.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Setup\Patch\Data;

use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Config;
use Magento\Framework\{Exception\NoSuchEntityException,
    Exception\StateException,
    Setup\Patch\DataPatchInterface,
    App\Config\Storage\WriterInterface};
use Magento\Framework\Setup\ModuleDataSetupInterface;

class ConfigSetAddressLines implements DataPatchInterface
{
    /**
     * @const string
     */
    private const XML_PATH_CUSTOMER_ADDRESS_STREET_LINES = 'customer/address/street_lines';

    /**
     * @param WriterInterface $writer
     * @param AttributeRepositoryInterface $attributeRepository
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        private readonly WriterInterface $writer,
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly ModuleDataSetupInterface $moduleDataSetup
    ) {}

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function apply(): void
    {
        $this->addConfiguration();
    }

    /**
     * @return void
     * @throws NoSuchEntityException
     * @throws StateException
     */
    private function addConfiguration(): void
    {
        $this->moduleDataSetup->startSetup();

        $this->writer->save(
            self::XML_PATH_CUSTOMER_ADDRESS_STREET_LINES,
            3
        );

        $attribute = $this->attributeRepository->get('customer_address', 'street');
        $attribute->setData('multiline_count', 3);
        $this->attributeRepository->save($attribute);

        $this->moduleDataSetup->endSetup();
    }
}
