<?php
    #ini_set("display_errors", 1);
    //header('Content-Type: application/json');
	//header("Access-Control-Allow-Origin: *");
    include_once('connection.php');
    /**
	*	Generate random password
	*/
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
    }
    
    /**
	*	Capture GET Request
	*/
    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if(isset($_GET['cdcu_id']) && !empty($_GET['cdcu_id']) && isset($_GET['dcu_id']) && !empty($_GET['dcu_id']) && isset($_GET['node_id']) && !empty($_GET['node_id']) && isset($_GET['request_id']) && !empty($_GET['request_id']) && isset($_GET['message']) && !empty($_GET['message']))
        {
            $message        = $_GET['message'];            
            $message_total  = explode('*', $message);
            $type           = $message_total[0];
            switch($type)
            {
                case 'REQ':
                    $dis_type_id    = $message_total[1];
                    $response_code  = $message_total[2];

                    $message_record_query   = "SELECT * FROM `tbl_disaster_messages` WHERE `response_code` = ".$response_code;
                    $messageResult  	    = mysqli_query($con, $message_record_query);
                    if($messageResult->num_rows == 1)
                    {
                        $messageData = mysqli_fetch_assoc($messageResult);
                        include_once($messageData['file'].".php");
                        $_SESSION['request_params'] = $_GET;
                    }
                    else
                    {
                        echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
                        exit(0);
                    }
                break;

                case 'ALERT':
                    $alert_type_id      = $message_total[1];
                    $response_code      = $message_total[2];

                    $message_record_query   = "SELECT `tbl_alert_messages`.*, `tbl_alert_type`.file FROM `tbl_alert_messages`, `tbl_alert_type` WHERE `tbl_alert_messages`.response_code = ".$response_code." AND `tbl_alert_type`.alert_type_id = ".$alert_type_id;
                    $messageResult  	    = mysqli_query($con, $message_record_query);
                    if($messageResult->num_rows == 1)
                    {
                        $messageData = mysqli_fetch_assoc($messageResult);
                        include_once("alerts.php");
                    }
                    else
                    {
                        echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
                        exit(0);
                    }
                break;

                default:
                    echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
                    exit(0);
            }
        }
        else
        {
            echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
            exit(0);
        }
    }
    /**
	*	Capture POST Request
	*/
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if(isset($_POST['op']) && !empty($_POST['op']))
        {
            include_once('phpMQTT.php');
            switch($_POST['op'])
            {
                case 'POST_NODE_COMMON_MESSAGE_DATA':
                    $request_data   = $_SESSION['request_params'];
                    $MQTT_CLIENT_ID = rand_string(8);
                    $message_total  = explode('*', $request_data['message']);
                    $type           = $message_total[0];
                    $dis_type_id    = $message_total[1];
                    $response_code  = $message_total[2];
                    $response_code  = (int)$response_code + 1;
					$message_string	= "NN&".$request_data['cdcu_id']."#".$request_data['dcu_id']."#".$request_data['request_id']."#".$request_data['node_id']."#RES*".$dis_type_id."*".$response_code."*".$_POST['death']."@".$_POST['casualty']."@".$_POST['house_damaged']."@".$_POST['is_road_blocked']."@".$_POST['animal_death']."@".$_POST['animal_casualty']."@".$_POST['electric_pole_destroyed'];
					$mqtt           = new phpMQTT(MQTT_SERVER, MQTT_PORT, $MQTT_CLIENT_ID);
					if ($mqtt->connect(true, NULL, MQTT_USERNAME, MQTT_PASSWORD)) {
						$mqtt->publish($request_data['node_id'], $message_string, 0);
                        $mqtt->close();
                        include_once("header.php");
                        echo '<div class="container text-center"><h2 class="mt-3">Message successfully Sent</h2></div>';
                        include_once("footer.php");
                    } else {
                        echo 'Message Not Sent';;
                    }
                break;

                case 'POST_NODE_RELIEF_MESSAGE_DATA':
                    $request_data   = $_SESSION['request_params'];
                    $MQTT_CLIENT_ID = rand_string(8);
                    $message_total  = explode('*', $request_data['message']);
                    $type           = $message_total[0];
                    $dis_type_id    = $message_total[1];
                    $response_code  = $message_total[2];
                    $response_code  = (int)$response_code + 1;
					$message_string	= "NN&".$request_data['cdcu_id']."#".$request_data['dcu_id']."#".$request_data['request_id']."#".$request_data['node_id']."#RES*".$dis_type_id."*".$response_code."*".$_POST['no_food_packet']."@".$_POST['no_drinking_water']."@".$_POST['no_polythenes']."@".$_POST['is_rescue_required']."@".$_POST['no_airlift']."@".$_POST['no_ndrf_personale'];
					$mqtt           = new phpMQTT(MQTT_SERVER, MQTT_PORT, $MQTT_CLIENT_ID);
					if ($mqtt->connect(true, NULL, MQTT_USERNAME, MQTT_PASSWORD)) {
						$mqtt->publish($request_data['node_id'], $message_string, 0);
                        $mqtt->close();
                        include_once("header.php");
                        echo '<div class="container text-center"><h2 class="mt-3">Message successfully Sent</h2></div>';
                        include_once("footer.php");
                    } else {
                        echo 'Message Not Sent';;
                    }
                break;

                case 'SEND_MESSAGE_TO_ADMIN':
                    $MQTT_CLIENT_ID = rand_string(8);
                    $request_data['cdcu_id']    = "CDCU-2";
                    $request_data['dcu_id']     = "DCU-4";
                    $request_data['request_id'] = "11";
                    $request_data['node_id']    = "NODE-6";
                    $message                    = $_POST['node_message'];

                    $response_code  = (int)$response_code + 1;
					$message_string	= "NN&".$request_data['cdcu_id']."#".$request_data['dcu_id']."#".$request_data['request_id']."#".$request_data['node_id']."#SMSG*".$message;
					$mqtt           = new phpMQTT(MQTT_SERVER, MQTT_PORT, $MQTT_CLIENT_ID);
					if ($mqtt->connect(true, NULL, MQTT_USERNAME, MQTT_PASSWORD)) {
						$mqtt->publish($request_data['node_id'], $message_string, 0);
                        $mqtt->close();
                        include_once("header.php");
                        echo '<div class="container text-center"><h2 class="mt-3">Message successfully Sent</h2></div>';
                        include_once("footer.php");
                    } else {
                        echo 'Message Not Sent';;
                    }
                break;

                default:
                    echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
            }
        }
        else
        {
            echo json_encode(array('status'=>0, 'msg'=>'Invalid Request'));
            exit(0);
        }
    }
?>
