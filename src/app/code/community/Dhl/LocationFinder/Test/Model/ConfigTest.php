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
 * Dhl_LocationFinder_Test_Model_ConfigTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_ConfigTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function isAutoloadEnabled()
    {
        $enabled = Mage::getModel('dhl_locationfinder/config')->isAutoloadEnabled();
        $this->assertTrue($enabled);
    }

    /**
     * @test
     * @loadFixture ConfigTest
     */
    public function getApiKey()
    {
        $key = Mage::getModel('dhl_locationfinder/config')->getApiKey();
        $this->assertEquals('foo', $key);

        $key = Mage::getModel('dhl_locationfinder/config')->getApiKey('store_one');
        $this->assertEquals('bar', $key);
    }

    /**
     * @test
     */
    public function getWsAuthUser()
    {
        $username = Mage::getModel('dhl_locationfinder/config')->getWsAuthUser();
        $this->assertInternalType('string', $username);
        $this->assertNotEmpty($username);
    }

    /**
     * @test
     */
    public function getWsAuthPass()
    {
        $password = Mage::getModel('dhl_locationfinder/config')->getWsAuthPass();
        $this->assertInternalType('string', $password);
        $this->assertNotEmpty($password);
    }

    /**
     * @test
     */
    public function getWsValidCountries()
    {
        $countries = Mage::getModel('dhl_locationfinder/config')->getWsValidCountries();
        foreach ($countries as $countryId => $country) {
            $this->assertInternalType('string', $countryId);
            $this->assertEquals(2, strlen($countryId));

            $this->assertInternalType('string', $country);
        }
    }

    /**
     * @test
     */
    public function getCurrentMapProvider()
    {
        $mapProvider = Mage::getModel('dhl_locationfinder/config')->getCurrentMapProvider();
        $this->assertInternalType('string', $mapProvider);
        $this->assertNotEmpty($mapProvider);
    }

    /**
     * @test
     */
    public function getResultsLimit()
    {
        $mapProvider = Mage::getModel('dhl_locationfinder/config')->getResultsLimit();
        $this->assertInternalType('int', $mapProvider);
        $this->assertNotEmpty($mapProvider);
    }

    /**
     * @test
     */
    public function getZoomMethod()
    {
        $mapProvider = Mage::getModel('dhl_locationfinder/config')->getZoomMethod();
        $this->assertInternalType('string', $mapProvider);
        $this->assertNotEmpty($mapProvider);
    }

    /**
     * @test
     */
    public function getZoomFactor()
    {
        $mapProvider = Mage::getModel('dhl_locationfinder/config')->getZoomFactor();
        $this->assertInternalType('int', $mapProvider);
        $this->assertNotEmpty($mapProvider);
    }
}
