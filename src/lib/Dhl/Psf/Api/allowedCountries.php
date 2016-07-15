<?php

namespace Dhl\Psf\Api;

class allowedCountries
{
    /**
     * @var array $countryMap The allowed countries for the location finder
     */
    protected static $countryMap = array (
        'AT' => 'Austria',
        'BE' => 'Belgium',
        'CZ' => 'Czech Republic',
        'DE' => 'Germany',
        'NL' => 'Netherlands',
        'PL' => 'Poland',
        'SK' => 'Slovakia'
    );

    public function getCountries(){
        return self::$countryMap;
    }
}
