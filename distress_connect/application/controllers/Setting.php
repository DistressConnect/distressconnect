<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once("application/libraries/Custom.php");
class Setting extends CI_Controller
{
	public $role;
	public function __construct()
	{
		parent::__construct();

		# helpers
		$this->load->helper(array('form'));

		# libraries
		$this->load->library('user_agent');

		$this->role = $this->session->userdata('role');

		# models
		$this->load->model('setting_model');
		$this->load->model('getter_model');

		$this->load->view('templates/header');
	}


	/*
	*	purpose : to check whether the method is correct or not
	*/
	public function _remap($method)
	{
		$class 	= $this->router->class;
		$role 	= $this->session->userdata('role');

		/*$role_action_auth = array(
			'admin'=>array('country', 'address')
		);

		if( $role == false || !isset($role_action_auth[$role]) || !in_array($method, $role_action_auth[$role]) )*/

		if( $role == false || $this->session->userdata('role_permission') == "" || searchPermissionArray($this->session->userdata('role_permission'), "module_name", "PAGE", "operation_name", $method, $role) != 1)
		{
			self::page_not_found();
		}
		else
		{
			if (in_array(strtolower($method), array_map('strtolower', get_class_methods($this))))
			{
				$uri = $this->uri->segment_array();
				unset($uri[1]);
				unset($uri[2]);
				call_user_func_array(array($this, $method), $uri);
			}
			else
			{
				self::page_not_found();
			}
		}
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
		redirect('user/dashboard');
	}

	/**
	*	purpose : Entry point of user controller
	*/
	public function configuration()
	{
		//$this->load->view('setting/configuration.php');
		//$this->load->view('templates/footer');

		$type = $this->uri->segment(3);
		$data = array();
		$view = '';
		switch($type)
		{
			case 'all':
				$view 						= 'setting/configuration';
				$data['disaster_type']		= $this->getter_model->get(null, 'GET_ALL_DISASTER_TYPE');
				$data['disaster_message']	= $this->getter_model->get(null, 'GET_ALL_DISASTER_MESSAGE');
				$data['alert_type']			= $this->getter_model->get(null, 'GET_ALL_ALERT_TYPE');
				$data['alert_message']		= $this->getter_model->get(null, 'GET_ALL_ALERT_MESSAGE');
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
						case 'add_disaster_type':
							$this->session->set_flashdata('tab_choosen', 'tab_one');
							$response 			= $this->setting_model->configuration($post_data, 'ADD_DISASTER_TYPE');
						break;
						case 'edit_disaster_type':
							$this->session->set_flashdata('tab_choosen', 'tab_one');
							$response 			= $this->setting_model->configuration($post_data, 'UPDATE_DISASTER_TYPE');
						break;
						case 'add_disaster_message':
							$this->session->set_flashdata('tab_choosen', 'tab_two');
							$response 			= $this->setting_model->configuration($post_data, 'ADD_DISASTER_MESSAGE');
						break;
						case 'edit_disaster_message':
							$this->session->set_flashdata('tab_choosen', 'tab_two');
							$response 			= $this->setting_model->configuration($post_data, 'UPDATE_DISASTER_MESSAGE');
						break;

						case 'add_alert_type':
							$this->session->set_flashdata('tab_choosen', 'tab_three');
							$response 			= $this->setting_model->configuration($post_data, 'ADD_ALERT_TYPE');
						break;
						case 'edit_alert_type':
							$this->session->set_flashdata('tab_choosen', 'tab_three');
							$response 			= $this->setting_model->configuration($post_data, 'UPDATE_ALERT_TYPE');
						break;
						case 'add_alert_message':
							$this->session->set_flashdata('tab_choosen', 'tab_four');
							$response 			= $this->setting_model->configuration($post_data, 'ADD_ALERT_MESSAGE');
						break;
						case 'edit_alert_message':
							$this->session->set_flashdata('tab_choosen', 'tab_four');
							$response 			= $this->setting_model->configuration($post_data, 'UPDATE_ALERT_MESSAGE');
						break;

						default:
							redirect($this->agent->referrer());
					}

				break;

			}
			if(isset($response['status']))
			{
				if($response['status'])
					$this->session->set_flashdata('info', $response['msg']);
				else
					$this->session->set_flashdata('error', $response['msg']);
			}
			redirect($this->agent->referrer());
		}
		if(!$this->session->flashdata('tab_choosen'))
		$this->session->set_flashdata('tab_choosen', 'tab_one');

		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}


}
