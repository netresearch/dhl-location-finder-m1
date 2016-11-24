<?php

namespace Netresearch\Dhl\Psf\Api;

class psfWelcometext
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
     * @var string $language
     */
    protected $language = null;

    
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
     * @return \Dhl\Psf\Api\psfWelcometext
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
     * @return \Dhl\Psf\Api\psfWelcometext
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
      return $this->language;
    }

    /**
     * @param string $language
     * @return \Dhl\Psf\Api\psfWelcometext
     */
    public function setLanguage($language)
    {
      $this->language = $language;
      return $this;
    }

}
