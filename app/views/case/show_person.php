<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Person Involved In : <strong><?php echo $case->title?></strong></h4>
            <small>(Case Incident Name)</small>
            <?php echo wLinkDefault(_route('case:show', $case->id) , 'Back to Case')?>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Case #</td>
                                <td><?php echo $case->reference?></td>
                            </tr>
                            <tr>
                                <td>Involvement</td>
                                <td><?php echo $person->people_type?></td>
                            </tr>
                            <tr>
                                <td>Crime</td>
                                <td><?php echo $case->crime_type?></td>
                            </tr>

                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Name(Fullname, Lastname)</td>
                                <td><?php echo $person->fullname?></td>
                            </tr>

                            <tr>
                                <td>Is Deceased</td>
                                <td><?php echo $person->is_deceased?></td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td><?php echo $person->age?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td><?php echo $person->gender?></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td><?php echo $person->phone?></td>
                            </tr>
                            <tr>
                                <td>Edit</td>
                                <td><?php echo wLinkDefault(_route('case:editPeople', $person->id) ,'Edit')?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <div><strong>Injuries</strong></div>
                        <p><?php echo $person->injury_remarks?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>
