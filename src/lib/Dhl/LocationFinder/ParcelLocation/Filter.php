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
namespace Dhl\LocationFinder\ParcelLocation;
/**
 * Filter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Filter
{
    /**
     * @var string[]
     */
    private $shopTypes = [];

    /**
     * Filter constructor.
     * @param string[] $shopTypes
     */
    public function __construct($shopTypes = [])
    {
        $this->shopTypes = $shopTypes;
    }

    /**
     * @param Collection $locationCollection
     * @return Collection
     */
    public function filter(Collection $locationCollection)
    {
        $locations = $locationCollection->getItems();
        $filteredLocations = array_filter(
            $locations,
            function (Item $location) {
                return (in_array($location->getType(), $this->shopTypes));
            }
        );

        $locationCollection->setItems($filteredLocations);
    }
}
