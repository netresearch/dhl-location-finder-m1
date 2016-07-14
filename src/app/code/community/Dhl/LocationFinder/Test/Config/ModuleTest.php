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

/**
 * Dhl_LocationFinder_Test_Config_ModuleTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Config_ModuleTest
    extends EcomDev_PHPUnit_Test_Case_Config
{ 
    /**
     * @test
     */
    public function validateCodePool()
    {
        $this->assertModuleCodePool('community');
    }

    /**
     * @test
     */
    public function validateConfig()
    {
        $this->assertConfigNodeHasChild('global', 'helpers');
        $this->assertConfigNodeHasChild('global', 'models');
        $this->assertConfigNodeHasChild('global', 'resources');

        $this->assertConfigNodeHasChild('default', 'dhl_locationfinder');
        $this->assertConfigNodeHasChild('default/dhl_locationfinder', 'webservice');
        $this->assertConfigNodeHasChild('default/dhl_locationfinder/webservice', 'auth_username');
        $this->assertConfigNodeHasChild('default/dhl_locationfinder/webservice', 'auth_password');

        $this->assertConfigNodeHasChild('default', 'dhl');
        $this->assertConfigNodeHasChild('default/dhl', 'dhl_locationfinder');
        $this->assertConfigNodeHasChild('default/dhl/dhl_locationfinder', 'enable_store_finder');
        $this->assertConfigNodeHasChild('default/dhl/dhl_locationfinder', 'map_type');
    }
}
