<?php

namespace Dhl\Psf\Api;

class psfParcellocation
{

    /**
     * @var string $additionalInfo
     */
    protected $additionalInfo = null;

    /**
     * @var string $additionalStreet
     */
    protected $additionalStreet = null;

    /**
     * @var string $area
     */
    protected $area = null;

    /**
     * @var string $city
     */
    protected $city = null;

    /**
     * @var string $countryCode
     */
    protected $countryCode = null;

    /**
     * @var string $district
     */
    protected $district = null;

    /**
     * @var string $format1
     */
    protected $format1 = null;

    /**
     * @var string $format2
     */
    protected $format2 = null;

    /**
     * @var location $geoPosition
     */
    protected $geoPosition = null;

    /**
     * @var string $houseNo
     */
    protected $houseNo = null;

    /**
     * @var int $id
     */
    protected $id = null;

    /**
     * @var string $keyWord
     */
    protected $keyWord = null;

    /**
     * @var location $location
     */
    protected $location = null;

    /**
     * @var string $partnerType
     */
    protected $partnerType = null;

    /**
     * @var string $primaryKeyDeliverySystem
     */
    protected $primaryKeyDeliverySystem = null;

    /**
     * @var string $primaryKeyZipRegion
     */
    protected $primaryKeyZipRegion = null;

    /**
     * @var string $primaryLanguage
     */
    protected $primaryLanguage = null;

    /**
     * @var psfClosureperiod[] $psfClosureperiods
     */
    protected $psfClosureperiods = null;

    /**
     * @var psfFiles[] $psfFiles
     */
    protected $psfFiles = null;

    /**
     * @var psfForeignkeys[] $psfForeignKeys
     */
    protected $psfForeignKeys = null;

    /**
     * @var psfOtherinfo[] $psfOtherinfos
     */
    protected $psfOtherinfos = null;

    /**
     * @var service[] $psfServicetypes
     */
    protected $psfServicetypes = null;

    /**
     * @var psfTimeinfo[] $psfTimeinfos
     */
    protected $psfTimeinfos = null;

    /**
     * @var psfWelcometext[] $psfWelcometexts
     */
    protected $psfWelcometexts = null;

    /**
     * @var string $routingCode
     */
    protected $routingCode = null;

    /**
     * @var string $secondaryLanguage
     */
    protected $secondaryLanguage = null;

    /**
     * @var string $shopName
     */
    protected $shopName = null;

    /**
     * @var string $shopType
     */
    protected $shopType = null;

    /**
     * @var string $street
     */
    protected $street = null;

    /**
     * @var string $systemID
     */
    protected $systemID = null;

    /**
     * @var string $tertiaryLanguage
     */
    protected $tertiaryLanguage = null;

