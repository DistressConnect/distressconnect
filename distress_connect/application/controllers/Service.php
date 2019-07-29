<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller
{
	public $role;
	public function __construct()
	{
		parent::__construct();
		# helpers
		$this->load->helper('url');

		# libraries
		$this->load->library('user_agent');

		# models
		$this->load->model('getter_model');
		$this->load->model('user_model');
		$this->role = $this->session->userdata('role');
	}


	private function random_color_part() {
    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	private function random_color() {
    	return self::random_color_part() . self::random_color_part() . self::random_color_part();
	}

	private function fixed_random_color() {
		$colors = array('#ffcdd2','#f8bbd0','#e1bee7','#d1c4e9','#c5cae9','#bbdefb','#b3e5fc','#b2ebf2','#b2dfdb','#c8e6c9','#dcedc8','#f0f4c3','#ffecb3','#ffe0b2','#ffccbc','#d7ccc8','#cfd8dc');
		$key = array_rand($colors, 1);
		return $colors[$key];
	}


    # Remap
	function _remap($method)
	{
		if($method != "login")
		{
			if(!$this->role)
			{
				echo json_encode(array('status'=>0, 'msg'=>'Session out! Please login.', 'login'=>false));
				exit(0);
			}
		}

		//if($this->input->is_ajax_request() && in_array(strtolower($method), array_map('strtolower', get_class_methods($this))))
		if(in_array(strtolower($method), array_map('strtolower', get_class_methods($this))) || $this->input->is_ajax_request())
		{
			$uri = $this->uri->segment_array();
			unset($uri[1]);
			unset($uri[2]);
			call_user_func_array(array($this, $method), $uri);
		}
		else
		{
			echo json_encode(array('status'=>0, 'msg'=>'Invalid requests'));
		}
    }

	function login()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		$post_data 	= $this->input->post();
		$result 	= $this->user_model->login();
		if( $result['status'] )
		{
			if((int)$result['logged_in_by'] == 2)
			{
				echo json_encode(array('status'=>0, 'msg'=>$result['msg']));
				exit(0);
			}
			else
			{
				$userfullname 		= $this->session->userdata('user_data');
				echo json_encode(array('status'=>1, 'msg'=>$result['msg'], 'profile_name'=>$userfullname['fullname']));
				exit(0);
			}
		}
		else
		{
			echo json_encode(array('status'=>0, 'msg'=>$result['msg']));
			exit(0);
		}
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
			case 'GET_NODE_REQUEST_MESSAGE_DATA':
				$data 	= $this->getter_model->get(null, 'GET_NODE_REQUEST_MESSAGE_DATA');
				if(!empty($data)):
					echo json_encode(array('status'=>1, 'msg'=>$data));
					exit();
				else:
					echo json_encode(array('status'=>0, 'msg'=>'No data found'));
					exit();
				endif;
			break;

			case 'GET_NODE_CONCURRENT_MESSAGE_DATA':
				//$data 	= $this->getter_model->get(null, 'GET_NODE_CONCURRENT_MESSAGE_DATA');
				$data 	= $this->getter_model->get(null, 'GET_NODE_REQUEST_MESSAGE_DATA');
				if(!empty($data)):
					echo json_encode(array('status'=>1, 'msg'=>$data));
					exit();
				else:
					echo json_encode(array('status'=>0, 'msg'=>'No data found'));
					exit();
				endif;
			break;

            default:
				echo json_encode(array('status'=>0, 'msg'=>'Operation failed! Conddtact support team.'));
				exit(0);
		}
	}
}
