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
use Dhl\Psf\Api\psfOtherinfo;
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
     * Extract opening hours dimension indicator from psfOtherinfo[].
     *
     * @param psfOtherinfo[] $otherInfos
     * @param string $dimensionType
     * @return string
     */
    protected function parseOpeningHourDimension(array $otherInfos, $dimensionType)
    {
        $dimension = array_reduce($otherInfos, function ($carry, psfOtherinfo $otherInfo) use ($dimensionType) {
            if ($otherInfo->getType() === $dimensionType) {
                $carry = $otherInfo->getContent();
            }
            return $carry;
        }, 0);

        return $dimension;
    }

    /**
     * Extract opening hours information from psfOtherinfo[].
     *
     * @param psfOtherinfo[] $otherInfos
     * @return string[]
     */
    protected function parseOpeningHours(array $otherInfos)
    {
        $tableRows = $this->parseOpeningHourDimension($otherInfos, 'tt_openinghour_rows');
        $tableCols = $this->parseOpeningHourDimension($otherInfos, 'tt_openinghour_cols');

        $openingHoursData = array_reduce($otherInfos, function ($carry, psfOtherinfo $otherInfo) {
            if (preg_match('/^tt_openinghour_(\d)(\d)$/', $otherInfo->getType(), $matches)) {
                $col = $matches[1];
                $row = $matches[2];
                $carry[$col][$row] = $otherInfo->getContent();
            }

            return $carry;
        }, array());

        // compare dimensions with extracted data
        if ( (count($openingHoursData) == $tableRows) && (count($openingHoursData[0]) == $tableCols) ) {
            return $openingHoursData;
        }

        return array();
    }

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
                'opening_hours'   => $this->parseOpeningHours($parcelLocation->getPsfOtherinfos()),
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
