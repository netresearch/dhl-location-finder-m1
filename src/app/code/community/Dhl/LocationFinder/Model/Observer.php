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
 * Dhl_LocationFinder_Model_Observer
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
class Dhl_LocationFinder_Model_Observer
{
    /**
     * Register autoloader in order to locate the extension libraries.
     */
    public function registerAutoload()
    {
        if (!Mage::getModel('dhl_locationfinder/config')->isAutoloadEnabled()) {
            return;
        }

        $autoloader = Mage::helper('dhl_locationfinder/autoloader');

        $dhlLibs = array('LocationFinder', 'Psf');
        array_walk($dhlLibs,
            function($libDir) use ($autoloader) {
                $autoloader->addNamespace(
                    "Dhl\\$libDir\\", // prefix
                    sprintf('%s/Dhl/%s/', Mage::getBaseDir('lib'), $libDir) // baseDir
                );
            }
        );

        $autoloader->register();
    }

    /**
     * Append CTA Parcel Store Finder to html output.
     *
     * @param Varien_Event_Observer $observer
     *
     * @event core_block_abstract_to_html_after
     *
     * @return void
     */
    public function appendLocationFinderToShipping(Varien_Event_Observer $observer)
    {
        $block = $observer->getData('block');
        if ($block instanceof Mage_Checkout_Block_Onepage_Shipping) {
            $transport = $observer->getData('transport');
            $layout    = $block->getLayout();
            $html      = $transport->getHtml();

            /** @var Dhl_LocationFinder_Block_Checkout_Onepage_Locationfinder $locationFinder */
            $locationFinder = $layout->createBlock(
                'dhl_locationfinder/checkout_onepage_locationfinder',
                'onepage_locationfinder',
                array(
                    'template' => 'dhl_locationfinder/checkout/onepage/locationfinder.phtml',
                )
            );

            $transport->setHtml($html . $locationFinder->toHtml());
        }
    }

    /**
     * Append new DHL fields into quote address
     *
     * @param Varien_Event_Observer $observer
     *
     * @event sales_quote_save_before
     *
     * @return void
     */
    public function saveDHLFieldsInQuote(Varien_Event_Observer $observer)
    {
        $shippingData = Mage::app()->getRequest()->getParam('shipping');
        if (!empty($shippingData)) {
            /** @var Mage_Sales_Model_Quote $quote */
            $quote  = $observer->getData('quote');

            $shippingAddress = $quote->getShippingAddress();

            $stationIdCode = Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER;
            if (isset($shippingData[$stationIdCode])) {
                $stationId = preg_filter('/^.*([\d]{3})$/', '$1', $shippingData[$stationIdCode]);
                $shippingAddress->setData($stationIdCode, $stationId);
            } elseif ($shippingAddress->getData($stationIdCode)) {
                $shippingAddress->setData($stationIdCode, null);
            }

            $postNumberCode = Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER;
            if (isset($shippingData[$postNumberCode])) {
                $shippingAddress->setData($postNumberCode, $shippingData[$postNumberCode]);
            } elseif ($shippingAddress->getData($postNumberCode)) {
                $shippingAddress->setData($postNumberCode, null);
            }

            $stationTypeCode = Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE;
            if (isset($shippingData[$stationTypeCode])) {
                $shippingAddress->setData($stationTypeCode, $shippingData[$stationTypeCode]);
            } elseif ($shippingAddress->getData($stationTypeCode)) {
                $shippingAddress->setData($stationTypeCode, null);
            }
        }
    }

    /**
     * Load the additional address fields for use by dispatcher.
     * - event: dhl_versenden_fetch_postal_facility
     *
     * @param Varien_Event_Observer $observer
     */
    public function loadPostalFacilityFields(Varien_Event_Observer $observer)
    {
        /** @var Varien_Object $facility */
        $facility = $observer->getData('postal_facility');
        /** @var Mage_Sales_Model_Quote_Address | Mage_Sales_Model_Order_Address $address */
        $address  = $observer->getData('customer_address');

        if ($facility->hasData()) {
            // someone else already set a facility, we assume they know what they did.
            return;
        }

        $shopType = $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE);
        $shopNumber = $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER);
        $postNumber = $address->getData(Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER);

        if ($shopType) {
            $facility->setData('shop_type', $shopType);
            $facility->setData('shop_number', preg_filter('/^.*([\d]{3})$/', '$1', $shopNumber));
            $facility->setData('post_number', $postNumber);
        }
    }

    /**
     * Save postal facility data as announced by dispatcher.
     * - event: dhl_versenden_announce_postal_facility
     *
     * @param Varien_Event_Observer $observer
     */
    public function updatePostalFacilityFields(Varien_Event_Observer $observer)
    {
        /** @var Varien_Object $facility */
        $facility = $observer->getData('postal_facility');
        /** @var Mage_Sales_Model_Quote_Address|Mage_Sales_Model_Order_Address $address */
        $address = $observer->getData('customer_address');

        $address->setData(
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_TYPE,
            $facility->getData('shop_type')
        );
        $address->setData(
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_STATION_NUMBER,
            $facility->getData('shop_number')
        );
        $address->setData(
            Dhl_LocationFinder_Model_Resource_Setup::ATTRIBUTE_CODE_POST_NUMBER,
            $facility->getData('post_number')
        );

        $address->save();
    }

    /**
     * Translate the station type string
     * - event: customer_address_format
     *
     * @param Varien_Event_Observer $observer
     */
    public function translateStationtype(Varien_Event_Observer $observer)
    {
        $address = $observer->getData('address');
        $stationType = Mage::helper('dhl_locationfinder/data')->__($address->getData('dhl_station_type'));
        $address->setData('dhl_station_type', $stationType);
    }


    /**
     * Add the Postnumber Label
     * - event: customer_address_format
     *
     * @param Varien_Event_Observer $observer
     */
    public function addPostNumberLabel(Varien_Event_Observer $observer)
    {
        $address = $observer->getData('address');
        if ($address->getData('dhl_post_number')) {
            $postNumberLabel = Mage::helper('dhl_locationfinder/data')->__('Postnumber: ');
            $postNumberString = $postNumberLabel . $address->getData('dhl_post_number');
            $address->setData('dhl_post_number', $postNumberString);
        }
    }
}
