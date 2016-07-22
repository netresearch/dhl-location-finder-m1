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
use \Dhl\LocationFinder\Webservice\Adapter as AdapterInterface;
use \Dhl\LocationFinder\Webservice\Adapter\Soap as WebserviceAdapter;
use \Dhl\Psf\Api as LocationsApi;

/**
 * Dhl_LocationFinder_Helper_Data
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Obtain the adapter that should perform the webservice requests
     *
     * @return AdapterInterface
     */
    public function getWebserviceAdapter()
    {
        $soapClient = new LocationsApi\SoapServiceImplService(
            [
            'trace' => true,
            ]
        );

        return new WebserviceAdapter($soapClient);
    }

    /**
     * Obtain the Google Maps API JS with API key appended.
     *
     * @return string
     */
    public function getMapJsUrl()
    {
        $jsUrl  = 'https://maps.googleapis.com/maps/api/js';

        $apiKey = Mage::getSingleton('dhl_locationfinder/config')->getApiKey();
        if ($apiKey) {
            $jsUrl = sprintf('%s?key=%s', $jsUrl, $apiKey);
        }

        return $jsUrl;
    }
}
