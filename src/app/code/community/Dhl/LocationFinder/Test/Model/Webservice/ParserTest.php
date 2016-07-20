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
use \Dhl\LocationFinder\Webservice\Parser\Location as LocationParser;
use \Dhl\LocationFinder\ParcelLocation\Collection as LocationCollection;
use \Dhl\LocationFinder\ParcelLocation\Item as Location;
/**
 * Dhl_LocationFinder_Test_Model_Webservice_ParserTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_Webservice_ParserTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     * @dataProvider dataProvider
     * @param $serializedResponse
     */
    public function parcelLocations($serializedResponse)
    {
        /** @var \Dhl\Psf\Api\psfParcellocation[] $psfLocations */
        $psfLocations = unserialize($serializedResponse);

        $parser = new LocationParser();
        $locationCollection = $parser->parse($psfLocations);
        $this->assertInstanceOf(LocationCollection::class, $locationCollection);
        $this->assertCount(3, $locationCollection);
        /** @var Location $location */
        foreach ($locationCollection as $location) {
            $this->assertNotEmpty($location->getType());
            // TODO(nr): how to obtain 3 digit station number from response?
//            $this->assertNotEmpty($location->getNumber());
            $this->assertNotEmpty($location->getName());
            $this->assertNotEmpty($location->getStation());
            $this->assertNotEmpty($location->getStreet());
            $this->assertNotEmpty($location->getHouseNo());
            $this->assertNotEmpty($location->getZipCode());
            $this->assertNotEmpty($location->getCity());
            $this->assertNotEmpty($location->getCountry());
            $this->assertNotEmpty($location->getId());
            $this->assertNotEmpty($location->getLatitude());
            $this->assertNotEmpty($location->getLongitude());
        }
    }
}
