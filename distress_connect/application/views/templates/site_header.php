<!--
 * Distress Connect
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
-->
<?php ini_set('memory_limit', '-1'); include_once("application/libraries/Custom.php"); ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
  <title><?php echo BROWSER_TITLE; ?></title>
  <meta charset="utf-8">
  <meta name = "format-detection" content = "telephone=no" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="author" content="Distress Team">
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />

  <link rel="icon" href="<?php echo base_url(); ?>public/assets/images/favicon.png" type="image/x-icon">

  <!--Bootstrap -->
  <link href="<?php echo base_url(); ?>public/assets/css/style-site.css" rel="stylesheet">


  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <?php
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT'");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  //echo date('d-m-Y H:i:s', 1518163003);
    $user_session_data = $this->session->userdata('user_data');
  ?>
  </head>

	<body id="root">
        <nav class="navbar navbar-expand-lg fixed-bottom navbar-dark bg-primary thematic-nav">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url('site'); ?>"><img src="<?php echo site_url(); ?>public/assets/images/logo.png" alt="Logo" class="logo-img"><div class="logo-text"><span class="d-none d-md-block"><?php echo HEADER_LOGO_TEXT; ?></span></div></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo site_url("site"); ?>">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url("user/login"); ?>">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
