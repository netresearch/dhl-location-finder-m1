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

===============================================================
DHL Lieferadressen: Adress-Suche von Packstationen und Filialen
===============================================================

Das Modul *DHL Lieferadressen* für Magento ermöglicht es, durch den von der DHL bereitgestellter Service Standortsuche API Europa,
DHL Abholstationen (Packstationen, Postfilialen und Paketshops) im Magento One Page Checkout zu wählen
und diese als alternative Lieferadresse zu übernehmen.

Als synonyme Bezeichnungen gelten auch: DHL Locationfinder, DHL Parcelshop Finder, DHL Standortsuche Europa

.. contents:: Endbenutzer-Dokumentation

.. raw:: pdf

   PageBreak

Voraussetzungen
===============

Die nachfolgend benannten Voraussetzungen müssen für den reibungslosen Betrieb des Moduls DHL *LocationFinder* erfüllt sein.

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
- PHP 5.6
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

Modulkonfiguration
------------------

Öffnen Sie nach erfolgter Installation den Konfigurationsbereich:

::

    System → Konfiguration → Verkäufe → Zur Kasse (bzw.)
    System → Configuration → Sales → Checkout

Dort finden Sie einen neuen Reiter "DHL Standortsuche" mit den für das Modul
relevanten Konfigurationseinstellungen.

.. list-table:: Konfiguration DHL Locationfinder
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
       Die Standortsuche API Europa liefert maximal 50 Abholstationen zurück.
   * - Zoom (Automatisch oder Festwert)
     - Pflichtfeld
     - Dieses Feld legt fest, ob die Karte im Checkout entsprechend den
       Suchergebnissen eingepasst oder ein fester Zoom-Faktor verwendet wird.
   * - Zoom-Faktor (nur bei Festwert)
     - Pflichtfeld
     - Sofern in der vorherigen Konfiguration eingestellt wurde, dass nach der
       Suche ein fester Zoom-Faktor verwendet werden soll, kann dieser hier
       ausgewählt werden. Werte zwischen 9 und 15 sind möglich, wobei 15 der
       größte Zoom-Faktor ist.

.. raw:: pdf

   PageBreak

Einrichten der Adress-Templates
-------------------------------

Das Modul *DHL Locationfinder* führt neue Adress-Attribute ein. Um diese auch im
System anzuzeigen, ist es gegebenenfalls erforderlich, die Adress-Templates um
die neuen Attribute zu erweitern.

::

    System → Configuration → Customers → Customer Configuration → Address Templates

Im folgenden Ausschnitt sind die mit dem Modul ausgelieferten Standard-Templates zu sehen.

.. image:: images/address-templates-clip.png
   :width: 16.5cm

Sollten Sie diesen Konfigurations-Abschnitt bereits verändert haben, müssen Sie
die Adress-Attribute manuell in Ihrer Systemkonfiguration ergänzen, bspw.

::

    {{depend dhl_post_number}}Postnummer: {{var dhl_post_number}}|{{/depend}}
    {{depend dhl_station}}{{var dhl_station}}|{{/depend}}

.. raw:: pdf

   PageBreak

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

Hinweise bei der Verwendung des Moduls
======================================

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

Somit sind auch nur maximal diese Länder (je nach Shop-Konfiguration) als
Auswahl im Checkout bei der Standortsuche verfügbar.

Sprachunterstützung
-------------------

Das Modul unterstützt die Lokalisierungen ``en_US`` und ``de_DE``. Die
Übersetzungen sind in den CSV-Übersetzungsdateien gepflegt und somit auch durch
dritte Module anpassbar.

Einbindung von jQuery
---------------------

Das im Modul *DHL Locationfinder* verwendete DHL Location Maps Plugin *Store Locator*
basiert auf der JavaScript-Bibliothek jQuery. Diese wird durch die Template-Datei
``base/default/template/dhl_locationfinder/page/html/head.phtml`` eingebunden.

Nicht eingebunden wird jQuery hingegen bei Verwendung des *rwd*-Themes. Sollten
Sie ein angepasstes Theme einsetzen, das bereits jQuery ausliefert, übernehmen
Sie die Datei ``rwd/default/template/dhl_locationfinder/page/html/head.phtml``
in Ihr eigenes Theme.

.. raw:: pdf

   PageBreak

Magento API
-----------

Die vom Modul *DHL Locationfinder* im System angelegten Adressattribute sind
für die Verwendung in Drittsystemen über die Magento API abrufbar.

SOAP V2
~~~~~~~

::

    $result = $proxy->salesOrderInfo($sessionId, $incrementId);
    var_dump($result->shipping_address);

SOAP V2 (WS-I Compliance Mode)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

::

    $result = $proxy->salesOrderInfo((object)array(
        'sessionId' => $sessionId->result,
        'orderIncrementId' => $incrementId,
    ));
    var_dump($result->result->shipping_address);

REST
~~~~

::

    curl --get \
        -H 'Accept: application/xml' \
        -H 'Authorization: [OAuth Header] \
        "https://magentohost/api/rest/orders/:orderid/addresses"

Beachten Sie, dass die neuen Attribute für den Abruf über die REST-API explizit
freigegeben werden müssen.

::

    System → Web Services → REST - Attributes

.. image:: images/rest-attributes.png
   :width: 50%
   :align: left

.. raw:: pdf

   PageBreak

Funktionsweise im Frontend
==========================

Magento Checkout
----------------

- Betreten Sie den Checkout wie im Magento Standard vorgesehen
- Geben Sie im Checkout Schritt *Rechnungsadresse* Ihre Rechnungsadresse an
- Wählen Sie die Option *An andere Adresse verschicken* aus und gehen weiter

.. image:: images/en-checkout-step-001.png
   :width: 5.0cm

