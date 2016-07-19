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
use \Dhl\LocationFinder\ParcelLocation\Collection as ParcelLocationCollection;
use \Dhl\LocationFinder\ParcelLocation\Item as ParcelLocation;
use \Dhl\LocationFinder\Webservice;
use \Dhl\LocationFinder\Webservice\Parser\Location as LocationParser;
use \Dhl\LocationFinder\Webservice\RequestData;
use \Dhl\Psf\Api as LocationsApi;
/**
 * Dhl_LocationFinder_Test_Model_WebserviceTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_WebserviceTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function getParcelLocationByAddress()
    {
        // TODO(nr): record response, do not actually call webservice from tests
        $soapClient = new LocationsApi\SoapServiceImplService([
            'trace' => true,
        ]);
        $parser = new LocationParser();
        $address = new RequestData\Address('de', '04229', 'Leipzig', 'Plagwitz', 'Nonnenstr.', '11d');

        $adapter = new Webservice\Adapter\Soap($soapClient);
        $result = $adapter->getParcelLocationByAddress($address, $parser);

        $this->assertInstanceOf(ParcelLocationCollection::class, $result);
        array_walk($result->getIterator()->getArrayCopy(), function (ParcelLocation $parcelLocation) {
            $this->assertNotEmpty($parcelLocation->getType());
        });
    }
}
