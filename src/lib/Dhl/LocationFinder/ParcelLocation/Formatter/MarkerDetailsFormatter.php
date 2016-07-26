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
namespace Dhl\LocationFinder\ParcelLocation\Formatter;

use Dhl\LocationFinder\ParcelLocation\Item;
use Dhl\Psf\Api\psfOtherinfo;

/**
 * MarkerDetailsFormatter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class MarkerDetailsFormatter extends DetailsFormatter
{
    /**
     * Only display service information for the given types.
     *
     * @var string[]
     */
    private $servicesTypes = [];

    /**
     * MarkerDetailsFormatter constructor.
     *
     * @param string[] $translations
     * @param string[] $serviceTypes
     */
    public function __construct(array $translations, array $serviceTypes)
    {
        $translations['dash'] = '—';
        $translations['|']    = '<br/>';
        $translations['-']    = ' - ';

        $this->servicesTypes = $serviceTypes;

        parent::__construct($translations);
    }

    /**
     * @param psfOtherinfo[]  $info
     * @param string $dimensionType
     * @return string
     */
    protected function getOpeningHourDimension(array $info, $dimensionType)
    {
        $infoItems = array_filter($info, function (psfOtherinfo $infoItem) use ($dimensionType) {
            return ($infoItem->getType() === $dimensionType);
        });

        $infoItem = array_shift($infoItems);
        if (!$infoItem instanceof psfOtherinfo) {
            return '';
        }

        return $infoItem->getContent();
    }

    /**
     * @param psfOtherinfo[] $info
     * @return string[]
     */
    protected function getOpeningHourData(array $info)
    {
        $data = array_reduce($info, function ($carry, psfOtherinfo $infoItem) {
            if (preg_match('/^tt_openinghour_(\d)(\d)$/', $infoItem->getType(), $matches)) {
                $col = $matches[1];
                $row = $matches[2];
                $carry[$col][$row] = $infoItem->getContent();
            }

            return $carry;
        }, array());

        return $data;
    }

    /**
     * @param \stdClass $item
     */
    protected function formatOpeningHours(\stdClass $item)
    {
        if ($item->type === Item::TYPE_PACKSTATION) {
            // Only show opening hours for postOffice and parcelShops
            $item->openingHours = '';
        } else {
            $tableRows = $this->getOpeningHourDimension($item->openingHours, 'tt_openinghour_rows');
            $tableCols = $this->getOpeningHourDimension($item->openingHours, 'tt_openinghour_cols');
            $tableData = $this->getOpeningHourData($item->openingHours);

            // compare dimensions with extracted data
            if ( (count($tableData) == $tableRows) && (count($tableData[0]) == $tableCols) ) {
                $rowFormat = '<span class="dayCol">%s:</span><span class="timeCol">%s</span><br/>';

                $tableMarkup = array_map(function (array $tableRow) use ($rowFormat) {
                    return $this->replace(sprintf($rowFormat, $tableRow[0], $tableRow[1]));
                }, $tableData);

                $item->openingHours = '<span class="opening-hours h5">' . $this->translate('openHours') . '</span>';
                $item->openingHours.= implode("", $tableMarkup);
            }
        }
    }

    /**
     * Convert service information to markup.
     *
     * @param \stdClass $item
     */
    protected function formatService(\stdClass $item)
    {
        $itemServices = array_intersect($item->services, $this->servicesTypes);
        if ($item->type === Item::TYPE_PACKSTATION || !count($itemServices)) {
            // do not display any service information for the packStation type
            $item->services = '';
        } else {
            $serviceListFormat = '<span class="services h5">%s</span><ul>%s</ul>';
            $serviceItemFormat = '<li class="service">%s</li>';

            $serviceItemHtml = '';
            foreach ($itemServices as $itemService) {
                $serviceItemHtml.= sprintf($serviceItemFormat, $this->replace($itemService));
            }

            $item->services = sprintf($serviceListFormat, $this->translate('services'), $serviceItemHtml);
        }
    }

    /**
     * @param Item[] $items
     *
     * @return \stdClass[]
     */
    public function format(array $items)
    {
        $items = parent::format($items);

        foreach ($items as $item) {
            $this->formatOpeningHours($item);
            $this->formatService($item);
        }

        return $items;
    }
}
