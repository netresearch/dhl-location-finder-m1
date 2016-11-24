<?php

namespace Netresearch\Dhl\Psf\Api;

class getParcellocationByCoordinateResponse
{

    /**
     * @var psfParcellocation[] $parcelLocation
     */
    protected $parcelLocation = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return psfParcellocation[]
     */
    public function getParcelLocation()
    {
      return $this->parcelLocation;
    }

    /**
     * @param psfParcellocation[] $parcelLocation
     * @return \Dhl\Psf\Api\getParcellocationByCoordinateResponse
     */
    public function setParcelLocation(array $parcelLocation = null)
    {
      $this->parcelLocation = $parcelLocation;
      return $this;
    }

}
