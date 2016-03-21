<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller
{
	//Get request maps
	public function get_maps()
	{
		$filter = $this->input->get('clear');
		$category = $this->input->get('category');
		$lang = $this->input->get('lang');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_maps($filter,$category,$lang);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($query);
	}
			
	//Get request list
	public function get_list()
	{
		$filter = $this->input->get('q');
		$category_id = $this->input->get('id');
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		$lang = $this->input->get('lang');
		$lat = $this->input->get('lat');
		$lon = $this->input->get('lon');
		$option = $this->input->get('option');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_list($category_id, $filter, $limit, $start, $lang, $lat, $lon, $option);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');		
		echo json_encode($query);
	}
	
	//Get request nearby
	public function get_nearby()
	{
		$lat = $this->input->get('lat');
		$long = $this->input->get('long');
		$option = $this->input->get('option');
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		$lang = $this->input->get('lang');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_nearby($lat, $long, $option, $limit, $start, $lang);

		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($query);
	}

	//Get request category
	public function get_category()
	{		
		$this->load->model('service_model');
		$lang = $this->input->get('lang');
		
		$query = $this->service_model->get_category($lang);

		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');		
		echo json_encode($query);
	}

	//Get request dashboard
	public function get_dash()
	{		
		$this->load->model('service_model');
		$lang = $this->input->get('lang');
		$query = $this->service_model->get_dash($lang);

		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');		
		echo json_encode($query);
	}
	
	//Get request detail
	public function get_detail()
	{
		$filter = $this->input->get('id');
		$lang = $this->input->get('lang');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_detail($filter,$lang);

		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');		
		echo json_encode($query);
	}

	//Get request images
	public function get_images()
	{
		$filter = $this->input->get('id');
		$lang = $this->input->get('lang');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_images($filter, $lang);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($query);
	}

	//Get request comment
	public function get_comment()
	{
		$filter = $this->input->get('id');
		
		$this->load->model('service_model');
		$query = $this->service_model->get_comment($filter);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($query);
	}

	//Get request language
	public function get_lang()
	{
		
		$this->load->model('service_model');
		$query = $this->service_model->get_lang();
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($query);
	}
	
	//Send comment
	public function send_comment()
	{
		$id 	 = $this->input->get('id');
		$name 	 = $this->input->get('form-comment-name');
		$comment = $this->input->get('form-comment');

		$data = array(
			'comment_markers_id'=>$id ,
			'comment_name'=>$name ,
			'comment_value'=>$comment
		);	
		
		$this->load->model('service_model');
		$query = $this->service_model->send_comment($data);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		
		if($query)
			echo "Thanks for your comment!";
		else
			echo "Your Comment not send!";
		
 		
	}

	//Rating
	public function rating()
	{
		$id 	 = $this->input->get('id');
		$score 	 = $this->input->get('score');

		$data = array(
			'rating_markers_id'=>$id ,
			'rating_value'=>$score
		);	
		
		$this->load->model('service_model');
		$query = $this->service_model->rating($data);
		
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		
		if($query)
			echo "Thanks for your rating!";
		else
			echo "Your rating not send!";
		
 		
	}	
	
}

/* End of file service.php */
/* Location: ./application/controller/service.php */