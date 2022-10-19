<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">List of Stations</h4>
            <?php echo wLinkDefault(_route('station:create'), 'Create Station')?>
        </div>

        <div class="card-body">
            <?php Flash::show()?>
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Name</th>
                        <th>Hotline</th>
                        <th>Address</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($stations as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->reference?></td>
                                <td><?php echo $row->name?></td>
                                <td><?php echo $row->hotline?></td>
                                <td><?php echo $row->address?></td>
                                <td>
                                    <?php echo wLinkDefault(_route('station:show', $row->id), 'Show')?>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>