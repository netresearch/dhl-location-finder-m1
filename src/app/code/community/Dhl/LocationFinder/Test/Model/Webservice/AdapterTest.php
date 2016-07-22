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
use Dhl\LocationFinder\Webservice\Adapter\Soap as SoapAdapter;
use Dhl\Psf\Api as LocationsApi;
/**
 * Dhl_LocationFinder_Test_Model_Webservice_AdapterTest
 *
 * @category Dhl
 * @package  Dhl_LocationFinder
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Dhl_LocationFinder_Test_Model_Webservice_AdapterTest
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function getLastRequest()
    {
        $requestBody = 'body';

        $clientStub = $this->getMockBuilder(LocationsApi\SoapServiceImplService::class)
            ->setMethods(['__getLastRequest'])
            ->getMock();

        $clientStub
            ->method('__getLastRequest')
            ->willReturn($requestBody);

        $adapter = new SoapAdapter($clientStub);
        $this->assertSame($requestBody, $adapter->getLastRequest());
    }

    /**
     * @test
     */
    public function getLastResponse()
    {
        $responseHeaders = 'headers';
        $responseBody = 'body';

        $clientStub = $this->getMockBuilder(LocationsApi\SoapServiceImplService::class)
            ->setMethods(['__getLastResponse', '__getLastResponseHeaders'])
            ->getMock();

        $clientStub
            ->method('__getLastResponseHeaders')
            ->willReturn($responseHeaders)
        ;
        $clientStub
            ->method('__getLastResponse')
            ->willReturn($responseBody)
        ;

        $adapter = new SoapAdapter($clientStub);
        $this->assertSame($responseBody, $adapter->getLastResponse(false));

        $responseWithHeaders = $adapter->getLastResponse();
        $this->assertNotEquals($responseHeaders, $responseWithHeaders);
        $this->assertNotEquals($responseBody, $responseWithHeaders);
        $this->assertStringStartsWith($responseHeaders, $responseWithHeaders);
        $this->assertStringEndsWith($responseBody, $responseWithHeaders);

    }
}
