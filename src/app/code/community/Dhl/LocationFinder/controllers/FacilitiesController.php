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
        $billingAddress = $this->getRequest()->getParam('billing');
        //if no billing exist, it should be a test call
        if ($billingAddress) {
            $soapAddress = '';
            isset($billingAddress['postcode']) ? $soapAddress .= $billingAddress['postcode'] : null;
            isset($billingAddress['city']) ? $soapAddress .= ' ' . $billingAddress['city'] : null;
            isset($billingAddress['street'][0]) ? $soapAddress .= ' ' . $billingAddress['street'][0] : null;
            isset($billingAddress['country_id']) ? $soapAddress .= ' ' . $billingAddress['country_id'] : null;
        } else {
            $soapAddress = '04229 Leipzig Nonnenstraße 11d Germany';
        }

        $service     = new LocationsApi\SoapServiceImplService(['trace' => true,]);
        $requestType = new LocationsApi\getParcellocationByAddress($soapAddress);

        try {
            $response  = $service->getParcellocationByAddress($requestType);
            $locations = $response->getParcelLocation();
            if ($locations) {
                foreach ($locations as $location) {
                    $mapLocation       = new stdClass();
                    $mapLocation->type = $location->getShopType();
                    $mapLocation->name = $location->getShopName();

                    $mapLocation->street  = $location->getStreet();
                    $mapLocation->houseNo = $location->getHouseNo();
                    $mapLocation->zipCode = $location->getZipCode();
                    $mapLocation->city    = $location->getCity();
                    $mapLocation->country = !empty($billingAddress) ? $billingAddress['country_id'] : 'DE';

//            $mapLocation->timeInfo = $location->getPsfTimeinfos();
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
