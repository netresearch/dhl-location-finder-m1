<?php

namespace Dhl\Psf\Api;

class psfOtherinfo
{

    /**
     * @var string $content
     */
    protected $content = null;

    /**
     * @var int $id
     */
    protected $id = null;

    /**
     * @var string $type
     */
    protected $type = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getContent()
    {
      return $this->content;
    }

    /**
     * @param string $content
     * @return \Dhl\Psf\Api\psfOtherinfo
     */
    public function setContent($content)
    {
      $this->content = $content;
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
     * @return \Dhl\Psf\Api\psfOtherinfo
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param string $type
     * @return \Dhl\Psf\Api\psfOtherinfo
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

}
