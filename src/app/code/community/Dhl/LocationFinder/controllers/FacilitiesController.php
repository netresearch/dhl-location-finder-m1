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
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_FacilitiesController extends Mage_Core_Controller_Front_Action
{
    protected function _construct()
    {
        parent::_construct();

        $libDir = Mage::app()->getConfig()->getOptions()->getLibDir();
        $autoloaderDir = 'Dhl/Psf/Api/autoload.php';
        require_once $libDir . DS . $autoloaderDir;
    }

    public function indexAction()
    {
        $mapLocations = [];

        $service = new LocationsApi\SoapServiceImplService([
            'trace' => true,
        ]);
        $requestType = new LocationsApi\getParcellocationByAddress("04229 Leipzig Nonnenstraße 11d Germany");
        $response = $service->getParcellocationByAddress($requestType);
        $locations = $response->getParcelLocation();
        foreach ($locations as $location) {
            $mapLocation = new stdClass();
            $mapLocation->type = $location->getShopType();
            $mapLocation->name = $location->getShopName();

            $mapLocation->street = $location->getStreet();
            $mapLocation->houseNo = $location->getHouseNo();
            $mapLocation->zipCode = $location->getZipCode();
            $mapLocation->city = $location->getCity();

//            $mapLocation->timeInfo = $location->getPsfTimeinfos();

            $mapLocations[]= $mapLocation;
        }

        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core/data')->jsonEncode($mapLocations));
    }
}
