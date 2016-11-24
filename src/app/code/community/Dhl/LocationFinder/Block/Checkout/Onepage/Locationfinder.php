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
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
use \Netresearch\Dhl\LocationFinder\ParcelLocation;

/**
 * Dhl_LocationFinder_Block_Checkout_Onepage_Locationfinder
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
class Dhl_LocationFinder_Block_Checkout_Onepage_Locationfinder
    extends Mage_Core_Block_Template
{
    /**
     * Get the Url for the Controller
     *
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('dhlpsf/facilities');
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
        foreach (array_keys($allowedCountries) as $countryId) {
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
     * Obtain skin images per location type.
     *
     * @return string[]
     */
    public function getMarkerIcons()
    {
        $shopTypes = array_combine(
            ParcelLocation\Item::getLocationTypes(),
            ParcelLocation\Item::getLocationTypes()
        );

        $getSkinImages = function ($shopType) {
            $file = sprintf('images/dhl_locationfinder/icon-%s.png', $shopType);
            return $this->getSkinUrl($file);
        };
        $icons = array_map($getSkinImages, $shopTypes);

        return $icons;
    }

    /**
     * Compare all allowed countries with the enabled ones from DHL and get the result
     *
     * @return array
     */
    protected function getAllowedCountriesForLocationFinder()
    {
        $allowedDhlCountries     = Mage::getModel('dhl_locationfinder/config')->getWsValidCountries();
        $allowedMagentoCountries = array_flip(explode(',', Mage::getStoreConfig('general/country/allow')));

        return array_intersect_key($allowedDhlCountries, $allowedMagentoCountries);
    }
}
