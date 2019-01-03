<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Staff_model extends CI_Model {

 	
	function get_staff($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
		
        
		$this->db->select("s.*");
		$this->db->from('staff s');
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
	
}

?>