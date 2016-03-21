<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function index()
	{	

		$this->load->view('category');
	}

	/*
	Get requst data from datatables.
	*/
	public function get()
	{
		// Get data category
		$result = $this->datatables->getData('category', array('category_name','category_desc','category_lan','category_aktif','category_icon','category_marker','category_id','category_dash','category_created','category_created_date'), 'category_id');
		echo $result;
	}

	/*
	Get action handle insert and update data.
	*/	
	public function insert()
	{	
	
		$this->load->model('login_model');
		$get_logged_in_user_info = $this->login_model->get_logged_in_user_info();
		$user_name = $get_logged_in_user_info->user_name;
		
		// Set upload folder
	    $config['path']   = './upload/marker/';
		// Set images type
	    $config['format'] =	array("jpg", "png", "gif", "bmp");
		// Set images size
	    $config['size']   = '1024';
	    // Load library 
	    $this->load->library('ajaxupload');
	    $this->ajaxupload->getUpload($config,"category_marker");
	    $query = $this->ajaxupload->query();
		// Cek images submit
	   	if($query['file_name'] == ''){
			$img = $this->input->post('category_marker_old');
		}else{
			$img = $query['file_name'];
		}
		
		$insert_id = $this->input->post('category_id');

		$data = array(
		'category_name'=>$this->input->post('category_name'),
		'category_desc'=>$this->input->post('category_desc'),
		'category_icon'=>$this->input->post('category_icon'),
		'category_dash'=>$this->input->post('category_dash'),
		'category_lan'=>$this->input->post('category_lan'),
		'category_aktif'=>$this->input->post('category_aktif'),
		'category_created'=>$user_name,
		'category_marker'=>$img,
		);		
		
		$this->load->model('category_model');
		$result = $this->category_model->insert($data,$insert_id);
		
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

	/*
	Get language data.
	*/		
	public function get_language()
	{
		$this->load->model('category_model');
		$category = $this->category_model->language();
		
		echo json_encode($category);
	}	
	
	/*
	Get action handle remove data.
	*/	
	public function remove()
	{
		$data_id = $this->input->post('remove_category_id');
		
		$this->load->model('category_model');
		$result = $this->category_model->remove($data_id);
		
		if($result)
		echo "Data remove was successful!";
		else
		echo "Data remove not successful!";
		
	}
}

/* End of file category.php */
/* Location: ./application/controller/category.php */