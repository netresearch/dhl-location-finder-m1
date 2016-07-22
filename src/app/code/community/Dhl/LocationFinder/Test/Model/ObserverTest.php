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
 * Dhl_LocationFinder_Test_Model_ObserverTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_ObserverTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     *
     * @loadFixture ObserverTest
     */
    public function registerAutoload()
    {
        $observer = new Dhl_LocationFinder_Model_Observer();

        $this->assertEmpty($observer->registerAutoload());
    }

    /**
     * @test
     */
    public function appendLocationFinderToShipping()
    {
        $blockMock = $this->getBlockMock('checkout/onepage_shipping', array('getCheckout'), false, array(), '', false);
        $blockMock->expects($this->any())->method('getCheckout')->will($this->returnValue(new Varien_Object()));
        $this->replaceByMock('block', 'checkout/onepage_shipping', $blockMock);

        $observer  = new Varien_Event_Observer();
        $block     = Mage::app()->getLayout()->createBlock('checkout/onepage_shipping');
        $transport = new Varien_Object();
        $transport->setData('html', '');

        $observer->setData('block', $block);
        $observer->setData('transport', $transport);

        $observerModel = new Dhl_LocationFinder_Model_Observer();
        $observerModel->appendLocationFinderToShipping($observer);

        $changedObject = $observer->getData('transport');

        $this->assertInternalType('string', $changedObject['html']);
    }

}
