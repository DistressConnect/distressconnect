<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth
{

    public $CI;
    public function is_login()
	{
		$this->CI = & get_instance();
		//PRINT_r($this->CI->router->fetch_class());
		$x = $this->is_logged_in();
		if($this->CI->router->fetch_method() == "login" && $x)
		{
			if($this->CI->router->fetch_class() != "request")
				redirect(site_url('user/dashboard'));
		}

		if(!in_array($this->CI->router->fetch_method(), array("login", "forgot_password")) && !$x && !$this->CI->input->is_ajax_request() && !in_array($this->CI->router->fetch_class(), array('site')))
		{
			if($this->CI->router->fetch_class() != "request")
				redirect(site_url('user/login'));
		}

		if( !$x &&  $this->CI->input->is_ajax_request() )
		{
			if($this->CI->router->fetch_class() != "service" && $this->CI->router->fetch_class() != "request" && $this->CI->router->fetch_class() != "site")
			{
				echo json_encode(array('status'=>'0', 'msg'=>'You are no longer logged in. Login again.'));
				exit(0);
			}
		}
    }

	private function is_logged_in()
	{
		$this->CI->load->library('session');
		$this->CI->load->library('user_agent');
		$user = $this->CI->session->userdata('logged_in');
		if ($user == "") { return false; } else { return true; }
	}

}