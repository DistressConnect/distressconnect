<?php
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Distress Team">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>public/assets/images/favicon.png">

    <title><?php echo BROWSER_TITLE; ?></title>

	<link rel="icon" href="<?php echo base_url(); ?>public/assets/images/favicon.png" type="image/x-icon">

	<!--Bootstrap -->
	<!--link href="<?php echo base_url(); ?>public/plugins/ct-bootstrap-4.3.1/dist/css/bootstrap.min.css" rel="stylesheet"-->

	<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"-->

	<link href="<?php echo base_url(); ?>public/assets/css/style.css" rel="stylesheet">


</head>

<body id="root" class="">
	<!-- Main content -->
	<div class="half-bg">
		<div class="cover bg-primary"></div>
	</div>
	<div class="container">
		<div class="row login">
			<div class="my-auto mx-auto">
				<div class="card login-box">
					<div class="card-body">
						<?php echo form_open(null, array('class'=>'login-form', 'id'=>'login_form')); ?>
							<h3 class="">Log In</h3>
							<div class="form-group">
								<label for="uname" class="">User Name</label>
								<input id="uname" name="username" class="form-control" type="text" required>
							</div>
							<div class="form-group">
								<label for="password" class="">Password</label>
								<input id="password" name="password" class="form-control" type="password" required>
							</div>
							<div class="form-group btn-container">
								<input type="submit" class="btn btn-block btn-primary mt-4" value="Log In">
							</div>

							<p class="semibold-text"><a href="<?php echo site_url('user/forgot_password'); ?>">Forgot Password ?</a></p>
							<hr>
							<?php echo (FOOTER_COPYRIGHT_TEXT); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--Bootstrap -->
	<script src="<?php echo base_url(); ?>public/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>public/plugins/jquery/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>public/plugins/jquery/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>public/plugins/ct-bootstrap-4.3.1/dist/js/bootstrap.min.js"></script>

	<!-- custom scripts -->
	<script src="<?php echo base_url(); ?>public/assets/js/form-validation.js"></script>
	<script src="<?php echo base_url(); ?>public/assets/js/custom.js"></script>

</body>
</html>
