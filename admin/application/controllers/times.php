<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Times extends CI_Controller
{

	public function index()
	{	

		
		$this->load->view('times');
	}
	
	public function get()
	{
		
		$data_id = $this->input->get('id');
		$result = $this->datatables->getData('times', array('CASE WHEN times_day = 1 THEN "Sunday" WHEN times_day = 2 THEN "Monday" WHEN times_day = 3 THEN "Tuesday" WHEN times_day = 4 THEN "Wednesday" WHEN times_day = 5 THEN "Thursday" WHEN times_day = 6 THEN "Friday" ELSE "Saturday" END','times_open','times_close','times_id','times_day'), 'markers_id','','', array('times_markers_id',$data_id));
		echo $result;
		
	}

	public function insert()
	{
		
		$data_id = $this->input->post('times_id');
		
		$data = array();
		$data['times_markers_id'] 	= $this->input->post('times_markers_id');
		$data['times_day']  	  	= $this->input->post('times_day');
		$data['times_open']  		= $this->input->post('times_open');
		$data['times_close'] 		= $this->input->post('times_close');

			$this->load->model('times_model');
			$result = $this->times_model->insert($data,$data_id);
  
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
		$data_id = $this->input->post('remove_times_id');
		
		$this->load->model('times_model');
		$result = $this->times_model->remove($data_id);
		
		if($result)
			echo "Data remove was successful!";
		else
			echo "Data remove was successful!";
		
	}
			
	
}

/* End of file images.php */
/* Location: ./application/controller/images.php */