<?php

namespace Dhl\Psf\Api;

class psfTimeinfo
{

    /**
     * @var int $id
     */
    protected $id = null;

    /**
     * @var psfParcellocation[] $psfParcellocations
     */
    protected $psfParcellocations = null;

    /**
     * @var string $timefrom
     */
    protected $timefrom = null;

    /**
     * @var string $timeto
     */
    protected $timeto = null;

    /**
     * @var timeInfoType $type
     */
    protected $type = null;

    /**
     * @var int $weekday
     */
    protected $weekday = null;

    
    public function __construct()
    {
    
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
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return psfParcellocation[]
     */
    public function getPsfParcellocations()
    {
      return $this->psfParcellocations;
    }

    /**
     * @param psfParcellocation[] $psfParcellocations
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setPsfParcellocations(array $psfParcellocations = null)
    {
      $this->psfParcellocations = $psfParcellocations;
      return $this;
    }

    /**
     * @return string
     */
    public function getTimefrom()
    {
      return $this->timefrom;
    }

    /**
     * @param string $timefrom
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setTimefrom($timefrom)
    {
      $this->timefrom = $timefrom;
      return $this;
    }

    /**
     * @return string
     */
    public function getTimeto()
    {
      return $this->timeto;
    }

    /**
     * @param string $timeto
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setTimeto($timeto)
    {
      $this->timeto = $timeto;
      return $this;
    }

    /**
     * @return timeInfoType
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param timeInfoType $type
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    /**
     * @return int
     */
    public function getWeekday()
    {
      return $this->weekday;
    }

    /**
     * @param int $weekday
     * @return \Dhl\Psf\Api\psfTimeinfo
     */
    public function setWeekday($weekday)
    {
      $this->weekday = $weekday;
      return $this;
    }

}
