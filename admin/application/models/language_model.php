<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_model extends CI_Model
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
			$result = $this->db->insert('language',$data);
			
			return $result;
			
		}else{
		
			$this->db->where('language_id', $data_id);
			$result = $this->db->update('language',$data);
		
			return $result;
			
			}	
		}

	/*
	Remove 
	*/
	function remove($data_id)
	{
		
	 	return $this->db->delete('language', array('language_id' => $data_id));
				
	}
	
	
	
}