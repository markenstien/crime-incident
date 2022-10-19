<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Station : <?php echo $station->name?></h4>
            <?php echo wLinkDefault(_route('station:create'), 'Create Station')?>
        </div>

        <div class="card-body">
            <?php Flash::show()?>

            <div class="table-responsive">
                <section>
                    <h4 class="mb-2">Station Info</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>Reference : </td>
                            <td><?php echo $station->reference?></td>
                        </tr>
                        <tr>
                            <td>Name : </td>
                            <td><?php echo $station->name?></td>
                        </tr>
                        <tr>
                            <td>Chief of Police : </td>
                            <td><?php echo $station->chief?></td>
                        </tr>
                        <tr>
                            <td>Hotline : </td>
                            <td><?php echo $station->hotline?></td>
                        </tr>
                        <tr>
                            <td>Address : </td>
                            <td><?php echo $station->address?></td>
                        </tr>
                        <tr>
                            <td>Description : </td>
                            <td><?php echo $station->description?></td>
                        </tr>
                        <tr>
                            <td><?php echo wLinkDefault(_route('station:edit', $station->id), 'Edit')?></td>
                        </tr>
                    </table>
                </section>

                <?php echo wDivider(20)?>
                <section>
                    <h4 class="mb-2">User Admin</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>Username : </td>
                            <td><?php echo $station_admin->username?></td>
                        </tr>
                        <tr>
                            <td>Created On : </td>
                            <td><?php echo $station_admin->created_at?></td>
                        </tr>
                    </table>
                </section>
            </div>
            <!-- <div class="table-responsive">
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
            </div> -->
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>