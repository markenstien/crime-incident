<?php build('content') ?>
    <style>
        td
        {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Case Report</h4>
            <?php echo wLinkDefault(_route('case:index') , 'Back To Cases') ?>
        </div>

        <div class="card-body">
            <?php Flash::show()?>
            <section class="mb-3">
                <h4>Case Report info</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Reference</td>
                                <td><?php echo $case->reference?></td>
                            </tr>
                            <tr>
                                <td>Crime Type</td>
                                <td><?php echo $case->crime_type?></td>
                            </tr>
                            <tr>
                                <td>Case Name</td>
                                <td><?php echo $case->title?></td>
                            </tr>
                            <tr>
                                <td>Incident Date</td>
                                <td><?php echo $case->incident_date?></td>
                            </tr>
                            <tr>
                                <td>Incident Time</td>
                                <td><?php echo $case->incident_time?>(Military Time)</td>
                            </tr>
                            <tr>
                                <td>Station</td>
                                <td><?php echo $case->station_name?></td>
                            </tr>
                            <tr>
                                <td>Barangay</td>
                                <td><?php echo $case->barangay?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo wLinkDefault(_route('case:edit', $case->id), 'Edit Case')?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
            <div id="myMap" style="width: 500px; height:500px"></div>
            </section>

            <section>
                <div class="mb-3">
                    <h4>People</h4>
                    <?php echo wLinkDefault(_route('case:addPeople', $case->id), 'Add People')?>
                </div>

                <section class="mb-3">
                    <h5>Victims</h5>
                    <?php if(!$peopleArray['victims']) :?>
                        <p>No Victims Involved.</p>
                    <?php else:?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">Name</th>
                                <th style="width: 15%">Phone</th>
                                <th style="width: 5%">Gender</th>
                                <th style="width: 5%">Age</th>
                                <th>Is Deceased</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($peopleArray['victims'] as $victimKey => $victimRow) :?>
                                    <tr>
                                        <td><?php echo ++$victimKey?></td>
                                        <td><?php echo $victimRow->fullname?></td>
                                        <td><?php echo $victimRow->phone?></td>
                                        <td><?php echo $victimRow->gender?></td>
                                        <td><?php echo $victimRow->age?></td>
                                        <td><?php echo $victimRow->is_deceased?></td>
                                        <td>
                                            <?php echo wLinkDefault(_route('case:showPeople', $victimRow->id) ,'Show')?>
                                            <?php echo wLinkDefault(_route('case:editPeople', $victimRow->id) ,'Edit')?>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif?>
                </section>
                <section>
                    <h5>Suspects</h5>
                    <?php if(!$peopleArray['suspects']) :?>
                        <p>No Suspects Involved.</p>
                    <?php else:?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 15%">Name</th>
                                    <th style="width: 15%">Phone</th>
                                    <th style="width: 5%">Gender</th>
                                    <th style="width: 5%">Age</th>
                                    <th>Is Deceased</th>
                                    <th>Action</th>
                                </thead>

                                <tbody>
                                    <?php foreach($peopleArray['suspects'] as $suspectKey => $suspectRow) :?>
                                        <tr>
                                            <td><?php echo ++$suspectKey?></td>
                                            <td><?php echo $suspectRow->fullname?></td>
                                            <td><?php echo $suspectRow->phone?></td>
                                            <td><?php echo $suspectRow->gender?></td>
                                            <td><?php echo $suspectRow->age?></td>
                                            <td><?php echo $suspectRow->is_deceased?></td>
                                            <td>
                                                <?php echo wLinkDefault(_route('case:showPeople', $suspectRow->id) ,'Show')?>
                                                <?php echo wLinkDefault(_route('case:editPeople', $suspectRow->id) ,'Edit')?>
                                            </td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif?>
                </section>
            </section>
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
            let myLatLng = { lat: <?php echo $case->lat?>, lng: <?php echo $case->lng?> };
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