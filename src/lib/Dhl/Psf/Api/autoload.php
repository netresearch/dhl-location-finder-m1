<?php


 function autoload_5f633a5198ff1fe8a8a7c19398045a95($class)
{
    $classes = array(
        'Dhl\Psf\Api\SoapServiceImplService' => __DIR__ .'/SoapServiceImplService.php',
        'Dhl\Psf\Api\getParcellocationByCoordinate' => __DIR__ .'/getParcellocationByCoordinate.php',
        'Dhl\Psf\Api\getParcellocationByCoordinateResponse' => __DIR__ .'/getParcellocationByCoordinateResponse.php',
        'Dhl\Psf\Api\psfParcellocation' => __DIR__ .'/psfParcellocation.php',
        'Dhl\Psf\Api\location' => __DIR__ .'/location.php',
        'Dhl\Psf\Api\psfClosureperiod' => __DIR__ .'/psfClosureperiod.php',
        'Dhl\Psf\Api\psfFiles' => __DIR__ .'/psfFiles.php',
        'Dhl\Psf\Api\psfForeignkeys' => __DIR__ .'/psfForeignkeys.php',
        'Dhl\Psf\Api\psfOtherinfo' => __DIR__ .'/psfOtherinfo.php',
        'Dhl\Psf\Api\psfTimeinfo' => __DIR__ .'/psfTimeinfo.php',
        'Dhl\Psf\Api\psfWelcometext' => __DIR__ .'/psfWelcometext.php',
        'Dhl\Psf\Api\getParcellocationByAddress' => __DIR__ .'/getParcellocationByAddress.php',
        'Dhl\Psf\Api\getParcellocationByAddressResponse' => __DIR__ .'/getParcellocationByAddressResponse.php',
        'Dhl\Psf\Api\service' => __DIR__ .'/service.php',
        'Dhl\Psf\Api\closurePeriodType' => __DIR__ .'/closurePeriodType.php',
        'Dhl\Psf\Api\timeInfoType' => __DIR__ .'/timeInfoType.php',
        'Dhl\Psf\Api\ServiceException' => __DIR__ .'/ServiceException.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_5f633a5198ff1fe8a8a7c19398045a95');

// Do nothing. The rest is just leftovers from the code generation.
{
}
