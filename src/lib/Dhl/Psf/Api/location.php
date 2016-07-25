<?php

namespace Dhl\Psf\Api;

class location
{

    /**
     * @var int $distance
     */
    protected $distance = null;

    /**
     * @var float $latitude
     */
    protected $latitude = null;

    /**
     * @var float $longitude
     */
    protected $longitude = null;

    /**
     * @param int $distance
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($distance, $latitude, $longitude)
    {
      $this->distance = $distance;
      $this->latitude = $latitude;
      $this->longitude = $longitude;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
      return $this->distance;
    }

    /**
     * @param int $distance
     * @return \Dhl\Psf\Api\location
     */
    public function setDistance($distance)
    {
      $this->distance = $distance;
      return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
      return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return \Dhl\Psf\Api\location
     */
    public function setLatitude($latitude)
    {
      $this->latitude = $latitude;
      return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
      return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return \Dhl\Psf\Api\location
     */
    public function setLongitude($longitude)
    {
      $this->longitude = $longitude;
      return $this;
    }

}
