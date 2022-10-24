<?php build('content')?>
	<div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
              <img src="http://www.officialgazette.gov.ph/images/uploads/philippine-national-police-assembly-march.jpg"
                      style="width:100%">
                <div class="card">
                    <div class="col-md-7 mx-auto">
                      <div class="auth-form-wrapper px-4 py-5">
                        <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                        <?php Flash::show()?>
                        <?php  __( $form->start() ); ?>
                          <div class="mb-3">
                            <?php __( $form->getCol('username' , ['required' => true]) ); ?>
                          </div>
                          <div class="mb-3">
                            <?php __( $form->getCol('password') ); ?>
                          </div>
                          <div>
                            <?php __($form->get('submit')) ?>
                          </div>
                          <!-- <a href="<?php echo _route('auth:register')?>" class="d-block mt-3 text-muted">Not a user? Sign up</a> -->
                        <?php __( $form->end() )?>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>


