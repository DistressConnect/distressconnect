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

	<link href="<?php echo base_url(); ?>public/assets/css/style-site.css" rel="stylesheet">


</head>

<body id="root" class="">

    <div class="bg-white">
        <div class="bg-primary text-white alarm-message scroll-left">
            <!--marquee scrollamount="3" scrolldelay="60" >Alert message</marquee-->
            <p id="wheather_alert_data_display_cont">Loading...</p>
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
