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

=========================================================================
DHL Standortsuche Europa: Packstationen und Paketshops im Checkout wählen
=========================================================================

Die Standortsuche API Europa ist ein von DHL bereitgestellter Service,
der es ermöglicht, im One Page Checkout eine DHL Abholstation zu wählen
und diese als alternative Lieferadresse zu übernehmen.

.. contents:: DHL LocationFinder - Endbenutzer-Dokumentation

.. raw:: pdf

   PageBreak


Voraussetzungen
===============

Die nachfolgend benannten Voraussetzungen müssen für den reibungslosen Betrieb des Moduls DHL LocationFinder erfüllt sein.

Magento
-------

Folgende Magento-Versionen werden vom Modul unterstützt bzw. vorausgesetzt:

- Magento Community Edition 1.9
- Magento Community Edition 1.8
- Magento Community Edition 1.7

PHP
---

Folgende PHP-Versionen werden vom Modul unterstützt bzw. vorausgesetzt:

- PHP 7.0
- PHP 5.5
- PHP 5.4

Für die Anbindung der API muss die PHP SOAP Erweiterung auf dem Webserver installiert und aktiviert sein.

.. raw:: pdf

   PageBreak

Installation und Konfiguration
==============================

Im Folgenden wird beschrieben, wie das Modul installiert wird und welche
Konfigurationseinstellungen vorgenommen werden müssen.

Installation
------------

Installieren Sie die Dateien gemäß Ihrer bevorzugten Installations- und
Deployment-Strategie. Aktualisieren Sie den Konfigurations-Cache, damit die
Änderungen wirksam werden.

Beim ersten Aufruf des Moduls werden drei neue Adress-Attribute im System angelegt:

- ``dhl_post_number``
- ``dhl_station_type``
- ``dhl_station``

Diese Attribute werden in folgenden Tabellen hinzugefügt:

- ``sales_flat_quote_address``
- ``sales_flat_order_address``
- ``eav_attribute``

Konfiguration
-------------

Modulkonfiguration
~~~~~~~~~~~~~~~~~~

Öffnen Sie nach erfolgter Installation den Konfigurationsbereich:

::

    System → Konfiguration → Verkäufe → Zur Kasse (bzw.)
    System → Configuration → Sales → Checkout

Dort finden Sie einen neuen Reiter "DHL Parcelshop Finder" mit den für das Modul
relevanten Konfigurationseinstellungen.

.. list-table:: Konfiguration DHL LocationFinder
   :widths: 3 2 7
   :header-rows: 1

   * - Konfiguration
     - Pflichtfeld / fakultativ
     - Kommentar
   * - Google Maps API Key
     - Pflichtfeld
     - Zur Anzeige der DHL Abholstationen im Checkout wird die Google Maps API
       verwendet, die einen API Key erfordert.
   * - Suchergebnisse beschränken
     - fakultativ
     - Dieses Feld legt fest, wie viele Ergebnisse auf der Karte angezeigt werden.
       Die Standortsuche API Europa selbst liefert maximal 50 Abholstationen zurück.
   * - Zoom (Automatisch oder Festwert)
     - Pflichtfeld
     - Dieses Feld legt fest, ob die Karte im Checkout entsprechend der
       Suchergebnisse eingepasst oder ein fester Zoom-Faktor verwendet wird.
   * - Zoom-Faktor (nur bei Festwert)
     - Pflichtfeld
     - Sofern in der vorherigen Konfiguration eingestellt wurde, dass nach der
       Suche ein fester Zoom-Faktor verwendet werden soll, kann dieser hier
       ausgewählt werden. Werte zwischen 9 und 15 sind möglich, wobei 15 der
       größte Zoom-Faktor ist.

.. raw:: pdf

   PageBreak

Adressen
~~~~~~~~

Das Modul DHL LocationFinder führt neue Adress-Attribute ein. Um diese auch im
System anzuzeigen, ist es gegebenenfalls erforderlich, die Adress-Templates um
die neuen Attribute zu erweitern.

::

    System → Configuration → Customers → Customer Configuration → Address Templates

