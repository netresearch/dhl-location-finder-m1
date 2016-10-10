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

/**
 * Dhl_LocationFinder_Test_Model_ObserverTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_ObserverTest
    extends EcomDev_PHPUnit_Test_Case
{
    protected function setUp()
    {
        $sessionMock = $this->getModelMock('core/session', array('init'));
        $this->replaceByMock('singleton', 'core/session', $sessionMock);
    }

    /**
     * @test
     * @loadFixture
     */
    public function registerAutoloadDisabled()
    {
        $helperMock = $this->getHelperMock('dhl_locationfinder/autoloader', array('register'));
        $helperMock
            ->expects($this->never())
            ->method('register');
        $this->replaceByMock('helper', 'dhl_locationfinder/autoloader', $helperMock);

        $observer = new Dhl_LocationFinder_Model_Observer();
        $observer->registerAutoload();
    }

    /**
     * @test
     * @loadFixture
     */
    public function registerAutoloadEnabled()
    {
        $helperMock = $this->getHelperMock('dhl_locationfinder/autoloader', array('register'));
        $helperMock
            ->expects($this->once())
            ->method('register');
        $this->replaceByMock('helper', 'dhl_locationfinder/autoloader', $helperMock);

        $observer = new Dhl_LocationFinder_Model_Observer();
        $observer->registerAutoload();
    }

    /**
     * @test
     * @loadFixture ../../ConfigTest/fixtures/ConfigTest
     */
    public function appendLocationFinderToShipping()
    {
        $this->setCurrentStore('store_one');

        $originalMarkup = '<div id="checkout-step-shipping" class="step">foo</div>';

        $blockMock = $this->getBlockMock('checkout/onepage_shipping', array('getCheckout'), false, array(), '', false);
        $this->replaceByMock('block', 'checkout/onepage_shipping', $blockMock);

        $block     = Mage::app()->getLayout()->createBlock('checkout/onepage_shipping');
        $transport = new Varien_Object();
        $transport->setData('html', $originalMarkup);

        $observer = new Varien_Event_Observer();
        $observer->setData('block', $block);
        $observer->setData('transport', $transport);

        // before observer, shipping address does not contain map
        $this->assertNotContains('map-canvas', $transport->getData('html'));

        $dhlObserver = new Dhl_LocationFinder_Model_Observer();
        $dhlObserver->appendLocationFinderToShipping($observer);

        // after observer, shipping address contains map
        $this->assertContains('map-canvas', $transport->getData('html'));
        $this->assertStringStartsWith($originalMarkup, $transport->getData('html'));
    }

    /**
     * @test
     */
    public function saveDHLFieldsInQuote()
    {
        $stationType = 'Station Type';
        $stationId = '123';
        $station = "$stationType $stationId";
        $postNumber = 'Post Number';

        $postData = array(
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE   => $stationType,
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER => $station,
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER    => $postNumber,
        );
        Mage::app()->getRequest()->setParam('shipping', $postData);

        $quote = new Varien_Object();
        $quote->setData('shipping_address', Mage::getModel('sales/quote_address'));

        $observer = new Varien_Event_Observer();
        $observer->setData('quote', $quote);

        $dhlObserver = new Dhl_LocationFinder_Model_Observer();
        $dhlObserver->saveDHLFieldsInQuote($observer);

        /** @var Mage_Sales_Model_Quote_Address $address */
        $address = $quote->getData('shipping_address');
        $this->assertEquals(
            $stationType,
            $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE)
        );
        $this->assertEquals(
            $stationId,
            $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER)
        );
        $this->assertEquals(
            $postNumber,
            $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER)
        );
    }

    /**
     * Shift data from customer address to postal facility transport object
     *
     * @test
     */
    public function loadPostalFacilityFields()
    {
        $stationType = 'Station Type';
        $stationId = '123';
        $station = "$stationType $stationId";
        $postNumber = 'Post Number';

        $postalFacility = new Varien_Object();

        $addressData = array(
            'dhl_station_type' => $stationType,
            'dhl_post_number'  => $postNumber,
            'dhl_station'      => $station,
        );
        $address = new Varien_Object($addressData);

        $observer = new Varien_Event_Observer();
        $observer->setData('postal_facility', $postalFacility);
        $observer->setData('customer_address', $address);

        $dhlObserver = new Dhl_LocationFinder_Model_Observer();
        $dhlObserver->loadPostalFacilityFields($observer);

        $this->assertArrayHasKey('shop_type', $postalFacility->getData());
        $this->assertEquals($stationType, $postalFacility->getData('shop_type'));
        $this->assertArrayHasKey('shop_number', $postalFacility->getData());
        $this->assertEquals($stationId, $postalFacility->getData('shop_number'));
        $this->assertArrayHasKey('post_number', $postalFacility->getData());
        $this->assertEquals($postNumber, $postalFacility->getData('post_number'));
    }

    /**
     * Shift data from customer address to postal facility transport object
     *
     * @test
     */
    public function loadPostalFacilityFieldsAlreadySet()
    {
        $stationType = 'Station Type';
        $stationId = '123';
        $station = "$stationType $stationId";
        $postNumber = 'Post Number';

        $postalFacilityData = array('foo' => 'bar');
        $postalFacility = new Varien_Object($postalFacilityData);

        $addressData = array(
            'dhl_station_type' => $stationType,
            'dhl_post_number'  => $postNumber,
            'dhl_station'      => $station,
        );
        $address = new Varien_Object($addressData);

        $observer = new Varien_Event_Observer();
        $observer->setData('postal_facility', $postalFacility);
        $observer->setData('customer_address', $address);

        $dhlObserver = new Dhl_LocationFinder_Model_Observer();
        $dhlObserver->loadPostalFacilityFields($observer);

        $this->assertArrayNotHasKey('shop_type', $postalFacility->getData());
        $this->assertArrayNotHasKey('shop_number', $postalFacility->getData());
        $this->assertArrayNotHasKey('post_number', $postalFacility->getData());
    }

    /**
     * @test
     */
    public function loadPostalFacilityFieldsNoStation()
    {
        $observer       = new Varien_Event_Observer();
        $postalFacility = new Varien_Object();
        $address        = new Varien_Object();

        $observer->setData('postal_facility', $postalFacility);
        $observer->setData('customer_address', $address);

        $dhlObserver = new Dhl_LocationFinder_Model_Observer();
        $dhlObserver->loadPostalFacilityFields($observer);

        $this->assertArrayNotHasKey('shop_type', $postalFacility->getData());
        $this->assertArrayNotHasKey('shop_number', $postalFacility->getData());
        $this->assertArrayNotHasKey('post_number', $postalFacility->getData());
    }

    /**
     * Shift data from postal facility transport object to customer address
     *
     * @test
     */
    public function updatePostalFacilityFields()
    {
        $addressMock = $this->getModelMock('sales/order_address', array('save'));
        $this->replaceByMock('model', 'sales/order_address', $addressMock);

        $postalFacilityData = array(
            'shop_type'   => 'Stationtyp',
            'post_number' => 'Postnumber',
            'shop_number' => 'DHL Station'
        );
        $postalFacility = new Varien_Object($postalFacilityData);

        $orderAddress = Mage::getModel('sales/order_address');

        $observer = new Varien_Event_Observer();
        $observer->setData('postal_facility', $postalFacility);
        $observer->setData('customer_address', $orderAddress);

        $observerModel = new Dhl_LocationFinder_Model_Observer();
        $observerModel->updatePostalFacilityFields($observer);

        $this->assertArrayHasKey('dhl_station_type', $orderAddress->getData());
        $this->assertEquals($postalFacilityData['shop_type'], $orderAddress->getData('dhl_station_type'));
        $this->assertArrayHasKey('dhl_station', $orderAddress->getData());
        $this->assertEquals($postalFacilityData['shop_number'], $orderAddress->getData('dhl_station'));
        $this->assertArrayHasKey('dhl_post_number', $orderAddress->getData());
        $this->assertEquals($postalFacilityData['post_number'], $orderAddress->getData('dhl_post_number'));
    }
}
