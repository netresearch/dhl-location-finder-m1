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
 * Dhl_LocationFinder_FacilitiesController
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Block_Checkout_Onepage_ParcelfinderTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function testaddMapToCheckout()
    {
        $block = new Dhl_LocationFinder_Block_Checkout_Onepage_Parcelfinder();

        $config = $this->getModelMock(
            'dhl_locationfinder/config',
            array('getIsModuleActive', 'getCurrentMapProvider')
        );
        $config->expects($this->any())
               ->method('getIsModuleActive')
               ->will($this->returnValue(1));
        $config->expects($this->any())
               ->method('getCurrentMapProvider')
               ->will($this->returnValue('googlemaps'));
        $this->replaceByMock('model', 'dhl_locationfinder/config', $config);

        $config = $this->getBlockMock(
            'dhl_locationfinder/checkout_onepage_parcelfinder',
            array('getHeadBlock')
        );
        $config->expects($this->once())
               ->method('getHeadBlock')
               ->will($this->returnValue(new Mage_Page_Block_Html_Head()));
        $this->replaceByMock('block', 'dhl_locationfinder/checkout_onepage_parcelfinder', $config);

        $this->markTestIncomplete(
            'Could not Mock Private method'
        );
        $this->assertNotNull($block->addMapToCheckout()->getChild('mapForCheckout')->getData('text'));
    }
}