Im folgenden Bild sind die mit dem Modul ausgelieferten Standard-Templates zu sehen.

.. image:: images/address-templates.png
   :width: 16.5cm
   :height: 18cm
   :align: left

.. raw:: pdf

   PageBreak

Sollten Sie diesen Konfigurations-Abschnitt bereits verändert haben, müssen Sie
die Adress-Attribute manuell in Ihren Templates ergänzen, bspw.

::

    {{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}|{{/depend}}
    {{depend dhl_station}}{{var dhl_station}}|{{/depend}}

Text:

::

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

::

    {{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}}
    {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}{{depend dhl_post_number}},
    Postnummer: {{var dhl_post_number}}{{/depend}}{{depend dhl_station}}, {{var dhl_station}}{{/depend}},
    {{var street}}, {{var city}}, {{var region}} {{var postcode}}, {{var country}}

HTML:

::

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

::

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

::

    #{prefix} #{firstname} #{middlename} #{lastname} #{suffix}<br/>#{company}<br/>#{dhl_post_number},
    #{dhl_station}<br/>#{street0}<br/>#{street1}<br/>#{street2}<br/>#{street3}<br/>#{city}, #{region},
    #{postcode}<br/>#{country_id}<br/>T: #{telephone}<br/>F: #{fax}

.. raw:: pdf

   PageBreak

Hinweise bei der Verwendung des Modules
=======================================

Erlaubte Länder
---------------

Derzeit werden folgende Länder durch Standortsuche API Europa unterstützt:

- Belgien
- Deutschland
- Niederlande
- Österreich
- Polen
- Slowakei
- Tschechien

Somit sind auch nur maximal diese (je nach Shop-Konfiguration) als Auswahl im Checkout bei der Standortsuche verfügbar.

Sprachunterstützung
-------------------

Das Modul unterstützt die Lokalisierungen ``en_US`` und ``de_DE``. Die
Übersetzungen sind in den CSV-Übersetzungsdateien gepflegt und somit auch durch
dritte Module anpassbar.

Einbindung von jQuery
---------------------

Das im Modul DHL LocationFinder verwendete Google Maps Plugin *Store Locator*
basiert auf der JavaScript-Bibliothek jQuery. Diese wird durch die Template-Datei
``base/default/template/dhl_locationfinder/page/html/head.phtml`` eingebunden.

Nicht nochmals eingebunden wird jQuery bei Verwendung des *rwd*-Themes. Sollten
Sie ein angepasstes Theme einsetzen, das bereits jQuery ausliefert, übernehmen
Sie die Datei ``rwd/default/template/dhl_locationfinder/page/html/head.phtml``
in Ihr eigenes Theme.

Bearbeiten der Bestellung im Backend
------------------------------------

Da die Standorte von DHL kommen und sich theoretisch jederzeit in der Adresse oder verfügbarkeit ändern können,
wurde davon abgesehen die Lieferadressen mit ausgewählter Station für den Kunden abzuspeichern. Zuzüglich kann man die
Informationen über die Versandstation im Backend auch nicht anpassen.

Deaktivieren des Modules
------------------------

Sofern es gewünscht wird, das Modul zu deaktivieren, ohne es zu deinstallieren, kann man dies auf zwei verschiedene
Wege lösen.

1. Deaktivierung des Modules durch die 'app/etc/modules/Dhl_LocationFinder.xml' Datei. Darin den Wert für 'active' von
   true auf false abändern.

2. Deaktivieren der Frontend Ausgaben. Im Backend unter dem Menupunkt "System" -> "Konfiguration" -> "Erweitert"
   -> "Erweitert" -> "Deaktiviere Modulausgaben" können alle Ausgaben und die Einbindung der JavaScripte deaktiviert
   werden, wenn in der Zeile mit "Dhl_LocationFinder" der Wert "Aktiviert" auf "Deaktiviert" gesetzt wird.

.. raw:: pdf

   PageBreak

Abfrage über SOAP API
---------------------

Die neuen drei Attribute sind auch über die SOAP API abrufbar, wenn ein Aufruf alá "sales_order.info" statt findet.
