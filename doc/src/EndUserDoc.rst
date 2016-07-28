.. |date| date:: %d/%m/%Y
.. |year| date:: %Y

.. footer::
   .. class:: footertable

   +-------------------------+-------------------------+
   | Stand: |date|           | .. class:: rightalign   |
   |                         |                         |
   |                         | ###Page###/###Total###  |
   +-------------------------+-------------------------+

.. header::
   .. image:: images/dhl.jpg
      :width: 4.5cm
      :height: 1.2cm
      :align: right

.. sectnum::

=======================================================
DHL Parcel Shop Finder: Select Parcel Shops in Checkout
=======================================================

The shipping software Parcel Shop Finder is a service provided by DHL, which makes it possible for the checkout to
choose a DHL location as shipping address.

.. contents:: DHL Locationfinder - EndUser-Documentation

.. raw:: pdf

   PageBreak


Requirements
============

The following requirements must be met for the smooth operation of the DHL location finder module.

Magento
-------

The following Magento versions are supported or provided:

- Community-Edition 1.7, 1.8, 1.9

Server
------

- On the server PHP should be installed in the version 5.4.x or 5.5.x

- The SOAP extension must be installed and enabled on the server.

DHL-Locationfinder
------------------

The following DHL Location Finder data must be configured for the module:

.. list-table:: required DHL-Locationfinder data
   :widths: 4 2 6
   :header-rows: 1

   * - Configuration
     - Required / Optional
     - Comment
   * - Google Maps API Key
     - Required
     - The API Key is required for all new Web pages, otherwise the Google Map Api can not be used.
   * - Limit Results
     - Optional
     - This field decides how many results are shown on the map, where 50 represents the maximum amount returning from
       DHL.
   * - Fix Zoom or Boundaries
     - Optional
     - This field specifies whether, after a successful station search, a specified zoom factor is applied on the map
       or whether the map section aligns with the found stations.
   * - Fix Zoom
     - Optional
     - If in the previous configuration the fixed zoom factor was set, here the specific zoom factor can be defined.
       Values between 9-15 are possible. 15 is the largest zoom factor.

.. raw:: pdf

   PageBreak

Installation and Configuration
==============================

The module can be installed on the preferred path.

During the installation, three new attributes are integrated into the system. Their names are 'dhl_post_number',
'dhl_station_type' and 'dhl_station'. These attributes are added in the following three tables:
'sales_flat_quote_address', 'sales_flat_order_address' and 'eav_attribute'.

After the installation there exist under the point "System" -> "Configuration" -> "Checkout" a new tab
"DHL Parcel Shop Finder".
This tab contains all modules relevant configurations.

.. raw:: pdf

   PageBreak

Integration
===========

Immediately after installation, the module is active and can be used. So now you can see the output of the module
in the checkout process "shipping address".

In order to see the new attributes in orders, the address templates must be adjusted. With the installation an initial
adjustment of the address templates is done. But in case the templates was changed / saved already, they must changed
manually.
The following image shows how the templates look like after the installation on a fresh Magento.

.. image:: images/address-templates.png
   :width: 16.5cm
   :height: 18cm
   :align: left

.. raw:: pdf

   PageBreak

For an easy handling, here are the different templates, for copying uses. If the system need to have multiple changes
in the templates, this are the most important lines, for the location finder. The concrete parts can be copied from the
individual templates.

