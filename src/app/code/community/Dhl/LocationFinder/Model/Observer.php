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
        array_walk($dhlLibs, function($libDir) use ($autoloader) {
            $autoloader->addNamespace(
                "Dhl\\$libDir\\", // prefix
                sprintf('%s/Dhl/%s/', Mage::getBaseDir('lib'), $libDir) // baseDir
            );
        });

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
        if (!empty($shippingData) && isset($shippingData['dhl_station_type'])) {
            /** @var Mage_Sales_Model_Quote $quote */
            $quote           = $observer->getData('quote');
            $shippingAddress = $quote->getShippingAddress();
            $shippingAddress->setData('dhl_station_type', $shippingData['dhl_station_type']);
            $shippingAddress->setData('dhl_post_number', $shippingData['dhl_post_number']);
            $shippingAddress->setData('dhl_station', $shippingData['dhl_station']);
            $shippingAddress->save();
        }
    }

    /**
     * Append new DHL fields into postal facility for DHL Versenden
     *
     * @param Varien_Event_Observer $observer
     *
     * @event dhl_versenden_set_postal_facility
     *
     * @return void
     */
    public function saveDHLFieldsInPostalFacility(Varien_Event_Observer $observer)
    {
        /** @var Varien_Object $facility */
        $facility = $observer->getData('postal_facility');

        /** @var Mage_Sales_Model_Quote_Address $address */
        $address = $observer->getData('quote_address');

        if ($address->getData('dhl_station_type')) {
            $facility->setData(
                array(
                    'shop_type'   => $address->getData('dhl_station_type'),
                    'shop_number' => preg_filter('/^.*([\d]{3})$/', '$1', $address->getData('dhl_station')),
                    'post_number' => $address->getData('dhl_post_number') ? $address->getData('dhl_post_number') : '',
                )
            );
        }
    }

}
