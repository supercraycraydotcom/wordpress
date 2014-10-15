/*
 * gmaps.js 
 * ========
 */
+function($) { 'use strict';
        if( typeof GMaps != "undefined" ) {
                var mapContainer = $('#map').height( $(window).height() / 2 ); // set the map container's height

                new GMaps({
                        div: '#map',
                        lat: mapContainer.data('lat'), 
                        lng: mapContainer.data('long'),
                        scrollwheel: false
                }).addMarker({
                        lat: mapContainer.data('lat'), 
                        lng: mapContainer.data('long'),
                        title: mapContainer.data('marker')
                });
        }
}(jQuery);