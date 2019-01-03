<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Product_model extends CI_Model {

	function get_suppliers($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {        
		$this->db->select("s.*");
		$this->db->from('product_supplier s');
		if($arr_search != '' && count((array($arr_search))) > 0) {
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
	
	function get_categories($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {        
		$this->db->select("c.*");
		$this->db->from('product_category c');
		if($arr_search != '' && count((array($arr_search))) > 0) {
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
	
	function get_brands($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {        
		$this->db->select("c.*");
		$this->db->from('product_brand c');
		$this->db->where('type',2);
		if($arr_search != '' && count((array($arr_search))) > 0) {
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
	
	function get_products($count = false, $arr_search,$product_search, $perpage = '', $offset = '',$order_by='', $order='') {   
		//echo "<pre>"; print_r($arr_search); die;
		$this->db->select("p.*,c.category_name,b.brand_name,s.first_name,s.last_name");
		$this->db->from('product p');
		$this->db->join('product_category c', 'p.category_id = c.id','left');
		$this->db->join('product_brand b', 'p.brand_id = b.id','left');
		$this->db->join('product_supplier s', 'p.supplier_id = s.id','left');		
		if($arr_search != '' && count((array($arr_search))) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }
        $this->db->where('p.status !=',2);
        if ($product_search!='') {
        	$this->db->where("( product_name like '%$product_search%' OR bar_code like '%$product_search%' OR retail_price like '%$product_search%'  )");
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
	
	function get_supplier_detail($supplier_id="") {        
		
		if($supplier_id=="")
			return false;
		
		$this->db->select("s.*,c.name as country_name");
		$this->db->from('product_supplier s');
		$this->db->join('country c', 's.country_id = c.iso_code','left');
		$this->db->where('id', $supplier_id);
		
	    $query = $this->db->get();
        //echo $this->db->last_query(); die;
      	if ($query->num_rows() > 0) {
			return $query->result_array();
		}else
			return false;	
    }
	
	function get_location_products($arr_search) {        
		$this->db->select("l.id,l.location_name,p.quantity");
		$this->db->from('location l');
		$this->db->join('product_locationwise p', 'l.id = p.location_id','left');
		if($arr_search != '' && count((array($arr_search))) > 0) {
           foreach ($arr_search as $key => $value) {
               	$this->db->where($key, $value);
            }
        }		
       $query = $this->db->get();
       //echo $this->db->last_query(); die;
       if ($query->num_rows() > 0) {
			return $query->result_array();
		}else
			return false;	
    }
	
	function get_orders($count = false, $arr_search, $perpage = '', $offset = '',$order_by='', $order='') {        
		$this->db->select("o.*,l.location_name,s.first_name,s.last_name");
		$this->db->from('orders o');
		$this->db->join('product_supplier s', 'o.supplier_id = s.id','left');
		$this->db->join('location l', 'o.location_id = l.id','left');
		//$this->db->where('o.order_type',2);
		//$this->db->group_by('o.order_id');
		if($arr_search != '' && count((array($arr_search))) > 0) {
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
	
	function get_ordered_products($condition="",$received_items="") {        
		$this->db->select("o.*,p.product_name,p.purchase_price");
		$this->db->from('product_locationwise o');
		$this->db->join('product p', 'o.product_id = p.id','left');
		if(!empty($condition))
			$this->db->where($condition, null, false);		
        $query = $this->db->get();
       //echo $this->db->last_query(); die;
       if ($query->num_rows() > 0) {
			return $query->result_array();
		}else
			return false;	
    }

     public function getproductrecordCount($search = '',$business_id) {

   $this->db->select("p.*,c.category_name,b.brand_name,s.first_name,s.last_name,count(p.id) as allcount");
		$this->db->from('product p');
		$this->db->join('product_category c', 'p.category_id = c.id','left');
		$this->db->join('product_brand b', 'p.brand_id = b.id','left');
		$this->db->join('product_supplier s', 'p.supplier_id = s.id','left');
		$this->db->where('p.business_id',$business_id);

    if($search != ''){
			$this->db->where("(p.product_name like '%$search%' OR p.bar_code like '%$search%' OR p.retail_price like '%$search%' OR p.date_created like '%$search%')");
    		//$this->db->or_like('email',$search);
    }

    $query = $this->db->get();
    $result = $query->result_array();
 
    return $result[0]['allcount'];
  }
	
	
	
}

?>