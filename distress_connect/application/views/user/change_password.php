<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Password</li>
        </ol>
    </nav>

    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-4 offset-sm-4">
				<div class="card">
					<div class="card-header"><h5>Change Password</h5></div>
					<div class="card-body myspace">
						<div class="col-sm-12">
							<?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
							<?php echo form_open(null, array('id'=>'change_password_form')); ?>
								<div class="form-group">
									<label class="bmd-label-floating">New Password <span class="text-danger">*</span></label>
									<input id="new_password" type="password" class="form-control view_pass" name="new_password" placeholder="">
								</div>
								<div class="form-group">
									<label class="bmd-label-floating">New Password Retype <span class="text-danger">*</span></label>
									<input type="password" class="form-control view_pass" name="cnf_password" placeholder="">
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="show_password">
									<label class="custom-control-label" for="show_password">Show Password</label>
								</div>
								<!--<input type="submit" class="btn btn-primary btn-raised mt-3" data-form-name="change_password_form" value="Change Password">-->
                                <button class="btn btn-primary btn-raised mt-3" data-form-name="change_password_form" value="Change Password">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>