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
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @copyright 2016 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/**
 * Dhl_LocationFinder_Test_Helper_DataTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author   Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Helper_DataTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function getMapJsUrl()
    {
        $helper = new Dhl_LocationFinder_Helper_Data();
        $jsUrl = $helper->getMapJsUrl();

        $this->assertInternalType('string', $jsUrl);
        $this->assertNotContains('key=', $jsUrl);
    }

    /**
     * @test
     */
    public function getMapJsUrlWithApiKey()
    {
        $configMock = $this->getModelMock('dhl_locationfinder/config', array('getApiKey'));
        $configMock->expects($this->once())
            ->method('getApiKey')
            ->willReturn('foo');
        $this->replaceByMock('model', 'dhl_locationfinder/config', $configMock);

        $helper = new Dhl_LocationFinder_Helper_Data();
        $jsUrl = $helper->getMapJsUrl();

        $this->assertInternalType('string', $jsUrl);
        $this->assertContains('key=', $jsUrl);
    }
}
