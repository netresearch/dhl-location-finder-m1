<?php

namespace Dhl\Psf\Api;

class psfForeignkeys
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
     * @var string $scope
     */
    protected $scope = null;

    
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
     * @return \Dhl\Psf\Api\psfForeignkeys
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
     * @return \Dhl\Psf\Api\psfForeignkeys
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
      return $this->scope;
    }

    /**
     * @param string $scope
     * @return \Dhl\Psf\Api\psfForeignkeys
     */
    public function setScope($scope)
    {
      $this->scope = $scope;
      return $this;
    }

}
