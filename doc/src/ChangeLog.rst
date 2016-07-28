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

ChangeLog
=========

.. list-table::
   :header-rows: 1
   :widths: 1 1 6

   * - **Revision**
     - **Date**
     - **Description**

   * - 1.0.1
     - 27.07.2016
     - Features:

       * Select "Shipping per DHl Station" in checkout process, in the shipping address step
       * Show a Google Map for searching a dhl station
       * Show stations according to the selected address
       * Fill the shipping address with customer data and the address data from the chosen station
       * Save this Data into the order address and show them:
           * in the backend order view
           * per SOAP Call
           * in the transaction emails
           * in the frontend order view in the customer account

