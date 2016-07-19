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
class Dhl_LocationFinder_Model_Config
{
    const CONFIG_XML_PATH_WS_AUTH_USER       = 'dhl_locationfinder/webservice/auth_username';
    const CONFIG_XML_PATH_WS_AUTH_PASS       = 'dhl_locationfinder/webservice/auth_password';
    const CONFIG_XML_PATH_DHL_PSF_ENABLED    = 'dhl/dhl_locationfinder/enable_location_finder';
    const CONFIG_XML_PATH_DHL_MAP_TYPE       = 'dhl/dhl_locationfinder/map_type';
    const CONFIG_XML_PATH_DHL_INCLUDE_JQUERY = 'dhl/dhl_locationfinder/include_jquery';
    const URL_PATH_FACILITY_CONTROLLER       = 'dhlpsf/facilities/';

    /**
     * Obtain username for HTTP Basic Auth
     *
     * @param mixed $store
     *
     * @return string
     */
    public function getWsAuthUser($store = null)
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_WS_AUTH_USER, $store);
    }

    /**
     * Obtain password for HTTP Basic Auth
     *
     * @param mixed $store
     *
     * @return string
     */
    public function getWsAuthPass($store = null)
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_WS_AUTH_PASS, $store);
    }

    /**
     * Check, if module is active
     *
     * @param mixed $store
     *
     * @return string
     */
    public function getIsModuleActive($store = null)
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_DHL_PSF_ENABLED, $store);
    }

    /**
     * Obtain Map provider for the location finder
     *
     * @param mixed $store
     *
     * @return string
     */
    public function getCurrentMapProvider($store = null)
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_DHL_MAP_TYPE, $store);
    }

    /**
     * Check if jQuery has to be includes (used by the google store locator)
     *
     * @param mixed $store
     *
     * @return string
     */
    public function getWillJQueryIncluded($store = null)
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_DHL_INCLUDE_JQUERY, $store);
    }
}
