<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Business_model extends CI_Model {

  function get_business_categories($count = false, $arr_search ='', $perpage = '', $offset = '',$order_by='', $order='') {
        
		$this->db->select("*");
		$this->db->from('business_category');
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
	
	function get_business($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
        
		$this->db->select("b.*,c.name as business_category,au.status");
		$this->db->from('business b');
		$this->db->join('business_category c', 'b.business_category_id = c.id','left');
		$this->db->join('admin_users au', 'au.business_id = b.id','inner');
		if($arr_search != '' && count((array)$arr_search) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }
        $this->db->group_by('b.id');

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
	
	
  function get_business_locations($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
        
		$this->db->select("*");
		$this->db->from('location');
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
	
	public function update_business($id,$data) {

		$this->db->where('id', $id);
		$this->db->update('business', $data);
	}
	
	public function insert_business($data) {
	
		$this->db->insert('business', $data);
		return $this->db->insert_id();
	}

	function get_business_warehouse($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
        
		$this->db->select("*");
		$this->db->from('warehouse');
		$this->db->where('status !=',2);
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
     //  echo $this->db->last_query(); die;
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