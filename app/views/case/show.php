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
                                <td>Barangay</td>
                                <td><?php echo $case->barangay?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
<?php loadTo()?>