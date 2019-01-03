<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Voucher_model extends CI_Model {


	function get_vouchers($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') 
	{
        
		$this->db->select("*");
		$this->db->from('voucher_category');
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