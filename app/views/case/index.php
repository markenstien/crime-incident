<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">List of Incidents</h4>
            <?php echo wLinkDefault(_route('case:create'), 'Record New Incident')?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>Incident Reference</th>
                        <th>Crime Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Barangay</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($cases as $key => $row) :?>
                            <tr>
                                <td><?php echo $row->reference?></td>
                                <td><?php echo $row->crime_type?></td>
                                <td><?php echo $row->incident_date?></td>
                                <td><?php echo $row->incident_time?></td>
                                <td><?php echo $row->incident_status?></td>
                                <td><?php echo $row->barangay?></td>
                                <td><?php echo wLinkDefault(_route('case:show', $row->id), 'Show')?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>