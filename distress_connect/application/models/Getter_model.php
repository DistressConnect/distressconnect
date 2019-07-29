<?php
include_once("application/libraries/Custom.php");
class Getter_model extends CI_model
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
		$this->role 	= $this->session->userdata('role');
		$this->user_id 	= $this->session->userdata('user_id');
    }

	/*
    *	return string with padding
    */
    private function padding_string($data, $pad_str, $pad_length)
    {
    	return str_pad($data, $pad_length, $pad_str, STR_PAD_LEFT);
    }


	/**
	*	Generate random string
	*/
	public function rand_string( $length ) {
		$chars = "0123456789";
		return substr(str_shuffle($chars),0,$length);
	}

    /**
    * 	return data according to $op
    */
	public function get($data, $op)
	{
		switch ($op)
		{
			# Retrun all users
			case 'GET_ALL_USERS':
				switch($this->role)
				{
					case 'admin':
						$this->db->select('tbl_users.*, tbl_roles.role');
						$this->db->from('tbl_users');
						$this->db->join('tbl_roles', 'tbl_roles.role_id = tbl_users.fk_role_id', 'left');
						$this->db->where('tbl_users.status != ', 2);
						$this->db->order_by('tbl_users.user_id', 'DESC');
						$res = $this->db->get();
						if($res->num_rows() > 0)
						{
							$user_data = $res->result_array();
							foreach($user_data as $key=>$single_user):
								$this->db->where('node_key', $single_user['passkey']);
								$this->db->order_by('wheather_msg_id', 'DESC');
								$this->db->limit(10);
								$weaher_res = $this->db->get('tbl_node_weather_message');
								if($weaher_res->num_rows() > 0)
								{
									$user_data[$key]['weather_data'] = $weaher_res->result_array();
								}
							endforeach;
						}
						return $user_data;
					break;

					default:
						$this->db->select('tbl_users.*, tbl_roles.role');
						$this->db->from('tbl_users');
						$this->db->join('tbl_roles', 'tbl_roles.role_id = tbl_users.fk_role_id', 'left');
						$this->db->where('tbl_users.status != ', 2);
						$this->db->where('tbl_roles.role != ', 'admin');
						$this->db->order_by('tbl_users.user_id', 'DESC');
						$res = $this->db->get();
						return $res->result_array();
				}
			break;

			# Return user if id matched
			case 'GET_SINGLE_USER':
				$this->db->where('user_id', $data);
				$res = $this->db->get('tbl_users');
				return $res->result_array()[0];
			break;

			case 'GET_SINGLE_NODE':
				$this->db->where('user_id', $data);
				$res = $this->db->get('tbl_users');
				if($res->num_rows() == 1)
				{
					$user_data = $res->result_array()[0];
					$this->db->where('node_id', $user_data['user_id']);
					$node_res = $this->db->get('tbl_node_dcu_cdcu_association');
					if($node_res->num_rows() == 1)
					{
						$node_data = $node_res->result_array()[0];
						$dcu_res = $this->db->get_where('tbl_users', array('user_id'=>$node_data['dcu_id']));
						if($dcu_res->num_rows() == 1)
							$user_data['dcu_data'] = $dcu_res->result_array()[0];

						$cdcu_res = $this->db->get_where('tbl_users', array('user_id'=>$node_data['cdcu_id']));
						if($cdcu_res->num_rows() == 1)
							$user_data['cdcu_data'] = $cdcu_res->result_array()[0];
					}
					return $user_data;
				}
				else
					return false;
			break;

			case 'GET_SINGLE_DCU':
				$this->db->where('user_id', $data);
				$res = $this->db->get('tbl_users');
				if($res->num_rows() == 1)
				{
					$user_data = $res->result_array()[0];
					$this->db->where('dcu_id', $user_data['user_id']);
					$dcu_res = $this->db->get('tbl_dcu_cdu_association');
					if($dcu_res->num_rows() == 1)
					{
						$dcu_assoc_data = $dcu_res->result_array()[0];
						$cdcu_res = $this->db->get_where('tbl_users', array('user_id'=>$dcu_assoc_data['cdcu_id']));
						if($cdcu_res->num_rows() == 1)
							$user_data['cdcu_data'] = $cdcu_res->result_array()[0];
					}
					return $user_data;
				}
				else
					return false;
			break;

			case 'GET_ALL_ROLES':
				$roles_query = $this->db->get('tbl_roles');
				return $roles_query->result_array();
			break;

			case 'GET_ALL_DCU':
				$this->db->where('fk_role_id', 3);
				$dcu_query = $this->db->get('tbl_users');
				return $dcu_query->result_array();
			break;

			case 'GET_ALL_CDCU':
				$this->db->where('status', 1);
				$this->db->where('fk_role_id', 4);
				$cdcu_query = $this->db->get('tbl_users');
				return $cdcu_query->result_array();
			break;

			case 'GET_ALL_CDCU_WITH_DETAILS':
				$cdcu_data = array();
				$this->db->where('status', 1);
				$this->db->where('fk_role_id', 4);
				$cdcu_query = $this->db->get('tbl_users');
				if($cdcu_query->num_rows() > 0)
				{
					$cdcu_data = $cdcu_query->result_array();
					foreach($cdcu_data as $cdcu_key=>$single_cdcu):
						$this->db->where('cdcu_id', $single_cdcu['user_id']);
						$assoc_dcu_res = $this->db->get('tbl_dcu_cdu_association');
						if($assoc_dcu_res->num_rows() > 0)
						{
							$dcu_ids =  array_column($assoc_dcu_res->result_array(), 'dcu_id');
							foreach($dcu_ids as $dcu_key=>$single_dcu):
								$dcu_res = $this->db->get_where('tbl_users', array('user_id'=>$single_dcu));
								$cdcu_data[$cdcu_key]['dcu_data'][$dcu_key] = $dcu_res->result_array()[0];

								$this->db->where('dcu_id', $single_dcu);
								$assoc_node_res = $this->db->get('tbl_node_dcu_cdcu_association');
								if($assoc_node_res->num_rows() > 0)
								{
									$node_ids =  array_column($assoc_node_res->result_array(), 'node_id');
									foreach($node_ids as $node_key=>$single_node):
										$node_res = $this->db->get_where('tbl_users', array('user_id'=>$single_node));
										$cdcu_data[$cdcu_key]['dcu_data'][$dcu_key]['node_data'][] = $node_res->result_array()[0];
									endforeach;
								}
							endforeach;
						}
					endforeach;
				}
				return $cdcu_data;
			break;

			case 'GET_MAP_NODE_POINTS_DATA':
				$this->db->select('latitude, longitude, fullname, fk_role_id');
				$this->db->where('status', 1);
				$this->db->where('fk_role_id != ', 1);
				$nodes_query = $this->db->get('tbl_users');
				return $nodes_query->result_array();
			break;

			case 'GET_ALL_DISASTER_TYPE_WITH_MESSAGES':
				$disaster_type_data = array();
				$dis_type_query 	= $this->db->get('tbl_disaster_type');
				if($dis_type_query->num_rows() > 0)
				{
					$disaster_type_data = $dis_type_query->result_array();

					foreach($disaster_type_data as $key=>$single_dis_type):
						$this->db->where('type', 'REQUEST');
						$this->db->where('fk_disaster_type_id', $single_dis_type['disaster_type_id']);
						$dis_msg_res = $this->db->get('tbl_disaster_messages');
						if($dis_msg_res->num_rows() > 0)
						{
							$disaster_type_data[$key]['dis_msg_data'] = $dis_msg_res->result_array();
						}
					endforeach;
				}
				return $disaster_type_data;
			break;

			case 'GET_ALL_ALERT_TYPE_WITH_MESSAGES':
				$alert_type_data = array();
				$alert_type_query 	= $this->db->get('tbl_alert_type');
				if($alert_type_query->num_rows() > 0)
				{
					$alert_type_data = $alert_type_query->result_array();

					foreach($alert_type_data as $key=>$single_alert_type):
						$this->db->where('fk_alert_type_id', $single_alert_type['alert_type_id']);
						$alert_msg_res = $this->db->get('tbl_alert_messages');
						if($alert_msg_res->num_rows() > 0)
						{
							$alert_type_data[$key]['alert_msg_data'] = $alert_msg_res->result_array();
						}
					endforeach;
				}
				return $alert_type_data;
			break;

			case 'GET_ROLE_PERMISSION_DATA':
				$role_permission_query = $this->db->get('tbl_role_permission');
				return $role_permission_query->result_array();
			break;

			# Return All Disaster Type
			case 'GET_ALL_DISASTER_TYPE':
				$res = $this->db->get('tbl_disaster_type');
				return $res->result_array();
			break;
			# Return All Disaster Message
			case 'GET_ALL_DISASTER_MESSAGE':
				$this->db->select('tbl_disaster_messages.*, tbl_disaster_type.disaster_type_id, tbl_disaster_type.disaster_type');
				$this->db->from('tbl_disaster_messages');
				$this->db->join('tbl_disaster_type', 'tbl_disaster_type.disaster_type_id = tbl_disaster_messages.fk_disaster_type_id', 'left');
				$res = $this->db->get();
				return $res->result_array();
			break;

			# Return All Disaster Type
			case 'GET_ALL_ALERT_TYPE':
				$res = $this->db->get('tbl_alert_type');
				return $res->result_array();
			break;
			# Return All Disaster Message
			case 'GET_ALL_ALERT_MESSAGE':
				$this->db->select('tbl_alert_messages.*, tbl_alert_type.alert_type_id, tbl_alert_type.alert_type');
				$this->db->from('tbl_alert_messages');
				$this->db->join('tbl_alert_type', 'tbl_alert_type.alert_type_id = tbl_alert_messages.fk_alert_type_id', 'left');
				$res = $this->db->get();
				return $res->result_array();
			break;

			case 'GET_NODE_ALERT_MESSAGE_STATS':
				$alert_res = $this->db->get('tbl_alert_type');
				$node_req_alert_type_msg_data = $alert_res->result_array();
				foreach($node_req_alert_type_msg_data as $key=>$single_alert_type):
					$sql = "SELECT count(*) as alert_count, node_key FROM `tbl_node_alerts` WHERE `fk_alert_type_id` = ".$single_alert_type['alert_type_id']." GROUP BY `node_key`";
					$query = $this->db->query($sql);
					$node_req_alert_type_msg_data[$key]['count_details'] = $query->result_array();
				endforeach;
				return $node_req_alert_type_msg_data;
			break;

			case 'GET_NODE_NAMES':
				$this->db->select('passkey, fullname');
				$this->db->where('status', 1);
				$this->db->where('fk_role_id != ', 1);
				$nodes_query = $this->db->get('tbl_users');
				$nodes_data = $nodes_query->result_array();
				$nodes_names = array();
				foreach($nodes_data as $single_node):
					$nodes_names[$single_node['passkey']] = $single_node['fullname'];
				endforeach;
				return $nodes_names;
			break;

			case 'GET_NODE_ALERTS_DATA':
				$this->db->select('latitude, longitude, fullname, passkey, fk_role_id');
				$this->db->where('status', 1);
				$this->db->where('fk_role_id != ', 1);
				$nodes_query = $this->db->get('tbl_users');
				$nodes_data = array();
				if($nodes_query->num_rows() > 0)
				{
					$nodes_data = $nodes_query->result_array();
					$node_ids = array();
					foreach($nodes_data as $single_node):
						$ip 		= IP_ADDRESS;
						$details 	= json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
						$geoIP 		= explode(",", $details->loc);
						$distance = distance($geoIP[0], $geoIP[1], $single_node['latitude'], $single_node['longitude'], "K");
						if((float)$distance < (float)IP_LOC_DISTANCE)
						{
							array_push($node_ids, $single_node['passkey']);
						}
						$this->db->get('tbl_node_alerts');
					endforeach;
					if(isset($node_ids) && count($node_ids) > 0)
					{
						$this->db->select('tbl_node_alerts.*, tbl_alert_messages.*, tbl_alert_type.*');
						$this->db->from('tbl_node_alerts');
						$this->db->join('tbl_alert_messages', 'tbl_alert_messages.response_code = tbl_node_alerts.alert_msg_code', 'left');
						$this->db->join('tbl_alert_type', 'tbl_alert_type.alert_type_id = tbl_node_alerts.fk_alert_type_id', 'left');
						$this->db->where_in('tbl_node_alerts.node_key', $node_ids);
						$res 						= $this->db->get();
						$nodes_data['alerts_data'] 	= $res->result_array();
					}
				}
				return $nodes_data;
			break;

			case 'GET_NODE_REQUEST_MESSAGE_STATS':
				$dis_res = $this->db->get('tbl_disaster_type');
				$node_req_dis_type_request_data = $dis_res->result_array();
				foreach($node_req_dis_type_request_data as $key=>$single_dis_type):
					$sql = "SELECT count(*) as req_count, node_key FROM `tbl_node_request_details` WHERE `fk_dis_type_id` = ".$single_dis_type['disaster_type_id']." GROUP BY `node_key`";
					$query = $this->db->query($sql);
					$node_req_dis_type_request_data[$key]['count_details'] = $query->result_array();
				endforeach;
				return $node_req_dis_type_request_data;
			break;

			case 'GET_NODE_SPEECH_MESSAGE_DATA':
				$this->db->order_by('speech_msg_id', 'DESC');
				$speech_mes_res = $this->db->get('tbl_node_speech_message');
				return $speech_mes_res->result_array();
			break;

			case 'GET_DASHBOARD_STATISTICS':
				$statistics_data 			= array('dcu_data'=>array());
					
				$this->db->select('fullname, passkey');
				$this->db->where('fk_role_id', 3);
				$dcu_res 	= $this->db->get('tbl_users');
				$statistics_data['dcu_data'] 	= $dcu_res->result_array();
				$labels_array = array('How Many People Died', 'Human casulaities Number', 'Number of House Damaged', 'Is Road Blocked', 'Number of Animal Death', 'Animal casulaities Number', 'Number of Electric Pole Destroyed');

				$labels_array1 = array('No of Food Packets Required', 'Number of Drinking water packets', 'Number of Polythenes', 'Urgent rescue team required', 'Number of People need to rescued from location - Need Airlift', 'Please Send NDRF Personal (Number)');

				$info_arr = array();
				
				foreach($statistics_data['dcu_data'] as $key=>$single_data)
				{
					foreach($labels_array as $single_info)
					{
						$val 	= '"'.$single_info.'"';
						$sql 	= "SELECT sum(msg_return_value->>'$.".$val."') as info_count FROM tbl_node_request_details WHERE `dcu_key` = '".$single_data['passkey']."' AND `status`='SUCCESS'";
						$query 	= $this->db->query($sql);
						$result = $query->result_array();
						$statistics_data['dcu_data'][$key]['info_arr'][$single_info]			= $result[0]['info_count'];
					}

					foreach($labels_array1 as $single_support)
					{
						$val 	= '"'.$single_support.'"';
						$sql 	= "SELECT sum(msg_return_value->>'$.".$val."') as support_count FROM tbl_node_request_details WHERE `dcu_key` = '".$single_data['passkey']."' AND `status`='SUCCESS'";
						$query 	= $this->db->query($sql);
						$result = $query->result_array();
						$statistics_data['dcu_data'][$key]['support_arr'][$single_support]			= $result[0]['support_count'];
					}
				}
				return $statistics_data;
			break;

		}
	}
}
