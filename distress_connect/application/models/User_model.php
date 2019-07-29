<?php
class User_model extends CI_model
{
	private $role;

	function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT == 'production')
		{
		    $this->db->save_queries = FALSE;
		}
		date_default_timezone_set('Asia/Kolkata');
		$this->role = $this->session->userdata('role');
		$this->user_id = $this->session->userdata('user_id');
    }

	# make md5 hash
	private function getHash($string)
	{
		return md5($string);
	}


	/**
	*	Generate random password
	*/
	public function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
	}

	/**
	*	Generate random Loginid
	*/
	public function rand_int( $length ) {
		$chars = "0123456789";
		//return substr(str_shuffle($chars),0,$length);
		$val = rand(10000000,99999999);
		return $val;
	}

	/**
	*	Purpose : Check if mallisious element present like ' then replace with &#39;
	*/
	public function checkMalPresent($str)
	{
		$countOccurance =  substr_count($str, "'"); // 2
		if($countOccurance > 0)
			$str = str_replace("'", "&#39;", $str);

		return $str;
	}

	/**
	*	Forgot password
	*/
	public function forgot_password()
	{
		$email = $this->input->post('email');
		$this->db->where('email', $email);
		$query = $this->db->get('tbl_users');

		if($query->num_rows() == 1)
		{
			$result 		= $query->result_array()[0];
			$randomPassword = self::rand_string(8);;
			$data = array(
				'renew_password'=>md5($randomPassword),
				'is_password_renew'=>1
			);

			if($result['email'] != "")
			{
				$this->db->where('user_id', $result['user_id']);
				if( $this->db->update('tbl_users', $data) )
				{
					$return_data = array('email'=>$result['email'], 'name'=>$result['fullname'], 'data'=>$result, 'password'=>$randomPassword, 'is_email_found'=>true);
					return array('status'=>true, 'msg'=>"Please check your E-mail after some time. It is sent to your registered e-mail ".$result['email'].".", 'return_data'=>$return_data);
				}
				else
					return array('status'=>0, 'msg'=>'Your request can not be processed. Try again later');
			}
			else {
				$return_data = array('is_email_found'=>false);
				return array('status'=>false, 'msg'=>"Password reset not successful.", 'return_data'=>$return_data);
			}
		}
		else
		{
			return array('status'=>0, 'msg'=>"Please enter correct Email.");
		}
	}


	/*
	*	Authenticate a user with username & password
	*/
	public function login()
	{
		$userRecord = $this->db->get_where('tbl_users', array(
			'username'=>$this->db->escape_str($this->input->post('username'))
		));

		$userDataArr = $userRecord->result_array();

		$logged_in_by = 1;
		$msg = "";
		if($userRecord->num_rows() == 1)
		{
			if($userDataArr[0]['status'] == 0)
			{
				return array('status'=>false, 'msg'=>'Your account has been blocked please contact administrator');
			}
			else
			{
				if($userDataArr[0]['is_password_renew'] == 1)
				{
					$userNewRecord = $this->db->get_where('tbl_users', array(
						'username'=>$this->db->escape_str($this->input->post('username')),
						'renew_password'=>$this->getHash($this->input->post('password'))
					));
					if($userNewRecord->num_rows() == 1)
					{
						$this->db->where('user_id', $userDataArr[0]['user_id']);
						$this->db->update('tbl_users', array('password'=>$this->getHash($this->input->post('password')), 'last_login'=>strtotime(date('Y-m-d H:i:s')), 'last_ip_address'=>$this->input->ip_address(), 'renew_password'=>null, 'is_password_renew'=>0));
						$logged_in_by = 2;
						$msg = "Login success. Please change your password for more secure";
					}
					else
					{
						return array('status'=>false, 'msg'=>'Invalid username or password');
					}
				}
				else
				{
					$userOldRecord = $this->db->get_where('tbl_users', array(
						'username'=>$this->db->escape_str($this->input->post('username')),
						'password'=>$this->getHash($this->input->post('password'))
					));
					if($userOldRecord->num_rows() == 1)
					{
						$this->db->where('user_id', $userDataArr[0]['user_id']);
						$this->db->update('tbl_users', array('last_login'=>strtotime(date('Y-m-d H:i:s')), 'last_ip_address'=>$this->input->ip_address()));
						$msg = "Login Success";
					}
					else
					{
						return array('status'=>false, 'msg'=>'Invalid username or password');
					}
				}
			}
		}
		else
		{
			return array('status'=>false, 'msg'=>'Invalid username or password');
		}

		$this->session->set_userdata('logged_in', 'yes');
		$this->session->set_userdata('user_id', $userDataArr[0]['user_id']);
		$this->session->set_userdata('user_data', $userDataArr[0]);

		$roleRecord = $this->db->get_where('tbl_roles', array(
			'role_id'=>$userDataArr[0]['fk_role_id']
		));

		$role = $roleRecord->result_array()[0]['role'];

		$this->session->set_userdata('role', $role);

		$role_permission_records = $this->db->get('tbl_role_permission');
		$role_permission_data = $role_permission_records->result_array();
		$this->session->set_userdata('role_permission', $role_permission_data);

		return array('status'=>true, 'msg'=>$msg, 'logged_in_by'=>$logged_in_by);
	}


	/**
	*	purpose : Change password for the user
	*/
	public function change_password()
	{
		$this->db->trans_begin();
		try{
			$userID = $this->session->userdata('user_id');
			$user_session_data = $this->session->userdata('user_data');

			$new_pass =  $this->getHash($this->input->post('new_password'));
			$this->db->where('user_id', $userID);
			$this->db->update('tbl_users', array('password'=>$new_pass));
			switch($this->db->affected_rows())
			{

				case 1:
					$created_on 	= strtotime(date('Y-m-d H:i:s'));
					$user_audit_trail_data = array(
						'updated_by' 		=> $this->user_id,
						'updated_on' 		=> $created_on,
						'actionable_module'	=> MODULE_USER,
						'action_performed'	=> CONST_CHANGE_PASSWORD . $user_session_data['fullname'],
						'fk_action_id'		=> $userID
					);

					if(!$this->db->insert('tbl_operation_track', $user_audit_trail_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				break;
				default:
					throw new Exception(ERR_101);
			}
		}
		catch(Exception $e)
		{
			$this->db->trans_rollback();
			return array('status'=>false, 'msg'=>$e->getMessage());
		}
	}

	/**
	*	Purpose : Manage Role
	*/
	public function role($data, $op)
	{
		switch($op)
		{
			case 'ROLE_PERMISSION_SET':
				$this->db->trans_begin();
				try{
					$roles_query 	= $this->db->get('tbl_roles');
					$all_roles 		= $roles_query->result_array();
					if(isset($data['role_id']) && count($data['role_id']) > 0 ){
						foreach($data['role_id'] as $key=>$role_id):
							$role_permission_data = array();
							foreach($all_roles as $idk=>$single_role):
								if($single_role['role'] != "admin")
								{
									$role_permission_check 						= $single_role['role'].'_'.$role_id;
									$role_permission_data[$single_role['role']] = isset($data[$role_permission_check]) ? 1 : 0;
								}
							endforeach;
							$this->db->where('rp_id', $role_id);
							$this->db->update('tbl_role_permission', $role_permission_data);
						endforeach;

						$role_permission_records 	= $this->db->get('tbl_role_permission');
						$role_permission_data 		= $role_permission_records->result_array();
						$this->session->set_userdata('role_permission', $role_permission_data);
						$this->db->trans_commit();
						return array('status'=>true, 'msg'=>OP_SUCCESS);
					}
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			default:
				throw new Exception(ERR_101);

		}
	}

	/**
	*	Purpose : Manage User
	*/
	public function users($data, $op)
	{
		switch($op)
		{
			case 'ADD_USER':
				$this->db->trans_begin();
				try{
					$this->db->where('email', $data['email']);
					if($this->db->count_all_results('tbl_users') > 0)
						throw new Exception("Entered email already exists.");
					$randomPassword = self::rand_string(8);
					$created_on 	= strtotime(date('Y-m-d H:i:s'));

					$new_data = array(
						'user_id'		=> NULL,
						'username'		=> $data['email'],
						'email'			=> $data['email'],
						'password'		=> md5($randomPassword),
						'fullname'		=> ucwords($data['fullname']),
						'phone'			=> $data['phone'],
						'fk_role_id'	=> $data['role'],
						'status'		=> $data['status'],
						'created_by'	=> $this->user_id,
						'created_on'	=> $created_on,
						'last_login'	=> NULL,
						'last_ip_address'=> $this->input->ip_address(),
						'latitude'		=> $data['latitude'],
						'longitude'		=> $data['longitude'],
						'passkey'		=> $data['passkey'],
						'pincode'		=> $data['pincode']
					);
					if(!$this->db->insert('tbl_users', $new_data))
						throw new Exception(OP_FAILED);

					$userID = $this->db->insert_id();

					$user_audit_trail_data = array(
						'updated_by' 		=> $this->user_id,
						'updated_on' 		=> $created_on,
						'actionable_module'	=> MODULE_USER,
						'action_performed'	=> CONST_CREATE_USER . $data['fullname'],
						'fk_action_id'		=> $userID
					);

					if(!$this->db->insert('tbl_operation_track', $user_audit_trail_data))
						throw new Exception(OP_FAILED);

					$body = "\n Hello \t: ".$data['fullname']."\n Your new password is \t: ".$randomPassword . ". Now you can login by your registered email id";

					$subject = "User Credentials";

					$return_data = array('email'=>$data['email'], 'name'=>$data['fullname'], 'password'=>$randomPassword, 'body'=>$body, 'subject'=>$subject);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS, 'return_data'=>$return_data);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'UPDATE_USER':
				$this->db->trans_begin();
				try{
					$new_data = array(
						'fullname'	=> ucwords($data['fullname']),
						'phone'		=> $data['phone'],
						'fk_role_id'=> $data['role'],
						'status'	=> $data['status'],
						'latitude'	=> $data['latitude'],
						'longitude'	=> $data['longitude'],
						'passkey'	=> $data['passkey'],
						'pincode'	=> $data['pincode']
					);

					$this->db->where('user_id', $data['user_id']);
					$this->db->update('tbl_users', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							//$this->db->trans_commit();
							return array('status'=>true, 'msg'=>"No Changes to update");
						case 1:
							$user_audit_trail_data = array(
								'updated_by' 		=> $this->user_id,
								'updated_on' 		=> strtotime(date('Y-m-d H:i:s')),
								'actionable_module'	=> MODULE_USER,
								'action_performed'	=> CONST_EDIT_USER . $data['fullname'],
								'fk_action_id'		=> $data['user_id']
							);

							if(!$this->db->insert('tbl_operation_track', $user_audit_trail_data))
								throw new Exception(OP_FAILED);

							$this->db->trans_commit();
							return array('status'=>true, 'msg'=>OP_SUCCESS);
						break;
						default:
							throw new Exception(OP_FAILED);
					}
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'UPDATE_PROFILE':
				$this->db->trans_begin();
				try{
					$new_data = array(
						'phone'		=> $data['phone'],
					);

					$this->db->where('id', $this->user_id);
					$this->db->update('tbl_users', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							//$this->db->trans_commit();
							return array('status'=>true, 'msg'=>"No Changes to update");
						case 1:
							$user_audit_trail_data = array(
								'updated_by' 		=> $this->user_id,
								'updated_on' 		=> strtotime(date('Y-m-d H:i:s')),
								'actionable_module'	=> MODULE_USER,
								'action_performed'	=> CONST_PROFILE_USER . $this->session->userdata('name'),
								'fk_action_id'		=> $this->user_id
							);

							if(!$this->db->insert('tbl_user_audit_trail', $user_audit_trail_data))
								throw new Exception(OP_FAILED);

							$this->db->trans_commit();
							return array('status'=>true, 'msg'=>OP_SUCCESS);
						break;
						default:
							throw new Exception(OP_FAILED);
					}
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'DELETE_USER':
				$this->db->trans_begin();
				try{
					$this->db->where('user_id', $data);
					$this->db->update('tbl_users', array('status'=>2));
					switch($this->db->affected_rows())
					{
						case 1:
							$this->db->where('user_id', $data);
							$user_res 		= $this->db->get('tbl_users');
							$user_record 	= $user_res->result_array()[0];

							$user_audit_trail_data = array(
								'updated_by' 		=> $this->user_id,
								'updated_on' 		=> strtotime(date('Y-m-d H:i:s')),
								'actionable_module'	=> MODULE_USER,
								'action_performed'	=> CONST_DELETE_USER . $user_record['fullname'],
								'fk_action_id'		=> $data
							);

							if(!$this->db->insert('tbl_operation_track', $user_audit_trail_data))
								throw new Exception(OP_FAILED);

							$this->db->trans_commit();
							return array('status'=>true, 'msg'=>OP_SUCCESS);
						break;
						default:
							throw new Exception(ERR_101);
					}
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'UNBLOCK_USER':
				$this->db->where('id', $data);
				$this->db->update('tbl_users', array('status'=>1));
				switch($this->db->affected_rows())
				{
					case 1:
						return array('status'=>true, 'msg'=>OP_SUCCESS);
					break;
					default:
						return array('status'=>false, 'msg'=>ERR_101);
				}
			break;

			case 'ADD_USER_TO_DCU':
				$this->db->trans_begin();
				try{
					$new_data = array(
						'node_id'			=> $data['node_id'],
						'dcu_id'			=> $data['dcu_id'],
						//'cdcu_id'			=> $data['dcu_id']
					);

					
					$res = $this->db->get_where('tbl_node_dcu_cdcu_association', array('node_id'=>$data['node_id'], 'dcu_id'=>$data['dcu_id']));
					if($res->num_rows() > 0)
						throw new Exception("This Node already added to this Dcu");

					$assoc_res = $this->db->get_where('tbl_dcu_cdu_association', array('dcu_id'=>$data['dcu_id']));
					if($assoc_res->num_rows() == 0)
						throw new Exception("This Node cannot be added to this dcu as this dcu doesnot belongs to any cdcu");
					$new_data['cdcu_id'] = $assoc_res->result_array()[0]['cdcu_id'];
					
					if(!$this->db->insert('tbl_node_dcu_cdcu_association', $new_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'ADD_USER_TO_CDCU':
				$this->db->trans_begin();
				try{
					$new_data = array(
						'dcu_id'			=> $data['dcu_id'],
						'cdcu_id'			=> $data['cdcu_id']
					);

					$res = $this->db->get_where('tbl_dcu_cdu_association', array('cdcu_id'=>$data['cdcu_id'], 'dcu_id'=>$data['dcu_id']));
					if($res->num_rows() > 0)
						throw new Exception("This Dcu already added to this Cdcu");

					if(!$this->db->insert('tbl_dcu_cdu_association', $new_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'DELETE_USER_ADDED_TO_DCU':
				$this->db->trans_begin();
				try{
					$this->db->where('node_id', $data['node_id']);
					$this->db->where('dcu_id', $data['dcu_id']);
					if(!$this->db->delete('tbl_node_dcu_cdcu_association'))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'DELETE_USER_ADDED_TO_CDCU':
				$this->db->trans_begin();
				try{
					$this->db->where('cdcu_id', $data['cdcu_id']);
					$this->db->where('dcu_id', $data['dcu_id']);
					if(!$this->db->delete('tbl_dcu_cdu_association'))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			default:
				return array('status'=>false, 'msg'=>NO_OPERATION);
		}
	}

	public function log_post_data($data, $op)
	{
		switch($op)
		{
			case 'POST_NODE_ALERT_MESSAGE':
				$this->db->trans_begin();
				try{
					foreach($data['node_id'] as $single_node):
						$node_alert_msg_data[] = array(
							'node_key' 			=> $single_node,
							'alert_msg_code'	=> $data['alert_msg'],
							'fk_alert_type_id'	=> $data['alert_type'],
							'created_date'		=> date('Y-m-d')
						);
					endforeach;
					if(!$this->db->insert_batch('tbl_node_alerts', $node_alert_msg_data))
						throw new Exception(OP_FAILED);

					$alert_id = $this->db->insert_id();
					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS, 'request_id'=>$alert_id);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'POST_NODE_REQUEST_START_MESSAGE':
				$this->db->trans_begin();
				try{
					$node_request_data = array(
						'fk_msg_response_code' 	=> $data['dis_msg'],
						'created_date'   		=> date('Y-m-d')
					);

					if(!$this->db->insert('tbl_node_requests', $node_request_data))
						throw new Exception(OP_FAILED);
					$request_id = $this->db->insert_id();

					foreach($data['node_id'] as $single_node):
						$node_request_details_data[] = array(
							'fk_request_id' 	=> $request_id,
							'cdcu_key'       	=> $data['cdcu_id'],
							'dcu_key'        	=> $data['dcu_id'],
							'node_key' 			=> $single_node,
							'fk_dis_type_id' 	=> $data['dis_type'],
							'msg_sent_req_code'	=> $data['dis_msg'],
							'status'			=> "INITIATED"
						);
					endforeach;

					if(!$this->db->insert_batch('tbl_node_request_details', $node_request_details_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS, 'request_id'=>$request_id);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'POST_NODE_RESPONSE_MESSAGE':
				$this->db->trans_begin();
				try{
					$message_total  = explode('*', $data['message']);
					$type           = $message_total[0];
					$dis_type_id    = $message_total[1];
					$response_code  = $message_total[2];
					$message_string = $message_total[3];
					$message_data	= explode('@', $message_string);

					$this->db->where('response_code', $response_code);
					$dis_msg_res 	= $this->db->get('tbl_disaster_messages');
					$dis_msg_labels_json = $dis_msg_res->result_array()[0]['labels'];
					$dis_msg_labels = json_decode($dis_msg_labels_json, true);

					if(count($dis_msg_labels) != count($message_data))
					{
						throw new Exception("MESSAGE FORMAT WRONG");
					}

					$new_message_construct = array();
					foreach($dis_msg_labels as $key=>$single_label):
						$new_message_construct[$single_label] = $message_data[$key];
					endforeach;

					$node_request_details_data = array(
						'msg_retrun_res_code' 	=> $response_code,
						'msg_return_value' 		=> json_encode($new_message_construct),
						'status'				=> "SUCCESS",
						'ack_time'				=> date('Y-m-d H:i:s')
					);

					$this->db->where('fk_request_id', $data['request_id']);
					$this->db->where('node_key', $data['node_id']);
					$this->db->update('tbl_node_request_details', $node_request_details_data);
					switch($this->db->affected_rows())
					{
						case 0:
							return array('status'=>true, 'msg'=>"No Changes to update");
						case 1:
							$this->db->trans_commit();
							return array('status'=>true, 'msg'=>OP_SUCCESS);
						break;
						default:
							throw new Exception(OP_FAILED);
					}
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'POST_NODE_MESSAGE_FOR_SPEECH':
				$this->db->trans_begin();
				try{
					$message_total  = explode('*', $data['message']);
					$type           = $message_total[0];
					$message_string = $message_total[1];

					$node_speech_msg_data = array(
						'node_key' 			=> $data['node_id'],
						'speech_message'	=> $message_string
					);
					if(!$this->db->insert('tbl_node_speech_message', $node_speech_msg_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			case 'POST_NODE_WEATHER_DATA':
				$this->db->trans_begin();
				try{
					$message_total  = explode('*', $data['message']);
					$type           = $message_total[0];
					$temperature 	= $message_total[1];
					$humidity		= $message_total[2];

					$node_weather_msg_data = array(
						'humidity'			=> $humidity,
						'temperature'		=> $temperature,
						'node_key' 			=> $data['node_id']
					);
					if(!$this->db->insert('tbl_node_weather_message', $node_weather_msg_data))
						throw new Exception(OP_FAILED);

					$this->db->trans_commit();
					return array('status'=>true, 'msg'=>OP_SUCCESS);
				}
				catch(Exception $e)
				{
					$this->db->trans_rollback();
					return array('status'=>false, 'msg'=>$e->getMessage());
				}
			break;

			default:
				return array('status'=>false, 'msg'=>NO_OPERATION);
		}
	}
}
