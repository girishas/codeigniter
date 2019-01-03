<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Service_model extends CI_Model {


	function get_services($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('services');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
       
       $this->db->where('service_class_type','1');
	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }


    function get_service_category($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('service_category');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
       
       $this->db->where('cat_type','1');
	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }
	
	function get_packages($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('packages');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
       
       // add condition for group
       $this->db->where('group_type',1); 

	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }


    function get_service_group($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('packages');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }

       // add condition for group
       $this->db->where('group_type',2); 

	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }


    function get_class($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('services');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
       
       $this->db->where('service_class_type','2');
	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }


    function get_class_category($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('service_category');
		//$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
        if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
       
       $this->db->where('cat_type','2');
	   $query = $this->db->get();
       //echo $this->db->last_query(); //die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }

	// get all service_timing
	function getAllServiceTiming($admin_session)
    {	

		$this->db->select('service_timing.id,service_timing.service_id,service_timing.caption,service_timing.special_price,services.service_name as sn, services.sku');
		$this->db->from('service_timing');
		$this->db->join('services','services.id=service_timing.service_id','Right');
		if($admin_session['business_id'] !=""){
			$this->db->where(['services.business_id'=>$admin_session['business_id'],'services.service_class_type'=>1]);
		}
		$this->db->where("service_timing.status",1);
		$this->db->order_by('services.service_name,service_timing.id ASC');
		$query=$this->db->get();
		
		//echo '<pre>';
		//print_r($query->result_array());die;

		//$this->db->order_by('service_id', 'DESC');
		//$result = $this->db->get('service_timing');
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
			
    }
	
	// get all service_timing for service groups
	function getAllServiceTimingServiceGroup($admin_session)
    {	
		
		$this->db->select('service_timing.id,service_timing.service_id,service_timing.caption,service_timing.special_price,services.service_name as sn, services.sku');
		$this->db->from('service_timing');
		$this->db->join('services','services.id=service_timing.service_id','Right');
		if($admin_session['business_id'] !=""){
			$this->db->where(['services.business_id'=>$admin_session['business_id'],'services.service_class_type'=>1]);
		}
		$this->db->where("service_timing.status",1);
		$this->db->where("services.is_service_group",1);
		$this->db->order_by('services.service_name,service_timing.id ASC');
		$query=$this->db->get();
		
		//echo '<pre>';
		//print_r($query->result_array());die;

		//$this->db->order_by('service_id', 'DESC');
		//$result = $this->db->get('service_timing');
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
			
    }

    // whether slug is unique or not
    function checkSlugDuplicate($slug='',$id='')
    {
    	if($id == ''){ // check for insert record
    		if(!empty($slug))
	    	{
	    		$this->db->where('slug',$slug);
	    		$result = $this->db->get('templates');
	    		if($result->num_rows() > 0){
	    			return false;
	    		}
	    		else{
	    			return true;
	    		}
	    	}
	    	else{
	    		return false;
	    	}
    	}
    	else{ // check for update record
    		if(!empty($slug)) { 
	    		
	    		$this->db->where_not_in('id', $id);
	    		$this->db->where('slug',$slug);
	    		$result = $this->db->get('templates');
	    		if($result->num_rows() > 0){
	    			//return false;
	    		}
	    		else{
	    			return true;
	    		}
	    	}
	    	else{
	    		return false;
	    	}
    	}
    	
    }
	
}

?>