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

use Dhl\LocationFinder\ParcelLocation\Formatter;
use Dhl\LocationFinder\ParcelLocation\Item;
use Dhl\Psf\Api\psfOtherinfo as OtherInfo;

/**
 * MapPopupFormatter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class MapPopupFormatter extends Formatter
{
    /**
     * @var string[]
     */
    private $translations = [];

    /**
     * @var string[]
     */
    private $allowedServices = ['parking', 'handicappedAccess'];

    /**
     * @param \stdClass $item
     */
    protected function formatOpeningHours(\stdClass $item)
    {
        // Only show opening hours for postOffice and parcelShops
        $resultString = '';
        if ($item->type != Item::TYPE_PACKSTATION) {
            // Get opening hours out of the item
            $workData         = array();
            $needleString     = 'tt_openinghour_';
            $openingHoursData = $item->openingHours;
            if (!empty($openingHoursData)) {
                /** @var OtherInfo $element */
                foreach ($openingHoursData as $element) {
                    switch ($element->getType()) {
                        case 'tt_openinghour_rows':
                            $workData['rows'] = (int)$element->getContent();
                            break;
                        case 'tt_openinghour_cols':
                            $workData['cols'] = (int)$element->getContent();
                            break;
                        case (preg_match('/' . $needleString . '.*/', $element->getType()) ? true : false):
                            $workData['hourData'][$element->getType()] = $element->getContent();
                            break;
                        default:
                            break;
                    }
                }
            }

            // convert the opening hours data into a string for the frontend
            $this->translations['dash'] = '-';
            $this->translations['|']    = '<br/>';
            $this->translations['-']    = ' - ';
            $needleData                 = array_keys($this->translations);
            $replaceData                = array_values($this->translations);

            $resultString .= '<span class="opening-hours h5">' . $this->translations['openHours'] . '</span>';
            for ($i = 0; $i < $workData['rows']; $i++) {
                for ($j = 0; $j < $workData['cols']; $j++) {
                    $timeElement = '';
                    // Separate columns
                    if ($j == 0) {
                        $timeElement .= '<span class="dayCol">';
                    } else {
                        $timeElement .= '<span class="timeCol">';
                    }
                    $timeElement .= $workData['hourData'][$needleString . $i . $j];
                    if ($j == 0) {
                        $timeElement .= ': ';
                    }
                    // replace non frontend values against them
                    $timeElement = str_replace($needleData, $replaceData, $timeElement);
                    $resultString .= $timeElement . '</span>';
                }
                $resultString .= '<br/>';
            }
        }

        $item->openingHours = $resultString;
    }

    /**
     * @param \stdClass $item
     */
    protected function formatService(\stdClass $item)
    {
        // Only show opening hours for postOffice and parcelShops
        $resultString = '';
        if ($item->type != Item::TYPE_PACKSTATION) {
            $serviceData = $item->services;

            $serviceData = array_intersect($serviceData, $this->allowedServices);

            // convert the services into a string for the frontend
            $needleData  = array_keys($this->translations);
            $replaceData = array_values($this->translations);

            if (count($serviceData) > 0) {
                $resultString .= '<span class="services h5">' . $this->translations['services'] . '</span><ul>';
                foreach ($serviceData as $service) {
                    $resultString .= '<li class="service">' . str_replace($needleData, $replaceData, $service)
                        . '</li>';
                }
                $resultString .= '</ul >';
            }

        }

        $item->services = $resultString;
    }

    /**
     * @param array $items
     * @param array $translations
     *
     * @return \stdClass[]
     */
    public function format(array $items, array $translations)
    {

        $this->translations = $translations;
        $items              = parent::format($items);
        foreach ($items as $item) {
            $this->formatOpeningHours($item);
            $this->formatService($item);
        }

        return $items;
    }
}
