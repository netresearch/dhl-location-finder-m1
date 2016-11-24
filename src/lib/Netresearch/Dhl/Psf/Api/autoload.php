<?php


 function autoload_5f633a5198ff1fe8a8a7c19398045a95($class)
{
    $classes = array(
        'Netresearch\Dhl\Psf\Api\SoapServiceImplService' => __DIR__ . '/SoapServiceImplService.php',
        'Netresearch\Dhl\Psf\Api\getParcellocationByCoordinate' => __DIR__ . '/getParcellocationByCoordinate.php',
        'Netresearch\Dhl\Psf\Api\getParcellocationByCoordinateResponse' => __DIR__ . '/getParcellocationByCoordinateResponse.php',
        'Netresearch\Dhl\Psf\Api\psfParcellocation' => __DIR__ . '/psfParcellocation.php',
        'Netresearch\Dhl\Psf\Api\location' => __DIR__ . '/location.php',
        'Netresearch\Dhl\Psf\Api\psfClosureperiod' => __DIR__ . '/psfClosureperiod.php',
        'Netresearch\Dhl\Psf\Api\psfFiles' => __DIR__ . '/psfFiles.php',
        'Netresearch\Dhl\Psf\Api\psfForeignkeys' => __DIR__ . '/psfForeignkeys.php',
        'Netresearch\Dhl\Psf\Api\psfOtherinfo' => __DIR__ . '/psfOtherinfo.php',
        'Netresearch\Dhl\Psf\Api\psfTimeinfo' => __DIR__ . '/psfTimeinfo.php',
        'Netresearch\Dhl\Psf\Api\psfWelcometext' => __DIR__ . '/psfWelcometext.php',
        'Netresearch\Dhl\Psf\Api\getParcellocationByAddress' => __DIR__ . '/getParcellocationByAddress.php',
        'Netresearch\Dhl\Psf\Api\getParcellocationByAddressResponse' => __DIR__ . '/getParcellocationByAddressResponse.php',
        'Netresearch\Dhl\Psf\Api\service' => __DIR__ . '/service.php',
        'Netresearch\Dhl\Psf\Api\closurePeriodType' => __DIR__ . '/closurePeriodType.php',
        'Netresearch\Dhl\Psf\Api\timeInfoType' => __DIR__ . '/timeInfoType.php',
        'Netresearch\Dhl\Psf\Api\ServiceException' => __DIR__ . '/ServiceException.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_5f633a5198ff1fe8a8a7c19398045a95');

// Do nothing. The rest is just leftovers from the code generation.
{
}
