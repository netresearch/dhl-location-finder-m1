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
namespace Netresearch\Dhl\LocationFinder\ParcelLocation\Formatter;

use Netresearch\Dhl\LocationFinder\ParcelLocation\Item;

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
     * Convert opening hours information to markup.
     *
     * @param \stdClass $item
     */
    protected function formatOpeningHours(\stdClass $item)
    {
        if ($item->type === Item::TYPE_PACKSTATION) {
            // Only show opening hours for postOffice and parcelShops
            $item->openingHours = '';
        } else {
            $rowFormat = '<span class="dayCol">%s:</span><span class="timeCol">%s</span><br/>';

            $tableMarkup = array_map(function (array $tableRow) use ($rowFormat) {
                return $this->replace(sprintf($rowFormat, $tableRow[0], $tableRow[1]));
            }, $item->openingHours);

            $item->openingHours = '<span class="opening-hours h5">' . $this->translate('openHours') . '</span>';
            $item->openingHours.= implode("", $tableMarkup);
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
