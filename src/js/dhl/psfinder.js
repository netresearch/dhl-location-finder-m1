function addParcelFinderToShippingForm() {
    $('shipping-new-address-form').insert({
        top: $('dhl_psfinder_trigger')
    });
}

function addMapToCheckout(){
    this.insert({
        after: '<div id="map-canvas" style="height: 500px;"></div>'
    });

    var map = new google.maps.Map(
        document.getElementById('map-canvas'), // element
        {
            center: new google.maps.LatLng(52.4945047, 13.4006041),
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    // set map center based on a given address
    // see https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple
    var geoCoder  = new google.maps.Geocoder();
    geoCoder.geocode(
        { 'address': 'Nonnenstraße, Leipzig' },
        function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        }
    );

    // TODO(nr): build data feed from webservice response
    var store = new storeLocator.Store(
        '387', // id
        new google.maps.LatLng(52.4945047, 13.4006041), // location
        null, // features
        { // info
            title: 'Post-Kaffee/Schreibwaren',
            address: 'Urbanstr. 183 Berlin 10961',
            phone: '',
            misc: 'psfTimeinfos?',
            web: '',
            street: 'Urbanstr.' // custom info from webservice response, see below
        }
    );
    var stores = [store];

    var dataFeed = new storeLocator.StaticDataFeed();
    dataFeed.setStores(stores);

    var view = new storeLocator.View(
        map,
        dataFeed,
        {
            geolocation: false
        }
    );

    stores.each(function (store) {
        view.getMarker(store).addListener("click", function () {
            console.log("TODO: write store info to form elements, e.g. " + this.getDetails().street);
        }.bind(store));
    });
}
