<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class User_model extends CI_Model {

function get_admin_users($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
        $admin_session = $this->session->userdata('admin_logged_in');
		$this->db->select("u.*,b.name");
		$this->db->from("admin_users u");
		$this->db->join('business b', 'u.business_id = b.id','left');
		$this->db->where('role','owner');
		
		if(isset($admin_session['business_id']) && $admin_session['business_id']!=""){
			$this->db->where('business_id', $admin_session['business_id']);
			$this->db->where("u.id!='".$admin_session['admin_id']."' ");
		}
		
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
       //echo $this->db->last_query(); die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }
	
	function get_customer($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='',$customer_name=null) {
		$this->db->select("c.*");
		$this->db->from('customer c');
		$this->db->where('status',1);
		//$this->db->join('staff_job_title j', 's.job_title_id = j.id','left');
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

        if($customer_name != '') {
        	$this->db->where("(first_name like '%$customer_name%' OR last_name like '%$customer_name%' OR mobile_number like '%$customer_name%' OR customer_number like '%$customer_name%' OR email like '%$customer_name%')" );
		}
            
	   $query = $this->db->get();
       //echo $this->db->last_query(); die;
       if ($count == false) {  
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else
				return false;
		}else{
			return $query->num_rows();
		}		
    }
	
	public function update_user($id,$data) {

		$this->db->where('id', $id);
		$this->db->update('admin_users', $data);
	}
	
	public function insert_user($data) {
	
		$this->db->insert('admin_users', $data);
		return $this->db->insert_id();
	}


	

  // Select total records
  public function getrecordCount($search = '',$where) {

    $this->db->select('count(*) as allcount');
    $this->db->from('customer');
    $this->db->where('status',1);
    $this->db->where($where);
 
    if($search != ''){
            $this->db->where("(first_name like '%$search%' OR last_name like '%$search%' OR mobile_number like '%$search%' OR customer_number like '%$search%' OR email like '%$search%')");
	}

    $query = $this->db->get();
    $result = $query->result_array();
 
    return $result[0]['allcount'];
  }

	
}

?>