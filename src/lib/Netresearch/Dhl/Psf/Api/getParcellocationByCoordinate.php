<?php

namespace Netresearch\Dhl\Psf\Api;

class getParcellocationByCoordinate
{

    /**
     * @var float $lat
     */
    protected $lat = null;

    /**
     * @var float $lng
     */
    protected $lng = null;

    /**
     * @var service $service
     */
    protected $service = null;

    /**
     * @var string $countrycode
     */
    protected $countrycode = null;

    /**
     * @param float $lat
     * @param float $lng
     */
    public function __construct($lat, $lng)
    {
      $this->lat = $lat;
      $this->lng = $lng;
    }

    /**
     * @return float
     */
    public function getLat()
    {
      return $this->lat;
    }

    /**
     * @param float $lat
     * @return \Dhl\Psf\Api\getParcellocationByCoordinate
     */
    public function setLat($lat)
    {
      $this->lat = $lat;
      return $this;
    }

    /**
     * @return float
     */
    public function getLng()
    {
      return $this->lng;
    }

    /**
     * @param float $lng
     * @return \Dhl\Psf\Api\getParcellocationByCoordinate
     */
    public function setLng($lng)
    {
      $this->lng = $lng;
      return $this;
    }

    /**
     * @return service
     */
    public function getService()
    {
      return $this->service;
    }

    /**
     * @param service $service
     * @return \Dhl\Psf\Api\getParcellocationByCoordinate
     */
    public function setService($service)
    {
      $this->service = $service;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountrycode()
    {
      return $this->countrycode;
    }

    /**
     * @param string $countrycode
     * @return \Dhl\Psf\Api\getParcellocationByCoordinate
     */
    public function setCountrycode($countrycode)
    {
      $this->countrycode = $countrycode;
      return $this;
    }

}
