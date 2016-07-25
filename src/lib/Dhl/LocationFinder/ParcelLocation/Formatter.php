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
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\LocationFinder\ParcelLocation;
/**
 * Formatter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Formatter
{
    /**
     * Obtain serializable location representation.
     *
     * @param Item[] $items
     *
     * @return \stdClass[]
     */
    public function format(array $items)
    {
        $locations = [];

        foreach ($items as $item) {
            $location               = new \stdClass();
            $location->type         = $item->getType();
            $location->name         = $item->getName();
            $location->station      = $item->getStation();
            $location->number       = $item->getNumber();
            $location->openingHours = $item->getOtherInfos();
            $location->services     = $item->getServices();
            $location->street       = $item->getStreet();
            $location->houseNo      = $item->getHouseNo();
            $location->zipCode      = $item->getZipCode();
            $location->city         = $item->getCity();
            $location->country      = $item->getCountry();
            $location->id           = $item->getId();
            $location->lat          = $item->getLatitude();
            $location->long         = $item->getLongitude();

            $locations[] = $location;
        }

        return $locations;
    }
}
