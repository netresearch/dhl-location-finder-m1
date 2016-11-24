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
namespace Netresearch\Dhl\LocationFinder\Webservice;
use Netresearch\Dhl\LocationFinder\ParcelLocation\Collection as ParcelLocationCollection;
use Netresearch\Dhl\LocationFinder\Webservice\Parser as LocationParser;
use Netresearch\Dhl\LocationFinder\Webservice\RequestData;

/**
 * Adapter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
interface Adapter
{
    /**
     * @param RequestData\Address $requestData
     * @param LocationParser $locationParser
     * @return ParcelLocationCollection
     */
    public function getParcelLocationByAddress(RequestData\Address $requestData, LocationParser $locationParser);

    /**
     * @param RequestData\Coordinate $requestData
     * @param LocationParser $locationParser
     * @return ParcelLocationCollection
     */
    public function getParcelLocationByCoordinate(RequestData\Coordinate $requestData, LocationParser $locationParser);
}
