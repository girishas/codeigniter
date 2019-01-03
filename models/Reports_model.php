<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Reports_model extends CI_Model {


	function get_product_details($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='',$filter='') {
        
		//$this->db->select("*");
		//$this->db->from('product');
		
	 	$this->db->select('p.id pid,p.product_name pname,p.sku psku,p.alert_quantity p_alrtqty,p.purchase_price p_pprice,p.retail_price p_rprice,pl.location_id pl_locid,sum(pl.quantity) as totalstcokqty');    
		$this->db->from('product p');
		$this->db->join('product_locationwise pl', 'p.id = pl.product_id AND p.business_id = pl.business_id','left');
		//$this->db->where('p.business_id');
		$this->db->group_by('pl.product_id');
		$this->db->group_by('pl.location_id');
		//$this->db->join('invoice_services is', 'p.id = is.product_id');


		
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['role']=="business_owner")
		{
			$this->db->where('pl.business_id',$admin_session['business_id']);
			
		}
		if($admin_session['role']=="location_owner")
		{
			$this->db->where('pl.location_id',$admin_session['location_id']);
			
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

        if($filter != '' && count((array)$filter) > 0) {
           foreach ($filter as $key => $value) {
               	//$this->db->where($key, $value);
           		if($key == 'pl.business_id' || $key == 'pl.location_id'){
           			$this->db->where($key, $value);
           		}
           		if($key == 'p.sku'  ){
           			$this->db->like($key, $value);
           		}
           		if($key == 'p.product_name' ){
           			$this->db->or_like($key, $value);
           		}
           		
            }
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

    

    // start all invoices
	
    function get_invoices($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {
        
		$this->db->select("*");
		$this->db->from('invoices');
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

	// end all invoices
}

?>