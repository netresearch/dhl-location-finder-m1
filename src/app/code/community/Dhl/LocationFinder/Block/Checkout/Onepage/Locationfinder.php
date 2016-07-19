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
use \Dhl\Psf\Api as LocationsApi;

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
class Dhl_LocationFinder_Block_Checkout_Onepage_Locationfinder
    extends Mage_Core_Block_Template
{

    /**
     * Initialize the library class
     */
    protected function _construct()
    {
        parent::_construct();

        $libDir        = Mage::app()->getConfig()->getOptions()->getLibDir();
        $autoLoaderDir = 'Dhl/Psf/Api/autoload.php';
        require_once $libDir . DS . $autoLoaderDir;
    }

    /**
     * Add the script for the selected map to the head
     *
     * @return Mage_Page_Block_Html_Head
     */
    public function addMapToCheckout()
    {
        /** @var Mage_Page_Block_Html_Head $head */
        $head = $this->getHeadBlock();
        /** @var Dhl_LocationFinder_Model_Config $configModel */
        $configModel = Mage::getSingleton('dhl_locationfinder/config');

        if ($configModel->getIsModuleActive()) {

            $externalBlock = $this->getLayout()->createBlock('core/text', 'mapForCheckout');
            switch ($configModel->getCurrentMapProvider()) {

                case Dhl_LocationFinder_Model_Adminhtml_System_Config_Source_Maptype::MAP_TYPE_GOOGLE:
                default:
                    $includeString =
                        '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>';
                    if ($configModel->getWillJQueryIncluded()) {
                        $includeString .=
                            '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
                        $includeString .= '<script type="text/javascript">var $j = jQuery.noConflict();</script>';
                    }
                    $includeString .= '<script type="text/javascript" src="' . Mage::getBaseUrl('js')
                        . 'googlemaps/store-locator.min.js"></script>';

                    $externalBlock->setText($includeString);
                    $head->addItem('css', 'googlemaps/storelocator.css');
                    break;
            }
            $head->setChild('mapForCheckout', $externalBlock);
        }

        return $head;
    }

    /**
     * Get the Url for the Controller
     *
     * @return string
     */
    public function getActionUrl()
    {
        return Mage::getBaseUrl() . Dhl_LocationFinder_Model_Config::URL_PATH_FACILITY_CONTROLLER;
    }

    /**
     * Get the select options for the location finder form
     *
     * @param string $formName
     *
     * @return string
     */
    public function getCountrySelect($formName)
    {
        $allowedCountries = $this->getAllowedCountriesForLocationFinder();
        $defaultCountry   = Mage::getStoreConfig('general/country/default');

        // Translate the countries
        foreach ($allowedCountries as $countryId => $allowedCountry) {
            $allowedCountries[$countryId] = Mage::app()->getLocale()->getCountryTranslation($countryId);
        }

        $select = $this->getLayout()->createBlock('core/html_select')
                       ->setName($formName . '[country]')
                       ->setId($formName . '-country')
                       ->setTitle(Mage::helper('checkout')->__('Country'))
                       ->setOptions($allowedCountries);

        if (array_key_exists($defaultCountry, $allowedCountries)) {
            $select->setValue($defaultCountry);
        }

        return $select->getHtml();
    }

    /**
     * @param string $shopType
     *
     * @return string
     */
    public function getMarkerIconForShopType($shopType)
    {
        return $this->getSkinUrl('images/dhl_locationfinder/icon-' . $shopType . '.png', array('_secure' => true));
    }

    /**
     * Compare all allowed countries with the enabled ones from DHL and get the result
     *
     * @return array
     */
    protected function getAllowedCountriesForLocationFinder()
    {
        $allowedDhlCountriesClass = new LocationsApi\allowedCountries();
        $allowedDhlCountries      = $allowedDhlCountriesClass->getCountries();
        $allowedMagentoCountries  = array_flip(explode(',', Mage::getStoreConfig('general/country/allow')));

        return array_intersect_key($allowedDhlCountries, $allowedMagentoCountries);
    }

    /**
     * Get the Head Block for Layout adaptions
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function getHeadBlock()
    {
        return $this->getLayout()->getBlock('head');
    }
}
