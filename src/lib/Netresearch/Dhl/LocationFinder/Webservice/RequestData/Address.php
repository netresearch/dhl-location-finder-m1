<?php
/**
 * Dhl LocationFinder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 5
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Netresearch\Dhl\LocationFinder\Webservice\RequestData;
/**
 * Address
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
final class Address
{
    const MSG_INVALID_COUNTRY = '%s is currently not supported.';
    const MSG_INVALID_ADDRESS = 'Insufficient address parts given.';

    /** @var string[] Supported Countries */
    private $validCountries = [];

    /** @var string Street */
    private $street = '';
    /** @var string HouseNo */
    private $houseNo = '';
    /** @var string ZipCode */
    private $zipCode = '';
    /** @var string City */
    private $city = '';
    /** @var string District */
    private $district = '';
    /** @var string CountryCode */
    private $country = '';

    /** @var string[] services */
    private $services = [];

    /**
     * Address constructor.
     *
     * @param string[] $validCountries
     * @param string $country
     * @param string $zipCode
     * @param string $city
     * @param string $district
     * @param string $street
     * @param string $houseNo
     * @param string[] $services
     */
    public function __construct(
        $validCountries,
        $country = '', $zipCode = '', $city = '', $district = '', $street = '', $houseNo = '',
        $services = []
    )
    {
        $this->validCountries = $validCountries;

        $this->country = strtoupper(trim($country));
        $this->zipCode = trim($zipCode);
        $this->city = trim($city);
        $this->district = trim($district);
        $this->street = trim($street);
        $this->houseNo = trim($houseNo);

        $this->services = $services;
    }

    /**
     * Retrieve address prepared for webservice request.
     *
     * @return string
     * @throws AddressException
     */
    public function getAddress()
    {
        if ($this->country && !isset($this->validCountries[$this->country])) {
            $message = sprintf(self::MSG_INVALID_COUNTRY, $this->country);
            throw new AddressException($message);
        }

        $address = [];
        if ($this->zipCode) {
            $address[]= $this->zipCode;
        }
        if ($this->city) {
            $address[]= $this->city;
        }
        if ($this->district) {
            $address[]= $this->district;
        }
        if ($this->street) {
            $address[]= $this->street;
        }
        if ($this->houseNo) {
            $address[]= $this->houseNo;
        }
        if ($this->country) {
            $address[]= $this->validCountries[$this->country];
        }

        $address = implode(' ', $address);
        if (strlen($address) < 2) {
            throw new AddressException(self::MSG_INVALID_ADDRESS);
        }

        return $address;
    }

    /**
     * @return string
     */
    public function getServices()
    {
        return implode(', ', $this->services);
    }
}
