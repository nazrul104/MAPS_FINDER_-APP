<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_maps($filter,$category, $lang)
	{
		if($filter != 'undefined'){
			$this->db->like('markers_name', $filter);
		}
		if($category != 'undefined'){
			$this->db->like('markers_category_id', $category);
		}
		$this->db->where('markers_lan',$lang);
		
		$this->db->select('*');
        $this->db->from('markers');
		$this->db->join('category', 'markers.markers_category_id =  category.category_id','right');
		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
		
	function get_list($category_id, $filter, $limit, $start, $lang, $lat, $long, $option)
	{
		
		$this->db->where('markers_lan',$lang);
		
		if($category_id){
			$this->db->where('markers_category_id', $category_id);
		}

		if($filter){
			$this->db->like('markers_name',$filter);
			$this->db->order_by('distance', 'asc');
		}

		if($limit!='' && $start!=''){
   		$this->db->limit($limit, $limit*$start);
   		}
		$this->db->order_by('markers_name', 'ASC');
		
		if($option == "km")
			$this->db->select("*, ROUND(((acos(sin((".$lat." * pi()/180)) * sin((markers_lat*pi()/180))+cos((".$lat." * pi()/180)) * cos((markers_lat*pi()/180)) * cos(((".$long." - markers_lng) *pi()/180))))*180/pi())*60*1.1515*1.609344) as distance");
		else
			$this->db->select("*, ROUND(((acos(sin((".$lat." * pi()/180)) * sin((markers_lat*pi()/180))+cos((".$lat." * pi()/180)) * cos((markers_lat*pi()/180)) * cos(((".$long." - markers_lng)* pi()/180))))*180/pi())*60*1.1515) as distance");
		
		$this->db->from('markers');		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}

	function get_nearby($lat, $long, $option, $limit, $start, $lang)
	{

		if($option == "km")
			$this->db->select("*, ROUND(((acos(sin((".$lat." * pi()/180)) * sin((markers_lat*pi()/180))+cos((".$lat." * pi()/180)) * cos((markers_lat*pi()/180)) * cos(((".$long." - markers_lng) *pi()/180))))*180/pi())*60*1.1515*1.609344) as distance");
		else
			$this->db->select("*, ROUND(((acos(sin((".$lat." * pi()/180)) * sin((markers_lat*pi()/180))+cos((".$lat." * pi()/180)) * cos((markers_lat*pi()/180)) * cos(((".$long." - markers_lng)* pi()/180))))*180/pi())*60*1.1515) as distance");
					
        $this->db->from('markers');
		$this->db->where('markers_lan',$lang);
        $this->db->order_by('distance', 'asc');
		
		  if($limit!='' && $start!=''){
   			$this->db->limit($limit, $limit*$start);
   		}	
   			
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	function get_category($lang)
	{
		$this->db->select('category.category_id, category.category_name, category.category_icon, COUNT(markers_category_id) AS count');
        $this->db->from('category');
		$this->db->where('category_lan',$lang);
        $this->db->order_by('category_name', 'ASC');
		$this->db->join('markers', 'category.category_id = markers.markers_category_id','left');
        $this->db->group_by('category.category_name');
		 
		$query = $this->db->get();
		
		$result = $query->result_array();
		
		return $result;
	}

	function get_lang()
	{
		$this->db->select('language_code, language_name');
        $this->db->from('language');
		$this->db->order_by('language_id', 'DESC');
		$query = $this->db->get();
		
		$result = $query->result_array();
		
		return $result;
	}
	
	function get_dash($lang)
	{
		$this->db->select('category.category_id, category.category_name, category.category_icon');
        $this->db->from('category');
		$this->db->where('category_dash',1);
		$this->db->where('category_lan',$lang);
        $this->db->order_by('category_name', 'ASC');
		 
		$query = $this->db->get();
		
		$result = $query->result_array();
		
		return $result;
	}
	
	function get_detail($filter, $lang)
	{
		if($filter != 'undefined'){
			$this->db->where('markers_id', $filter);
		}
		
		$this->db->select('*,DATE_FORMAT(times.times_open,"%H:%i") AS OPEN,DATE_FORMAT(times.times_close,"%H:%i") AS CLOSE');
        $this->db->from('markers');
		$this->db->where('markers_lan',$lang);
		$this->db->join('category', 'markers.markers_category_id =  category.category_id','left');
		$this->db->join('view_rating', 'markers.markers_id =  view_rating.rating_markers_id','left');
		$this->db->join('times', 'markers.markers_id = times.times_markers_id AND times.times_day = DAYOFWEEK(NOW())','left');
		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}
	
	function get_images($filter)
	{

		$this->db->where('images_markers_id', $filter);
		
		$query = $this->db->get('images');
		$result = $query->result_array();
		
		return $result;
	}

	function get_comment($filter)
	{
		
		$this->db->where('comment_markers_id', $filter);
		$this->db->where('comment_active', 1);
		
		$this->db->select('*, DATE_FORMAT(comment_date,"%m/%d/%Y %H:%m") AS date');
		$this->db->order_by('comment_date', 'desc');
        $this->db->from('comment');
		
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;
	}

	function send_comment($data)
	{
		
			$result = $this->db->insert('comment',$data);
			
			return $result;
	}

	function rating($data)
	{
		
			$result = $this->db->insert('rating',$data);
			
			return $result;
	}

}