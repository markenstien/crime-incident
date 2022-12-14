<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Record New Incident</h4>
            <?php echo wLinkDefault(_route('case:index'), 'Cases')?>
        </div>

        <div class="card-body">
            <?php echo $_form->start()?>
            <?php echo $_form->getFormItems()?>

            <div id="myMap" style="width: 500px; height:500px"></div>

            <?php echo wDivider(15)?>
            <div class="form-group">
                <?php Form::submit('' , 'Save Incident')?>
            </div>
            <?php echo $_form->end()?>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
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
            map = new google.maps.Map(document.getElementById("myMap"), {
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
<?php endbuild()?>
<?php loadTo()?>
    