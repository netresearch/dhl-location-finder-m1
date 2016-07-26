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
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/** @var Mage_Customer_Model_Resource_Setup $installer */
$installer = Mage::getResourceModel('customer/setup', 'customer_setup');

$fields = array(
    Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER    => 'Dhl Post Number',
    Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE   => 'Dhl Station Type',
    Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER => 'Dhl Station',
);

/**
 * address renderers only render visible customer address attributes
 * @see Mage_Customer_Block_Address_Renderer_Default::render()
 */
foreach ($fields as $attributeCode => $label) {
    $attributeOptions = array(
        'label'    => $label,
        'type'     => 'varchar',
        'visible'  => true,
        'required' => false,
    );
    $installer->addAttribute('customer_address', $attributeCode, $attributeOptions);
}
