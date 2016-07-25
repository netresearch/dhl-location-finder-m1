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
namespace Dhl\LocationFinder\Webservice\Parser;

use Dhl\LocationFinder\Webservice\Parser;
use Dhl\LocationFinder\ParcelLocation\Collection as ParcelLocationCollection;
use Dhl\LocationFinder\ParcelLocation\Item as ParcelLocation;
use Dhl\Psf\Api\psfParcellocation;

/**
 * Location
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Location implements Parser
{
    /**
     * @param psfParcellocation[] $parcelLocations
     *
     * @return ParcelLocationCollection
     */
    public function parse($parcelLocations)
    {
        $collection = new ParcelLocationCollection();
        if (!$parcelLocations) {
            return $collection;
        }

        foreach ($parcelLocations as $parcelLocation) {
            $collection->addItem(new ParcelLocation([
                'key_word'        => $parcelLocation->getKeyWord(),
                'shop_type'       => $parcelLocation->getShopType(),
                'shop_number'     => $parcelLocation->getPrimaryKeyZipRegion(),
                'shop_name'       => $parcelLocation->getShopName(),
                'additional_info' => $parcelLocation->getAdditionalInfo(),
                'other_infos'     => $parcelLocation->getPsfOtherinfos(),
                'services'        => $parcelLocation->getPsfServicetypes(),
                'street'          => $parcelLocation->getStreet(),
                'house_no'        => $parcelLocation->getHouseNo(),
                'zip_code'        => $parcelLocation->getZipCode(),
                'city'            => $parcelLocation->getCity(),
                'country_code'    => $parcelLocation->getCountryCode(),
                'id'              => $parcelLocation->getPrimaryKeyDeliverySystem(),
                'latitude'        => $parcelLocation->getLocation()->getLatitude(),
                'longitude'       => $parcelLocation->getLocation()->getLongitude(),
            ]));
        }

        return $collection;
    }
}
