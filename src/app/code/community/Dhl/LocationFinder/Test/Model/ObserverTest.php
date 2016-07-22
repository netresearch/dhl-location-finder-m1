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

    /**
     * @test
     */
    public function saveDHLFieldsInQuote()
    {
        Mage::app()->getRequest()->setParam('shipping',
            array('dhl_station_type' => 'Stationtyp', 'dhl_post_number' => 'Postnumber', 'dhl_station' => 'Station')
        );

        $modelMock = $this->getModelMock('sales/quote_address', array('save'));
        $modelMock->expects($this->once())
                  ->method('save')
                  ->will($this->returnSelf());
        $this->replaceByMock('model', 'sales/quote_address', $modelMock);

        $observer = new Varien_Event_Observer();
        $quote    = new Varien_Object();
        $quote->setData('shipping_address', Mage::getModel('sales/quote_address'));

        $observer->setData('quote', $quote);

        $observerModel = new Dhl_LocationFinder_Model_Observer();
        $observerModel->saveDHLFieldsInQuote($observer);

        $changedObject = $observer->getData('quote')->getShippingAddress()->getData();

        $this->assertArrayHasKey('dhl_station_type', $changedObject);
    }

    /**
     * @test
     */
    public function saveDHLFieldsInPostalFacility()
    {
        $observer       = new Varien_Event_Observer();
        $postalFacility = $quoteAddress = new Varien_Object();

        $quoteAddress->setData(
            array(
                'dhl_station_type' => 'Stationtyp',
                'dhl_post_number'  => 'Postnumber',
                'dhl_station'      => 'Station'
            )
        );

        $observer->setData('postal_facility', $postalFacility);
        $observer->setData('quote_address', $quoteAddress);

        $observerModel = new Dhl_LocationFinder_Model_Observer();
        $observerModel->saveDHLFieldsInPostalFacility($observer);

        $changedObject = $observer->getData('postal_facility')->getData();

        $this->assertArrayHasKey('shop_type', $changedObject);

        // negative case
        $observer->getData('quote_address')->setData('dhl_station_type', false);
        $observer->setData('postal_facility', new Varien_Object());

        $observerModel->saveDHLFieldsInPostalFacility($observer);

        $changedObject = $observer->getData('postal_facility')->getData();

        $this->assertArrayNotHasKey('shop_type', $changedObject);
    }

}
