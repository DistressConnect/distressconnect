<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once("application/libraries/Custom.php");
include_once("application/third_party/phpMQTT.php");
class User extends CI_Controller
{
	private $role;

	public function __construct()
	{
		parent::__construct();

		$this->role = $this->session->userdata('role');

		# helpers
		$this->load->helper(array('form'));
		$this->load->helper('captcha');

		# libraries
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('image_lib');
		$this->load->library('email');
		$this->load->library('excel');

		# models
		$this->load->model('user_model');
		$this->load->model('getter_model');

		$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
		if( !in_array($this->router->fetch_method(), array("login", "forgot_password")) )
			$this->load->view('templates/header');
	}


	/*
	*	purpose : to check whether the method is correct or not
	*/
	public function _remap($method)
	{
		$class 	= $this->router->class;
		$role 	= $this->session->userdata('role');

		$non_auth_method = array('index', 'login', 'forgot_password', 'logout', 'password');

		/*$role_action_auth = array(
			'admin'=>array('users', 'dashboard', 'change_password', 'profile', 'profile_view', 'role_matrix', 'shg', 'household'),
		);

		if( $role !== false && isset($role_action_auth[$role]) && !in_array($method, $role_action_auth[$role]) && !in_array($method, $non_auth_method))
			self::page_not_found();
		else
			self::$method();*/
		if( $role !== false && $this->session->userdata('role_permission') != "" && searchPermissionArray($this->session->userdata('role_permission'), "module_name", "PAGE", "operation_name", $method, $role) != 1 && !in_array($method, $non_auth_method))
			self::page_not_found();
		else
			self::$method();
	}

	/*
	*	purpose : Handle page not found
	*/
	public function page_not_found()
	{
		$this->load->view('templates/404.php');
		$this->load->view('templates/footer');
	}


	/**
	*	purpose : Entry point of user controller
	*/
	public function index()
	{
		redirect('user/login');
	}


	/**
	*	purpose : Authenticate user
	*/
	public function login()
	{
		# if post is not empty
		if( $this->input->post() && $this->form_validation->run('login_user') !== FALSE)
		{
			$post_data = $this->input->post();
			$result = $this->user_model->login();
			if( $result['status'] )
			{
				if((int)$result['logged_in_by'] == 2)
				{
					$this->session->set_flashdata('info', $result['msg']);
					redirect('user/change_password');
				}
				else
				{
					$this->session->set_flashdata('info', $result['msg']);
					redirect('user/dashboard');
				}
			}
			else
			{
				$this->session->set_flashdata('error', $result['msg']);
				redirect($this->agent->referrer());
			}
		}
		$this->load->view('user/login');
	}

	// logout user
	public function logout()
	{
		$this->session->unset_userdata('user');

		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_data');
		$this->session->unset_userdata('role');

		// redirect to login
		$this->session->set_flashdata('info', 'User logout');
		redirect('user/login');
	}

	/**
	* Change password
	*/
	public function change_password()
	{

		if($this->input->post())
		{
			$response = $this->user_model->change_password();
			if($response['status'])
				$this->session->set_flashdata('info', $response['msg']);
			else
				$this->session->set_flashdata('error', $response['msg']);

			redirect($this->agent->referrer());
		}

		$this->load->view('user/change_password');
		$this->load->view('templates/footer');
	}


	/**
	* Forgot password
	*/
	public function forgot_password()
	{
		if($this->input->post())
		{
			$response 	= $this->user_model->forgot_password();
			if($response['status'])
			{
				if($this->sendMailToUser($response['return_data'], 'FORGOT_PASSWORD'))
					$this->session->set_flashdata('info', $response['msg']);
				else
					$this->session->set_flashdata('error', $response['msg']);
			}
			else
				$this->session->set_flashdata('error', $response['msg']);

			redirect($this->agent->referrer());
		}

		$this->load->view('user/forgot_password');
		//$this->load->view('templates/footer');
	}

