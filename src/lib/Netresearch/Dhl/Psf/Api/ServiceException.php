<?php

namespace Netresearch\Dhl\Psf\Api;

class ServiceException
{

    /**
     * @var string $id
     */
    protected $id = null;

    /**
     * @var string $message
     */
    protected $message = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $id
     * @return \Dhl\Psf\Api\ServiceException
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return \Dhl\Psf\Api\ServiceException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
