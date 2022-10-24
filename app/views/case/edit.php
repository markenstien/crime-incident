<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Record New Incident</h4>
            <?php echo wLinkDefault(_route('case:index'), 'Cases')?>
        </div>

        <div class="card-body">
            <?php echo $_form->start()?>
            <?php echo $_form->getFormItems()?>

            <section id="mapDiv" style="margin:0px auto;">
                <h4>Point Location here.</h4>
                <div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" 
                src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                <a href="https://123movies-to.org"></a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:600px;}</style><a href="https://www.embedgooglemap.net">google maps for websites</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style></div></div>
            </section>

            <?php echo wDivider(15)?>
            <div class="form-group">
                <?php Form::submit('' , 'Save Incident')?>
            </div>
            <?php echo $_form->end()?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>