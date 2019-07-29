<?php
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en">
	<head>
		<!--====== Required meta tags ======-->
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--====== Title ======-->
		<title>Natural Disaster</title>

		<!--====== Favicon Icon ======-->
		<link rel="shortcut icon" href="images/favicon.png" type="image/png">

		<!--====== Style css ======-->
		<link rel="stylesheet" href="css/style.css">

	</head>

	<body>

    <body id="root" class="bg-primary text-white text-center alarm-message" style="height:100vh;">
        <!--span id="wheather_alert_data_display_cont align-middle"><?php if(isset($messageData)) //echo $messageData['alert_message']; ?></span-->

        <div class="container d-flex h-100">
            <div class="row justify-content-center align-self-center text-center">
                <span id="wheather_alert_data_display_cont align-middle"><?php if(isset($messageData)) echo $messageData['alert_message']; ?></span>
            </div>
        </div>

	</body>
	
    <script type="text/javascript" src="js/jquery.min.js"></script>
</html>
