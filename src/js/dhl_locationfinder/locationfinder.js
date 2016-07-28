var DhlLocationFinder = Class.create();

DhlLocationFinder.prototype = {
    initialize: function (wrapperElementId, buttonElementId, formElementId, loadingElement, markerIcons, zoomMethod, zoomFactor) {
        this.initLocationFinder(wrapperElementId, buttonElementId);
        this.initDhlFields(formElementId);
        this.loadingElement = loadingElement;
        this.markerIcons = markerIcons;
        this.zoomMethod = zoomMethod;
        if (zoomFactor != undefined && zoomFactor === parseInt(zoomFactor, 10)) {
            this.zoomFactor = zoomFactor;
        } else {
            this.zoomFactor = 13;
        }
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
            var currentClass = this;

            // observe customer address book for other addresses
            var shippingAddressElement = $('shipping-address-select');
            if (shippingAddressElement != undefined) {
                shippingAddressElement.observe('change', function () {
                    $('shipping:useLocationFinder').checked = false;
                    currentClass.showLocationData(false);
                });
            }
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

            // Call initial Ajax request with billing data
            var selector = $('shipping:city');
            if (selector != undefined) {
                $('locationfinder-city').value = selector.value;
            }
            selector = $('shipping:postcode');
            if (selector != undefined) {
                $('locationfinder-zipcode').value = selector.value;
            }
            selector = $('shipping:street1');
            if (selector != undefined) {
                $('locationfinder-street').value = selector.value;
            }

            // Add only the country, if it exist for this service
            selector = $('shipping:country_id');
            if (selector != undefined) {
                var exists = false;
                $$('select#locationfinder-country option').each(function (el) {
                    if (el.value == selector.value) {
                        exists = true;
                        throw $break;
                    }
                });
                if (exists) {
                    $('locationfinder-country').value = selector.value;
                }
            }


            $('locationFinderForm').onsubmit();

        }
    },

    showLocationFinder: function () {
        this.mapWrapper.addClassName('active');
    },

    hideLocationFinder: function () {
        this.mapWrapper.removeClassName('active');
    },

    showLocationData: function (showElements) {

        var saveInAddressElement = $('shipping:save_in_address_book');
        var sameAsBillingElement = $('shipping:same_as_billing');
        if (showElements) {
            this.formFields.addClassName('active');
            $$('.locationfinder-opener')[0].addClassName('active');
            this.formFields.select('input').forEach(function (inputField) {
                inputField.disabled = false;
            });

            // secure DHL data
            $('shipping:street1').readOnly = true;
            $('shipping:city').readOnly = true;
            $('shipping:country_id').readOnly = true;
            $('shipping:postcode').readOnly = true;
            sameAsBillingElement.disabled = true;
            sameAsBillingElement.checked = false;

            // Add post number to required fields
            $('shipping:dhl_post_number').addClassName('required-entry');

            // Prevent saving this address to customer addresses
            if (saveInAddressElement != undefined) {
                saveInAddressElement.disabled = true;
                saveInAddressElement.checked = false;
            }

            // Add basic data into the shipping fields from the billing fields
            this.syncWithBillingAddress();
            if ($('shipping:region_id') != undefined) {
                $('shipping:region_id').value = '';
            }

        } else {
            this.formFields.removeClassName('active');
            $$('.locationfinder-opener')[0].removeClassName('active');
            this.formFields.select('input').forEach(function (inputField) {
                inputField.disabled = true;
                inputField.value = '';
            });

            // unsecure DHL data
            $('shipping:street1').readOnly = false;
            $('shipping:city').readOnly = false;
            $('shipping:country_id').readOnly = false;
            $('shipping:postcode').readOnly = false;
            sameAsBillingElement.disabled = false;

            // Remove post number from the required fields
            $('shipping:dhl_post_number').removeClassName('required-entry');

            if (saveInAddressElement != undefined) {
                saveInAddressElement.disabled = false;
            }
        }
    },

    updateMapInLocationFinder: function (formId, actionUrl) {
        if (formId && actionUrl) {

            var currentClass = this;
            var map = currentClass.map;
            var markerIcons = currentClass.markerIcons;

            $(currentClass.loadingElement).addClassName('active');
            currentClass.deactivateStoreFilter();
            new Ajax.Request(actionUrl, {
                parameters: $(formId).serialize(true),
                onSuccess: function (data) {
                    var responseData = JSON.parse(data.responseText);
                    // Check if stores was found
                    if (responseData['success']) {

                        // Set results as stores
                        var stores = [];
                        var filter = [];
                        var newCenter = '';
                        var bounds = new google.maps.LatLngBounds();
                        responseData['locations'].forEach(function (location) {

                            var coordinates = new google.maps.LatLng(location['lat'], location['long']);
                            bounds.extend(coordinates);
                            var store = new storeLocator.Store(
                                location['id'],
                                coordinates,
                                null,
                                {
                                    title: location['name'],
                                    hours: location['openingHours'],
                                    services: location['services'],
                                    address1: location['street'] + ' ' + location['houseNo'],
                                    address2: location['zipCode'] + ' ' + location['city'],
                                    icon: markerIcons[location['type']],
                                    street: location['street'] + ' ' + location['houseNo'],
                                    city: location['city'],
                                    country: location['country'],
                                    zipCode: location['zipCode'],
                                    type: location['type'],
                                    station: location['station'] + ' ' + location['number']
                                }
                            );
                            // Set InfoWindow information for later use, to get the location credentials
                            store.getInfoWindowContent = function () {
                                var details = this.getDetails();
                                var linkElement = '<p>' +
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
                                    '</p>';

                                return '<div class="store-infos">' +
                                    '<h3>' + details.title + '</h3>' +
                                    linkElement +
                                    '<p>' + details.address1 + '</p>' +
                                    '<p>' + details.address2 + '</p>' +
                                    '<p>' + details.station + '</p>' +
                                    '<p class="opening-hours-wrapper">' + details.hours + '</p>' +
                                    '<p>' + details.services + '</p>' +
                                    linkElement +
                                    '</div>';
                            };
                            if (newCenter == '') {
                                newCenter = coordinates;
                            }
                            stores.push(store);

                            // Add new added store type to filter activation, if not exist already
                            if (filter.indexOf(location['type']) == -1) {
                                filter.push(location['type']);
                            }
                        });

                        currentClass.stores = stores;

                        if (typeof currentClass.view === 'undefined') {

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
                        stores.forEach(function (store) {
                            // For the case, a store will use multiple times (through multiple searches)
                            google.maps.event.clearListeners(currentClass.view.getMarker(store), 'dblclick');
                            currentClass.view.getMarker(store).setVisible(true);

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
                            if (currentClass.zoomMethod == 'fixed') {
                                map.setZoom(currentClass.zoomFactor);
                            } else {
                                map.fitBounds(bounds);
                            }
                            currentClass.view.refreshView();
                        }

                        // Activate filter
                        currentClass.activateStoreFilter(filter);

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

    deactivateStoreFilter: function () {
        var typeArray = ['packStation', 'postOffice', 'parcelShop'];
        typeArray.forEach(function (type) {
            var selector = $('locationfinder:show_' + type);
            if (selector != undefined) {
                selector.disabled = true;
                selector.checked = false;
            }
        });
    },

    activateStoreFilter: function (typeArray) {
        typeArray.forEach(function (type) {
            var selector = $('locationfinder:show_' + type);
            if (selector != undefined) {
                selector.disabled = false;
                selector.checked = true;
            }
        });
    },

    filterStores: function (visibility, type) {
        this.stores.forEach(function (store) {
            if (store.getDetails().type == type) {
                store.getMarker().setVisible(visibility);
            }
        });
    },

    transmitStoreData: function (dataObject) {
        $('shipping:street1').setValue(dataObject.street);
        $('shipping:city').setValue(dataObject.city);
        $('shipping:country_id').setValue(dataObject.country);
        $('shipping:postcode').setValue(dataObject.zipCode);
        $('shipping:dhl_station_type').setValue(dataObject.type);
        $('shipping:dhl_station').setValue(dataObject.station);
        this.hideLocationFinder();
    },

    syncWithBillingAddress: function () {
        arrElements = Form.getElements($('co-shipping-form'));
        for (var elemIndex in arrElements) {
            if (arrElements[elemIndex].id) {
                var sourceField = $(arrElements[elemIndex].id.replace(/^shipping:/, 'billing:'));
                if (sourceField) {
                    arrElements[elemIndex].value = sourceField.value;
                }
            }
        }
        shippingRegionUpdater.update();
        $('shipping:region_id').value = $('billing:region_id').value;
        $('shipping:region').value = $('billing:region').value;
    }
};