	/**
	 *  Purpose : Sending Email
	*/
	public function sendMailToUser($data, $op)
	{
		switch($op)
		{
			case 'RESET_PASSWORD':
				$user_data  = $this->session->userdata('user_data');
				$from 	 	= $user_data['email'];
				$subject 	= "Password Reset Successfully";
				$message 	= $this->load->view('templates/reset_password', $data, true);
			break;

			case 'FORGOT_PASSWORD':
				$from 	 = 'putyourmailid@gmail.com';
				$subject = "Password Reset Successfully";
				$message = $this->load->view('templates/forgot_password', $data, true);
			break;

			default:
				redirect("user/logout");
		}

		$receiver_email = $data['email'];

		$this->email->initialize();
		$this->email->set_newline("\r\n");
		$this->email->from($from);
		$this->email->to($receiver_email);

		if(isset($data['cc_email']) && !empty($data['cc_email']))
		{
			$this->email->cc($data['cc_email']);
		}
		$this->email->subject($subject);
		$this->email->message($message);
		if($this->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	*	purpose : Show dashboard
	*/
	public function dashboard()
	{
		$user_id 			= $this->session->userdata('user_id');
		$data 				= array();
		$data				= $this->getter_model->get($user_id, 'GET_DASHBOARD_STATISTICS');
		$this->load->view('user/dashboard', $data);
		$this->load->view('templates/footer');
	}

	/**
	* Role Permission
	*/
	public function role_matrix()
	{
		$data['role_permission_data']	= $this->getter_model->get(null, 'GET_ROLE_PERMISSION_DATA');
		$data['permission_data'] 		= array();
		$data['all_roles'] 				= $this->getter_model->get(null, 'GET_ALL_ROLES');
		foreach($data['role_permission_data'] as $key=>$single_data)
		{
			$data['permission_data'][$single_data['module_name']][] = $single_data;
		}
		if($this->input->post())
		{
			$post_data = $this->input->post();
			$response = $this->user_model->role($post_data, 'ROLE_PERMISSION_SET');
			if($response['status'])
				$this->session->set_flashdata('info', $response['msg']);
			else
				$this->session->set_flashdata('error', $response['msg']);

			redirect($this->agent->referrer());
		}
		$this->load->view('user/role_matrix', $data);
		$this->load->view('templates/footer');
	}

	/**
	*	purpose : Manage Users
	*/
	public function users()
	{
		$type = $this->uri->segment(3);
		$data = array();
		$view = '';
		switch($type)
		{
			case 'all':
				$view = 'user/users';
				$data['all_user'] 			= $this->getter_model->get(null, 'GET_ALL_USERS');
				$data['all_roles'] 			= $this->getter_model->get(null, 'GET_ALL_ROLES');
			break;
			case 'delete_user':
				if(in_array($this->role, array('admin')))
				{
					$user_id 			= $this->uri->segment(4);
					$data['user_data'] 	= $this->getter_model->get($user_id, 'GET_SINGLE_USER');

					if(!$data['user_data'])
					{
						$this->session->set_flashdata('error', 'Invalid user');
						redirect('user/users/all');
					}

					$response = $this->user_model->users($user_id, 'DELETE_USER');
					if($response['status'])
						$this->session->set_flashdata('info', $response['msg']);
					else
						$this->session->set_flashdata('error', $response['msg']);

					redirect($this->agent->referrer());
				}
				else
					redirect('user/dashboard');
			break;
			case 'add_to_dcu':
				$view 							= 'user/add_to_dcu';
				$user_id 						= $this->uri->segment(4);
				$data['user_data'] 				= $this->getter_model->get($user_id, 'GET_SINGLE_NODE');
				$data['all_dcu']				= $this->getter_model->get(null, 'GET_ALL_DCU');
				$data['all_cdcu']				= $this->getter_model->get(null, 'GET_ALL_CDCU');
				//$data['added_node_to_dcu'] 		= $this->getter_model->get($user_id, 'GET_NODE_ADDED_TO_DCU');
				if(!$data['user_data'])
				{
					$this->session->set_flashdata('error', 'Invalid User!');
					redirect('user/dashboard');
				}
			break;
			case 'add_to_cdcu':
				$view 							= 'user/add_to_cdcu';
				$user_id 						= $this->uri->segment(4);
				$data['user_data'] 				= $this->getter_model->get($user_id, 'GET_SINGLE_DCU');
				$data['all_dcu']				= $this->getter_model->get(null, 'GET_ALL_DCU');
				$data['all_cdcu']				= $this->getter_model->get(null, 'GET_ALL_CDCU');
				//$data['added_node_to_dcu'] 		= $this->getter_model->get($user_id, 'GET_NODE_ADDED_TO_DCU');
				if(!$data['user_data'])
				{
					$this->session->set_flashdata('error', 'Invalid User!');
					redirect('user/dashboard');
				}
			break;
			case 'delete_user_added_to_dcu':
				$list['node_id'] 					= $this->uri->segment(4);
				$list['dcu_id']						= $this->uri->segment(5);
				$data['user_data'] 					= $this->getter_model->get($list['node_id'], 'GET_SINGLE_NODE');
				if(!$data['user_data'])
				{
					$this->session->set_flashdata('error', 'Invalid User!');
					redirect('user/dashboard');
				}

				$response 	= $this->user_model->users($list, 'DELETE_USER_ADDED_TO_DCU');
				if($response['status'])
					$this->session->set_flashdata('info', $response['msg']);
				else
					$this->session->set_flashdata('error', $response['msg']);
				redirect($this->agent->referrer());
			break;
			case 'delete_user_added_to_cdcu':
				$list['dcu_id'] 					= $this->uri->segment(4);
				$list['cdcu_id']						= $this->uri->segment(5);
				$data['user_data'] 					= $this->getter_model->get($list['dcu_id'], 'GET_SINGLE_DCU');
				if(!$data['user_data'])
				{
					$this->session->set_flashdata('error', 'Invalid User!');
					redirect('user/dashboard');
				}

				$response 	= $this->user_model->users($list, 'DELETE_USER_ADDED_TO_CDCU');
				if($response['status'])
					$this->session->set_flashdata('info', $response['msg']);
				else
					$this->session->set_flashdata('error', $response['msg']);
				redirect($this->agent->referrer());
			break;
			default:
				redirect('user/dashboard');
		}

		if($this->input->post())
		{
			switch($type)
			{
				case 'all':
					$post_data = $this->input->post();
					switch($post_data['op'])
					{
						case 'add':
							if(in_array($this->role, array('admin')))
							{
								$response = $this->user_model->users($post_data, 'ADD_USER');
								if($response['status'])
								{
									$this->session->set_flashdata('info', $response['msg']);
								}
								else
									$this->session->set_flashdata('error', $response['msg']);
							}
							else
								redirect($this->agent->referrer());
						break;
						case 'edit':
							if(in_array($this->role, array('admin')))
							{
								$response = $this->user_model->users($post_data, 'UPDATE_USER');
								if(isset($response['status']))
								{
									if($response['status'])
										$this->session->set_flashdata('info', $response['msg']);
									else
										$this->session->set_flashdata('error', $response['msg']);
								}
								redirect($this->agent->referrer());
							}
							else
								redirect($this->agent->referrer());
						break;
						default:
							redirect($this->agent->referrer());
					}
				break;

				case 'add_to_dcu':
					$post_data = $this->input->post();
					switch($post_data['op'])
					{
						case 'user_add_to_dcu':
							$response 			= $this->user_model->users($post_data, 'ADD_USER_TO_DCU');
							if($response['status'])
								$this->session->set_flashdata('info', $response['msg']);
							else
								$this->session->set_flashdata('error', $response['msg']);
						break;
						default:
							redirect($this->agent->referrer());
					}
				break;
				case 'add_to_cdcu':
					$post_data = $this->input->post();
					switch($post_data['op'])
					{
						case 'user_add_to_cdcu':
							$response 			= $this->user_model->users($post_data, 'ADD_USER_TO_CDCU');
							if($response['status'])
								$this->session->set_flashdata('info', $response['msg']);
							else
								$this->session->set_flashdata('error', $response['msg']);
						break;
						default:
							redirect($this->agent->referrer());
					}
				break;
				default:
					redirect($this->agent->referrer());
			}
			redirect($this->agent->referrer());
		}

		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}

	/**
	*	purpose : Get status messages from different nodes
	*/
	public function get_node_status()
	{
		$data 						= array();
		$view 						= 'user/get_node_status';
		$data['all_cdcu']			= $this->getter_model->get(null, 'GET_ALL_CDCU_WITH_DETAILS');
		$data['disaster_types']		= $this->getter_model->get(null, 'GET_ALL_DISASTER_TYPE_WITH_MESSAGES');
		$data['node_request_data']  = $this->getter_model->get(null, 'GET_NODE_REQUEST_MESSAGE_STATS');
		$data['node_names_data']  	= $this->getter_model->get(null, 'GET_NODE_NAMES');

		if($this->input->post())
		{
			$post_data = $this->input->post();
			switch($post_data['op'])
			{
				case 'GET_NODE_STATUS':
					$MQTT_CLIENT_ID 	= self::rand_string(8);
					$response 			= $this->user_model->log_post_data($post_data, 'POST_NODE_REQUEST_START_MESSAGE');
					if(!$response['status'])
					{
						$this->session->set_flashdata('error', $response['msg']);
						redirect($this->agent->referrer());
					}

					$node_details 		= implode('@', $post_data['node_id']);
					$message_string		= "CD&".$post_data['cdcu_id']."#".$post_data['dcu_id']."#".$response['request_id']."#".$node_details."#REQ*".$post_data['dis_type']."*".$post_data['dis_msg'];
					$mqtt 				= new phpMQTT(MQTT_SERVER, MQTT_PORT, $MQTT_CLIENT_ID);
					if ($mqtt->connect(true, NULL, MQTT_USERNAME, MQTT_PASSWORD)) {
						$mqtt->publish($post_data['cdcu_id'], $message_string, 0);
						$mqtt->close();
						$this->session->set_flashdata('info', $response['msg']);
						redirect($this->agent->referrer());
					} else {
						$this->session->set_flashdata('error', "Time out!");
						redirect($this->agent->referrer());
					}
				break;

				default:
					redirect($this->agent->referrer());
			}
		}
		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}

	/**
	*	purpose : Send alert messages to different nodes
	*/
	public function send_alerts()
	{
		$data 						= array();
		$view 						= 'user/send_alerts';
		$data['all_cdcu']			= $this->getter_model->get(null, 'GET_ALL_CDCU_WITH_DETAILS');
		$data['alert_types']		= $this->getter_model->get(null, 'GET_ALL_ALERT_TYPE_WITH_MESSAGES');
		$data['node_alert_data']  	= $this->getter_model->get(null, 'GET_NODE_ALERT_MESSAGE_STATS');
		$data['node_names_data']  	= $this->getter_model->get(null, 'GET_NODE_NAMES');

		if($this->input->post())
		{
			$post_data = $this->input->post();
			switch($post_data['op'])
			{
				case 'SEND_ALERTS':
					$MQTT_CLIENT_ID 	= self::rand_string(8);
					$response 			= $this->user_model->log_post_data($post_data, 'POST_NODE_ALERT_MESSAGE');
					if(!$response['status'])
					{
						$this->session->set_flashdata('error', $response['msg']);
						redirect($this->agent->referrer());
					}

					$node_details 		= implode('@', $post_data['node_id']);
					$message_string		= "CD&".$post_data['cdcu_id']."#".$post_data['dcu_id']."#".$response['request_id']."#".$node_details."#ALERT*".$post_data['alert_type']."*".$post_data['alert_msg'];
					$mqtt 				= new phpMQTT(MQTT_SERVER, MQTT_PORT, $MQTT_CLIENT_ID);
					if ($mqtt->connect(true, NULL, MQTT_USERNAME, MQTT_PASSWORD)) {
						$mqtt->publish($post_data['cdcu_id'], $message_string, 0);
						$mqtt->close();
						$this->session->set_flashdata('info', $response['msg']);
						redirect($this->agent->referrer());
					} else {
						$this->session->set_flashdata('error', "Time out!");
						redirect($this->agent->referrer());
					}
				break;

				default:
					redirect($this->agent->referrer());
			}
		}
		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}

	/**
	*	purpose : Get All speech messages from different nodes
	*/
	public function speech_message()
	{
		$data 						= array();
		$view 						= 'user/speech_message';
		$data['speech_msg_data']	= $this->getter_model->get(null, 'GET_NODE_SPEECH_MESSAGE_DATA');

		if($this->input->post())
		{
			$post_data 		= $this->input->post();
			$message 		= $post_data['message'];
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
		}
		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}

	/**
	*	Generate random password
	*/
	public function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
	}
}
