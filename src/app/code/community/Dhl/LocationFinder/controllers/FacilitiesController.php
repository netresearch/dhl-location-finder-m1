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
class Dhl_LocationFinder_FacilitiesController
    extends Mage_Core_Controller_Front_Action
{
    protected function _construct()
    {
        parent::_construct();

        $libDir        = Mage::app()->getConfig()->getOptions()->getLibDir();
        $autoLoaderDir = 'Dhl/Psf/Api/autoload.php';
        require_once $libDir . DS . $autoLoaderDir;
    }

    public function indexAction()
    {
        $mapLocations = [];
        $success      = false;
        $message      = '';

        // Build Address Data from Billing Form
        $searchAddress = $this->getRequest()->getParam('locationfinder');

        // Use required string for searched country
        $allowedCountries = new LocationsApi\allowedCountries();
        $allowedCountries = $allowedCountries->getCountries();

        $soapAddress = '';
        isset($searchAddress['country']) ? $soapAddress .= $allowedCountries[$searchAddress['country']]
            : null;
        isset($searchAddress['city']) ? $soapAddress .= ' ' . $searchAddress['city'] : null;
        isset($searchAddress['zipcode']) ? $soapAddress .= ' ' . $searchAddress['zipcode'] : null;
        isset($searchAddress['street']) ? $soapAddress .= ' ' . $searchAddress['street'] : null;

        if ($soapAddress != '') {

            $service     = new LocationsApi\SoapServiceImplService(['trace' => true,]);
            $requestType = new LocationsApi\getParcellocationByAddress($soapAddress);

            try {
                $response  = $service->getParcellocationByAddress($requestType);
                $locations = $response->getParcelLocation();
                if ($locations) {

                    // Get Icons for the store marker
                    /** @var Dhl_LocationFinder_Block_Checkout_Onepage_Locationfinder $locationBlock */
                    $locationBlock = Mage::getBlockSingleton('dhl_locationfinder/checkout_onepage_locationfinder');

                    foreach ($locations as $location) {
                        $mapLocation       = new stdClass();
                        $mapLocation->type = $location->getShopType();
                        $mapLocation->name = $location->getShopName();
                        $mapLocation->icon = $locationBlock->getMarkerIconForShopType($location->getShopType());

                        $mapLocation->street  = $location->getStreet();
                        $mapLocation->houseNo = $location->getHouseNo();
                        $mapLocation->zipCode = $location->getZipCode();
                        $mapLocation->city    = $location->getCity();
                        $mapLocation->country = strtoupper($location->getCountryCode());
                        $mapLocation->id      = $location->getPrimaryKeyDeliverySystem();

                        $coordinates       = $location->getLocation();
                        $mapLocation->lat  = $coordinates->getLatitude();
                        $mapLocation->long = $coordinates->getLongitude();

                        $mapLocations[] = $mapLocation;
                    }
                    $success = true;
                } else {
                    $message = $this->__('We could not find any stores in your area.');
                }
            } catch (SoapFault $sf) {
                // DHL got an unknown Address
                $message = $sf->getMessage();
            }
        } else {
            $message = $this->__('Please enter a valid address.');
        }

        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()
             ->setBody(Mage::helper('core/data')
                           ->jsonEncode(['success'   => $success,
                                         'message'   => $message,
                                         'locations' => $mapLocations]
                           )
             );
    }
}
