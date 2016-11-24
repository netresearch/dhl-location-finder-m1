<?php

namespace Netresearch\Dhl\Psf\Api;

class SoapServiceImplService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'getParcellocationByCoordinate' => 'Netresearch\\Dhl\\Psf\\Api\\getParcellocationByCoordinate',
      'getParcellocationByCoordinateResponse' => 'Netresearch\\Dhl\\Psf\\Api\\getParcellocationByCoordinateResponse',
      'psfParcellocation' => 'Netresearch\\Dhl\\Psf\\Api\\psfParcellocation',
      'location' => 'Netresearch\\Dhl\\Psf\\Api\\location',
      'psfClosureperiod' => 'Netresearch\\Dhl\\Psf\\Api\\psfClosureperiod',
      'psfFiles' => 'Netresearch\\Dhl\\Psf\\Api\\psfFiles',
      'psfForeignkeys' => 'Netresearch\\Dhl\\Psf\\Api\\psfForeignkeys',
      'psfOtherinfo' => 'Netresearch\\Dhl\\Psf\\Api\\psfOtherinfo',
      'psfTimeinfo' => 'Netresearch\\Dhl\\Psf\\Api\\psfTimeinfo',
      'psfWelcometext' => 'Netresearch\\Dhl\\Psf\\Api\\psfWelcometext',
      'getParcellocationByAddress' => 'Netresearch\\Dhl\\Psf\\Api\\getParcellocationByAddress',
      'getParcellocationByAddressResponse' => 'Netresearch\\Dhl\\Psf\\Api\\getParcellocationByAddressResponse',
      'ServiceException' => 'Netresearch\\Dhl\\Psf\\Api\\ServiceException',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      if (!$wsdl) {
        $wsdl = 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/parcelshopfinder/1.0/parcelshopfinder-1.0-production.wsdl';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * @param getParcellocationByCoordinate $parameters
     * @return getParcellocationByCoordinateResponse
     */
    public function getParcellocationByCoordinate(getParcellocationByCoordinate $parameters)
    {
      return $this->__soapCall('getParcellocationByCoordinate', array($parameters));
    }

    /**
     * @param getParcellocationByAddress $parameters
     * @return getParcellocationByAddressResponse
     */
    public function getParcellocationByAddress(getParcellocationByAddress $parameters)
    {
      return $this->__soapCall('getParcellocationByAddress', array($parameters));
    }

}
