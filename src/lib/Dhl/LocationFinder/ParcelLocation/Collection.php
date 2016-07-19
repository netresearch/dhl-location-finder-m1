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
 * Location
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @var Item[]
     */
    protected $locations = [];

    /**
     * @return int
     */
    public function count()
    {
        return count($this->locations);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->locations);
    }

    /**
     * Set all locations to the collection.
     *
     * @param Item[] $locations
     * @return $this
     */
    public function setItems(array $locations)
    {
        $this->locations = [];
        foreach ($locations as $location) {
            $this->addItem($location);
        }

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->locations;
    }

    /**
     * Add a location to the collection.
     *
     * @param Item $location
     * @return $this
     */
    public function addItem(Item $location)
    {
        $this->locations[$location->getId()] = $location;

        return $this;
    }

    /**
     * @param $id
     * @return Item|null
     */
    public function getItem($id)
    {
        if (!isset($this->locations[$id])) {
            return null;
        }

        return $this->locations[$id];
    }
}
