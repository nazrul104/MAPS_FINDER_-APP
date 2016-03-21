<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_list extends CI_Controller
{

	public function index()
	{	

		
		$this->load->view('location_list');
	}
	
	public function get()
	{

		$result = $this->datatables->getData('markers', array('markers_name','category_name','markers_phone','markers_url','markers_address','markers_lan','markers_aktif','markers_logo','markers_lat','markers_lng','markers_desc','markers_id','markers_category_id','total','rating_user','markers_created','markers_created_date'), 'markers_id',array('category','markers.markers_category_id = category.category_id','inner'),array('view_rating','markers.markers_id = view_rating.rating_markers_id','left'));
		echo $result;
		
	}
	
	public function get_category()
	{
		$this->load->model('location_list_model');
		$category = $this->location_list_model->category();
		
		echo json_encode($category);
	}	

	public function insert()
	{
		$this->load->model('login_model');
		$get_logged_in_user_info = $this->login_model->get_logged_in_user_info();
		$user_name = $get_logged_in_user_info->user_name;
		
		// Upload logo
	   $config['path']   = './upload/logo/';
	   $config['format'] =	array("jpg", "png", "gif", "bmp");
	   $config['size']   = '1024';
	   
	   $this->load->library('ajaxupload');
	   $this->ajaxupload->getUpload($config,"markers_logo");

		
		$query = $this->ajaxupload->query();

		// Upload logo
	   $config1['path']   = './upload/catalogue/';
	   $config1['format'] =	array("pdf", "doc", "docx");
	   $config1['size']   = '10240';
	   
	   $this->load->library('ajaxupload');
	   $this->ajaxupload->getUpload($config1,"markers_catalogue");
	
		$query1 = $this->ajaxupload->query();
		
		$data_id = $this->input->post('markers_id');

		$data = array();	
		$data['markers_name']  = $this->input->post('markers_name');
		$data['markers_category_id']  = $this->input->post('markers_category_id');
		$data['markers_phone']  = $this->input->post('markers_phone');
		$data['markers_url']  = $this->input->post('markers_url');
		$data['markers_address']  = $this->input->post('markers_address');
		$data['markers_lat']  = $this->input->post('markers_lat');
		$data['markers_lng']  = $this->input->post('markers_lng');
		$data['markers_desc']  = $this->input->post('markers_desc');
		$data['markers_name']  = $this->input->post('markers_name');
		$data['markers_lan']  = $this->input->post('markers_lan');
		$data['markers_aktif']  = $this->input->post('markers_aktif');
		$data['markers_created']  = $user_name;
		
		if($query['file_name'] != ''){
			$data['markers_logo'] = $query['file_name'];
		}	
		if($query1['file_name'] != ''){
			$data['markers_catalogue'] = $query1['file_name'];
		}	
		$this->load->model('location_list_model');
		$result = $this->location_list_model->insert($data,$data_id);
		
		if(!$data_id)
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

	public function remove()
	{
		$data_id = $this->input->post('remove_location_list_id');
		
		$this->load->model('location_list_model');
		$result = $this->location_list_model->remove($data_id);
		
		if($result)
			echo "Data remove was successful!";
		else
			echo "Data remove not successful!";
		
	}
			
	
}

/* End of file list_location.php */
/* Location: ./application/controller/list_location.php */