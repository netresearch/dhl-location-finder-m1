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
                            zoom: 10,
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
                        console.log(responseData['locations']);
                        //updateMapInCheckout(responseData['locations']);
                    } else {
                        alert(responseData['message']);
                    }
                }
            });
        }
    }
};
