<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/*
	Action insert or update
	*/
	function insert($data,$data_id)
	{
		if ($data_id == '')
		{
			$result = $this->db->insert('user',$data);
			
			return $result;
			
		}else{
		
			$this->db->where('user_id', $data_id);
			$result = $this->db->update('user',$data);
		
			return $result;
			
			}	
		}

	/*
	Get category
	*/
	function group()
	{

		$query = $this->db->get("groups");
		$result = $query->result_array();
		
		return $result;
	}		
	
	/*
	Remove 
	*/
	function remove($data_id)
	{
		
	 	return $this->db->delete('user', array('user_id' => $data_id));
				
	}
	
	
	
}