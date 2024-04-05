<?php
declare(strict_types=1);

/**
 * File: registration.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Algolytics_AlgoIntegration', __DIR__);
