<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once("application/libraries/Custom.php");
class Site extends CI_Controller
{
	private $role;

	public function __construct()
	{
		parent::__construct();

		# helpers
		$this->load->helper(array('form'));
		$this->load->helper('captcha');

		# libraries
		$this->load->library('form_validation');
		$this->load->library('user_agent');

		# models
		$this->load->model('user_model');
		$this->load->model('getter_model');

		# libraries
		$this->load->library('email');

		$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
	}


	/*
	*	purpose : to check whether the method is correct or not
	*/
	public function _remap($method)
	{
		$class 	= $this->router->class;

		$non_auth_method = array('index', 'alarm', 'get', 'post');

		if(in_array($method, $non_auth_method) || $this->input->is_ajax_request())
			self::$method();
		else
			self::page_not_found();
	}

	/*
	*	purpose : Handle page not found
	*/
	public function page_not_found()
	{
		$this->load->view('templates/404.php');
		$this->load->view('templates/site_footer');
	}

	/**
	*	purpose : Entry point of user controller
	*/
	public function index()
	{
		$data = array();
		$this->load->view('templates/site_header');
		$this->load->view('site/index', $data);
		$this->load->view('templates/site_footer');
	}

	/**
	*	purpose : View alarm
	*/
	public function alarm()
	{
		$data = array();
		$this->load->view('site/alarm', $data);
	}

