<?php

namespace Dhl\Psf\Api;

class psfFiles
{

    /**
     * @var string $category
     */
    protected $category = null;

    /**
     * @var int $id
     */
    protected $id = null;

    /**
     * @var string $path
     */
    protected $path = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getCategory()
    {
      return $this->category;
    }

    /**
     * @param string $category
     * @return \Dhl\Psf\Api\psfFiles
     */
    public function setCategory($category)
    {
      $this->category = $category;
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
     * @return \Dhl\Psf\Api\psfFiles
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
      return $this->path;
    }

    /**
     * @param string $path
     * @return \Dhl\Psf\Api\psfFiles
     */
    public function setPath($path)
    {
      $this->path = $path;
      return $this;
    }

}
