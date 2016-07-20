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
namespace Dhl\LocationFinder\ParcelLocation;
/**
 * Item
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
final class Item
{
    const TYPE_PACKSTATION = 'packStation';
    const TYPE_PAKETSHOP   = 'parcelShop';
    const TYPE_POSTFILIALE = 'postOffice';

    /** @var string ShopType */
    private $type = '';
    /** @var string ShopNumber */
    private $number = '';
    /** @var string ShopName or KeyWord */
    private $name = '';
    /** @var string AdditionalInfo or KeyWord */
    private $station = '';
    /** @var string Street */
    private $street = '';
    /** @var string HouseNo */
    private $houseNo = '';
    /** @var string ZipCode */
    private $zipCode = '';
    /** @var string City */
    private $city = '';
    /** @var string CountryCode */
    private $country = '';
    /** @var string Id */
    private $id = '';
    /** @var string LocationLatitude */
    private $latitude = '';
    /** @var string LocationLongitude */
    private $longitude = '';

    /**
     * Item constructor.
     * @param string[] $data
     */
    public function __construct(array $data)
    {
        $keyWord = isset($data['key_word']) ? $data['key_word'] : '';
        $this->type = isset($data['shop_type']) ? $data['shop_type'] : '';
        // TODO(nr): Find 3 digit station number in response
        $this->number = isset($data['shop_number']) ? $data['shop_number'] : '';
        $this->name = isset($data['shop_name']) ? $data['shop_name'] : $keyWord;
        $this->station = isset($data['additional_info']) ? $data['additional_info'] : $keyWord;
        $this->street = isset($data['street']) ? $data['street'] : '';
        $this->houseNo = isset($data['house_no']) ? $data['house_no'] : '';
        $this->zipCode = isset($data['zip_code']) ? $data['zip_code'] : '';
        $this->city = isset($data['city']) ? $data['city'] : '';
        $this->country = isset($data['country_code']) ? strtoupper($data['country_code']) : '';
        $this->id = isset($data['id']) ? $data['id'] : '';
        $this->latitude = isset($data['latitude']) ? $data['latitude'] : '';
        $this->longitude = isset($data['longitude']) ? $data['longitude'] : '';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getHouseNo()
    {
        return $this->houseNo;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Obtain serializable location representation.
     *
     * @return \stdClass
     */
    public function toObject()
    {
        $location = new \stdClass();
        $location->type    = $this->getType();
        $location->name    = $this->getName();
        $location->station = $this->getStation();
        $location->street  = $this->getStreet();
        $location->houseNo = $this->getHouseNo();
        $location->zipCode = $this->getZipCode();
        $location->city    = $this->getCity();
        $location->country = $this->getCountry();
        $location->id      = $this->getId();
        $location->lat     = $this->getLatitude();
        $location->long    = $this->getLongitude();

        return $location;
    }
}