{{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}|{{/depend}}
{{depend dhl_station}}{{var dhl_station}}|{{/depend}}

Text:

.. sourcecode:: php

   {{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}}
   {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}
   {{depend company}}{{var company}}{{/depend}}
   {{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}{{/depend}}
   {{depend dhl_station}}{{var dhl_station}}{{/depend}}
   {{if street1}}{{var street1}}{{/if}}
   {{depend street2}}{{var street2}}{{/depend}}
   {{depend street3}}{{var street3}}{{/depend}}
   {{depend street4}}{{var street4}}{{/depend}}
   {{if city}}{{var city}}, {{/if}}{{if region}}{{var region}}, {{/if}}{{if postcode}}{{var postcode}}
   {{/if}}{{var country}}
   T: {{var telephone}}
   {{depend fax}}F: {{var fax}}{{/depend}}

Text One Line:

.. sourcecode:: php

   {{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}}
   {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}{{depend dhl_post_number}},
   Postnummer: {{var dhl_post_number}}{{/depend}}{{depend dhl_station}}, {{var dhl_station}}{{/depend}},
   {{var street}}, {{var city}}, {{var region}} {{var postcode}}, {{var country}}

HTML:

.. sourcecode:: php

   {{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}}
   {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}<br/>
   {{depend company}}{{var company}}<br />{{/depend}}
   {{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}<br />{{/depend}}
   {{depend dhl_station}}{{var dhl_station}}<br />{{/depend}}
   {{if street1}}{{var street1}}<br />{{/if}}
   {{depend street2}}{{var street2}}<br />{{/depend}}
   {{depend street3}}{{var street3}}<br />{{/depend}}
   {{depend street4}}{{var street4}}<br />{{/depend}}
   {{if city}}{{var city}},  {{/if}}{{if region}}{{var region}}, {{/if}}{{if postcode}}{{var postcode}}
   {{/if}}<br/>{{var country}}<br/>
   {{depend telephone}}T: {{var telephone}}{{/depend}}
   {{depend fax}}<br/>F: {{var fax}}{{/depend}}

.. raw:: pdf

   PageBreak

PDF:

.. sourcecode:: php

   {{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}}
   {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}|
   {{depend company}}{{var company}}|{{/depend}}
   {{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}|{{/depend}}
   {{depend dhl_station}}{{var dhl_station}}|{{/depend}}
   {{if street1}}{{var street1}}{{/if}}
   {{depend street2}}{{var street2}}|{{/depend}}
   {{depend street3}}{{var street3}}|{{/depend}}
   {{depend street4}}{{var street4}}|{{/depend}}
   {{if city}}{{var city}},  {{/if}}{{if region}}{{var region}}, {{/if}}{{if postcode}}{{var postcode}}
   {{/if}}| {{var country}}|
   {{depend telephone}}T: {{var telephone}}{{/depend}}|
   {{depend fax}}<br/>F: {{var fax}}{{/depend}}

JavaScript Template:

.. sourcecode:: php

   #{prefix} #{firstname} #{middlename} #{lastname} #{suffix}<br/>#{company}<br/>#{dhl_post_number},
   #{dhl_station}<br/>#{street0}<br/>#{street1}<br/>#{street2}<br/>#{street3}<br/>#{city}, #{region},
    #{postcode}<br/>#{country_id}<br/>T: #{telephone}<br/>F: #{fax}

.. raw:: pdf

   PageBreak

Hints when using the module
===========================

Allowed Countries
-----------------

Currently the following countries can be supported by the DHL Parcel Shop Finder.

- Austria
- Belgium
- Czech Republic
- Germany
- Netherlands
- Poland
- Slovakia

Thus, even this  as a selection in the checkout in this search.
These countries are therefore all available (depending on the store configuration) countries in the selection of
countries in the location search in the checkout.

Translations
------------

All translations are included in the supplied CSV files and thus adaptable by local translation files.

Use of jQuery
-------------

The extension of the Google Map API, the store locator, is based on the JavaScript framework jQuery. jQuery will be
included in the template file 'dhl_locationfinder/page/html/head.phtml'. If the store integrates jQuery already,
a local template can modify this behavior. For the default theme 'rwd' from Magento CE 1.9 a template file was already
prepared, which excludes the jQuery inclusion.

Edit the order in the backend
-----------------------------

Since the locations of the stations coming from DHL and could be different the next time, the shipping addresses will
knowingly not be saved for the customer and cannot be altered in the backend.

Deactivating the module
-----------------------

If it is necessary to deactivate the module without deinstalling it, there are two ways to achiev this.

1. Deactivate the module through the 'app/etc/modules/Dhl_LocationFinder.xml' file. Simply change the value in the node
   "active" from true to false.

2. "Disable Modules Output". In the backend under the point "System" -> "Configuration" -> "Advanced"
   -> "Advanced" -> "Disable Modules Output" all outputs including the JavaScript inclusions can be deactivated, if the
   value in the row with "Dhl_LocationFinder" will be changed from "Enable" to "Disable".

Query via SOAP API
------------------

The three new attributes are also accessible via the SOAP API when calling "sales_order.info".
