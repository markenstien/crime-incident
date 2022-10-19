<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Station</h4>
            <?php echo wLinkDefault(_route('station:index'), 'Stations')?>
        </div>

        <div class="card-body">
            <?php echo $_form->getForm()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>