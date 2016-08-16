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
 * Limiter
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Limiter
{
    private $limit = null;

    /**
     * Limiter constructor.
     * @param int $limit
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
    }

    /**
     * @param Collection $locationCollection
     * @return Collection
     */
    public function limit(Collection $locationCollection)
    {
        if ($this->limit === null || !is_numeric($this->limit)) {
            return $locationCollection;
        }

        $locations = $locationCollection->getItems();
        $limitedLocations = array_slice($locations, 0, $this->limit, true);

        $locationCollection->setItems($limitedLocations);
    }
}
