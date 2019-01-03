<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Operations extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('product_model', '', TRUE);
        /*$admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['admin_email'] =='') {
			redirect('admin');
	    }*/
	} 
	
	public function index()
	{
	    
	}


	public function delete_service_timing($id){
		if($id){
			$update = $this->others->update_common_value("service_timing",array("status"=>'0'),"id='".$id."' ");
			if($update){
				echo json_encode(array("status"=>"success"));
			}else{
				echo json_encode(array("status"=>"failed"));
			}
		}else{
			echo json_encode(array("status"=>"failed"));
		}
	}
	
		
	public function suggestion_list() {
		$admin_session = $this->session->userdata('admin_logged_in');

		$business_id = $admin_session['business_id'];
	 	$chars = $this->input->get('chars');
		if(strstr($chars,"_")){
			$char_str = explode("_",$chars);
			$chars = end($char_str);
		}
		//$orig_search_str = mysql_real_escape_string($chars);
		//$search_len = strlen($orig_search_str);
		$arr=array();
		$limit = 20;
		$this->db->select("first_name,last_name,id");
		$this->db->from('customer');

		if($admin_session['role']=='business_owner'){
		$this->db->where("(first_name like '%".$chars."%' OR last_name like '%".$chars."%' OR email like '%".$chars."%' or mobile_number like '%".$chars."%') and (business_id =$business_id) ", NULL, FALSE);
		}elseif($admin_session['role']=='owner')
		{
		$this->db->where("(first_name like '%".$chars."%' OR last_name like '%".$chars."%' OR email like '%".$chars."%' or mobile_number like '%".$chars."%') ", NULL, FALSE);
		}


		$this->db->limit($limit);
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$count = $query->num_rows();
		if ($count > 0) {
			$result = $query->result_array();			
			foreach($result as $data){
				$url = strip_tags(base_url('admin/customer/detail/'.$data['id']));
				$arr[]="<a href='".$url."'>".$data['first_name']." ".$data['last_name']."</a>";
			}
		}
		echo json_encode($arr);
	 }
	 
	 public function suggestion_product() {
	 	
	 	$admin_session = $this->session->userdata('admin_logged_in');
	 	
	 	$chars = $this->input->get('chars');
	 	if (empty($chars)) {
	 	 	$chars = $this->input->get('term');
	 	 } 
	 	
		$warehouse_id = $this->input->get('warehouse_id');
		$type = $this->input->get('type');
		$warehouse_id=preg_replace('/[^0-9]+/', '', $warehouse_id);
		if(strstr($chars,"_")){
			$char_str = explode("_",$chars);
			$chars = end($char_str);
		}

		//print_r($_GET); exit;
		//$orig_search_str = mysql_real_escape_string($chars);
		//$search_len = strlen($orig_search_str);
		$arr=array();
	//	$limit = 20;
		$this->db->select("product.product_name");
		$this->db->from('product');
		if ($type=='w') {
			$this->db->join('product_warehousewise', 'product_warehousewise.product_id=product.id','left');
			$this->db->where("product_warehousewise.warehouse_id",$warehouse_id);
		}elseif($type=='l') {
			$this->db->join('product_locationwise', 'product_locationwise.product_id=product.id','left');
			$this->db->where("product_locationwise.location_id",$warehouse_id);
		}
		$this->db->where("(product.product_name like '%".$chars."%' OR product.bar_code like '%".$chars."%' )");
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$this->db->where("product.business_id",$admin_session['business_id']);
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$this->db->where("product.business_id",$admin_session['business_id']);
		}
		
		$this->db->order_by('product.product_name', 'ASC');
		$this->db->group_by('product.id');

		//$this->db->limit($limit);
		
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$count = $query->num_rows();
		if ($count > 0) {
			$result = $query->result_array();
			foreach($result as $data){
				$arr[]=$data['product_name'];
			}
		}
		echo json_encode($arr);
	 }
	 
	 public function delete_business_category($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("business_category","id","id='".$id."' ");
			if($record){
				$delete = $this->others->delete_record("business_category","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function delete_business($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("business","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("business","id='".$id."'");
					//Delete business owner admin account
					$this->others->delete_record("admin_users","business_id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("business",array("status"=>'1'),"id='".$id."' ");
					$this->others->update_common_value("admin_users",array("status"=>'1'),"business_id='".$id."' ");
					 $this->business_active_mail($id);
				}elseif($operation=="inactive"){
					$this->others->update_common_value("business",array("status"=>'0'),"id='".$id."' ");

					$this->others->update_common_value("admin_users",array("status"=>'0'),"business_id='".$id."' ");

				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function delete_user($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("admin_users","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$this->others->delete_record("admin_users","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("admin_users",array("status"=>1),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("admin_users",array("status"=>'0'),"id='".$id."' ");
				}				
				
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function delete_staff($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("staff","id","id='".$id."' ");
			if($record){				
				if($operation=="delete"){
					$delete = $this->others->delete_record("staff","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("staff",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("staff",array("status"=>'0'),"id='".$id."' ");
				}				
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function get_business_locations($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$id."' ","location_name","ASC");
			if($locations){
				$copyright_like_html = '<select class="form-control" name="location_id" id="location_id" onChange="return get_location_data(this.value)">';
				$copyright_like_html .= '<option value="">Select Location</option>';
				foreach($locations as $loc){
					$copyright_like_html .='<option value="'.$loc['id'].'">'.$loc['location_name'].'</option>';
				}
				$copyright_like_html .='</select>';
			} else {
                $copyright_like_html = '<select class="form-control" name="location_id" id="location_id">';
				$copyright_like_html .= '<option value="">Select Location</option>';
				$copyright_like_html .='</select>';
            }
			
			//get suppliers
			$copyright_supplier_html='';
			$get_suppliers = $this->input->post('get_suppliers');
			if(isset($get_suppliers) && $get_suppliers==1){
				$suppliers = $this->others->get_all_table_value("product_supplier","id,first_name,last_name","business_id='".$id."'","first_name","ASC");
				if($suppliers){
					$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id" onChange="get_supplier_detail(this.value);">';
					$copyright_supplier_html .= '<option value="">Select Supplier</option>';
					foreach($suppliers as $supplier){
						$copyright_supplier_html .='<option value="'.$supplier['id'].'">'.$supplier['first_name'].' '.$supplier['last_name'].'</option>';
					}
					$copyright_supplier_html .='</select>';
				} else {
					$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
					$copyright_supplier_html .= '<option value="">Select Supplier</option>';
					$copyright_supplier_html .='</select>';
				}
			}			
			
			//get products
			$status_product=false;
			$copyright_product_html='';
			$get_products = $this->input->post('get_products');
			if(isset($get_products) && $get_products==1){
				$products = $this->others->get_all_table_value("product","id,product_name","business_id='".$id."'","product_name","ASC");
				if($products){
					$copyright_product_html = '<select class="form-control" name="product_id[]" id="product_id" style="width:350px;display:inline;">';
					$copyright_product_html .= '<option value="">Select Product</option>';
					foreach($products as $product){
						$copyright_product_html .='<option value="'.$product['id'].'">'.$product['product_name'].'</option>';
					}
					$copyright_product_html .='</select>';
					$status_product = true;
				} else {
					$copyright_product_html = '<select class="form-control" name="product_id[]" id="product_id" style="width:350px;display:inline;">';
					$copyright_product_html .= '<option value="">Select Product</option>';
					$copyright_product_html .='</select>';
				}
			}
			
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_like_html' => $copyright_like_html,'copyright_supplier_html' => $copyright_supplier_html,'copyright_product_html' => $copyright_product_html,'status_product'=>$status_product));
        echo $jsonEncode;
	 }
	 
	 public function get_business_location_data() {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $this->input->post('business_id');
		$location_id = $this->input->post('location_id');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            
			$condition = "";
			if(!empty($business_id)){
				$condition .= empty($condition)?"business_id='".$business_id."' ":" AND business_id='".$business_id."' " ; 
			}
			if(!empty($location_id)){
				$condition .= empty($condition)?"location_id='".$location_id."' ":" AND location_id='".$location_id."' " ; 
			}
			
			//get category
			$categories = $this->others->get_all_table_value("product_category","id,category_name",$condition,"category_name","ASC");
			if($categories){
				$copyright_category_html = '<select class="form-control" name="category_id" id="category_id">';
				$copyright_category_html .= '<option value="">Select Category</option>';
				foreach($categories as $cat){
					$copyright_category_html .='<option value="'.$cat['id'].'">'.$cat['category_name'].'</option>';
				}
				$copyright_category_html .='</select>';
			} else {
                $copyright_category_html = '<select class="form-control" name="category_id" id="category_id">';
				$copyright_category_html .= '<option value="">Select Category</option>';
				$copyright_category_html .='</select>';
            }
			
			//get brand
			$brands = $this->others->get_all_table_value("product_brand","id,brand_name",$condition,"brand_name","ASC");
			if($brands){
				$copyright_brand_html = '<select class="form-control" name="brand_id" id="brand_id">';
				$copyright_brand_html .= '<option value="">Select Brand</option>';
				foreach($brands as $brand){
					$copyright_brand_html .='<option value="'.$brand['id'].'">'.$brand['brand_name'].'</option>';
				}
				$copyright_brand_html .='</select>';
			} else {
                $copyright_brand_html = '<select class="form-control" name="brand_id" id="brand_id">';
				$copyright_brand_html .= '<option value="">Select Brand</option>';
				$copyright_brand_html .='</select>';
            }
			
			//get suppliers
			$suppliers = $this->others->get_all_table_value("product_supplier","id,first_name,last_name",$condition,"first_name","ASC");
			if($suppliers){
				$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				foreach($suppliers as $supplier){
					$copyright_supplier_html .='<option value="'.$supplier['id'].'">'.$supplier['first_name'].' '.$supplier['last_name'].'</option>';
				}
				$copyright_supplier_html .='</select>';
			} else {
                $copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				$copyright_supplier_html .='</select>';
            }			
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_category_html' => $copyright_category_html,'copyright_brand_html' => $copyright_brand_html,'copyright_supplier_html' => $copyright_supplier_html));
        echo $jsonEncode;
	 }
	 
	  public function delete_customer($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("customer","id","id='".$id."' ");
			if($record){
				//$this->others->delete_record("customer","id='".$id."'");

				$this->others->update_common_value("customer",array("status"=>'2'),"id='".$id."' ");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	
	 public function delete_supplier($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("product_supplier","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("product_supplier","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("product_supplier",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("product_supplier",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 
 	public function delete_product_category($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("product_category","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("product_category","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("product_category",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("product_category",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }


	 public function delete_product_brand($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("product_brand","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("product_brand","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("product_brand",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("product_brand",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function operation_location($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("location","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("location","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("location",array("status"=>1),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("location",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function operation_product($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("product","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					#$delete = $this->others->delete_record("product","id='".$id."'");
					$delete = $this->others->update_common_value("product",array("status"=>2),"id='".$id."' ");
				}elseif($operation=="active"){
					$this->others->update_common_value("product",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("product",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 
	 public function get_supplier_detail($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->product_model->get_supplier_detail($id);
			if($record){
				$copyright_supplier_html = '';
				$copyright_supplier_html .='<strong>Name</strong>: '.$record[0]['first_name'].' '.$record[0]['last_name'];
				$copyright_supplier_html .='<br/><strong>Email</strong>: '.$record[0]['email'];
				$copyright_supplier_html .='<br/><strong>Address1</strong>: '.$record[0]['address1'];
				$copyright_supplier_html .='<br/><strong>Address2</strong>: '.$record[0]['address2'];
				$copyright_supplier_html .='<br/><strong>City</strong>: '.$record[0]['city'];
				$copyright_supplier_html .='<br/><strong>State</strong>: '.$record[0]['state'];
				$copyright_supplier_html .='<br/><strong>Country</strong>: '.$record[0]['country_name'];
				
				$copyright_product_html = '';
				$products = $this->others->get_all_table_value("product","id,product_name","supplier_id='".$id."'","product_name","ASC");
				$count_product = 0;
				if($products){
					$copyright_product_html .= '<select class="form-control" name="product_id[]" id="product_id" style="width:350px;display:inline;">';
					$copyright_product_html .='<option value="">Select Product</option>';
					foreach($products as $product){
						$copyright_product_html .='<option value="'.$product['id'].'">'.$product['product_name'].'</option>';
						$count_product ++ ; 
					}
					$copyright_product_html .='</select>';
				} else {
					$copyright_product_html = 'No Product added for this seller.';
				}	
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_supplier_html' => $copyright_supplier_html,'copyright_product_html' => $copyright_product_html,'count_product'=>$count_product));
        echo $jsonEncode;
	 }
	 
	 public function get_business_category_brand_suppliers() {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $this->input->post('business_id');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            
			$condition = "";
			if(!empty($business_id)){
				$condition .= empty($condition)?"business_id='".$business_id."' ":" AND business_id='".$business_id."' " ; 
			}
			//get category
			$categories = $this->others->get_all_table_value("product_category","id,category_name",$condition,"category_name","ASC");
			if($categories){
				$copyright_category_html = '<select class="form-control" name="category_id" id="category_id">';
				$copyright_category_html .= '<option value="">Select Category</option>';
				foreach($categories as $cat){
					$copyright_category_html .='<option value="'.$cat['id'].'">'.$cat['category_name'].'</option>';
				}
				$copyright_category_html .='</select>';
			} else {
                $copyright_category_html = '<select class="form-control" name="category_id" id="category_id">';
				$copyright_category_html .= '<option value="">Select Category</option>';
				$copyright_category_html .='</select>';
            }
			
			//get brand
			$brands = $this->others->get_all_table_value("product_brand","id,brand_name",$condition,"brand_name","ASC");
			if($brands){
				$copyright_brand_html = '<select class="form-control" name="brand_id" id="brand_id">';
				$copyright_brand_html .= '<option value="">Select Brand</option>';
				foreach($brands as $brand){
					$copyright_brand_html .='<option value="'.$brand['id'].'">'.$brand['brand_name'].'</option>';
				}
				$copyright_brand_html .='</select>';
			} else {
                $copyright_brand_html = '<select class="form-control" name="brand_id" id="brand_id">';
				$copyright_brand_html .= '<option value="">Select Brand</option>';
				$copyright_brand_html .='</select>';
            }
			
			//get suppliers
			$suppliers = $this->others->get_all_table_value("product_supplier","id,first_name,last_name",$condition,"first_name","ASC");
			if($suppliers){
				$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				foreach($suppliers as $supplier){
					$copyright_supplier_html .='<option value="'.$supplier['id'].'">'.$supplier['first_name'].' '.$supplier['last_name'].'</option>';
				}
				$copyright_supplier_html .='</select>';
			} else {
                $copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				$copyright_supplier_html .='</select>';
            }			
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_category_html' => $copyright_category_html,'copyright_brand_html' => $copyright_brand_html,'copyright_supplier_html' => $copyright_supplier_html));
        echo $jsonEncode;
	 }
	 
	 public function add_product_order_list() {

	 	$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $admin_session['business_id'];
		$product_name = $this->input->post('product_name');
		$warehouse_id = $this->input->get_post('warehouse_id');
		$type = $this->input->get_post('type');
		
		$warehouse_id=preg_replace('/[^0-9]+/', '', $warehouse_id);
		//print_r($_POST); exit;
		//echo $warehouse_id; exit;
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
           /* $product_detail = $this->others->get_all_table_value_limit("product","id,product_name,purchase_price,product_tax,product_tax_type","product_name='".$product_name."' and business_id ='".$business_id."'","","",1);*/
          
           if ($type=='w') {
           		 $this->db->select("product.id,product.product_name,product.purchase_price,product.product_tax,product.product_tax_type,SUM(warehouse_quantity) AS quantity,product_warehousewise.warehouse_id ");
	           $this->db->from('product');
	           $this->db->where('product.business_id',$business_id);
	           $this->db->where('product.product_name',$product_name);
			   $this->db->join('product_warehousewise', 'product_warehousewise.product_id=product.id','left');
				$this->db->where("product_warehousewise.warehouse_id",$warehouse_id);
			}
			elseif($type=='l') {
				 $this->db->select("product.id,product.product_name,product.purchase_price,product.product_tax,product.product_tax_type,SUM(product_locationwise.quantity) AS quantity, product_locationwise.location_id ");
	           $this->db->from('product');
	          
	           $this->db->where('product.business_id',$business_id);
	           $this->db->where('product.product_name',$product_name);
				$this->db->join('product_locationwise', 'product_locationwise.product_id=product.id','left');
				

				$this->db->where("product_locationwise.location_id",$warehouse_id);
			}

			elseif($type=='s') {
				 $this->db->select("product.id,product.product_name,product.purchase_price,product.product_tax,product.product_tax_type");
	           $this->db->from('product');	          
	           $this->db->where('product.business_id',$business_id);
	           $this->db->where('product.product_name',$product_name);
			}
          $product_detail= $this->db->get()->row_array();
         
          if ($type=='l') {
          	$product_id= $product_detail['id'];
          	$location_id= $product_detail['location_id'];
          	$sql_used = "SELECT SUM(quantity) as used_quantity from product_used where product_id=$product_id and location_id=$location_id";
					$qty_used = $this->db->query($sql_used)->row_array();
					$used_quantity=$qty_used['used_quantity'];
					
          }

          elseif ($type=='w') {
          	$product_id= $product_detail['id'];
          	$warehouse_id= $product_detail['warehouse_id'];
          	 $sql_used = "SELECT SUM(quantity) as used_quantity from product_warehouse_used where product_id=$product_id and warehouse_id=$warehouse_id";
					$qty_used = $this->db->query($sql_used)->row_array();
					$used_quantity=$qty_used['used_quantity'];
          	
          }
          else{
          		$used_quantity=0;
          }

         

          //echo $used_qty; exit;

        // print_r($product_detail['id']); exit;

        //  print_r($this->db->last_query()); exit;
          //echo json_encode($product_detail);die;
			if($product_detail){
				//print_r($product_detail);
				//$price = $product_detail[0]['purchase_price'];
				$product_tax_percent = $product_detail['product_tax'];
				//$product_tax = $product_detail['product_tax'];
				if (isset($product_detail['quantity'])) {
					$quantity = $product_detail['quantity']-$used_quantity;
				}
				
				
				$ptax_type = $product_detail['product_tax_type'];
				if($product_detail['product_tax_type']=="exclusive"){
					$price = $product_detail['purchase_price'];
					$product_tax = ($price*$product_tax_percent)/100;
					$sub_total = $price+$product_tax;
				}elseif($product_detail['product_tax_type']=="inclusive")
				{
					$price = $product_detail['purchase_price'];
					$product_tax = ($price*$product_tax_percent)/100;
					//echo $product_tax;die;
					$price = $product_detail['purchase_price']-$product_tax;
					$sub_total = $product_detail['purchase_price'];
				}
				else{
					$price = $product_detail['purchase_price'];
					$product_tax = 0;
					$price = $product_detail['purchase_price']-$product_tax;
					$sub_total = $product_detail['purchase_price'];
				}
				//echo $product_tax;die;



				$copyright_product_html = '<tr id="row_'.$product_detail['id'].'">
					
					
						<input type="hidden" name="added_product_price[]" value="'.$product_detail['purchase_price'].'">
						<input class="cls_price" type="hidden" name="purchase_price_'.$product_detail['id'].'" id="purchase_price_'.$product_detail['id'].'" value="'.$price.'">
						<input class="tax_type" type="hidden" name="tax_type_'.$product_detail['id'].'" id="tax_type_'.$product_detail['id'].'" value="'.$product_detail['product_tax_type'].'">
						<input class="product_tax" type="hidden" name="product_tax_'.$product_detail['id'].'" id="product_tax_'.$product_detail['id'].'" value="'.$product_detail['product_tax'].'">
					
					<td class="cell-100">'.$product_detail['product_name'].'</td>
					<td class="cell-100"><input type="hidden" name="product_price[]" value="'.round($price, 2).'">'.round($price, 2).'</td>				
					<td class="cell-100"><input class="cls_qty" id="quantity_'.$product_detail['id'].'" maxlength="4" type="text" name="quantity[]" style="width:50px;" value="1" onKeyUp="change_price_data(this.value,\''.$product_detail['id'].'\')"></td>';

					if ($type=='s') {
						$copyright_product_html .= '<td class="cell-40"scope="col"><span class="available_qty_'.$product_detail['id'].'">N/A</span> </td>';
					}
					else{
						
						$copyright_product_html .= '<td class="cell-40"scope="col"><span class="available_qty_'.$product_detail['id'].'">'.$quantity.'</span> </td>';
					}


				


					$copyright_product_html .= '<td class="cell-40" scope="col"><span class="product_tax_'.$product_detail['id'].'">'.round($product_tax, 2).'</span>
					<input type="hidden" name="ptax[]" value="'.$product_tax.'">
					<input type="hidden" name="product_tax_percent[]" value="'.$product_tax_percent.'">
					<input type="hidden" name="ptax_type[]" value="'.$ptax_type.'">
					<input class="cls_tax" type="hidden" name="tax_amount[]" value="'.round($product_tax, 2).'" id="purchase_tax_amt_'.$product_detail['id'].'"></td>
					<td class="cell-50" scope="col" id="product_price_'.$product_detail['id'].'"><span class="product_price_'.$product_detail['id'].'">'.round($sub_total, 2).'</span><input class="cls_subtotal" type="hidden" name="cls_subtotal[]" value="'.round($sub_total, 2).'" id="cls_subtotal_'.$product_detail['id'].'"></td>
					<td class="cell-50" scope="col"><a href="javascript:void(0);" onClick="delete_row(\''.$product_detail['id'].'\')"  title="Delete">
											<button type="button" class="btn btn-sm btn-icon btn-pure btn-default waves-effect waves-classic">
											<i class="icon md-close" aria-hidden="true"></i></button></a></td>
					<input type="hidden" name="product_id[]" value="'.$product_detail['id'].'">
					</tr>';
				
			}			
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_product_html' => $copyright_product_html,"price"=>$price,"product_tax"=>$product_tax,"product_id"=>$product_detail['id']));
        echo $jsonEncode;
	 }
	 
	public function get_business_supplier_locations($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$id."' ","location_name","ASC");
			if($locations){
				$copyright_location_html = '<select class="form-control" name="location_id" id="location_id" onChange="fill_location_data(this.value);" >';
				$copyright_location_html .= '<option value="">Select Location</option>';
				foreach($locations as $loc){
					$copyright_location_html .='<option value="'.$loc['id'].'">'.$loc['location_name'].'</option>';
				}
				$copyright_location_html .='</select>';
			} else {
                $copyright_location_html = '<select class="form-control" name="location_id" id="location_id">';
				$copyright_location_html .= '<option value="">Select Location</option>';
				$copyright_location_html .='</select>';
            }
			
			//get suppliers
			$copyright_supplier_html='';
			$suppliers = $this->others->get_all_table_value("product_supplier","id,first_name,last_name","business_id='".$id."'","first_name","ASC");
			if($suppliers){
				$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id" onChange="get_supplier_data(this.value);">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				foreach($suppliers as $supplier){
					$copyright_supplier_html .='<option value="'.$supplier['id'].'">'.$supplier['first_name'].' '.$supplier['last_name'].'</option>';
				}
				$copyright_supplier_html .='</select>';
			} else {
				$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
				$copyright_supplier_html .= '<option value="">Select Supplier</option>';
				$copyright_supplier_html .='</select>';
			}
						
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_location_html' => $copyright_location_html,'copyright_supplier_html' => $copyright_supplier_html));
        echo $jsonEncode;
	 }
	 
	 /*
	 *	strat resorces here
	 */ 
	public function delete_resource($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("resources","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("resources","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end resorces here
	 */ 


	 /*
	 *	strat template here
	 */ 
	public function delete_template($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("templates","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("templates","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end resorces here
	 */ 


 	 

	 /*
	 *	strat voucher here
	 */ 
	public function delete_voucher($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("vouchers","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("vouchers","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	// get all location onchange of business select
 	public function getAllLocation($id) {
	 	
	 	if($id){
	        $record = $this->others->get_all_table_value("location","id,business_id,location_name","business_id='".$id."' ");
			if(count((array)$record) > 0){
				echo json_encode($record);
			} else {
	           return false;
	        }
	    }else {
           return false;
        }		
        
 	}



 	// get all location onchange of business select
 	public function getSelectedLocation($id) {
	 	
	 	if($id){
	        $record = $this->others->get_all_table_value("resources","*","id='".$id."' ");
			if(count((array)$record) > 0){
				
				$b_id = $record[0]['business_id'];
				$l_id = $record[0]['location_id'];

				$loc_details = $this->others->get_all_table_value("location","*","business_id='".$b_id."' ");
				if(count((array)$loc_details) > 0){
					$data['location'] = $loc_details;
					$data['location_id'] = $l_id;
					echo json_encode($data);
				}

			} else {
	           return false;
	        }
	    }else {
           return false;
        }		
        
 	}

 	 /*
	 *	end resorces here
	 */ 

	 /*
	 *	strat service here
	 */ 
	public function delete_service($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("services","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("services","id='".$id."'");
				// delete service_timing
				$this->others->delete_record("service_timing","service_id=".$id);
				// delete service_timing

				// delete staff_services
				$this->others->delete_record("staff_services","service_id='".$id."'");
				// delete staff_services
				
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}


 	public function delete_service_category($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("service_category","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("service_category","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}


 	// get all location onchange of business select
 	public function getAllServiceCategoryNameById($id) {

	 	if(!empty($id)){
	 		$cat_type = 1;
	 		$where['cat_type'] = $cat_type;
	 		$where['business_id'] = $id ;

			//$all_service_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
			$record = $this->others->get_all_table_value("service_category","id,name",$where,"name","ASC");
			
			if(count((array)$record) > 0){
				echo json_encode($record);
			} else {
	        	return false;
	       	}
	   	}else {
          return false;
     	}
   
 	}


 	// get all location onchange of business select
 	public function getSelectedServiceCategory($id) {
	 	
	 	if($id){
	        $record = $this->others->get_all_table_value("services","*","id='".$id."' ");
			if(count((array)$record) > 0){
				
				$b_id = $record[0]['business_id'];
				$l_id = $record[0]['service_category_id'];

				$cat_type = 1;
	 			$where['cat_type'] = $cat_type;
	 			$where['business_id'] = $record[0]['business_id'] ;

				//$loc_details = $this->others->get_all_table_value("service_category","*","business_id='".$b_id."' ");

				$loc_details = $this->others->get_all_table_value("service_category","*",$where);

				if(count((array)$loc_details) > 0){
					$data['name'] = $loc_details;
					$data['id'] = $l_id;
					echo json_encode($data);
				}

			} else {
	           return false;
	        }
	    }else {
           return false;
        }		
        
 	}

 	 /*
	 *	end service here
	 */ 
	 
	 /*
	 *	strat package here
	 */ 
	public function getSingleServicetiming($id) {
	 	
			
		// echo $id;
		//$this->db->join('services', 'service_timing.service_id = services.id','left');
		//$record = $this->others->get_all_table_value("service_timing","*","id='".$id."' ");
		
		$this->db->where('service_timing.id',$id);
		$this->db->select('service_timing.id,service_timing.service_id,service_timing.caption,service_timing.special_price,services.service_name as sn ,services.sku');
		$this->db->from('service_timing');
		$this->db->join('services','services.id=service_timing.service_id','Left');
		$record=$this->db->get();
		
		if(count((array)$record) > 0){
			$result = $record->result_array();
			echo json_encode($result);
		}else{
			echo json_encode('failed');
		}
		
		
 	}
	
	
	public function delete_package($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("packages","id","id='".$id."' ");
			
			if($record){
				$this->others->delete_record("packages","id='".$id."'");
				$this->others->delete_record("package_services","package_id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}


 	public function delete_service_group($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("packages","id","id='".$id."' ");
			
			if($record){
				$this->others->delete_record("packages","id='".$id."'");
				$this->others->delete_record("package_services","package_id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end package here
	 */ 

 	 /*
	 *	strat class here
	 */ 
	public function delete_class($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("services","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("services","id='".$id."'");

				// delete service_timing
				$this->others->delete_record("service_timing","service_id=".$id);
				// delete service_timing

				///$this->others->delete_record("staff_services","service_id='".$id."'");

				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}


 	public function delete_class_category($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("service_category","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("service_category","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end class here
	 */ 
 	 

 	 public function delete_invoices($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("invoices","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("invoices","id='".$id."'");
					
				}elseif($operation=="active"){
					$this->others->update_common_value("invoices",array("invoice_status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("invoices",array("invoice_status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }
	 

	
 	public function getAllStaff($id) {
	 	
	 	if($id){
	        $record = $this->others->get_all_table_value("staff","id,business_id,first_name,last_name","business_id='".$id."' ");
			if(count((array)$record) > 0){
				echo json_encode($record);
			} else {
	           return false;
	        }
	    }else {
           return false;
        }		
        
 	}


 	public function delete_discount($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("discounts","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("discounts","id='".$id."'");
					
				}elseif($operation=="active"){
					$this->others->update_common_value("discounts",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("discounts",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }


	 public function delete_membership($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("membership","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					$delete = $this->others->delete_record("membership","id='".$id."'");
					
				}elseif($operation=="active"){
					$this->others->update_common_value("membership",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("membership",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }


	 /*
	 *	strat notification here
	 */ 
	public function delete_notifications($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("general_comments","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("general_comments","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end notification here
	 */ 

 	 /*
	 *	Delete POs Category here
	 */ 
	 public function delete_pos_category($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');

		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("pos_expcategory","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("pos_expcategory","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end Delete POs Category
	 */ 

	 /*
	 *	Delete vendor here
	 */ 
	 public function delete_vendor($id) {
		
	 	$admin_session = $this->session->userdata('admin_logged_in');
	 	
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("vendors","id","id='".$id."' ");
			if($record){
				$this->others->delete_record("vendors","id='".$id."'");
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
 	}

 	 /*
	 *	end Delete POs Category
	 */ 
	 

	 function checkLocIdExistInPOS($loc_id=null){

	 	if(is_numeric($loc_id) AND !empty($loc_id)){

		 	$admin_session = $this->session->userdata('admin_logged_in');

			$record = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'location_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->row_array();
			//gs($record);
			if($record){
					$status = $record;
				} else {
	                $status = 'failed';
	            }
	            
	        $jsonEncode = json_encode(array('status' => $status));    
	        echo $jsonEncode;
	    }else{
	    	return false;
	    }

	}

	public function get_business_locationss($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$id."' ","location_name","ASC");
			if($locations){
				$copyright_like_html = '<select class="form-control" name="location_id" id="location_id" onChange="check_pos_daily(this.value)">';
				$copyright_like_html .= '<option value="">Select Location</option>';
				foreach($locations as $loc){
					$copyright_like_html .='<option value="'.$loc['id'].'">'.$loc['location_name'].'</option>';
				}
				$copyright_like_html .='</select>';
			} else {
                $copyright_like_html = '<select class="form-control" name="location_id" id="location_id">';
				$copyright_like_html .= '<option value="">Select Location</option>';
				$copyright_like_html .='</select>';
            }
			
			//get suppliers
			$copyright_supplier_html='';
			$get_suppliers = $this->input->post('get_suppliers');
			if(isset($get_suppliers) && $get_suppliers==1){
				$suppliers = $this->others->get_all_table_value("product_supplier","id,first_name,last_name","business_id='".$id."'","first_name","ASC");
				if($suppliers){
					$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id" onChange="get_supplier_detail(this.value);">';
					$copyright_supplier_html .= '<option value="">Select Supplier</option>';
					foreach($suppliers as $supplier){
						$copyright_supplier_html .='<option value="'.$supplier['id'].'">'.$supplier['first_name'].' '.$supplier['last_name'].'</option>';
					}
					$copyright_supplier_html .='</select>';
				} else {
					$copyright_supplier_html = '<select class="form-control" name="supplier_id" id="supplier_id">';
					$copyright_supplier_html .= '<option value="">Select Supplier</option>';
					$copyright_supplier_html .='</select>';
				}
			}			
			
			//get products
			$status_product=false;
			$copyright_product_html='';
			$get_products = $this->input->post('get_products');
			if(isset($get_products) && $get_products==1){
				$products = $this->others->get_all_table_value("product","id,product_name","business_id='".$id."'","product_name","ASC");
				if($products){
					$copyright_product_html = '<select class="form-control" name="product_id[]" id="product_id" style="width:350px;display:inline;">';
					$copyright_product_html .= '<option value="">Select Product</option>';
					foreach($products as $product){
						$copyright_product_html .='<option value="'.$product['id'].'">'.$product['product_name'].'</option>';
					}
					$copyright_product_html .='</select>';
					$status_product = true;
				} else {
					$copyright_product_html = '<select class="form-control" name="product_id[]" id="product_id" style="width:350px;display:inline;">';
					$copyright_product_html .= '<option value="">Select Product</option>';
					$copyright_product_html .='</select>';
				}
			}
			
			$status = 'success';
        }
        $jsonEncode = json_encode(array('status' => $status,'copyright_like_html' => $copyright_like_html,'copyright_supplier_html' => $copyright_supplier_html,'copyright_product_html' => $copyright_product_html,'status_product'=>$status_product));
        echo $jsonEncode;
	 }


	 public function getAllStaffByLocation() {	 	
	 	//print_r($_POST); //exit;
	 	$id=$this->input->post('location_id');
	 	$selected_staffid=$this->input->post('selected_staffid');
	 	$staff_id=$this->input->post('staff_id');
	 	
//echo $id; exit;
	 	if($id){
	 		//echo $selected_staffid; exit;
	        //$record = $this->others->get_all_table_value("staff","id,business_id,first_name,last_name","location_id='".$id."' ");
	        $workselected='';
	        if ($selected_staffid==-1) {
						if ($staff_id!='' && $staff_id==0 ) {
							//echo  "hi"; 
						$workselected="selected";
					}

				}
				$allselected='';
				 if ($selected_staffid==-1) {
						if ($staff_id=='') {
						$allselected="selected";
					}

				}
	        $record = $this->db->select('id,business_id,first_name,last_name')->from('staff')->where(['location_id'=>$id,'calendor_bookable_staff'=>1])->get()->result_array();
			if(count((array)$record) > 0){
				$staff_html = '<select class="form-control staff" onchange="selectStaff(this.value)" name="staff_name" id="content_staff_id">';

				$staff_html .= '<option '.$workselected.' value="0">Working Staff</option>';
				$staff_html .= '<option '.$allselected.' value="">All Staff</option>';
				//print_r($record); exit;
				foreach($record as $cat){

					if ($selected_staffid == $cat['id']) {
						$selected="selected";
					}
					else{
						$selected="";
					}

					if ($selected_staffid==-1) {
						if ($staff_id == $cat['id']) {
						$selected="selected";
					}
					else{
						$selected="";
					}
					}

					$staff_html .='<option '.$selected.' value="'.$cat['id'].'">'.$cat['first_name']. ' ' .$cat['last_name'].'</option>';
				}
				$staff_html .='</select>';

				//echo json_encode($record);
			} else {
	           $staff_html = '<select class="form-control" name="staff_name" id="content_staff_id">';
				$staff_html .= '<option value="">Select Location</option>';
				$staff_html .='</select>';
	        }
	       // echo $staff_html; exit;
	        $status = 'success';

	    }else {
           $status = 'not_logged_in';
        }
        $this->session->set_userdata("default_location",$id);	

        $jsonEncode = json_encode(array('status' => $status,'staff_html' => $staff_html));
                echo $jsonEncode;	
        
 	}

 	public function addNewClient(){
 		$formData = $this->input->post('formData');
 		$staff_id = $this->input->post('staff_id');
 		$business_id = getStaffBusinessId($staff_id);
 		$location_id = getLocationIdbyStaffId($staff_id);
 		$mobile_number = str_replace(" ","",$formData['mobile']);
 		$customer = $this->db->from('customer')->where(array('mobile_number'=>$mobile_number))->get()->row_array(); 
 		if($customer){
 			$customer_id = $customer['id'];
 		}else{
	 		$insert_array = [
	 			'business_id'=>$business_id,
	 			'location_id'=>$location_id,
	 			'first_name'=>$formData['first_name'],
	 			'last_name'=>$formData['last_name'],
	 			'email'=>$formData['email'],
	 			'mobile_number'=>$mobile_number,
	 			'customer_type'=>'new',
				'notification'=>'email',
				'reminders'=>'both',
				'date_created'=> date("Y-m-d H:i:s"),	
	 			'status'=>1
	 		];
	 		$insert = $this->others->insert_data("customer",$insert_array);
	 		$customer_id = $insert;
	 		$u_data = array(
				'customer_number'=>$business_id.'0'.$customer_id
			);
			$this->others->update_common_value("customer",$u_data,"id='".$customer_id."' ");
	 	}
 		$this->getClientDetails($customer_id);
 		
 	}

 	public function getClientDetails($id)
	{
		$data['personal_information'] = $this->db->select('*')->from('customer')->where(['id'=>$id])->get()->row_array();
		$data['customer_notes'] = $this->db->select('*')->from('customer_notes')->where(['customer_id'=>$id])->order_by('id', 'DESC')->get()->row_array();
		$data['invoices'] = $this->db->select('*')->from('invoices')->where(['customer_id'=>$id])->get()->result_array();
		$data['bookings'] = $this->db->select('*')->from('bookings')->where(['customer_id'=>$id])->get()->result_array();
		//total bookings      
          $data['count_all_booking'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
		  ->where('customer_id',$id)
		  ->get()->row_array();
		   //End

		  //total canceled      
			  $data['count_all_cancelled'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
			  ->where('customer_id',$id)
			  ->where('booking_status',2)
			  ->get()->row_array();
		   //End

		   //total completed      
			  $data['count_all_completed'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
			  ->where('customer_id',$id)
			  ->where('booking_status',3)
			  ->get()->row_array();
		   //End

		   //total no show      
			  $data['count_all_no_show'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
			  ->where('customer_id',$id)
			  ->where('booking_status',4)
			  ->get()->row_array();
		   //End
		echo $this->load->view('admin/calendar/client_details',$data,true);

	}

	public function fetchClients(){
		$term = $_GET['term'];
		$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $admin_session['business_id'];
		//$data = $this->db->select("id,CONCAT(first_name, ' ', last_name) as value")->from('customer')->where('business_id',$business_id)->like('first_name',$term)->or_where('last_name LIKE','%'.$term.'%')->or_where('customer_number LIKE','%'.$term.'%')->or_where('email LIKE','%'.$term.'%')->or_where('mobile_number LIKE','%'.$term.'%')->get()->result_array();
		$data = $this->db->query("SELECT id,CONCAT(first_name, ' ', last_name, ' (',mobile_number,' )') as value FROM customer WHERE (business_id=$business_id) and (first_name LIKE '%$term%' or last_name LIKE '%$term%' or email like '%$term%' or mobile_number LIKE '%$term%' or customer_number LIKE '%$term%')")->result_array();
		//echo $this->db->last_query(); die;
		echo json_encode($data);
	}
 	public function getStaff() {
 		$admin_session = $this->session->userdata('admin_logged_in');
 		$location_id = $this->input->post('location_id');
 		$staff_id = $this->input->post('staff_id');
		$date = $this->input->post('start');
 		$end = $this->input->post('end');
 		//$record = $this->others->get_all_table_value("staff","id,CONCAT(first_name, ' ', last_name) as title","business_id='".$admin_session['business_id']."' "); 		
 		if($staff_id !="" && $staff_id!=0){
 			$qry = $this->db->from('staff')->select("id, CONCAT(first_name, ' ', last_name) as title")->where(['id'=>$staff_id]);
 			$record = $qry->get()->result_array();
 		}
 		elseif ($staff_id==0 && $staff_id !="") {
 			//echo "hi"; exit;
 			$start_date = $date;
    	//$staff_id = $id;
    	$week_day = getWeekDay($date);
    	// case 1 (is_repeat=1)

    	$query = $this->db->query("SELECT staff.id, CONCAT(staff.first_name, ' ', staff.last_name) as title FROM  roster
    	JOIN staff ON staff.id =roster.staff_id 
    	 where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.is_repeat=1 and roster.is_break=0");
 		$data1 = $query->result_array();
 		// case 2 (is_repeat=0)
 		
 			$query = $this->db->query("SELECT staff.id, CONCAT(staff.first_name, ' ', staff.last_name) as title 
 				FROM  roster
 				JOIN staff ON staff.id =roster.staff_id
 				 where  roster.location_id=$location_id and roster.week_day_date='$start_date' and roster.is_repeat=0 and roster.is_break=0");
 			$data2 = $query->result_array();
 			//case 3 (is_repest=2)
 			
 				$query = $this->db->query("SELECT staff.id, CONCAT(staff.first_name, ' ', staff.last_name) as title
 					FROM  roster
 					JOIN staff ON staff.id =roster.staff_id
 					 where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.end_repeat_date>='$start_date' and roster.is_repeat=2 and roster.is_break=0");
 				$data3 = $query->result_array();

 				 $record=array_merge($data1,$data2,$data3);
 			}

 		else{
 			$qry = $this->db->from('staff')->select("id, CONCAT(first_name, ' ', last_name) as title")->where(['location_id'=>$location_id,'calendor_bookable_staff'=>1]);
 			$record = $qry->get()->result_array();

 			/*$qry = $this->db->from('staff')->select("staff.id, CONCAT(staff.first_name, ' ', staff.last_name) as title")->join('roster','staff.id=roster.staff_id','inner')
 			->where(['roster.location_id'=>$location_id,'staff.calendor_bookable_staff'=>1]);
 			$record = $qry->get()->result_array();*/

 		}		
 		
 		//gs($record);
 		if(count((array)$record)>0){
 			foreach ($record as $key => $value) {
 				if($staff_id ==0 or $staff_id ==""){
 					$record[$key]['businessHours'] = checkStaffAvailablity($value['id'],$date,$end,$location_id);
 				}else{
 					//echo $value['id']; exit;
 					//echo $value['id'].'  '.$date.'  '.$end.'  '.$location_id; exit;
	 				$i_work = checkStaffAvailablity($value['id'],$date,$end,$location_id);
	 				if(count((array)$i_work[0]['dow'])>0){
	 					$record[$key]['businessHours'] = $i_work;
	 				}else{
	 					unset($record[$key]);
	 				}
 				}
 			}
 			//print_r($record);
 			if($record){
	 			foreach ($record as $key => $value) {
	 				$nrecord[] = $value;
	 			}
	 			$record = $nrecord;
	 		}
 		}


 		
 		if(count((array)$record) > 0){

 			$jsonEncode = json_encode($record);
                echo $jsonEncode;
 		}
 	}

 	public function get_all_event() {

 		$admin_session = $this->session->userdata('admin_logged_in');

 		$booking = array();


 		$record = $this->db->from('bookings')->where(['business_id'=>$admin_session['business_id']])->where('start_date >=', $_POST['start'])->where('start_date <=', $_POST['end'])->get()->result_array();


 		 if(count((array)$record) > 0){
 			foreach($record as $key=>$val){
 				$booking = $this->db->from('booking_services')->where(['booking_id'=>$val['booking_number']])->select("service_id as title, book_start_time as start")->get()->row_array();
 				
 				$jsonEncode = json_encode($booking);
 				echo ($jsonEncode);
 				
 			}
 		}
 	}

 	public function getLocationTimezone($location_id){
 		$timezone_id = $this->db->select('timezone_id')->from('location')->where('id',$location_id)->get()->row_array();
 		if($timezone_id['timezone_id'] !=""){
 			$timezone = $this->db->select('*')->from('time_zones')->where('id',$timezone_id['timezone_id'])->get()->row_array();
 			$data = array("type"=>"success","timezone"=>$timezone['name']);
 		}else{
 			$data = array("type"=>"success","timezone"=>"Australia/Melbourne");
 		}
 		echo json_encode($data);
 	}

 	public function getduration($id){
 		$data = $this->db->from('service_timing')->where('id',$id)->get()->row_array();
 		$options = getduration($data['duration']);
 		$service = $this->db->from('services')->where('id',$data['service_id'])->get()->row_array();
 		$data['duration'] = $options;
 		$data['extra_time_after'] = $service['extra_time_after'];
 		$data['extra_time_mins'] = convertToMins($service['extra_time_after']);
 		echo json_encode($data);
 	}
 	public function getgroupservices(){
 		//print_r($_POST); exit;
		
			$start_time = $this->input->post('start_time');
			$staff_id = $this->input->post('staff_id');
			$start_time_array = $this->input->post('start_time_array');
			$duration_array = $this->input->post('duration_array');
			$extra_time_array = $this->input->post('extra_time_arr');
			$duration_arr = array();
			$extra_time_arr = array();
			$start_date = $this->input->post('select_start_date');
			
			//print_r($duration_array); exit;
			//echo "<pre>"; print_r($start_time_array); die;
			if($duration_array){
				foreach ($duration_array as $key => $value) {
					
						$duration_arr[] = date('H:i:00', mktime(0,$value));
					
					
				}
			}

			
			if($extra_time_array){
				foreach ($extra_time_array as $key => $value) {
					$extra_time_arr[] = date('H:i:00', mktime(0,$value));
				}
			}
			// Get Time for next appointment
			//print_r($duration_arr); exit;
			if($start_time_array){
				foreach ($start_time_array as $key => $value) {
					
						$next_time = sum_the_time3($value,$duration_arr[$key],$extra_time_arr[$key]);
					
					
				}
			}else{
				$next_time = $start_time;
			}	
			$data['next_time'] = $next_time;
			//$data['staff_id'] = $this->input->post('staff_id');
			//$data['get_hours_range'] = get_hours_range();
			$admin_session = $this->session->userdata('admin_logged_in');
		
		
 		$service_id = $this->input->post('service_id');
 		$location_id =  $this->input->post('location_id');
 		$select_id =  $this->input->post('id');
       // gs($service_id);
 		
 		  $packages = $this->db->from('packages')->where('id',$service_id)->get()->row_array();
 		 // gs($packages);
        $services = $this->db->from('package_services')->where('package_id',$service_id)->order_by('id', 'ASC')->get()->result_array();
        $data = array();
        $duration = array();

        $i = 0;


         $group_service_id=$service_id;
         $amount = (isset($packages['discounted_price'])?$packages['discounted_price']:0);
        // gs($amount);
        foreach($services as $key=>$val)
        {
            $data[$i]['service'] = $this->db->from('services')->where('id',$val['service_id'])->get()->row_array();
            $data[$i]['timing'] = $this->db->from('service_timing')->where('id',$val['service_timing_id'])->get()->row_array();
           // $data[$i]['duration'] = getduration($data[$i]['timing']['duration']);
            $i++;
        }
      //  print_r($data[0]['timing']['duration']); exit;

         //echo json_encode($duration);
        $options = $this->db->from('services')->get()->result_array();
        $admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){

        	//$location_id = $booking['location_id'];
			//$start_date = $booking['start_date'];
			//$end = $booking['start_date'];
 			$week_day = getWeekDay($start_date);
 			$query = $this->db->query("SELECT staff.*
					FROM  roster
    	JOIN staff ON staff.id =roster.staff_id 
    	 where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.is_repeat=1 and roster.is_break=0");
 		$data1 = $query->result_array();
 		// case 2 (is_repeat=0) 		
 			$query = $this->db->query("SELECT staff.*
 				FROM  roster
 				JOIN staff ON staff.id =roster.staff_id
 				 where  roster.location_id=$location_id and roster.week_day_date='$start_date' and roster.is_repeat=0 and roster.is_break=0");
 			$data2 = $query->result_array();
 			//case 3 (is_repest=2)
 			
 				$query = $this->db->query("SELECT staff.*
 					FROM  roster
 					JOIN staff ON staff.id =roster.staff_id
 					 where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.end_repeat_date>='$start_date' and roster.is_repeat=2 and roster.is_break=0");
 				$data3 = $query->result_array();

 				 $staffs=array_merge($data1,$data2,$data3);

				/*$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/

				}elseif($admin_session['role']=='location_owner'){
				$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'id'=>$staff_id])->get()->result_array();
			}

			elseif ($admin_session['role']=='staff') {
					$staffs = $this->db->select('*')->from('staff')->where('id',$admin_session['staff_id'])->get()->result_array();
				}
			$staffs = $staffs;

  

        $this->load->view('admin/operations/getgroupservices', array('options' => $options , 'data' => $data , 'staff' => $staffs, 'select_id' =>$select_id, 'group_service_id' =>$group_service_id,'amount'=>$amount, 'next_time'=>$next_time, 'staff_id'=>$staff_id  ));
       // echo json_encode($data);
 	}
 	public function checkStaffAvailablity(){
 		//print_r($_POST); exit;
 		$input = $this->input->post(); 		
 		$start_time = $input['start_time'];
 		$service_id = $input['service_id'];
 		$staff_id = $input['staff_id'];
 		$duration = $input['duration'];
 		$location_id = $input['location_id'];
 		$staff_name = getStaffName($staff_id);
 		$start_date = date("Y-m-d",strtotime($input['start_date']));
 		$week_day = getWeekDay($start_date);
 		$service_timing =  $this->db->from('service_timing')->where('id',$service_id)->where("status",1)->get()->row_array();
 		if($duration==null){ 
 			$duration = $service_timing['duration'];
 		}else{
 			$duration = date('H:i:00', mktime(0,$duration));
 		}
 		//echo $start_time."<br>";
 		//echo $duration."<br>";
 		//$secs = strtotime($duration)-strtotime("00:00:00");
		//$end_hours = date("H:i:s",strtotime($start_time)+$secs);
		$end_hours = sum_the_time($start_time,$duration);
		//echo $end_hours;die;
 		//case 1s (is_repeat=1)
 		$query = $this->db->query("SELECT * FROM  roster where (staff_id=$staff_id and week_day=$week_day and week_day_date<='$start_date' and is_repeat=1 and location_id=$location_id and is_break=0 and start_hours<='$start_time' and end_hours>='$end_hours')");
 		$data = $query->result_array();
 		// case 2 (is_repeat=0)
 		if(count((array)$data)==0){
 			$query = $this->db->query("SELECT * FROM  roster where (staff_id=$staff_id and week_day_date='$start_date' and is_repeat=0 and is_break=0 and location_id=$location_id and start_hours<='$start_time' and end_hours>='$end_hours')");
 			$data = $query->result_array();
 			//case 3 (is_repest=2)
 			if(count((array)$data)==0){
 				$query = $this->db->query("SELECT * FROM  roster where (staff_id=$staff_id and week_day=$week_day and week_day_date<='$start_date' and end_repeat_date>='$start_date' and is_repeat=2 and is_break=0 and start_hours<='$start_time' and location_id=$location_id and end_hours>='$end_hours')");
 				$data = $query->result_array();
 			}
 		}
 		$data2 = array();
 		$data3 = array();
 		if(count((array)$data)>0){
 			//echo "SELECT * FROM booking_services WHERE date='$start_date' and staff_id=$staff_id and book_start_time<='$end_hours' and book_end_time >= '$start_time'";die;
 			$query = $this->db->query("SELECT * FROM booking_services WHERE date='$start_date' and staff_id=$staff_id and book_start_time<='$end_hours' and book_end_time >= '$start_time'");
 			$data2 = $query->result_array();
 		}

 		if((count((array)$data)>0) or count((array)$data2)>0){
 			//echo "SELECT * FROM booking_services WHERE date='$start_date' and staff_id=$staff_id and book_start_time<='$end_hours' and book_end_time >= '$start_time'";die;
 			$query = $this->db->query("SELECT * FROM blocked_time WHERE date='$start_date' and staff_id=$staff_id and start_time<='$end_hours' and end_time >= '$start_time'");
 			$data3 = $query->result_array();
 		}



 		//Hassan Kazmi isn’t working between 9:15am and 10:45am, but you can still book them.
 		//Hassan Kazmi has another booking at 10:45am, but you can still double-book them.
 		if(count((array)$data)==0){
 			$start = date("h:ia",strtotime($start_time));
 			$end = 	date("h:ia",strtotime($end_hours));
 			$message = "$staff_name isn’t working between $start and $end, but you can still book them.";
 			echo json_encode(["type"=>"failed","message"=>$message]);
 		}elseif(count((array)$data2)>0){
 			$start = date("h:ia",strtotime($start_time));
 			$end = 	date("h:ia",strtotime($end_hours));
 			$message = "$staff_name has another booking at $start but you can still double-book them.";
 			echo json_encode(["type"=>"failed","message"=>$message]);
 		}elseif(count((array)$data3)>0){
 			$start = date("h:ia",strtotime($start_time));
 			$end = 	date("h:ia",strtotime($end_hours));
 			$message = "$staff_name has a blocked time at $start but you can still book them.";
 			echo json_encode(["type"=>"failed","message"=>$message]);
 		}else{
 			$message = "Staff Available";
 			echo json_encode(["type"=>"success","message"=>$message]);
 		}
 	}

 	public function product_close($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');           
			if ($id!='') {
				$update_data = array(
					"flag_bit"=>0,
			"close_date"=>date("Y-m-d H:i:s"),			
					
				);
				/*$this->db->set($update_data);
				$this->db->where('id',$id);
				$this->db->update('product_used');*/
				
				$this->others->update_common_value("product_used",$update_data,"id='".$id."' ");
				
		$status = 'success';
			}
			else{
				 $status = 'invalid_data';
				}
       
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }

public function business_active_mail($id) {
	  $welcome_email = $this->db->select('*')->from('templates')->where('slug','business-active')->get()->row_array();
	   $businessDetails = $this->db->select('*')->from('business')->where('id',$id)->get()->row_array();
	   			$business_name=$businessDetails['name'];
	   			$business_email=$businessDetails['email'];
	   			
	   			 $click_here = "<a href='".base_url('admin/')."'>click here</a>";
				      $mail_data = str_replace(["{BUSINESS_NAME}","{click_here}"],[$business_name,$click_here], $welcome_email['email_html']);
				    $data['subject'] =$welcome_email['subject'];
				    $data['mail_data'] = $mail_data;
				   	$subject = $welcome_email['subject'];
				    $mail = $this->config->item('mail_data');
					  $mail_content = $this->load->view('booking-confirmation',$data,true);
				    $this->load->library('email', $mail);
				    $this->email->set_newline("\r\n");
				     $this->email->from($this->config->item('default_mail'),$business_name);
				    $list = array($business_email);
				    $this->email->to($list);
				    $this->email->subject($subject);
				    $this->email->message($mail_content);
				    $this->email->send();
				}

				 public function operation_warehouse($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("warehouse","id","id='".$id."' ");
			if($record){
				if($operation=="delete"){
					//$delete = $this->others->delete_record("warehouse","id='".$id."'");
					$this->others->update_common_value("warehouse",array("status"=>2),"id='".$id."' ");
				}elseif($operation=="active"){
					$this->others->update_common_value("warehouse",array("status"=>1),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("warehouse",array("status"=>'0'),"id='".$id."' ");
				}
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }



	 public function getSingleProductUnit($id) {
		
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('product');
		$record=$this->db->get();
		
		if(count((array)$record) > 0){
			$result = $record->result_array();
			echo json_encode($result);
		}else{
			echo json_encode('failed');
		}
		
		
 	}

 	public function active_staff($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("staff","id","id='".$id."' ");
			if($record){				
				if($operation=="delete"){
					$delete = $this->others->delete_record("staff","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("staff",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("staff",array("status"=>'0'),"id='".$id."' ");
				}				
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }


	 public function inactive_staff($id) {
	 	$admin_session = $this->session->userdata('admin_logged_in');
		$operation = $this->input->post('operation');
		if ($admin_session['admin_email'] == '') {
            $status = 'not_logged_in';
        } else {
            $record = $this->others->get_all_table_value("staff","id","id='".$id."' ");
			if($record){				
				if($operation=="delete"){
					$delete = $this->others->delete_record("staff","id='".$id."'");
				}elseif($operation=="active"){
					$this->others->update_common_value("staff",array("status"=>'1'),"id='".$id."' ");
				}elseif($operation=="inactive"){
					$this->others->update_common_value("staff",array("status"=>'0'),"id='".$id."' ");
				}				
				$status = 'success';
			} else {
                $status = 'invalid_data';
            }
        }
        $jsonEncode = json_encode(array('status' => $status));
        echo $jsonEncode;
	 }




}