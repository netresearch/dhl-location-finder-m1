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
 * Dhl_LocationFinder_Model_Config
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
        if ($block instanceof Mage_Checkout_Block_Onepage_Shipping
            && false == $block instanceof Mage_Paypal_Block_Express_Review_Shipping
            && Mage::getSingleton('dhl_locationfinder/config')->getIsModuleActive()
        ) {
            $transport = $observer->getData('transport');
            $layout    = $block->getLayout();
            $html      = $transport->getHtml();
            /** @var string $parcelFinderHtml */
            $locationFinderHtml =
                $layout->createBlock('dhl_locationfinder/checkout_onepage_locationfinder', 'onepage_locationfinder')
                       ->setTemplate('dhl_locationfinder/checkout/onepage/locationfinder.phtml')
                       ->renderView();
            $html .= $locationFinderHtml;
            $transport->setHtml($html);
        }
    }
}