Magento Checkout: Lieferadresse
-------------------------------

- Wenn Sie bereits mit Ihrem Kundenkonto eingeloggt sind und Ihr Adressbuch Dropdown zur Vefügung steht, wählen Sie die Option *Neue Adresse*
- Wählen Sie die Checkbox *Lieferung an eine DHL Abholstation* an
- Durch Aktivierung erscheinen die zusätzlichen Eingabefelder *DHL Postnummer* und *DHL Station* sowie zusätzliche Button *Packstation/ Postfiliale suchen*
- Per Klick auf den Button *Packstation/ Postfiliale suchen* öffnen Sie die DHL Location Map

.. image:: images/en-checkout-step-002-checkbox-locationfinder.png
   :width: 16.5cm

DHL Location Map: Initiales Anzeigeergebnis und neue Standortsuche
------------------------------------------------------------------

- Das initiale Anzeigeergebnis basiert stets auf der zuvor hinterlegten Rechnungsadresse
- Die Anzahl der Standort Ergebnisse und Zoomstufe der Map definieren Sie in der *Modulkonfiguration*
- Ändern Sie die Adressdaten gemäß Ihrer Standortsuche und starten den Prozess mit dem Button *Suchen*
- Für eine erfolgreiche Suche benötigen Sie mind. die Angabe *Land, Stadt* oder erweitert *Land, Stadt, PLZ* oder *Land, Stadt, PLZ, Straße ggf. Hausnummer*
- Das Dropdown Feld *Land* richtet sich nach Ihrer Systemkonfiguration gemäß ``general_country_default`` und ``general_country_allow``

.. image:: images/en-checkout-step-002-map-invoiceaddress.png
   :width: 16.5cm

DHL Location Map: Mögliche Filterung des Anzeigeergebnisses
-----------------------------------------------------------

- Durch Aktivierung oder Deaktivierung der Checkboxen können Sie das Anzeigeergebnis nach *Packstationen*, *Postfilialen* oder *Paketshops* filtern

.. image:: images/en-checkout-step-002-map-invoiceaddress-filtered.png
   :width: 16.5cm

.. raw:: pdf

   PageBreak

DHL Location Map: Zusätzliche Informationen und Übernahme des Standorts
-----------------------------------------------------------------------

- Per einfachen Klick auf das *Standort Icon* erhalten Sie zusätzliche Informationen zum Standort
- Für Packstationen (Packstation Nummer und Standortadresse)
- Für Postfilialen oder Paketshops (Titel, Standortadresse, Öffnungszeiten, Services)
- Per Klick auf den Textlink *Diesen Standort verwenden* können Sie den Standort übernehmen, die DHL Location Map schließt sich
- Per Doppel-Klick auf das *Standort Icon* können Sie den Standort direkt übernehmen, die Map schließt sich sofort

.. image:: images/en-checkout-step-002-shipping-information.png
   :width: 16.5cm

.. raw:: pdf

   PageBreak

Magento Checkout: Lieferadresse, Überprüfung Ihrer Angaben
----------------------------------------------------------

- Die Standortdaten der/ des *Packstationen*, *Postfilialen* oder *Paketshops* wurden übernommen, Sie können diese nicht manuell editieren
- Um einen anderen Standort zu wählen, öffen Sie wieder die DHL Location Map per Klick auf den Button *Packstation/ Postfiliale suchen*
- Haben Sie ein *Packstation* ausgewählt ergänzen Sie bitte Ihre persönlichen *DHL Postnummer*, dies ist ein Pflichtfeld
- Haben Sie ein/ eine *Postfiliale* oder *Paketshop* ausgewählt, benötigen Sie keine Angabe zur persönlichen *DHL Postnummer*
- Setzen Sie den Checkout wie im Magento Standard vorgesehen fort

.. image:: images/en-checkout-step-003-packstation-data.png
   :width: 16.5cm

Magento Checkout: Zusätzliche Hinweise
--------------------------------------

- Adressen von *Packstationen*, *Postfilialen* oder *Paketshops* können nicht im Adressbuch Ihres Kundenkontos gespeichert werden
- Falls Sie im Checkout Schritt *Lieferadresse* doch noch Ihre Rechnungsadresse verwenden möchten, deaktivieren Sie zuvor die Checkbox *Lieferung an eine DHL Abholstation*

.. raw:: pdf

   PageBreak

Deinstallation und Deaktivierung
================================

Gehen Sie wie folgt vor, um den *DHL Locationfinder* zu deinstallieren:

1. Löschen Sie alle Moduldateien aus dem Dateisystem.
2. Entfernen Sie die im Abschnitt `Installation`_ genannten Adressattribute.
3. Entfernen Sie den zum Modul gehörigen Eintrag ``dhl_locationfinder_setup`` aus der Tabelle ``core_resource``.
4. Entfernen Sie die zum Modul gehörigen Einträge ``checkout/dhl_locationfinder/*`` aus der Tabelle ``core_config_data``.
5. Leeren Sie abschließend den Cache.

Sollten Sie den *DHL Locationfinder* deaktivieren wollen, ohne ihn zu deinstallieren,
kann dies auf zwei verschiedenen Wegen erreicht werden.

1. Deaktivierung des Moduls

   Das Modul wird nicht geladen, wenn der Knoten ``active`` in der Datei
   ``app/etc/modules/Dhl_LocationFinder.xml`` von **true** auf **false**
   abgeändert wird.
2. Deaktivieren der Frontend-Ausgaben

   Das Modul wird im Frontend nicht angezeigt, wenn in der Systemkonfiguration
   die Modulausgaben deaktiviert werden.

   ::

       System → Konfiguration → Erweitert → Erweitert
           → Deaktiviere Modulausgaben → Dhl_LocationFinder

