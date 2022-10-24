<?php build('content') ?>
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search Case Incidents</h4>
            </div>


            <div class="card-body">
                <?php Flash::show()?>
                <?php if(is_null($cases)) :?>
                    <section class="mb-4">
                        <h4>Keyword Search</h4>
                        <?php
                            Form::open([
                                'method' => 'get'
                            ]);
                        ?>
                        <div class="form-group">
                            <?php
                                Form::text('keyword', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Enter: cases reference or person involve name']);
                            ?>
                        </div>

                        <?php Form::submit('keyword_search', 'keyword')?>

                        <?php Form::close()?>
                    </section>

                    <section class="mb-5">
                        <h4>Advance Filter search</h4>
                        <?php
                            Form::open([
                                'method' => 'get'
                            ]);
                        ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <?php echo $_formCommon->getCol('start_date'); ?>
                                </div>
                                <div class="col">
                                    <?php echo $_formCommon->getCol('end_date'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                                echo $_form->getCol('barangay_id', ['required' => false]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php echo $_form->getCol('crime_type_id', ['required' => false]); ?>
                        </div>

                        <div class="mt-3">
                            <?php Form::submit('advance_search', 'Advance Filter')?>
                        </div>

                        <?php Form::close()?>
                    </section>
                <?php else:?>
                    <?php echo wLinkDefault(_route('case:peopleSearch'), 'Remove Search')?>
                    <?php if(!empty($cases)) :?>
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Case #</th>
                                <th>Crime Type</th>
                                <th>Incident Date</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($cases as $key => $row) :?>
                                    <tr>
                                        <td><?php echo ++$key?></td>
                                        <td><?php echo $row->reference?></td>
                                        <td><?php echo $row->crime_type?></td>
                                        <td><?php echo $row->incident_date?></td>
                                        <td><?php echo wLinkDefault(_route('case:show', $row->case_id), 'Show')?></td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    <?php else:?>
                        <p class="text-center">No cases found.</p>
                    <?php endif?>
                <?php endif?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>