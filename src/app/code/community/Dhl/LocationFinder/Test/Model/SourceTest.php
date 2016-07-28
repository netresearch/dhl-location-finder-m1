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
 * Dhl_LocationFinder_Test_Model_SourceTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_SourceTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function limitToOptionArray()
    {
        $optionArray = Mage::getModel('dhl_locationfinder/adminhtml_system_config_source_limit')->toOptionArray();
        $this->assertArrayHasKey('10', $optionArray);
        $this->assertArrayHasKey('50', $optionArray);
    }

    /**
     * @test
     */
    public function centerToOptionArray()
    {
        $optionArray = Mage::getModel('dhl_locationfinder/adminhtml_system_config_source_scale')->toOptionArray();
        $this->assertArrayHasKey('auto', $optionArray);
        $this->assertArrayHasKey('fixed', $optionArray);
    }
}
