<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Others extends CI_Model {

   //for common updates
	function update_common_value($tableName='', $updated_data='', $where='',$where_in='',$where_in_value='') {
		 /* date_default_timezone_set('Australia/Melbourne');
		$melbourne = time();
		 echo date("h:i A",$melbourne); die;
 */
        
		if(empty($tableName) || empty($updated_data) || (empty($where) && empty($where_in)) )
			return FALSE;
		
				$this->db->select('*');
				$this->db->from($tableName);

				if($where_in !=''){
					$this->db->where_in($where_in,$where_in_value);
				}else{
					$this->db->where($where);	
				}
				
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$query_result = $query->result_array();
				}else{
					$query_result = array();
				}

				
				//print_r($this->db->last_query()); exit;
				
		//$this->db->where($where, null, false);
				if(!empty($where_in)){
					$this->db->where_in($where_in,$where_in_value);
				}else{
					$this->db->where($where);	
				}
		$success = $this->db->update($tableName, $updated_data);
		//print_r($this->db->last_query()); exit;

     	$last_insert_id = $this->db->insert_id();

		if ($success) {
			$admin_session = $this->session->userdata('admin_logged_in');
			$audit_data = array(
							'user_id'=>$admin_session['admin_id'],
							'type'=>'UPDATE',
							'description'=>$this->db->last_query(),
							'table_name'=>$tableName,
							'table_id'=>$this->db->insert_id(),
							'old_data'=>json_encode($query_result),
							'new_data'=>json_encode($updated_data),
							'created_at'=>date('Y-m-d H:i:s'),
							);
			$this->db->insert('audit_history', $audit_data);
           return TRUE;
			//return $last_insert_id;  
        } else {
            return FALSE;
        }
    }
	
	//for common get
	function get_all_table_value($tableName='', $select='', $where='',$order_by='', $order='') {
        
		if(empty($tableName))
			return FALSE;
		
		if(!empty($select))
			$this->db->select($select);
		else
			$this->db->select(' * ');
        
		$this->db->from($tableName);               
        
		if(!empty($where))
			$this->db->where($where, null, false);
		
		if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
              
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
				
    }
	
	function get_all_table_value_count($tableName='', $select='', $where='') {
        
		if(empty($tableName))
			return FALSE;
		
		if(!empty($select))
			$this->db->select($select);
		else
			$this->db->select(' * ');
        
		$this->db->from($tableName);               
        
		if(!empty($where))
			$this->db->where($where, null, false);
		
		$query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
				
    }
	
	//for common get
	function get_all_table_value_limit($tableName='', $select='', $where='',$order_by='', $order='',$perpage='',$offset='') {
        
		if(empty($tableName))
			return FALSE;
		
		if(!empty($select))
			$this->db->select($select);
		else
			$this->db->select(' * ');
        
		$this->db->from($tableName);               
        
		if(!empty($where))
			$this->db->where($where, null, false);
		
		if ($order != '' && $order_by != '') 
            $this->db->order_by($order_by, $order);
			
		if ($perpage != '' && $offset != '') {
            $this->db->limit($perpage, $offset);
        } else if ($perpage != '') {
            $this->db->limit($perpage);
        }
		      
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
				
    }
	
	 function admin_available($email, $password) {
        $this->db->select('*');
        $this->db->from('admin_users');
        $this->db->where('email = ' . "'" . $email . "'");
        $this->db->where('password = ' . "'" . MD5($password) . "'");
		$this->db->where('status',1);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	function insert_data($table, $insert_data) {
        $success = $this->db->insert($table, $insert_data);
        $last_insert_id= $this->db->insert_id(); 

		if ($success) {
			$admin_session = $this->session->userdata('admin_logged_in');
			$audit_data = array(
							'user_id'=>$admin_session['admin_id'],
							'type'=>'INSERT',
							'description'=>$this->db->last_query(),
							'table_name'=>$table,
							'table_id'=>$this->db->insert_id(),
							'new_data'=>json_encode($insert_data),
							'created_at'=>date('Y-m-d H:i:s'),
							);
			$this->db->insert('audit_history', $audit_data);
			return $last_insert_id;
        } else {
            return FALSE;
        }
    }
	
	function delete_record($table,$condition='',$where_in='',$where_in_value='') {
         if ($table != '' && ($condition != '' || $where_in != '')) {
				$this->db->select('*');
				$this->db->from($table);
				if(!empty($where_in)){
					$this->db->where_in($where_in,$where_in_value);
				}else{
					$this->db->where($condition);
				}
				$query = $this->db->get();
				//echo "<pre>"; print_r($this->db->last_query()); exit;
				if ($query->num_rows()>0) {
					$query_result = $query->result_array();
				}else{
					$query_result = array();
				}

           if(!empty($where_in)){
					$this->db->where_in($where_in,$where_in_value);
				}else{
					$this->db->where($condition);
				}
            $success = $this->db->delete($table);
            $last_insert_id= $this->db->insert_id();
			if ($success) {
				$admin_session = $this->session->userdata('admin_logged_in');
				$audit_data = array(
							'user_id'=>$admin_session['admin_id'],
							'type'=>'DELETE',
							'description'=>$this->db->last_query(),
							'table_name'=>$table,
							'table_id'=>'',
							'old_data'=>json_encode($query_result),
							'new_data'=>'',
							'created_at'=>date('Y-m-d H:i:s'),
							);
				$this->db->insert('audit_history', $audit_data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }


    function delete_mutiple_record($table,$condition='',$where_in='',$where_in_value='') {
         if ($table != '' && ($condition != '' || $where_in != '')) {
				$this->db->select('*');
				$this->db->from($table);
				if(!empty($where_in)){
					$this->db->where_not_in($where_in,$where_in_value);
				}else{
					$this->db->where($condition);
				}
				$query = $this->db->get();
				//echo "<pre>"; print_r($this->db->last_query()); exit;
				if ($query->num_rows()>0) {
					$query_result = $query->result_array();
				}else{
					$query_result = array();
				}

           if(!empty($where_in)){
					$this->db->where_not_in($where_in,$where_in_value);
				}else{
					$this->db->where($condition);
				}
            $success = $this->db->delete($table);
            $last_insert_id= $this->db->insert_id();
			if ($success) {
				$admin_session = $this->session->userdata('admin_logged_in');
				$audit_data = array(
							'user_id'=>$admin_session['admin_id'],
							'type'=>'DELETE',
							'description'=>$this->db->last_query(),
							'table_name'=>$table,
							'table_id'=>'',
							'old_data'=>json_encode($query_result),
							'new_data'=>'',
							'created_at'=>date('Y-m-d H:i:s'),
							);
				$this->db->insert('audit_history', $audit_data);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }



     function admin_verify_available($email, $password) {
        $this->db->select('*');
        $this->db->from('admin_users');
        $this->db->where('email = ' . "'" . $email . "'");
        $this->db->where('password = ' . "'" . MD5($password) . "'");
		$this->db->where('status',0);
        $this->db->limit(1);
		//echo $this->db-query(); die;
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    
	
}

?>