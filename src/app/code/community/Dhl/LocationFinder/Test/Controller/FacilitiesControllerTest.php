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
use \Dhl\LocationFinder\ParcelLocation;
use \Dhl\LocationFinder\Webservice\Adapter\Soap as SoapAdapter;
use \Dhl\LocationFinder\Webservice\RequestData;
/**
 * Dhl_LocationFinder_Test_Controller_FacilitiesControllerTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Controller_FacilitiesControllerTest
    extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Mock logger, do not actually write to disk.
     */
    protected function setUp()
    {
        parent::setUp();

        $loggerMock = $this->getModelMock('dhl_locationfinder/logger');
        $this->replaceByMock('model', 'dhl_locationfinder/logger', $loggerMock);
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function httpGetAccess()
    {
        $this->dispatch('dhlpsf/facilities/index');
        $this->assertRequestRoute('cms/index/noRoute');
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function retrieveEmptyResult()
    {
        $collection = new ParcelLocation\Collection();

        $adapterMock = $this->getMockBuilder(SoapAdapter::class)
            ->setMethods(['getParcelLocationByAddress'])
            ->disableOriginalConstructor()
            ->getMock();
        $adapterMock
            ->method('getParcelLocationByAddress')
            ->willReturn($collection)
        ;

        $helperMock = $this->getHelperMock('dhl_locationfinder/data', array('getWebserviceAdapter'));
        $helperMock
            ->expects($this->once())
            ->method('getWebserviceAdapter')
            ->willReturn($adapterMock);
        $this->replaceByMock('helper', 'dhl_locationfinder/data', $helperMock);


        $this->getRequest()->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->dispatch('dhlpsf/facilities/index', array(
            '_query' => array(
                'locationfinder' => array(
                    'country' => 'DE',
                    'zipcode' => '04229',
                    'city' => 'Leipzig',
                    'street' => 'Nonnenstraße 11d',
                )
            )
        ));

        $this->assertRequestRoute('dhl_locationfinder/facilities/index');
        $this->assertResponseBodyJson();

        $jsonResponse = $this->getResponse()->getOutputBody();
        $response = json_decode($jsonResponse);
        $this->assertFalse($response->success);
        $this->assertEquals(Dhl_LocationFinder_FacilitiesController::MSG_EMPTY_RESULT, $response->message);
        $this->assertEmpty($response->locations);
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function addressUnknownException()
    {
        $faultCode = 'S:Server';
        $faultString = 'Unknown address.';
        $fault = new \SoapFault($faultCode, $faultString);
        $adapterMock = $this->getMockBuilder(SoapAdapter::class)
            ->setMethods(['getParcelLocationByAddress', 'getLastRequest', 'getLastResponse'])
            ->disableOriginalConstructor()
            ->getMock();
        $adapterMock
            ->method('getParcelLocationByAddress')
            ->willThrowException($fault);

        $helperMock = $this->getHelperMock('dhl_locationfinder/data', array('getWebserviceAdapter'));
        $helperMock
            ->expects($this->once())
            ->method('getWebserviceAdapter')
            ->willReturn($adapterMock);
        $this->replaceByMock('helper', 'dhl_locationfinder/data', $helperMock);

        $this->getRequest()->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->dispatch('dhlpsf/facilities/index', array(
            '_query' => array(
                'locationfinder' => array(
                    'country' => 'DE',
                    'zipcode' => '33602',
                    'city' => 'Bielefeld',
                    'street' => 'Adenauerplatz 1',
                )
            )
        ));

        $this->assertRequestRoute('dhl_locationfinder/facilities/index');
        $this->assertResponseBodyJson();

        $jsonResponse = $this->getResponse()->getOutputBody();
        $response = json_decode($jsonResponse);
        $this->assertFalse($response->success);
        $this->assertEquals($faultString, $response->message);
        $this->assertEmpty($response->locations);
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function addressWrongCountryException()
    {
        $country = 'XX';

        $this->getRequest()->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->dispatch('dhlpsf/facilities/index', array(
            '_query' => array(
                'locationfinder' => array(
                    'country' => $country,
                    'zipcode' => '',
                    'city' => '',
                    'street' => '',
                )
            )
        ));

        $this->assertRequestRoute('dhl_locationfinder/facilities/index');
        $this->assertResponseBodyJson();

        $jsonResponse = $this->getResponse()->getOutputBody();
        $response = json_decode($jsonResponse);
        $this->assertFalse($response->success);
        $errorMsg = sprintf(RequestData\Address::MSG_INVALID_COUNTRY, $country);
        $this->assertEquals($errorMsg, $response->message);
        $this->assertEmpty($response->locations);
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function addressInsufficientException()
    {
        $this->getRequest()->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->dispatch('dhlpsf/facilities/index', array(
            '_query' => array(
                'locationfinder' => array(
                    'country' => '',
                    'zipcode' => '',
                    'city' => '',
                    'street' => '',
                )
            )
        ));

        $this->assertRequestRoute('dhl_locationfinder/facilities/index');
        $this->assertResponseBodyJson();

        $jsonResponse = $this->getResponse()->getOutputBody();
        $response = json_decode($jsonResponse);
        $this->assertFalse($response->success);
        $this->assertEquals(RequestData\Address::MSG_INVALID_ADDRESS, $response->message);
        $this->assertEmpty($response->locations);
    }

    /**
     * @test
     * @loadFixture ControllerTest
     */
    public function unknownException()
    {
        $adapterMock = $this->getMockBuilder(SoapAdapter::class)
            ->setMethods(['getParcelLocationByAddress'])
            ->disableOriginalConstructor()
            ->getMock();
        $adapterMock
            ->method('getParcelLocationByAddress')
            ->willThrowException(new \Exception("I've got a bad feeling about this…"))
        ;

        $helperMock = $this->getHelperMock('dhl_locationfinder/data', array('getWebserviceAdapter'));
        $helperMock
            ->expects($this->once())
            ->method('getWebserviceAdapter')
            ->willReturn($adapterMock);
        $this->replaceByMock('helper', 'dhl_locationfinder/data', $helperMock);

        $this->getRequest()->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->dispatch('dhlpsf/facilities/index', array(
            '_query' => array(
                'locationfinder' => array(
                    'country' => 'DE',
                    'zipcode' => '04229',
                    'city' => 'Leipzig',
                    'street' => 'Nonnenstraße 11d',
                )
            )
        ));

        $this->assertResponseHttpCode(503);
    }
}
