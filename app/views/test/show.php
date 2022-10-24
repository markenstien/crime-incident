<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style>
        /* 
            * Always set the map height explicitly to define the size of the div element
            * that contains the map. 
            */
            #map {
            height: 100%;
            }

            /* 
            * Optional: Makes the sample page fill the window. 
            */
            html,
            body {
            height: 100%;
            margin: 0;
            padding: 0;
            }
    </style>

  </head>
  <body>
    <div id="map"></div>

    <!-- 
     The `defer` attribute causes the callback to execute after the full HTML
     document has been parsed. For non-blocking uses, avoiding race conditions,
     and consistent behavior across browsers, consider loading using Promises
     with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBECPs4r98OarC3M5j6BAE8foUEFVBWEao&callback=initMap&v=weekly"
      defer
    ></script>

    <script defer>
        let map;
        function initMap() {
            let myLatLng = { lat: 14.487088305467827, lng: 121.04419151316694 };
            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 15,
            });

            new google.maps.Marker({
                position: myLatLng,
                map,
                title : 'testing'
            });
        }
        window.initMap = initMap;
    </script>
  </body>
</html>