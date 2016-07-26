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
use \Dhl\Psf\Api;

/**
 * Dhl_LocationFinder_Test_Model_ParcelLocationTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_ParcelLocationTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function filterAndLimit()
    {
        // prepare full set of stations
        $idOne   = '303';
        $idTwo   = '808';
        $idThree = '909';

        $shopTypeOne   = ParcelLocation\Item::TYPE_PACKSTATION;
        $shopTypeTwo   = ParcelLocation\Item::TYPE_POSTFILIALE;
        $shopTypeThree = ParcelLocation\Item::TYPE_PACKSTATION;

        $locationOne   = new ParcelLocation\Item(
            array(
                'id'        => $idOne,
                'shop_type' => $shopTypeOne,
                'key_word'  => 'foo',
            )
        );
        $locationTwo   = new ParcelLocation\Item(
            array(
                'id'        => $idTwo,
                'shop_type' => $shopTypeTwo,
                'key_word'  => 'bar',
            )
        );
        $locationThree = new ParcelLocation\Item(
            array(
                'id'        => $idThree,
                'shop_type' => $shopTypeThree,
                'key_word'  => 'baz',
            )
        );

        $collection = new ParcelLocation\Collection();
        $collection->setItems(array($locationOne, $locationTwo, $locationThree));
        $this->assertCount(3, $collection);

        // filter Packstation types
        $filter = new ParcelLocation\Filter(array(ParcelLocation\Item::TYPE_PACKSTATION));
        $filter->filter($collection);

        $this->assertCount(2, $collection);
        /** @var ParcelLocation\Item $location */
        foreach ($collection as $location) {
            $this->assertNotEquals($idTwo, $location->getId());
        }

        // limit remaining locations
        $limit   = null;
        $limiter = new ParcelLocation\Limiter($limit);
        $limiter->limit($collection);
        $this->assertCount(2, $collection);

        $limit   = 1;
        $limiter = new ParcelLocation\Limiter($limit);
        $limiter->limit($collection);
        $this->assertCount($limit, $collection);
        $this->assertNotNull($collection->getItem($idOne));
        $this->assertInstanceOf(ParcelLocation\Item::class, $collection->getItem($idOne));
    }

    /**
     * @test
     */
    public function itemData()
    {
        $type       = 'myType';
        $name       = 'myName';
        $station    = 'myStation';
        $street     = 'myStreet';
        $houseNo    = 'myHouseNo';
        $shopNumber = 'myShopNumber';
        $zipCode    = 'myZip';
        $city       = 'myCity';
        $country    = 'myCountry';
        $id         = 'myId';
        $latitude   = 'myLat';
        $longitude  = 'myLng';

        $location = new ParcelLocation\Item(
            array(
                'shop_type'       => $type,
                'shop_number'     => $shopNumber,
                'shop_name'       => $name,
                'additional_info' => $station,
                'street'          => $street,
                'house_no'        => $houseNo,
                'zip_code'        => $zipCode,
                'city'            => $city,
                'country_code'    => $country,
                'id'              => $id,
                'latitude'        => $latitude,
                'longitude'       => $longitude,
            )
        );

        $this->assertEquals($type, $location->getType());
        $this->assertEquals($name, $location->getName());
        $this->assertEquals($station, $location->getStation());
        $this->assertEquals($street, $location->getStreet());
        $this->assertEquals($houseNo, $location->getHouseNo());
        $this->assertEquals($shopNumber, $location->getNumber());
        $this->assertEquals($zipCode, $location->getZipCode());
        $this->assertEquals($city, $location->getCity());
        $this->assertEquals(strtoupper($country), $location->getCountry());
        $this->assertEquals($id, $location->getId());
        $this->assertEquals($latitude, $location->getLatitude());
        $this->assertEquals($longitude, $location->getLongitude());
    }

    /**
     * @test
     */
    public function item()
    {
        $idOne   = '303';
        $idTwo   = '808';
        $idThree = '909';

        $locationOne = new ParcelLocation\Item(
            array(
                'id'       => $idOne,
                'key_word' => 'foo',
            )
        );
        $locationTwo = new ParcelLocation\Item(
            array(
                'id'       => $idTwo,
                'key_word' => 'bar',
            )
        );
        $collection  = new ParcelLocation\Collection();

        $collection->addItem($locationOne);
        $this->assertEquals(1, count($collection));

        $collection->addItem($locationTwo);
        $this->assertEquals(2, count($collection));

        $location = $collection->getItem($idOne);
        $this->assertEquals($locationOne, $location);

        $location = $collection->getItem($idTwo);
        $this->assertEquals($locationTwo, $location);

        $location = $collection->getItem($idThree);
        $this->assertNull($location);
    }

    /**
     * @test
     */
    public function items()
    {
        $idOne   = '303';
        $idTwo   = '808';
        $idThree = '909';

        $shopTypeOne   = ParcelLocation\Item::TYPE_PACKSTATION;
        $shopTypeTwo   = ParcelLocation\Item::TYPE_POSTFILIALE;
        $shopTypeThree = ParcelLocation\Item::TYPE_PACKSTATION;

        $locationOne   = new ParcelLocation\Item(
            array(
                'id'        => $idOne,
                'shop_type' => $shopTypeOne,
                'key_word'  => 'foo',
            )
        );
        $locationTwo   = new ParcelLocation\Item(
            array(
                'id'        => $idTwo,
                'shop_type' => $shopTypeTwo,
                'key_word'  => 'bar',
            )
        );
        $locationThree = new ParcelLocation\Item(
            array(
                'id'        => $idThree,
                'shop_type' => $shopTypeThree,
                'key_word'  => 'baz',
            )
        );

        $collection = new ParcelLocation\Collection();

        $collection->setItems(array($locationOne));
        $this->assertEquals(1, count($collection));
        $items = $collection->getItems();
        $this->assertEquals($locationOne, $items[$idOne]);

        $collection->setItems(array($locationOne, $locationTwo, $locationThree));
        $this->assertEquals(3, count($collection));
        $items = $collection->getItems();
        $this->assertEquals($locationOne, $items[$idOne]);
        $this->assertEquals($locationTwo, $items[$idTwo]);
        $this->assertEquals($locationThree, $items[$idThree]);


        $type    = array(ParcelLocation\Item::TYPE_PACKSTATION);
        $limit   = 1;
        $filter  = new ParcelLocation\Filter($type);
        $limiter = new ParcelLocation\Limiter($limit);

        $items = $collection->getItems($filter, $limiter);
        $this->assertCount($limit, $items);
        $this->assertNotNull($items[$idOne]);
        $this->assertInstanceOf(ParcelLocation\Item::class, $items[$idOne]);
    }

    /**
     * @test
     */
    public function iterate()
    {
        $idOne = '303';
        $idTwo = '808';

        $locationOne = new ParcelLocation\Item(
            array(
                'id'       => $idOne,
                'key_word' => 'foo',
            )
        );
        $locationTwo = new ParcelLocation\Item(
            array(
                'id'       => $idTwo,
                'key_word' => 'bar',
            )
        );
        $collection  = new ParcelLocation\Collection();
        $collection->setItems(array($locationOne, $locationTwo));

        /** @var ParcelLocation\Item $item */
        foreach ($collection as $item) {
            $this->assertNotEmpty($item->getId());
        }
    }

    /**
     * @test
     */
    public function standardObjects()
    {
        // prepare full set of stations
        $idOne   = '303';
        $idTwo   = '808';
        $idThree = '909';

        $shopTypeOne   = ParcelLocation\Item::TYPE_PACKSTATION;
        $shopTypeTwo   = ParcelLocation\Item::TYPE_POSTFILIALE;
        $shopTypeThree = ParcelLocation\Item::TYPE_PAKETSHOP;

        // build OtherInformation for location
        $informationArray = array();
        $informationData  = array(
            'tt_openinghour_rows' => 1,
            'tt_openinghour_cols' => 2,
            'tt_openinghour_00'   => 'Mo:',
            'tt_openinghour_01'   => '07:00 - 17:00',
            'tt_another_thing'    => 'foo'
        );
        foreach ($informationData as $key => $value) {
            $otherInformation = new Api\psfOtherinfo();
            $otherInformation->setContent($value);
            $otherInformation->setType($key);
            $informationArray[] = $otherInformation;
        }


        $locationOne      = new ParcelLocation\Item(
            array(
                'id'        => $idOne,
                'shop_type' => $shopTypeOne,
                'key_word'  => 'foo'
            )
        );
        $locationTwo      = new ParcelLocation\Item(
            array(
                'id'        => $idTwo,
                'shop_type' => $shopTypeTwo,
                'key_word'  => 'bar'
            )
        );
        $locationThree    = new ParcelLocation\Item(
            array(
                'id'          => $idThree,
                'shop_type'   => $shopTypeThree,
                'key_word'    => 'baz',
                'other_infos' => $informationArray,
                'services'    => array('parking', 'COD')
            )
        );
        $translationArray =
            array('parking' => 'Parking allowed', 'openHours' => 'Open Times', 'services' => 'Services');

        $collection = new ParcelLocation\Collection();
        $formatter  = new ParcelLocation\Formatter\MarkerDetailsFormatter();
        $collection->setItems(array($locationOne, $locationTwo, $locationThree));

        // set limit and filter, convert to stdClass[]
        $type    = array(ParcelLocation\Item::TYPE_PACKSTATION);
        $limit   = 1;
        $filter  = new ParcelLocation\Filter($type);
        $limiter = new ParcelLocation\Limiter($limit);
        $objects = $formatter->format($collection->getItems($filter, $limiter), $translationArray);

        $this->assertInternalType('array', $objects);
        $this->assertContainsOnly(stdClass::class, $objects);
        $this->assertCount($limit, $objects);
        $this->assertArrayHasKey(0, $objects);

        $object = $objects[0];

        $this->assertEquals($idOne, $object->id);
        $this->assertEquals($type[0], $object->type);

        // set another filter to check the formatter methods
        $collection->setItems(array($locationOne, $locationTwo, $locationThree));
        $filter  = new ParcelLocation\Filter(array(ParcelLocation\Item::TYPE_PAKETSHOP));
        $objects = $formatter->format($collection->getItems($filter, $limiter), $translationArray);
        $object  = $objects[0];

        $this->assertContains('allowed', $object->services);
        $this->assertContains('Mo:', $object->openingHours);

        // set another filter to check that formatter methods skip empty values
        $collection->setItems(array($locationOne, $locationTwo, $locationThree));
        $filter  = new ParcelLocation\Filter(array(ParcelLocation\Item::TYPE_POSTFILIALE));
        $objects = $formatter->format($collection->getItems($filter, $limiter), $translationArray);
        $object  = $objects[0];

        $this->assertNotContains('allowed', $object->services);
        $this->assertNotContains('Mo:', $object->openingHours);
    }
}
