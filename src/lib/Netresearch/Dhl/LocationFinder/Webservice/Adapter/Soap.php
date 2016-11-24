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
namespace Netresearch\Dhl\LocationFinder\Webservice\Adapter;
use Netresearch\Dhl\LocationFinder\ParcelLocation\Collection as ParcelLocationCollection;
use Netresearch\Dhl\LocationFinder\Webservice\Adapter;
use Netresearch\Dhl\LocationFinder\Webservice\Parser as LocationParser;
use Netresearch\Dhl\LocationFinder\Webservice\RequestData;
use Netresearch\Dhl\Psf\Api as LocationsApi;

/**
 * Soap
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Soap implements Adapter
{
    /**
     * @var LocationsApi\SoapServiceImplService
     */
    private $soapClient;

    public function __construct(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * @param RequestData\Address $requestData
     * @param LocationParser $locationParser
     * @return ParcelLocationCollection
     */
    public function getParcelLocationByAddress(RequestData\Address $requestData, LocationParser $locationParser)
    {
        $requestType = new LocationsApi\getParcellocationByAddress($requestData->getAddress());
        $requestType->setService($requestData->getServices());

        $response = $this->soapClient->getParcellocationByAddress($requestType);
        return $locationParser->parse($response->getParcelLocation());
    }

    /**
     * @param RequestData\Coordinate $requestData
     * @param LocationParser $locationParser
     * @return ParcelLocationCollection
     */
    public function getParcelLocationByCoordinate(RequestData\Coordinate $requestData, LocationParser $locationParser)
    {
        $requestType = new LocationsApi\getParcellocationByCoordinate($requestData->getLat(), $requestData->getLng());
        $requestType->setService($requestData->getServices());

        $response = $this->soapClient->getParcellocationByCoordinate($requestType);
        return $locationParser->parse($response->getParcelLocation());
    }

    /**
     * Obtain last request from webservice client, optionally with headers.
     *
     * @return string
     */
    public function getLastRequest()
    {
        return $this->soapClient->__getLastRequest();
    }

    /**
     * Obtain last response from webservice client, optionally with headers.
     *
     * @param bool $withHeaders
     * @return string
     */
    public function getLastResponse($withHeaders = true)
    {
        $response = $this->soapClient->__getLastResponse();
        if ($withHeaders) {
            $response = sprintf("%s\n\n%s", $this->soapClient->__getLastResponseHeaders(), $response);
        }

        return $response;
    }
}
