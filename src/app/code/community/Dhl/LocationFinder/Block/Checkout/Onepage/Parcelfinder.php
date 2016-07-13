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
class Dhl_LocationFinder_Block_Checkout_Onepage_Parcelfinder
    extends Mage_Core_Block_Template
{

    public function addMapToCheckout()
    {
        /** @var Mage_Page_Block_Html_Head $head */
        $head = $this->getHeadBlock();
        /** @var Dhl_LocationFinder_Model_Config $configModel */
        $configModel = Mage::getSingleton('dhl_locationfinder/config');

        if ($configModel->getIsModuleActive()) {

            $externalBlock = $this->getLayout()->createBlock('core/text', 'addMapToCheckout');
            switch ($configModel->getCurrentMapProvider()) {

                case Dhl_LocationFinder_Model_Adminhtml_System_Config_Source_Maptype::MAP_TYPE_GOOGLE:
                    $externalBlock->setText(
                        '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>>'
                    );
                    break;
                default:
                    $externalBlock->setText(
                        '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>>'
                    );
                    break;
            }
            $head->setChild('mapForCheckout', $externalBlock);
        }

        return $head;
    }

    private function getHeadBlock()
    {
        return $this->getLayout()->getBlock('head');
    }

}
