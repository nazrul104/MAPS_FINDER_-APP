<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Times_model extends CI_Model
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
			$result = $this->db->insert('times',$data);
			
			return $result;
			
		}else{
		
			$this->db->where('times_id', $data_id);
			$result = $this->db->update('times',$data);
		
			return $result;
			
			}	
		}
		
	
	/*
	Remove 
	*/
	function remove($data_id)
	{
		
	 	return $this->db->delete('times', array('times_id' => $data_id));
				
	}
	
	
	
}