<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		$this->load->view('user');
	}

	/*
	Get requst data from datatables.
	*/
	public function get()
	{
		// Get data user
		$result = $this->datatables->getData('user', array('user_name','user_full_name','user_email','user_phone','user_address','group_name','IF(user_aktif = 1, "Active", "Inactive")','user_aktif','user_group','user_id'), 'user_id', array('groups','groups.group_id = user.user_group','inner'));
		echo $result;
	}

	/*
	Get action handle insert and update data.
	*/	
	public function insert()
	{	

		$insert_id = $this->input->post('user_id');

		$data = array(
		'user_name'=>$this->input->post('user_name'),
		'user_password'=>md5($this->input->post('user_password')),
		'user_group'=>$this->input->post('user_group'),
		'user_full_name'=>$this->input->post('user_full_name'),
		'user_email'=>$this->input->post('user_email'),
		'user_phone'=>$this->input->post('user_phone'),
		'user_address'=>$this->input->post('user_address'),
		'user_aktif'=>$this->input->post('user_aktif')
		);		
		
		$this->load->model('user_model');
		$result = $this->user_model->insert($data,$insert_id);

		// Cek data insert or data update
		if(!$insert_id)
			if($result)
				echo "Data insert was successful!";
			else
				echo "Data insert not success!";
		else
			if($result)
				echo "Data update was successful!";
			else
				echo "Data update not successful!";
	}
	
	public function get_group()
	{
		$this->load->model('user_model');
		$group = $this->user_model->group();
		
		echo json_encode($group);
	}	
	
	/*
	Get action handle remove data.
	*/	
	public function remove()
	{
		$data_id = $this->input->post('remove_user_id');
		
		$this->load->model('user_model');
		$result = $this->user_model->remove($data_id);
		
		if($result)
		echo "Data remove was successful!";
		else
		echo "Data remove not successful!";
		
	}
}

/* End of file category.php */
/* Location: ./application/controller/category.php */