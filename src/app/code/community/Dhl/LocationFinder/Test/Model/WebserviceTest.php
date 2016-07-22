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
use \Dhl\LocationFinder\ParcelLocation\Limiter as ParcelLocationLimiter;
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
     * @dataProvider dataProvider
     *
     * @param string $serializedResponse
     */
    public function getParcelLocationByAddress($serializedResponse)
    {
        $response = unserialize($serializedResponse);

        $clientStub = $this->getMockBuilder(LocationsApi\SoapServiceImplService::class)
            ->setMethods(['getParcellocationByAddress'])
            ->getMock();
        $clientStub
            ->method('getParcellocationByAddress')
            ->willReturn($response)
        ;
        $parser = new LocationParser();
        $address = new RequestData\Address(['DE' => 'Germany'], 'de', '04229', 'Leipzig', 'Plagwitz', 'Nonnenstr.', '11d');

        $adapter = new Webservice\Adapter\Soap($clientStub);
        $result = $adapter->getParcelLocationByAddress($address, $parser);

        $this->assertInstanceOf(ParcelLocationCollection::class, $result);

        $parcelLocations = $result->getItems(
            null,
            new ParcelLocationLimiter(2)
        );
        array_walk($parcelLocations, function (ParcelLocation $parcelLocation) {
            $this->assertNotEmpty($parcelLocation->getType());
        });
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param string $serializedResponse
     */
    public function getParcelLocationByCoordinate($serializedResponse)
    {
        $response = unserialize($serializedResponse);

        $clientStub = $this->getMockBuilder(LocationsApi\SoapServiceImplService::class)
            ->setMethods(['getParcelLocationByCoordinate'])
            ->getMock();
        $clientStub
            ->method('getParcelLocationByCoordinate')
            ->willReturn($response)
        ;
        $parser = new LocationParser();
        $coordinate = new RequestData\Coordinate('51.34', '12.375');

        $adapter = new Webservice\Adapter\Soap($clientStub);
        $result = $adapter->getParcelLocationByCoordinate($coordinate, $parser);

        $this->assertInstanceOf(ParcelLocationCollection::class, $result);

        $parcelLocations = $result->getItems(
            null,
            new ParcelLocationLimiter(2)
        );
        array_walk($parcelLocations, function (ParcelLocation $parcelLocation) {
            $this->assertNotEmpty($parcelLocation->getType());
        });
    }
}
