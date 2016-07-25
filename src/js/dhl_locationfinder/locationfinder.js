var DhlLocationFinder = Class.create();

DhlLocationFinder.prototype = {
    initialize: function (wrapperElementId, buttonElementId, formElementId, loadingElement, markerIcons) {
        this.initLocationFinder(wrapperElementId, buttonElementId);
        this.initDhlFields(formElementId);
        this.loadingElement = loadingElement;
        this.markerIcons = markerIcons;
    },

    initLocationFinder: function (elementId, buttonElementId) {
        if (elementId && buttonElementId) {
            $('shipping-new-address-form').insert({
                top: $(buttonElementId)
            });

            $$('body')[0].insert({
                bottom: $(elementId)
            });
            this.mapWrapper = $(elementId);
        }
    },

    initDhlFields: function (elementId) {
        if (elementId) {
            $$('#shipping-new-address-form ul')[0].insert({
                before: $(elementId)
            });
            this.formFields = $(elementId);
        }
    },

    initMap: function (elementId) {
        if (!this.map && elementId) {

            this.mapElement = $(elementId);

            var map = new google.maps.Map(
                this.mapElement,
                {
                    center: new google.maps.LatLng(52.4945047, 13.4006041),
                    zoom: 11,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );

            /** set map center based on a given address -> Wont work if i try it before the map was loaded,
             * because the geocoder will be called after the map was loaded
             * see https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple
             * Get initial center from billing address
             */
            var geoCoder = new google.maps.Geocoder();
            geoCoder.geocode(
                {'address': $('billing:postcode').value + ', ' + $('billing:city').value},
                function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                    } else {
                        console.log('Geocode was not successful for the following reason: ' + status);
                    }
                }
            );
            this.map = map;
        }
    },

    showLocationFinder: function () {
        this.mapWrapper.addClassName('active');
    },

    hideLocationFinder: function () {
        this.mapWrapper.removeClassName('active');
    },

    showLocationData: function (showElements) {
        if (showElements) {
            this.formFields.addClassName('active');
            $$('.locationfinder-opener')[0].addClassName('active');
            this.formFields.select('input').each(function (inputField) {
                inputField.disabled = false;
                inputField.value = '';
            });

            // secure DHL data
            $('shipping:street1').readOnly = true;
            $('shipping:city').readOnly = true;
            $('shipping:country_id').readOnly = true;
            $('shipping:postcode').readOnly = true;

            // Add post number to required fields
            $('shipping:postNumber').addClassName('required-entry');
        } else {
            this.formFields.removeClassName('active');
            $$('.locationfinder-opener')[0].removeClassName('active');
            this.formFields.select('input').each(function (inputField) {
                inputField.disabled = true;
            });
            // unsecure DHL data
            $('shipping:street1').readOnly = false;
            $('shipping:city').readOnly = false;
            $('shipping:country_id').readOnly = false;
            $('shipping:postcode').readOnly = false;
            // Remove post number from the required fields
            $('shipping:postNumber').removeClassName('required-entry');
        }
    },

    updateMapInLocationFinder: function (formId, actionUrl) {
        if (formId && actionUrl) {

            var currentClass = this;
            var map = currentClass.map;
            var markerIcons = this.markerIcons;

            $(currentClass.loadingElement).addClassName('active');
            new Ajax.Request(actionUrl, {
                parameters: $(formId).serialize(true),
                onSuccess: function (data) {
                    var responseData = JSON.parse(data.responseText);
                    // Check if stores was found
                    if (responseData['success']) {

                        // Set results as stores
                        var stores = [];
                        var newCenter = '';
                        responseData['locations'].each(function (location) {

                            var coordinates = new google.maps.LatLng(location['lat'], location['long']);
                            var store = new storeLocator.Store(
                                location['id'],
                                coordinates,
                                null,
                                {
                                    title: location['name'],
                                    address1: location['street'] + ' ' + location['houseNo'],
                                    address2: location['zipCode'] + ' ' + location['city'],
                                    icon: markerIcons[location['type']],
                                    street: location['street'] + ' ' + location['houseNo'],
                                    city: location['city'],
                                    country: location['country'],
                                    zipCode: location['zipCode'],
                                    type: location['type'],
                                    station: location['station'] + ' ' + location['id']
                                }
                            );
                            // Set InfoWindow information for later use, to get the location credentials
                            store.getInfoWindowContent = function () {
                                var details = this.getDetails();
                                return '<div class="store-infos">' +
                                    '<h3>' + details.title + '</h3>' +
                                    '<p>' + details.address1 + '</p>' +
                                    '<p>' + details.address2 + '</p>' +
                                    '<p>' + details.station + '</p>' +
                                    '<p>' +
                                    '<a class="store-selector" ' +
                                    'href="javascript:void(0)" ' +
                                    'onclick="transmitFormData(this)" ' +
                                    'data-street="' + details.street + '" ' +
                                    'data-city="' + details.city + '" ' +
                                    'data-country="' + details.country + '" ' +
                                    'data-zipCode="' + details.zipCode + '" ' +
                                    'data-type="' + details.type + '" ' +
                                    'data-station="' + details.station + '" >' +
                                    Translator.translate("Use this station") +
                                    '</a>' +
                                    '</p>' +
                                    '</div>';
                            };
                            if (newCenter == '') {
                                newCenter = coordinates;
                            }
                            stores.push(store);
                        });

                        if (typeof currentClass.view === "undefined") {

                            // Add the Stores to a dataset
                            currentClass.dataFeed = new storeLocator.StaticDataFeed();
                            currentClass.dataFeed.setStores(stores);

                            // Create View on the map
                            currentClass.view = new storeLocator.View(
                                map,
                                currentClass.dataFeed,
                                {
                                    geolocation: false
                                }
                            );

                            currentClass.view.createMarker = function (store) {
                                var markerOptions = {
                                    position: store.getLocation(),
                                    icon: markerIcons[store.getDetails().type],
                                    title: store.getDetails().title
                                };
                                return new google.maps.Marker(markerOptions);
                            };
                        } else {
                            currentClass.view.clearMarkers();
                            currentClass.dataFeed.setStores(stores);
                        }

                        // Add Click Event for later use, to get the location credentials
                        stores.each(function (store) {
                            // For the case, a store will use multiple times (through multiple searches)
                            google.maps.event.clearListeners(currentClass.view.getMarker(store), 'dblclick');
                            currentClass.view.getMarker(store).addListener("dblclick", function () {
                                var dataObject = {
                                    'street': this.getDetails().street,
                                    'city': this.getDetails().city,
                                    'country': this.getDetails().country,
                                    'zipCode': this.getDetails().zipCode,
                                    'type': this.getDetails().type,
                                    'station': this.getDetails().station
                                };
                                currentClass.transmitStoreData(dataObject);
                            }.bind(store));
                        });

                        // Update Map
                        if (newCenter != '') {
                            map.setCenter(newCenter);
                            map.setZoom(13);
                            currentClass.view.refreshView();
                        }

                    } else {
                        alert(responseData['message']);
                    }
                },
                onComplete: function () {
                    $(currentClass.loadingElement).removeClassName('active');
                }
            });
        }
    },

    transmitStoreData: function (dataObject) {
        $('shipping:street1').setValue(dataObject.street);
        $('shipping:city').setValue(dataObject.city);
        $('shipping:country_id').setValue(dataObject.country);
        $('shipping:postcode').setValue(dataObject.zipCode);
        $('shipping:stationType').setValue(dataObject.type);
        $('shipping:station').setValue(dataObject.station);
        this.hideLocationFinder();
    }
};
