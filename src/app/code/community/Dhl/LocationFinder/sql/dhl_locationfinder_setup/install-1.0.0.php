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


/**
 * Adding Extra Columns to sales_flat_quote_address
 * to store the dhl location fields
 */
$sales_quote_address = $installer->getTable('sales/quote_address');
/** @var Magento_Db_Adapter_Pdo_Mysql $connection */
$connection = $installer->getConnection();

$connection->addColumn($sales_quote_address, 'dhl_post_number', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Post Number'
    )
);
$connection->addColumn($sales_quote_address, 'dhl_station_type', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Station Type'
    )
);
$connection->addColumn($sales_quote_address, 'dhl_station', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Station'
    )
);

/**
 * Adding Extra Column to sales_flat_order_address
 * to store the dhl location fields
 */
$sales_order_address = $installer->getTable('sales/order_address');

$connection->addColumn($sales_order_address, 'dhl_post_number', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Post Number'
    )
);
$connection->addColumn($sales_order_address, 'dhl_station_type', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Station Type'
    )
);
$connection->addColumn($sales_order_address, 'dhl_station', array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Dhl Station'
    )
);
