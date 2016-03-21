<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->model('login_model');
	}

	public function index()
	{	
	
		if(!$this->login_model->is_logged_in()){ redirect('login'); }	
		$get_logged_in_user_info = $this->login_model->get_logged_in_user_info();
		$user_group = $get_logged_in_user_info->user_group;
		//access_id	access_group_id	access_module_id

		$this->db->select('*');
		$this->db->from('access');
		$this->db->where('access_view', 1);
		$this->db->where('access_group_id', $user_group);
		$this->db->join('module', 'access.access_module_id = module.module_id');
		$query = $this->db->get();
		$data['user_menu'] = $query;
		

		//$data['user_info'] = $get_logged_in_user_info;
		$this->template->display('home',$data);
		
	}
	
	function get_access_menu()
	{
	
	$get_logged_in_user_info = $this->login_model->get_logged_in_user_info();
	$user_group = $get_logged_in_user_info->user_group;
	
	$this->db->select('*');
	$this->db->from('access');
	$this->db->where('access_group_id', $user_group);
	$this->db->where('access_module_id', $this->input->get('modul'));
	$data = $this->db->get();
	
	foreach ($data->result_array() as $rows){
	 $response['access_insert'] = $rows['access_insert'];
 	 $response['access_update'] = $rows['access_update'];
 	 $response['access_delete'] = $rows['access_delete'];
	}
	echo json_encode( $response );
	
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */