Dhl Parcel Shop Finder Extension
================================

The DHL Parcel Location Finder extension for Magento allows customers to select
Parcel Shops in the One Page Checkout.

Facts
-----
- version: 1.0.3
- [extension on GitLab](https://git.netresearch.de/dhl/location-finder-m1)
- [extension on Magento Connect](https://www.magentocommerce.com/magento-connect/dhl-location-finder-standortsuche.html)
  - extension key: Dhl_LocationFinder
  - Magento Connect 2.0 extension key: http://connect20.magentocommerce.com/community/Dhl_LocationFinder
  - [direct download link](http://connect20.magentocommerce.com/community/Dhl_LocationFinder/1.0.2/Dhl_LocationFinder-1.0.2.tgz)

Description
-----------
This extension integrates a map in the One Page Checkout that visualizes
Parcel Shops or Packstation machines. The customer can then select a location
nearby and use it as delivery address.

Requirements
------------
- PHP >= 5.5.0

Compatibility
-------------
- Magento CE >= 1.7

Installation Instructions
-------------------------

1. Install the extension via Magento Connect with the key shown above or install
   via composer / modman.
2. Clear the cache, logout from the admin panel and then login again.

More information on configuration and integration into custom themes can be found
in the [documentation](https://www.netresearch.de/fileadmin/user_upload/partner-dhl/downloads/location-finder/DHL_Parcel_Shop_Finder_EN.pdf).

Uninstallation
--------------
1. Remove all extension files from your Magento installation
2. Clean up the database.


    ALTER TABLE `sales_flat_quote_address`
        DROP COLUMN `dhl_post_number`,
        DROP COLUMN `dhl_station_type`,
        DROP COLUMN `dhl_station`
    ;

    ALTER TABLE `sales_flat_order_address`
        DROP COLUMN `dhl_post_number`,
        DROP COLUMN `dhl_station_type`,
        DROP COLUMN `dhl_station`
    ;

    DELETE FROM `eav_attribute` WHERE `attribute_code` IN (
        'dhl_post_number',
        'dhl_station_type',
        'dhl_station'
    );

    DELETE FROM `core_config_data` WHERE `path` LIKE 'checkout/dhl_locationfinder/%';
    
    DELETE FROM `core_resource` WHERE `code` = 'dhl_locationfinder_setup';

Support
-------
In case of questions or problems, please have a look at the
[Support Portal (FAQ)](http://dhl.support.netresearch.de/) first.

If the issue cannot be resolved, you can contact the support team via the
[Support Portal](http://dhl.support.netresearch.de/) or by sending an email
to <dhl.support@netresearch.de>.

Developer
---------
Christoph Aßmann | [Netresearch GmbH & Co. KG](http://www.netresearch.de/) | [@mam08ixo](https://twitter.com/mam08ixo)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2016 DHL Paket GmbH
