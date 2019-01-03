<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
	Class Resources_model extends CI_Model {
		
		
		function get_resources($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
			
			$this->db->select("*");
			$this->db->from('resources');
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
		
		
		
		// start all invoices
		
		function get_invoices($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='',$business_id=null) {
			
			$this->db->select("*");
			$this->db->from('invoices');
			if($business_id != 'null') {
				$this->db->where('business_id',$business_id);
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
			// echo $this->db->last_query(); die;
			if ($count == false) {  
				if ($query->num_rows() > 0) {
					return $query->result_array();
				}else
				return false;
				}else{
				return $query->num_rows();
			}		
		}
		
		function getrecordCount($search = '',$location = '',$f_invoice_date='', $business_id='') {
			
			$admin_session = $this->session->userdata('admin_logged_in');
			$this->db->select('count(*) as allcount');
			$this->db->from('invoices');
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
			{
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"  )
			{
				$this->db->where('location_id',$admin_session['location_id']);
				
			}
			
			if($search != ''){
				$this->db->like('invoice_number', $search);
			}
			
			if($location != ''){
				$this->db->like('location_id', $location);
			}
			
			if($f_invoice_date != ''){
				$this->db->like('date_created', $f_invoice_date);
			}
			
			$query = $this->db->get();
			
			$result = $query->result_array();
			// gs($result);
			
			return $result[0]['allcount'];
			
		}
		
		public function getData($rowno,$rowperpage,$search="",$location="",$f_invoice_date='',$business_id="") {
			
			$this->db->select('*');
			$this->db->from('invoices');
			
			/*if($business_id != '' && count((array)$business_id) > 0) {
				$this->db->where('business_id',$business_id);
			}	*/
			$admin_session = $this->session->userdata('admin_logged_in');
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
			{
				$this->db->where('business_id',$admin_session['business_id']);
				
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff" )
			{
				$this->db->where('location_id',$admin_session['location_id']);
				
			} 
			
			if($search != ''){
				$this->db->like('invoice_number', $search);
			}
			
			if($location != '' && count((array)$location) > 0){
				$this->db->like('location_id', $location);
			}
			
			if($f_invoice_date != ''){
				$this->db->like('date_created', $f_invoice_date);
			}
			
			$this->db->order_by('date_created ', 'desc');
			$this->db->order_by('id', 'desc');
			
			$this->db->limit($rowperpage, $rowno); 
			$query = $this->db->get();
			
			// gs($this->db->last_query());
			
			
			
			return $query->result_array();
		}
		
		
	}
	
?>