	# Search Results
    function get()
    {
        if( !isset($_GET['op']) || empty($_GET['op']) )
		{
			echo json_encode(array('status'=>0, 'msg'=>'Operation failed! Contact support team.'));
			exit(0);
		}
		$op = $_GET['op'];
		$response = array('status'=>0, 'msg'=>ERR_100);
		switch($op)
		{
			case 'GET_WHEATHER_DATA':
				header('Content-Type: application/json');
				$accessT 	= '320c9252a6e642f38c9252a6e682f3c6';
				$ip 		= IP_ADDRESS;
				$details 	= json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
				$geoIP 		= explode(",", $details->loc);

				$URL		= 'https://api.weather.com/v3/wx/observations/current?geocode='.$geoIP[0].'%2C'.$geoIP[1].'&units=m&language=en-US&format=json&apiKey='.$accessT;

				$URL1		= 'https://api.weather.com/v1/geocode/13.08/80.27/forecast/wwir.json?units=m&language=en-US&apiKey=320c9252a6e642f38c9252a6e682f3c6';

				$wheather_info_data 		= file_get_contents($URL);
				$wheather_alert_data 		= file_get_contents($URL1);
				if(!empty($wheather_info_data) || !empty($wheather_alert_data)):
					echo json_encode(array('status'=>1, 'wheather_info_msg'=>$wheather_info_data, 'wheather_alert_msg'=>$wheather_alert_data));
					exit();
				else:
					echo json_encode(array('status'=>0, 'msg'=>'No data found'));
					exit();
				endif;
			break;

			case 'GET_WHEATHER_DATA_FOR_MAPP':
				header('Content-Type: application/json');
				$accessT 	= '320c9252a6e642f38c9252a6e682f3c6';
				$ip 		= IP_ADDRESS;
				$details 	= json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
				$geoIP 		= explode(",", $details->loc);

				$URL		= 'https://api.weather.com/v3/wx/observations/current?geocode='.$geoIP[0].'%2C'.$geoIP[1].'&units=m&language=en-US&format=json&apiKey='.$accessT;

				$URL1		= 'https://api.weather.com/v1/geocode/13.08/80.27/forecast/wwir.json?units=m&language=en-US&apiKey=320c9252a6e642f38c9252a6e682f3c6';

				$wheather_info_data 		= json_decode(file_get_contents($URL), true);
				$wheather_alert_data 		= json_decode(file_get_contents($URL1), true);
				$w_info_string				= "It will be <b>".$wheather_info_data['cloudCoverPhrase']."</b>, Temperature <b>".$wheather_info_data['temperatureDewPoint']."</b> Degree, Humidity <b>".$wheather_info_data['relativeHumidity']."</b>, wind Direction <b>".$wheather_info_data['windDirectionCardinal']."</b> with Speed <b>".$wheather_info_data['windSpeed']."</b>";

				if(!empty($wheather_info_data) || !empty($wheather_alert_data)):
					echo json_encode(array('status'=>1, 'wheather_info_msg'=>$w_info_string, 'wheather_alert_msg'=>$wheather_alert_data['forecast']['terse_phrase']));
					exit();
				else:
					echo json_encode(array('status'=>0, 'msg'=>'No data found'));
					exit();
				endif;
			break;

			case 'GET_MAP_NODE_POINTS_DATA':
				$all_nodes 	= $this->getter_model->get(null, 'GET_MAP_NODE_POINTS_DATA');
				echo json_encode(array('status'=>1, 'data'=>$all_nodes, 'features'=>$all_nodes));
			break;

			case 'GET_NODE_ALERTS_DATA':
				$data 	= $this->getter_model->get(null, 'GET_NODE_ALERTS_DATA');
				if(!empty($data)):
					echo json_encode(array('status'=>1, 'msg'=>$data));
					exit();
				else:
					echo json_encode(array('status'=>0, 'msg'=>'No data found'));
					exit();
				endif;
			break;

			case 'PLAY_MESSAGE_OF_LORA':
				$message 		= $_GET['message'];
				$accessT 		= '4yrCKKQTlFKlsHtljUjFdKQfRPDU7kfydU_NxQNufH8j';
				$URL			= 'https://gateway-lon.watsonplatform.net/text-to-speech/api/v1/synthesize';
				$format 		= 'audio/wav';
				header('Content-Type: '.$format); //for return of the media in the format you wish
				$data 			= array("text" => $message, "Accept" => $format); 
				$data_string 	= json_encode($data);
				$ch 			= curl_init();
				curl_setopt($ch, CURLOPT_URL,$URL);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_USERPWD, "apikey:4yrCKKQTlFKlsHtljUjFdKQfRPDU7kfydU_NxQNufH8j");				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
				$status_code 	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
				$result			= curl_exec ($ch);
				curl_close ($ch);

				//echo $result; will render out binary file use with above content type if desired.
				$myfile = fopen(FCPATH.'public'.DS.'audio_message'.DS.'test.wav', "w") or die("Unable to open file!");
				fwrite($myfile, $result);
				fclose($myfile);
			break;

            default:
				echo json_encode(array('status'=>0, 'msg'=>'Operation failed! Conddtact support team.'));
				exit(0);
		}
	}

	# Post data save
	function post()
    {
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		
		$json 	= file_get_contents('php://input');
		$_POST 	= json_decode($json, true);
		//print_R($_POST);
		/*$_POST['cdcu_id'] = "CDCU-2";
		$_POST['dcu_id'] = "DCU-4";
		$_POST['node_id'] = "NODE-7";
		$_POST['request_id'] = 1;
		$_POST['message'] = "RES*1*10003001*2@4@6@NO@10@12@14";*/
		/*$_POST['node_id'] = "NODE-5";
		$_POST['speech_message'] = "Earthquake Started";
		$_POST['op']	= "POST_NODE_MESSAGE_FOR_SPEECH";*/
		if( !isset($_POST['op']) || empty($_POST['op']) )
		{
			echo json_encode(array('status'=>0, 'msg'=>'Operation failed! Contact support team.'));
			exit(0);
		}
		$op = $_POST['op'];
		$response = array('status'=>0, 'msg'=>ERR_100);
		switch($op)
		{
			case 'POST_NODE_RESPONSE_MESSAGE':
				if(isset($_POST['cdcu_id']) && !empty($_POST['cdcu_id']) && isset($_POST['dcu_id']) && !empty($_POST['dcu_id']) && isset($_POST['node_id']) && !empty($_POST['node_id']) && isset($_POST['request_id']) && !empty($_POST['request_id']) && isset($_POST['message']) && !empty($_POST['message']))
				{
					$response 			= $this->user_model->log_post_data($_POST, 'POST_NODE_RESPONSE_MESSAGE');
					if($response['status'])
						echo json_encode(array('status'=>1, 'msg'=>$response['msg']));
					else
						echo json_encode(array('status'=>0, 'msg'=>$response['msg']));
				}
				else
				{
					echo json_encode(array('status'=>0, 'msg'=>'Invalid Data'));
					exit(0);
				}
			break;

			case 'POST_NODE_MESSAGE_FOR_SPEECH':
				if(isset($_POST['cdcu_id']) && !empty($_POST['cdcu_id']) && isset($_POST['dcu_id']) && !empty($_POST['dcu_id']) && isset($_POST['node_id']) && !empty($_POST['node_id']) && isset($_POST['request_id']) && !empty($_POST['request_id']) && isset($_POST['message']) && !empty($_POST['message']))
				{
					$response 			= $this->user_model->log_post_data($_POST, 'POST_NODE_MESSAGE_FOR_SPEECH');
					if($response['status'])
						echo json_encode(array('status'=>1, 'msg'=>$response['msg']));
					else
						echo json_encode(array('status'=>0, 'msg'=>$response['msg']));
				}
				else
				{
					echo json_encode(array('status'=>0, 'msg'=>'Invalid Data'));
					exit(0);
				}
			break;

			case 'POST_NODE_WEATHER_DATA':
				if(isset($_POST['cdcu_id']) && !empty($_POST['cdcu_id']) && isset($_POST['dcu_id']) && !empty($_POST['dcu_id']) && isset($_POST['node_id']) && !empty($_POST['node_id']) && isset($_POST['request_id']) && !empty($_POST['request_id']) && isset($_POST['message']) && !empty($_POST['message']))
				{
					$response 			= $this->user_model->log_post_data($_POST, 'POST_NODE_WEATHER_DATA');
					if($response['status'])
						echo json_encode(array('status'=>1, 'msg'=>$response['msg']));
					else
						echo json_encode(array('status'=>0, 'msg'=>$response['msg']));
				}
				else
				{
					echo json_encode(array('status'=>0, 'msg'=>'Invalid Data'));
					exit(0);
				}
			break;

			default:
				echo json_encode(array('status'=>0, 'msg'=>'Operation failed! Contact support team.1'));
				exit(0);
		}
	}
}