    /**
     * @var string $zipCode
     */
    protected $zipCode = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getAdditionalInfo()
    {
      return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setAdditionalInfo($additionalInfo)
    {
      $this->additionalInfo = $additionalInfo;
      return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalStreet()
    {
      return $this->additionalStreet;
    }

    /**
     * @param string $additionalStreet
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setAdditionalStreet($additionalStreet)
    {
      $this->additionalStreet = $additionalStreet;
      return $this;
    }

    /**
     * @return string
     */
    public function getArea()
    {
      return $this->area;
    }

    /**
     * @param string $area
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setArea($area)
    {
      $this->area = $area;
      return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
      return $this->city;
    }

    /**
     * @param string $city
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setCity($city)
    {
      $this->city = $city;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
      return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setCountryCode($countryCode)
    {
      $this->countryCode = $countryCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
      return $this->district;
    }

    /**
     * @param string $district
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setDistrict($district)
    {
      $this->district = $district;
      return $this;
    }

    /**
     * @return string
     */
    public function getFormat1()
    {
      return $this->format1;
    }

    /**
     * @param string $format1
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setFormat1($format1)
    {
      $this->format1 = $format1;
      return $this;
    }

    /**
     * @return string
     */
    public function getFormat2()
    {
      return $this->format2;
    }

    /**
     * @param string $format2
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setFormat2($format2)
    {
      $this->format2 = $format2;
      return $this;
    }

    /**
     * @return location
     */
    public function getGeoPosition()
    {
      return $this->geoPosition;
    }

    /**
     * @param location $geoPosition
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setGeoPosition($geoPosition)
    {
      $this->geoPosition = $geoPosition;
      return $this;
    }

    /**
     * @return string
     */
    public function getHouseNo()
    {
      return $this->houseNo;
    }

    /**
     * @param string $houseNo
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setHouseNo($houseNo)
    {
      $this->houseNo = $houseNo;
      return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param int $id
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getKeyWord()
    {
      return $this->keyWord;
    }

    /**
     * @param string $keyWord
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setKeyWord($keyWord)
    {
      $this->keyWord = $keyWord;
      return $this;
    }

    /**
     * @return location
     */
    public function getLocation()
    {
      return $this->location;
    }

    /**
     * @param location $location
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setLocation($location)
    {
      $this->location = $location;
      return $this;
    }

    /**
     * @return string
     */
    public function getPartnerType()
    {
      return $this->partnerType;
    }

    /**
     * @param string $partnerType
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPartnerType($partnerType)
    {
      $this->partnerType = $partnerType;
      return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyDeliverySystem()
    {
      return $this->primaryKeyDeliverySystem;
    }

    /**
     * @param string $primaryKeyDeliverySystem
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPrimaryKeyDeliverySystem($primaryKeyDeliverySystem)
    {
      $this->primaryKeyDeliverySystem = $primaryKeyDeliverySystem;
      return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyZipRegion()
    {
      return $this->primaryKeyZipRegion;
    }

    /**
     * @param string $primaryKeyZipRegion
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPrimaryKeyZipRegion($primaryKeyZipRegion)
    {
      $this->primaryKeyZipRegion = $primaryKeyZipRegion;
      return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryLanguage()
    {
      return $this->primaryLanguage;
    }

    /**
     * @param string $primaryLanguage
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPrimaryLanguage($primaryLanguage)
    {
      $this->primaryLanguage = $primaryLanguage;
      return $this;
    }

    /**
     * @return psfClosureperiod[]
     */
    public function getPsfClosureperiods()
    {
      return $this->psfClosureperiods;
    }

    /**
     * @param psfClosureperiod[] $psfClosureperiods
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfClosureperiods(array $psfClosureperiods = null)
    {
      $this->psfClosureperiods = $psfClosureperiods;
      return $this;
    }

    /**
     * @return psfFiles[]
     */
    public function getPsfFiles()
    {
      return $this->psfFiles;
    }

    /**
     * @param psfFiles[] $psfFiles
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfFiles(array $psfFiles = null)
    {
      $this->psfFiles = $psfFiles;
      return $this;
    }

    /**
     * @return psfForeignkeys[]
     */
    public function getPsfForeignKeys()
    {
      return $this->psfForeignKeys;
    }

    /**
     * @param psfForeignkeys[] $psfForeignKeys
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfForeignKeys(array $psfForeignKeys = null)
    {
      $this->psfForeignKeys = $psfForeignKeys;
      return $this;
    }

    /**
     * @return psfOtherinfo[]
     */
    public function getPsfOtherinfos()
    {
      return $this->psfOtherinfos;
    }

    /**
     * @param psfOtherinfo[] $psfOtherinfos
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfOtherinfos(array $psfOtherinfos = null)
    {
      $this->psfOtherinfos = $psfOtherinfos;
      return $this;
    }

    /**
     * @return service[]
     */
    public function getPsfServicetypes()
    {
      return $this->psfServicetypes;
    }

    /**
     * @param service[] $psfServicetypes
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfServicetypes(array $psfServicetypes = null)
    {
      $this->psfServicetypes = $psfServicetypes;
      return $this;
    }

    /**
     * @return psfTimeinfo[]
     */
    public function getPsfTimeinfos()
    {
      return $this->psfTimeinfos;
    }

    /**
     * @param psfTimeinfo[] $psfTimeinfos
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfTimeinfos(array $psfTimeinfos = null)
    {
      $this->psfTimeinfos = $psfTimeinfos;
      return $this;
    }

    /**
     * @return psfWelcometext[]
     */
    public function getPsfWelcometexts()
    {
      return $this->psfWelcometexts;
    }

    /**
     * @param psfWelcometext[] $psfWelcometexts
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setPsfWelcometexts(array $psfWelcometexts = null)
    {
      $this->psfWelcometexts = $psfWelcometexts;
      return $this;
    }

    /**
     * @return string
     */
    public function getRoutingCode()
    {
      return $this->routingCode;
    }

    /**
     * @param string $routingCode
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setRoutingCode($routingCode)
    {
      $this->routingCode = $routingCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryLanguage()
    {
      return $this->secondaryLanguage;
    }

    /**
     * @param string $secondaryLanguage
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setSecondaryLanguage($secondaryLanguage)
    {
      $this->secondaryLanguage = $secondaryLanguage;
      return $this;
    }

    /**
     * @return string
     */
    public function getShopName()
    {
      return $this->shopName;
    }

    /**
     * @param string $shopName
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setShopName($shopName)
    {
      $this->shopName = $shopName;
      return $this;
    }

    /**
     * @return string
     */
    public function getShopType()
    {
      return $this->shopType;
    }

    /**
     * @param string $shopType
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setShopType($shopType)
    {
      $this->shopType = $shopType;
      return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
      return $this->street;
    }

    /**
     * @param string $street
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setStreet($street)
    {
      $this->street = $street;
      return $this;
    }

    /**
     * @return string
     */
    public function getSystemID()
    {
      return $this->systemID;
    }

    /**
     * @param string $systemID
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setSystemID($systemID)
    {
      $this->systemID = $systemID;
      return $this;
    }

    /**
     * @return string
     */
    public function getTertiaryLanguage()
    {
      return $this->tertiaryLanguage;
    }

    /**
     * @param string $tertiaryLanguage
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setTertiaryLanguage($tertiaryLanguage)
    {
      $this->tertiaryLanguage = $tertiaryLanguage;
      return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
      return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return \Dhl\Psf\Api\psfParcellocation
     */
    public function setZipCode($zipCode)
    {
      $this->zipCode = $zipCode;
      return $this;
    }

}
