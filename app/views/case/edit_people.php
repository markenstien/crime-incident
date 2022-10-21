<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Person Involved</h4>
            <?php echo wLinkDefault(_route('case:show', $caseId), 'Back to case')?>
        </div>

        <div class="card-body">
            <?php Flash::show()?>
            <?php echo $_peopleForm->getForm()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>