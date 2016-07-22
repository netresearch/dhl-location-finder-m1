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
use \Dhl\LocationFinder\Webservice\RequestData;
/**
 * Dhl_LocationFinder_Test_Model_Webservice_RequestDataTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_Webservice_RequestDataTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function coordinates()
    {
        $lat = '33    ';
        $lng = '    44';
        $services = array(
            \Dhl\Psf\Api\service::ageVerification,
            \Dhl\Psf\Api\service::parking,
        );
        $flatServices = implode(', ', $services);

        $coordinate = new RequestData\Coordinate($lat, $lng, $services);
        $this->assertEquals(trim($lat), $coordinate->getLat());
        $this->assertEquals(trim($lng), $coordinate->getLng());
        $this->assertEquals($flatServices, $coordinate->getServices());
    }

    /**
     * @test
     */
    public function address()
    {
        $validCountries = ['AT' => 'Austria'];
        $street = 'myStreet';
        $houseNo = 'myHouseNo';
        $zipCode = 'myZip';
        $city = 'myCity';
        $district = 'myDistrict';
        $country = '    AT';
        $services = array(
            \Dhl\Psf\Api\service::ageVerification,
            \Dhl\Psf\Api\service::parking,
        );
        $flatAddress  = "$zipCode $city $district $street $houseNo Austria";
        $flatServices = implode(', ', $services);

        $address = new RequestData\Address($validCountries, $country, $zipCode, $city, $district, $street, $houseNo, $services);
        $this->assertEquals($flatAddress, $address->getAddress());
        $this->assertEquals($flatServices, $address->getServices());
    }

    /**
     * @test
     * @expectedException RequestData\AddressException
     */
    public function invalidCountry()
    {
        $this->setExpectedException(RequestData\AddressException::class);

        $country = 'myCountry';
        $address = new RequestData\Address(['FO' => 'Bar'], $country);
        $address->getAddress();
    }

    /**
     * @test
     */
    public function invalidAddress()
    {
        $this->setExpectedException(RequestData\AddressException::class);

        $address = new RequestData\Address(['FO' => 'Bar']);
        $address->getAddress();
    }
}
