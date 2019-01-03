<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
	Class Audit_history extends CI_Model {
		
		function get_business_staff($business_user_id){
			$this->db->select('admin_users.*,location.location_name');
			$this->db->from('admin_users');
			$this->db->where('admin_users.business_id',$business_user_id);
			/* $where = "admin_users.location_id is  NOT NULL";
			$this->db->where($where); */
			$this->db->join('location', 'location.id = admin_users.location_id', 'left');
			$result = $this->db->get();
			$result = $result->result_array();
			return $result;
		}
		
		function get_view_data($count = false, $arr_search='', $perpage = '', $offset = '',$id){
			
			$this->db->select('admin_users.admin_name as admin_name,audit_history.*');
			$this->db->from('audit_history');
			$this->db->where('audit_history.user_id',$id);
			if($arr_search){
				$this->db->where("(audit_history.table_name like '%$arr_search%' OR audit_history.type like '%$arr_search%' )");
			}
			$this->db->join('admin_users', 'admin_users.id = audit_history.user_id', 'left');
			$order_by = "audit_history.created_at";
			$order = "DESC";
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
					//echo $this->db->last_query(); die;
					return $query->result_array();
				}else
					return false;
			}else{
				return $query->num_rows();
			}	
		}
		
		public function record_count() {
			return $this->db->count_all("audit_history");
		}
		
		// Fetch data according to per_page limit.
		public function fetch_data($limit, $id) {
			$this->db->limit($limit);
			$this->db->where('user_id', $id);
			$query = $this->db->get("audit_history");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
				
				return $data;
			}
			return false;
		}
		
		
		
	}
	
?>