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
  <meta name="author" content="Team Distress Connect">
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />

  <link rel="icon" href="<?php echo base_url(); ?>public/assets/images/favicon.png" type="image/x-icon">

  <!--Bootstrap -->
  <link href="<?php echo base_url(); ?>public/plugins/datatable/datatables.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>public/plugins/Date-Time-Picker-Bootstrap-4/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>public/assets/css/style.css" rel="stylesheet">


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
        <div class="loader-content">
            <div class="d-flex justify-content-center" style="padding-top:25%;">
                <strong>Loading Data. Please wait...</strong>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary thematic-nav">
            <a class="navbar-brand" href="<?php echo site_url('user/dashboard'); ?>"><img src="<?php echo site_url(); ?>public/assets/images/logo.png" alt="<?php echo (HEADER_LOGO_TEXT);?>" class="logo-img"> <div class="logo-text"><span class="d-none d-md-block"><?php echo HEADER_LOGO_TEXT; ?></span></div></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "DASHBOARD", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="dashboard"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url('user/dashboard'); ?>">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "USER", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="users"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url("user/users/all"); ?>">Users</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "GET_NODE_STATUS", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="get_node_status"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url("user/get_node_status"); ?>">Node Requests</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "SEND_ALERTS", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="send_alerts"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url("user/send_alerts"); ?>">Alerts</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "SPEECH_MESSAGE", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="speech_message"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url("user/speech_message"); ?>">Speech Message</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "REPORT", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(2)=="report"){echo "active";}?>">
                        <a class="nav-link" href="<?php echo site_url("user/report/all"); ?>">Report</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "SETTINGS", $this->session->userdata('role')) == 1):
                    ?>
                    <li class="nav-item dropdown <?php if(in_array($this->uri->segment(2), array("role_matrix","configuration"))){echo "active";} ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSettings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Settings
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSettings">
                            <?php
                                if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "ROLE", $this->session->userdata('role')) == 1):
                            ?>
                                <a class="dropdown-item" href="<?php echo site_url("user/role_matrix"); ?>">Role Matrix</a>
                            <?php endif; ?>
                            <?php
                                if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "MENU", "operation_name", "CONFIGURATION", $this->session->userdata('role')) == 1):
                            ?>
                                <a class="dropdown-item" href="<?php echo site_url("setting/configuration/all"); ?>">Configuration</a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown <?php if($this->uri->segment(2)=="change_password"){echo "active";}?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo($user_session_data['fullname']); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                            <!--<a class="dropdown-item" href="<?php echo site_url("user/profile_view"); ?>">Profile</a>-->
                            <a class="dropdown-item" href="<?php echo site_url("user/change_password"); ?>">Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo site_url("user/logout"); ?>">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
