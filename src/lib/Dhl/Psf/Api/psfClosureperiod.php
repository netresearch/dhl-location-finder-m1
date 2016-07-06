<?php

namespace Dhl\Psf\Api;

class psfClosureperiod
{

    /**
     * @var \DateTime $fromDate
     */
    protected $fromDate = null;

    /**
     * @var int $id
     */
    protected $id = null;

    /**
     * @var \DateTime $toDate
     */
    protected $toDate = null;

    /**
     * @var closurePeriodType $type
     */
    protected $type = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return \DateTime
     */
    public function getFromDate()
    {
      if ($this->fromDate == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->fromDate);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $fromDate
     * @return \Dhl\Psf\Api\psfClosureperiod
     */
    public function setFromDate(\DateTime $fromDate = null)
    {
      if ($fromDate == null) {
       $this->fromDate = null;
      } else {
        $this->fromDate = $fromDate->format(\DateTime::ATOM);
      }
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
     * @return \Dhl\Psf\Api\psfClosureperiod
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getToDate()
    {
      if ($this->toDate == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->toDate);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $toDate
     * @return \Dhl\Psf\Api\psfClosureperiod
     */
    public function setToDate(\DateTime $toDate = null)
    {
      if ($toDate == null) {
       $this->toDate = null;
      } else {
        $this->toDate = $toDate->format(\DateTime::ATOM);
      }
      return $this;
    }

    /**
     * @return closurePeriodType
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param closurePeriodType $type
     * @return \Dhl\Psf\Api\psfClosureperiod
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

}
