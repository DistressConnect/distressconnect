<?php
class Setting_model extends CI_model
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
	*	Purpose : Manage Master Address
	*/
	public function configuration($data, $op)
	{
		switch ($op)
		{
			case 'ADD_DISASTER_TYPE':
				$this->db->trans_begin();
				try{
					$created_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'disaster_type_id'		=> NULL,
						'disaster_type'		=> self::checkMalPresent($data['disaster_type']),
						//'distric_label'		=> $created_on
					);

					if(!$this->db->insert('tbl_disaster_type', $new_data))
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

			case 'UPDATE_DISASTER_TYPE':
				$this->db->trans_begin();
				try{
					$updated_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'disaster_type'		=> self::checkMalPresent($data['disaster_type']),
						//'updated_on'		=> $updated_on
					);

					$this->db->where('disaster_type_id', $data['disaster_type_id']);
					$this->db->update('tbl_disaster_type', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							return array('status'=>true, 'msg'=>"No changes to update");
						break;
						case 1:
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

			case 'ADD_DISASTER_MESSAGE':
				$this->db->trans_begin();
				try{
					$created_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'disaster_message_id'		=> NULL,
						'fk_disaster_type_id'	=> $data['fk_disaster_type_id'],
						'disaster_message'		=> self::checkMalPresent($data['disaster_message']),
						//'created_on'		=> $created_on
					);

					if(!$this->db->insert('tbl_disaster_messages', $new_data))
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

			case 'UPDATE_DISASTER_MESSAGE':
				$this->db->trans_begin();
				try{
					$updated_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'fk_disaster_type_id'	=> $data['fk_disaster_type_id'],
						'disaster_message'		=> self::checkMalPresent($data['disaster_message']),
						//'updated_on'		=> $updated_on
					);

					$this->db->where('disaster_message_id', $data['disaster_message_id']);
					$this->db->update('tbl_disaster_messages', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							return array('status'=>true, 'msg'=>"No changes to update");
						break;
						case 1:
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

			case 'ADD_ALERT_TYPE':
				$this->db->trans_begin();
				try{
					$created_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'alert_type_id'		=> NULL,
						'alert_type'		=> self::checkMalPresent($data['alert_type']),
						//'distric_label'		=> $created_on
					);

					if(!$this->db->insert('tbl_alert_type', $new_data))
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

			case 'UPDATE_ALERT_TYPE':
				$this->db->trans_begin();
				try{
					$updated_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'alert_type'		=> self::checkMalPresent($data['alert_type']),
						//'updated_on'		=> $updated_on
					);

					$this->db->where('alert_type_id', $data['alert_type_id']);
					$this->db->update('tbl_alert_type', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							return array('status'=>true, 'msg'=>"No changes to update");
						break;
						case 1:
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

			case 'ADD_ALERT_MESSAGE':
				$this->db->trans_begin();
				try{
					$created_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'alert_message_id'		=> NULL,
						'fk_alert_type_id'		=> $data['fk_alert_type_id'],
						'alert_message'		=> self::checkMalPresent($data['alert_message']),
						//'created_on'		=> $created_on
					);

					if(!$this->db->insert('tbl_alert_messages', $new_data))
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

			case 'UPDATE_ALERT_MESSAGE':
				$this->db->trans_begin();
				try{
					$updated_on 	= strtotime(date('Y-m-d H:i:s'));
					$new_data = array(
						'fk_alert_type_id'	=> $data['fk_alert_type_id'],
						'alert_message'		=> self::checkMalPresent($data['alert_message']),
						//'updated_on'		=> $updated_on
					);

					$this->db->where('alert_message_id', $data['alert_message_id']);
					$this->db->update('tbl_alert_messages', $new_data);
					switch($this->db->affected_rows())
					{
						case 0:
							return array('status'=>true, 'msg'=>"No changes to update");
						break;
						case 1:
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

			default:
				return array('status'=>false, 'msg'=>NO_OPERATION);
		}
	}


}
