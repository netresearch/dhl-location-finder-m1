<?php

namespace Netresearch\Dhl\Psf\Api;

class getParcellocationByAddress
{

    /**
     * @var string $address
     */
    protected $address = null;

    /**
     * @var service $service
     */
    protected $service = null;

    /**
     * @var string $countrycode
     */
    protected $countrycode = null;

    /**
     * @param string $address
     */
    public function __construct($address)
    {
      $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
      return $this->address;
    }

    /**
     * @param string $address
     * @return \Dhl\Psf\Api\getParcellocationByAddress
     */
    public function setAddress($address)
    {
      $this->address = $address;
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
     * @return \Dhl\Psf\Api\getParcellocationByAddress
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
     * @return \Dhl\Psf\Api\getParcellocationByAddress
     */
    public function setCountrycode($countrycode)
    {
      $this->countrycode = $countrycode;
      return $this;
    }

}
