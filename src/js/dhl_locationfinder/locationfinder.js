var DhlLocationFinder = Class.create();

DhlLocationFinder.prototype = {
    initialize: function (wrapperElementId, buttonElementId, className) {
        this.initLocationFinder(wrapperElementId, buttonElementId, className);
    },
// TODO(nr) look, if i need the className
    initLocationFinder: function (elementId, buttonElementId, className) {
        if (elementId && buttonElementId && className) {
            $('shipping-new-address-form').insert({
                top: $(buttonElementId)
            });

            $$('body')[0].insert({
                bottom: $(elementId)
            });
            this.mapWrapper = $(elementId);
        }
    },
    initMap: function (mapType, elementId) {
        if (!this.map && mapType && elementId) {

            this.mapType = mapType;
            this.mapElement = $(elementId);

            switch (this.mapType) {
                case 'googlemaps':

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
                    break;
                default:
                    break;
            }
            this.map = map;
        }
    },

    showLocationFinder: function () {
        this.mapWrapper.addClassName('active');

    },

    hideLocationFinder: function () {
        this.mapWrapper.removeClassName('active');
    },
    updateMapInLocationFinder: function (formId, actionUrl) {
        if (formId && actionUrl) {

            var map = this.map;
            new Ajax.Request(actionUrl, {
                parameters: $(formId).serialize(true),
                onSuccess: function (data) {
                    var responseData = JSON.parse(data.responseText);
                    // Check if stores was found
                    if (responseData['success']) {
                        /*
                         // Add Address of store in shipping form
                         var store = responseData['locations'][0];
                         $('shipping:street1').setValue(store['street'] + ' ' + store['houseNo']);
                         $('shipping:city').setValue(store['city']);
                         $('shipping:country_id').setValue(store['country']);
                         $('shipping:postcode').setValue(store['zipCode']);

                         alert('Adressdaten wurden übertragen');
                         */

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
                                    address: location['street'] + ' ' + location['houseNo'] + ' ' + location['zipCode'] + ' ' + location['city'],
                                    icon: location['icon'],
                                    street: location['street'] // custom info from webservice response, see below
                                }
                            );
                            if (newCenter == '') {
                                newCenter = coordinates;
                            }
                            stores.push(store);
                        });

                        // Add the Stores to a dataset
                        var dataFeed = new storeLocator.StaticDataFeed();
                        dataFeed.setStores(stores);

                        // Create View on the map
                        var view = new storeLocator.View(
                            map,
                            dataFeed,
                            {
                                geolocation: false
                            }
                        );
                        view.createMarker = function (store) {
                            var markerOptions = {
                                position: store.getLocation(),
                                icon: store.getDetails().icon,
                                title: store.getDetails().title
                            };
                            return new google.maps.Marker(markerOptions);
                        };

                        // Add Click Event for later use, to get the location credentials
                        stores.each(function (store) {
                            view.getMarker(store).addListener("click", function () {
                                console.log("TODO: write store info to form elements, e.g. " + this.getDetails().street);
                            }.bind(store));
                        });

                        // Update Map
                        if (newCenter != '') {
                            map.setCenter(newCenter);
                            map.setZoom(13);
                            view.refreshView();
                        }

                    } else {
                        alert(responseData['message']);
                    }
                }
            });
        }
    }
};
