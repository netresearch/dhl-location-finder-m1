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

==========================================================
DHL Locationfinder: Search Parcelstations and Post Offices
==========================================================

ChangeLog
=========

.. list-table::
   :header-rows: 1
   :widths: 2 2 10

   * - **Revision**
     - **Date**
     - **Description**


   * - 1.0.3
     - 02.12.2016
     - Bugfixes:

       * Update Region Field after the country was changed in the Location Map Popup
       * Remove all locations from the map, which do not accept shipping orders

       Improvements:

       * Improve translations to DHL standard
       * Add validation for Postnumber
       * Add full compatibility with the new DHL Versenden extension in version 1.0.0

   * - 1.0.2
     - 17.10.2016
     - Bugfixes:

       * Post account number is now properly required in checkout if a packing station is selected

       Improvements:

       * Add compatibility for address updates performed with the new DHL Versenden extension based on GKP2.0 API

   * - 1.0.1
     - 27.07.2016
     - Features:

       * Select "Shipping to parcelstation or post office" in checkout process, in the shipping address step
       * Show a Google Map for searching a DHL station
       * Show stations according to the selected address
       * Fill the shipping address with customer data and the address data from the chosen station
       * Save this Data into the order address and show them:
           * in the backend order view
           * per SOAP Call
           * in the transaction emails
           * in the frontend order view in the customer account

