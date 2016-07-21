<?php
/**
 * Dhl LocationFinder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 5
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/**
 * Dhl_LocationFinder_Setup
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/** @var Mage_Customer_Model_Entity_Setup $installer */
$installer = $this;

$installer->startSetup();

$this->addAttribute('customer_address', 'dhl_post_number', array(
        'type'             => Varien_Db_Ddl_Table::TYPE_VARCHAR,
        'input'            => 'text',
        'label'            => 'Dhl Post Number',
        'global'           => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'          => 1,
        'required'         => 0,
        'user_defined'     => 1,
        'visible_on_front' => 1
    )
);
$this->addAttribute('customer_address', 'dhl_station_type', array(
        'type'             => Varien_Db_Ddl_Table::TYPE_VARCHAR,
        'input'            => 'text',
        'label'            => 'Dhl Station Type',
        'global'           => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'          => 1,
        'required'         => 0,
        'user_defined'     => 1,
        'visible_on_front' => 1
    )
);
$this->addAttribute('customer_address', 'dhl_station', array(
        'type'             => Varien_Db_Ddl_Table::TYPE_VARCHAR,
        'input'            => 'text',
        'label'            => 'Dhl Station',
        'global'           => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'          => 1,
        'required'         => 0,
        'user_defined'     => 1,
        'visible_on_front' => 1
    )
);
