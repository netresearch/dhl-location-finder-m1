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
 * Dhl_LocationFinder_Setup
 *
 * @category  Dhl
 * @package   Dhl_LocationFinder
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author    Benjamin Heuer <benjamin.heuer@netresearch.de>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

/** @var Mage_Core_Model_Config $config */
$config = Mage::getModel('core/config');

//append new fields to address templates in system configuration
$html = Mage::getConfig()->getNode('default/customer/address_templates/html');
$html .= '{{depend dhl_post_number}}<br/>DH:{{var dhl_post_number}} {{/depend}}';
$html .= '{{depend dhl_station_type}}<br/>DH:{{var dhl_station_type}} {{/depend}}';
$html .= '{{depend dhl_station}}<br/>DH:{{var dhl_station}} {{/depend}}';
$config->saveConfig('customer/address_templates/html', $html);

$text = Mage::getConfig()->getNode('default/customer/address_templates/text');
$text .= '{{depend dhl_post_number}}DT:{{var dhl_post_number}} {{/depend}}';
$text .= '{{depend dhl_station_type}}DT:{{var dhl_station_type}} {{/depend}}';
$text .= '{{depend dhl_station}}DT:{{var dhl_station}} {{/depend}}';
$config->saveConfig('customer/address_templates/text', $text);

$oneline = Mage::getConfig()->getNode('default/customer/address_templates/oneline');
$oneline .= '{{depend dhl_post_number}}DO:{{var dhl_post_number}} {{/depend}}';
$oneline .= '{{depend dhl_station_type}}DO:{{var dhl_station_type}} {{/depend}}';
$oneline .= '{{depend dhl_station}}DO:{{var dhl_station}} {{/depend}}';
$config->saveConfig('customer/address_templates/oneline', $oneline);

$pdf = Mage::getConfig()->getNode('default/customer/address_templates/pdf');
$pdf .= '{{depend dhl_post_number}}<br/>DP:{{var dhl_post_number}} {{/depend}}';
$pdf .= '{{depend dhl_station_type}}<br/>DP:{{var dhl_station_type}} {{/depend}}';
$pdf .= '{{depend dhl_station}}<br/>DP:{{var dhl_station}} {{/depend}}';
$config->saveConfig('customer/address_templates/pdf', $pdf);

$js_template = Mage::getConfig()->getNode('default/customer/address_templates/js_template');
$js_template .= '{{depend dhl_post_number}}<br/>DJ:{{var dhl_post_number}} {{/depend}}';
$js_template .= '{{depend dhl_station_type}}<br/>DJ:{{var dhl_station_type}} {{/depend}}';
$js_template .= '{{depend dhl_station}}<br/>DJ:{{var dhl_station}} {{/depend}}';
$config->saveConfig('customer/address_templates/js_template', $js_template);
