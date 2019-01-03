<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('product_model', '', TRUE);
        $this->__clear_cache();
		$admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['admin_email'] =='') {
			redirect(base_url('admin'));
	    }
    }

    private function __clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    } 

    public function getBrandsByCategory($id,$s_id=null){	
    	$brands = $this->db->select('*')->from('product_brand')->where('category_id',$id)->get()->result_array();
    	$data = "";
    	if($brands){
    		foreach ($brands as $key => $value) {
    			$selected = ($value['id']==$s_id)?"selected":"";
    			$data .= "<option ".$selected." value='".$value['id']."'>".$value['brand_name']."</option>";
    		}
    	}
    	echo $data;
    }
	public function check_bar_code() {
		$bar_code = $this->input->post('bar_code');// get bar_code
		$business_id = $this->input->post('business_id');// get business_id
		$this->db->select('bar_code');
		$this->db->from('product');
		$this->db->where('bar_code', $bar_code);
		$this->db->where('business_id', $business_id);
		$query = $this->db->get();
		$num = $query->num_rows();
		//echo "in".$num; die;
		if ($num > 0) {
			$this->form_validation->set_message('check_bar_code','This BarCode is already used!');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	 
	public function index()
	{

		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['p.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['p.business_id']= $admin_session['business_id'];
		}
		$this->load->library('pagination');				
		$arr_get = array();
        if ($this->input->get()) {
            foreach($this->input->get() as $key => $val) {
                if($key != 'offset' && $val != '') {
                    $arr_get[] = $key.'='.$val;
                }
            }
        }
        
		if ($this->input->post('record')) {
			$condition = "";
			if($admin_session['role']=="business_owner"){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("product","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Products are deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No products are selected to delete!");
			}	
			redirect(base_url('admin/product'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/product') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		/*if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;*/

		if($this->input->post('product_search')){
			//print_r($_POST); exit;

			$product_search = $this->input->post('product_search');


			$product_search = rtrim($product_search,"1");
			//echo $product_search; exit;
		
		}else{
			$product_search='';
		}	

			$config = array();

			$count = $this->product_model->getproductrecordCount($product_search,$admin_session['business_id']);
			//echo $count; exit;
	    $data['count'] = $count;



	    $config["base_url"] = base_url() . "admin/product/index";
	    $config['total_rows'] =  $count;
		$config['per_page'] = '10';
		$config['uri_segment'] =4;
		$config['full_tag_open'] = '<ul class="pagination" style="float:right;">';
	    $config['full_tag_close'] = '</ul>'; 
	    $config['prev_link'] = '&lt; Prev';
	    $config['prev_tag_open'] = '<li class="page-item">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = 'Next &gt;';
	    $config['next_tag_open'] = '<li class="page-item">';
	    $config['next_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active page-item"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li class="page-item">';
	    $config['num_tag_close'] = '</li>';
	    $config['first_link'] = FALSE;
	    $config['last_link'] = FALSE;
		$config['num_links']=3;
		$this->pagination->initialize($config);
     
       
 
       $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

       if($product_search){
       	 $page =0;
       	// $config["per_page"]='';
       }

       $count_all_records = $this->product_model->get_products(true,$arr_search,$product_search,$config["per_page"], $page,"date_created","DESC");
       //print_r($count_all_records); exit;
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;


		$all_records = $this->product_model->get_products(false,$arr_search,$product_search,$config["per_page"], $page,"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;

			
		}
		//$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		//print_r($data["links"]); exit;
		
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;
		//echo "<pre>"; print_r($data); exit;
		$this->load->view('admin/product/all_products', $data);
	}
	
	public function add_product()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($this->input->post('action')){
			$business_id = $this->input->post('business_id');
			
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			$data['product_name'] = $this->input->post('product_name');
			$data['category_id'] = $this->input->post('category_id');
			$data['brand_id'] = $this->input->post('brand_id');
			$data['brand_category_id'] = $this->input->post('brand_category_id');
			$data['color_code'] = $this->input->post('color_code');
			$data['supplier_id'] = $this->input->post('supplier_id');
			//$data['quantity'] = $this->input->post('quantity');
			$data['bar_code'] = $this->input->post('bar_code');
			$data['sku'] = $this->input->post('sku');
			$data['alert_quantity'] = $this->input->post('alert_quantity');
			$data['retail_price'] = $this->input->post('retail_price');
			//$data['special_price'] = $this->input->post('special_price');
			$data['description'] = $this->input->post('description');
			//$data['enable_commission'] = $this->input->post('enable_commission');
			$data['purchase_price'] = $this->input->post('purchase_price');
			$data['product_tax'] = $this->input->post('product_tax');
			$data['product_tax_type'] = $this->input->post('product_tax_type');
			$data['uses_type'] = $this->input->post('uses_type');
			$data['scale'] = $this->input->post('scale');
			$data['weight'] = $this->input->post('weight');
			$data['box_product_id'] = $this->input->post('box_product_id');
			$data['box_product_unit'] = $this->input->post('box_product_unit');			
			if(!empty($business_id)){
				/*$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
				if($locations)
					$data['locations'] = $locations;*/
				$categories = $this->others->get_all_table_value("product_category","id,category_name","business_id='".$business_id."' ","category_name","ASC");
				if($categories)
					$data['categories'] = $categories;	
				$brands = $this->others->get_all_table_value("product_brand","id,brand_name","business_id='".$business_id."' ","brand_name","ASC");
				if($brands)
					$data['brands'] = $brands;	
				$suppliers = $this->others->get_all_table_value("product_supplier","*","business_id='".$business_id."' ","first_name","ASC");
				if($suppliers)
					$data['suppliers'] = $suppliers;	
			}
			$this->load->library('form_validation');
			if($admin_session['role']=="owner"){
				$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			if($admin_session['role']=="business_owner"){
				$_POST['business_id'] = $admin_session['business_id'];
				//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('bar_code', 'bar_code', 'trim|required|xss_clean|callback_check_bar_code');
			
			
			$this->form_validation->set_rules('product_name', 'Product name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('category_id', 'Category name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('supplier_id', 'Supplier name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('alert_quantity', 'Alert quantity', 'trim|required|xss_clean');
			$this->form_validation->set_rules('purchase_price', 'Purchase price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('retail_price', 'Retail price', 'trim|required|xss_clean');
			
			
			if ($this->form_validation->run() == TRUE) {															
				
				$enable_commission = $this->input->post('enable_commission');
				$enable_commission = ($enable_commission==1)?$enable_commission:'0' ;  
				
				if($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
					$b_id = $admin_session['business_id'];
				}
				
				
				$picture = "";
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
					if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
						$this->load->library('image_lib');
						$uploadDir = $this->config->item('physical_url') . 'images/product/';
						$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
						$imgname = rand() . rand() . "_" . time() . '.' . $ext;
						move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imgname);										
						$config['image_library'] = 'gd2';
						$config['source_image'] = $uploadDir . $imgname;
						$config['new_image'] = $uploadDir .'thumb/'. $imgname;
						$this->image_lib->initialize($config);
					
						if ($this->image_lib->resize()) {
							$this->image_lib->clear();
					
							$config['new_image'] = $uploadDir .'thumb/'. $imgname;
							$config['create_thumb'] = FALSE;
							$config['maintain_ratio'] = TRUE;
							$config['width'] = 100;
							$config['height'] = 100; 
							$config['master_dim'] = 'width';
					
							$this->image_lib->initialize($config);
							$this->image_lib->resize();
							$this->image_lib->clear();
					
							list($original_width, $original_height) = getimagesize($uploadDir . $imgname);
							if ($original_width > 0 && $original_height > 0) {
								$picture = $imgname;
							}
						}
						if(file_exists($uploadDir.$imgname)){
							unlink($uploadDir.$imgname);						
						}
					}
				}
				
				$location_id = $this->input->post('location_id');
				$quantity = $this->input->post('quantity');
				
				$total_qty = 0;
				for($i=0;$i< count((array)$location_id);$i++){
					if($quantity[$i]!=""){
						$total_qty = $total_qty + $quantity[$i]; 
					}
				}
				
				$insert_data = array('business_id'=>$b_id,
					'product_name'=>$this->input->post('product_name'),
					'category_id'=>$this->input->post('category_id'),
					'brand_id'=>$this->input->post('brand_id'),
					'brand_category_id'=>$this->input->post('brand_category_id'),
					'bar_code'=>$this->input->post('bar_code'),
					'supplier_id'=>$this->input->post('supplier_id'),
					'color_code'=>$this->input->post('color_code'),
					'sku'=>$this->input->post('sku'),
					//'quantity'=>$total_qty,
					'alert_quantity'=>$this->input->post('alert_quantity'),
					'purchase_price'=>$this->input->post('purchase_price'),
					'retail_price'=>$this->input->post('retail_price'),
					//'special_price'=>$this->input->post('special_price'),
					'description'=>$this->input->post('description'),
					'photo'=>$picture,
					//'enable_commission'=>$enable_commission,
					'product_tax'=>$this->input->post('product_tax'),
					'product_tax_type'=>$this->input->post('product_tax_type'),
					'uses_type'=>$this->input->post('uses_type'),
					'box_product_unit'=>$this->input->post('box_product_unit'),
					'box_product_id'=>$this->input->post('box_product_id'),
					'weight'=>$this->input->post('weight'),
					'scale'=>$this->input->post('scale'),

					


					'date_created' => date('Y-m-d H:i:s'));
					
				$success = $this->others->insert_data("product",$insert_data);
				$product_id = $success;
				
				for($i=0;$i< count((array)$location_id);$i++){
					if($quantity[$i]!=""){
						$insert_data = array('location_id'=>$location_id[$i],
						'business_id'=>$b_id,
						'order_type'=>1,	
						'product_id'=>$product_id,
						'quantity'=>$quantity[$i],
						'supplier_id'=>$this->input->post('supplier_id'),
						'product_tax'=>$this->input->post('product_tax'),
						'product_tax_type'=>$this->input->post('product_tax_type'),
						'purchase_price'=>$this->input->post('purchase_price'),
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);
					}
				}


				//wherehouse in product add
				$warehouse_id=$this->input->post('warehouse_id');
				$warehouse_quantity=$this->input->post('warehouse_quantity');
				
				for($i=0;$i< count((array)$warehouse_id);$i++){
					if($warehouse_quantity[$i]!=""){
						$insert_data = array('warehouse_id'=>$warehouse_id[$i],
						'business_id'=>$b_id,
						'order_type'=>1,	
						'product_id'=>$product_id,
						'warehouse_quantity'=>$warehouse_quantity[$i],
						'supplier_id'=>$this->input->post('supplier_id'),
						'product_tax'=>$this->input->post('product_tax'),
						'product_tax_type'=>$this->input->post('product_tax_type'),
						'purchase_price'=>$this->input->post('purchase_price'),
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_warehousewise",$insert_data);
					}
				}


				
				if ($success) {
					$this->session->set_flashdata('success_msg', "Product is added successfully!");
					redirect(base_url('admin/product'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding product is failed!");
					redirect(base_url('admin/product/add_product'));
				}
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		
		//if($admin_session['role']=="business_owner"){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	

			
			$this->db->from('warehouse');
			if ($admin_session['business_id']!='') {
				$this->db->where('business_id',$admin_session['business_id']);
			}			
			$data['warehouse']=$this->db->where('status!=',2)->order_by('warehouse_name','ASC')->get()->result_array();

			/*$warehouse = $this->others->get_all_table_value("warehouse","id,warehouse_name","business_id='".$admin_session['business_id']."' ","warehouse_name","ASC");
			if($warehouse)
				$data['warehouse'] = $warehouse;*/

	//	}
		
		//product categories
	//	if($admin_session['role']=="business_owner"){
			$categories = $this->others->get_all_table_value("product_category","id,category_name","business_id='".$admin_session['business_id']."' ","category_name","ASC");
			if($categories)
				$data['categories'] = $categories;	
		//}		
		//product brands
		//if($admin_session['role']=="business_owner"){
			/*$brands = $this->others->get_all_table_value("product_brand","id,brand_name","business_id='".$admin_session['business_id']."' ","brand_name","ASC");*/
			$brands = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>1])->get()->result_array();
			if($brands)
				$data['brands'] = $brands;
	//	}
		//product supplier
	//	if($admin_session['role']=="business_owner"){
			$suppliers = $this->others->get_all_table_value("product_supplier","*","business_id='".$admin_session['business_id']."' ","first_name","ASC");
			if($suppliers)
				$data['suppliers'] = $suppliers;

			$data['product'] = $this->others->get_all_table_value("product","*","business_id='".$admin_session['business_id']."' ");

			$data['product_scale']=$this->db->select('*')->from('product_weight_scale_setting')->where('business_id',$admin_session['business_id'])->get()->result_array();



	//	}
		$data['product_active_open']=true;
		$this->load->view('admin/product/add_product', $data);
	}
	
	public function edit_product($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != '' && is_numeric($id)) {			
			$product_detail = $this->others->get_all_table_value("product","*","id='".$id."'");
			if($product_detail){
				if($this->input->post('action')){					
					$business_id = $this->input->post('business_id');
					$data['business_id'] = $this->input->post('business_id');
					$data['location_id'] = $this->input->post('location_id');
					$data['product_name'] = $this->input->post('product_name');
					$data['category_id'] = $this->input->post('category_id');
					$data['brand_id'] = $this->input->post('brand_id');
					$data['brand_category_id'] = $this->input->post('brand_category_id');
					$data['color_code'] = $this->input->post('color_code');
					$data['supplier_id'] = $this->input->post('supplier_id');
					//$data['bar_code'] = $this->input->post('bar_code');
					$data['sku'] = $this->input->post('sku');
					$data['alert_quantity'] = $this->input->post('alert_quantity');
					$data['retail_price'] = $this->input->post('retail_price');
					//$data['special_price'] = $this->input->post('special_price');
					$data['description'] = $this->input->post('description');
					//$data['enable_commission'] = $this->input->post('enable_commission');
					$data['purchase_price'] = $this->input->post('purchase_price');
					$data['product_tax'] = $this->input->post('product_tax');
					$data['product_tax_type'] = $this->input->post('product_tax_type');
					$data['uses_type'] = $this->input->post('uses_type');

					$data['product_box_id'] = $this->input->post('product_box_id');
					$data['box_product_unit'] = $this->input->post('box_product_unit');

					$data['scale'] = $this->input->post('scale');
					$data['weight'] = $this->input->post('weight');
					
					if(!empty($business_id)){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						if($locations)
							$data['locations'] = $locations;
					}
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					if($admin_session['role']=="business_owner"){
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('product_name', 'Product name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('category_id', 'Category name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('supplier_id', 'Supplier name', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('alert_quantity', 'Alert quantity', 'trim|required|xss_clean');
					$this->form_validation->set_rules('retail_price', 'Retail price', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {						
						
						$enable_commission = $this->input->post('enable_commission');
						$enable_commission = ($enable_commission==1)?$enable_commission:'0' ;  
						$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ; 
						
						$picture = "";
						if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
							if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
								$this->load->library('image_lib');
								$uploadDir = $this->config->item('physical_url') . 'images/product/';
								$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
								$imgname = rand() . rand() . "_" . time() . '.' . $ext;
								move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imgname);										
								$config['image_library'] = 'gd2';
								$config['source_image'] = $uploadDir . $imgname;
								$config['new_image'] = $uploadDir .'thumb/'. $imgname;
								$this->image_lib->initialize($config);
							
								if ($this->image_lib->resize()) {
									$this->image_lib->clear();
							
									$config['new_image'] = $uploadDir .'thumb/'. $imgname;
									$config['create_thumb'] = FALSE;
									$config['maintain_ratio'] = TRUE;
									$config['width'] = 100;
									$config['height'] = 100; 
									$config['master_dim'] = 'width';
							
									$this->image_lib->initialize($config);
									$this->image_lib->resize();
									$this->image_lib->clear();
							
									list($original_width, $original_height) = getimagesize($uploadDir . $imgname);
									if ($original_width > 0 && $original_height > 0) {
										$picture = $imgname;
									}
								}
								if(file_exists($uploadDir.'thumb/'.$product_detail[0]['photo'])){
									unlink($uploadDir.'thumb/'.$product_detail[0]['photo']);							
								}
								if(file_exists($uploadDir.$imgname)){
									unlink($uploadDir.$imgname);						
								}
							}
						}
						
						/*$location_id = $this->input->post('location_id');
						$quantity = $this->input->post('quantity');
						
						$total_qty = 0;
						for($i=0;$i< count((array)$location_id);$i++){
							if(empty($quantity[$i])){
								$quantity[$i] = 0;
							}
							$total_qty = $total_qty + $quantity[$i]; 
							
							$update_data = array();
							$update_data['quantity'] = $quantity[$i];
							$update_data['alert_quantity'] = $this->input->post('alert_quantity');
							$update_data['purchase_price'] = $this->input->post('purchase_price');
							$this->others->update_common_value("product_locationwise",$update_data,"location_id='".$location_id[$i]."' ");
							
						}*/
											
						$update_data['business_id'] = $b_id;
						//$update_data['location_id'] = $this->input->post('location_id');
						$update_data['product_name'] = $this->input->post('product_name');
						$update_data['category_id'] = $this->input->post('category_id');
						$update_data['brand_id'] = $this->input->post('brand_id');
						$update_data['brand_category_id'] = $this->input->post('brand_category_id');
						$update_data['color_code'] = $this->input->post('color_code');
						$update_data['supplier_id'] = $this->input->post('supplier_id');
						//$update_data['bar_code'] = $this->input->post('bar_code');
						$update_data['sku'] = $this->input->post('sku');
						//$update_data['quantity'] = $total_qty;
						$update_data['alert_quantity'] = $this->input->post('alert_quantity');
						$update_data['retail_price'] = $this->input->post('retail_price');
						//$update_data['special_price'] = $this->input->post('special_price');
						$update_data['description'] = $this->input->post('description');
						//$update_data['enable_commission'] = $enable_commission;
						$update_data['purchase_price'] = $this->input->post('purchase_price');
						$update_data['product_tax'] = $this->input->post('product_tax');
						$update_data['product_tax_type'] = $this->input->post('product_tax_type');
						$update_data['uses_type'] = $this->input->post('uses_type');
						if($picture!=""){
							$update_data['photo'] = $picture;
						}

						$update_data['box_product_id'] = $this->input->post('product_box_id');
						$update_data['box_product_unit'] = $this->input->post('box_product_unit');

						$update_data['weight'] = $this->input->post('weight');
						$update_data['scale'] = $this->input->post('scale');
						//echo "<pre>";print_r($update_data); echo "</pre>"; die;
						$success = $this->others->update_common_value("product",$update_data,"id='".$id."' "); 
						$this->session->set_flashdata('success_msg', "Product is updated successfully!");
						redirect(base_url('admin/product'));
					}
				}
				$data['product_detail'] = $product_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		
		if(!empty($product_detail[0]['business_id'])){
			$arr_search['l.business_id'] = $product_detail[0]['business_id'];
			$locations = $this->product_model->get_location_products($arr_search);
			//echo "<pre>"; print_r($locations); echo "</pre>"; die;
			if($locations)
				$data['locations'] = $locations;	
		}
		
		//product categories
		if(!empty($product_detail[0]['business_id'])){
			$categories = $this->others->get_all_table_value("product_category","id,category_name","business_id='".$product_detail[0]['business_id']."' ","category_name","ASC");
			if($categories)
				$data['categories'] = $categories;	
		}		
		//product brands
		if(!empty($product_detail[0]['business_id'])){
			//$brands = $this->others->get_all_table_value("product_brand","id,brand_name","business_id='".$product_detail[0]['business_id']."' ","brand_name","ASC");
			$brands = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>1])->get()->result_array();
			if($brands)
				$data['brands'] = $brands;	
		}
		//product supplier
		if(!empty($product_detail[0]['business_id'])){
			$suppliers = $this->others->get_all_table_value("product_supplier","*","business_id='".$product_detail[0]['business_id']."' ","first_name","ASC");
			if($suppliers)
				$data['suppliers'] = $suppliers;	
		}

		$data['product'] = $this->others->get_all_table_value("product","*");
		$data['product_scale']=$this->db->select('*')->from('product_weight_scale_setting')->where('business_id',$admin_session['business_id'])->get()->result_array();


		$data['product_active_open']=true;
		$this->load->view('admin/product/edit_product', $data);
	}

	public function view($id){
		//echo $id; exit;

		$locations = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		//print_r($admin_session); exit;

		if ($id != '' && is_numeric($id)) {	
			$query = $this->db->get_where('product', array('id' => $id));
			$product_data = $query->row();

			if($admin_session['role']=="business_owner"){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			}elseif($admin_session['role']=="owner"){
				$business_id = $product_data->business_id;
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
			}


			if($admin_session['role']=="business_owner"){
				$data['warehouse'] = $this->others->get_all_table_value("warehouse","*","business_id='".$admin_session['business_id']."' ","warehouse_name","ASC");
			}elseif($admin_session['role']=="owner"){
				$business_id = $product_data->business_id;
				$data['warehouse'] = $this->others->get_all_table_value("warehouse","*","business_id='".$business_id."' ","warehouse_name","ASC");
			}
			
			if($product_data)
			{
				//warehouse 

				$sql = "SELECT warehouse.warehouse_name,warehouse.id as warehouse_id,SUM(product_warehousewise.warehouse_quantity) as stockin_quantity FROM product_warehousewise JOIN warehouse ON warehouse.id = product_warehousewise.warehouse_id where (product_warehousewise.product_id = $id and product_warehousewise.order_type!=2) GROUP BY (warehouse_id)";
				$dd = $this->db->query($sql);
				 $warehouse_data= $dd->result_array();

				$stock_data = array();
				foreach ($warehouse_data as $key => $value) {
					$warehouse_id = $value['warehouse_id'];
					$warehouse_data[$key]['product_code'] = $product_data->bar_code;
					$sql_used = "SELECT SUM(quantity) as used_quantity from product_warehouse_used where product_id=$id and warehouse_id=$warehouse_id";
					$qty_used = $this->db->query($sql_used);
					$used_qty = $qty_used->row();
					$warehouse_data[$key]['stockout_quantity'] = $used_qty->used_quantity;
					$avl_qty = $value['stockin_quantity']-$used_qty->used_quantity;
					$warehouse_data[$key]['avl_qty'] = $avl_qty;
					$warehouse_data[$key]['total_price'] = $avl_qty*$product_data->purchase_price;
				}
				$data['warehouse_data']=$warehouse_data;



				$sql = "SELECT location.location_name,location.id as location_id,SUM(product_locationwise.quantity) as stockin_quantity FROM product_locationwise JOIN location ON location.id = product_locationwise.location_id where (product_locationwise.product_id = $id and product_locationwise.order_type!=2) GROUP BY (location_id)";
				$dd = $this->db->query($sql);
				$location_data = $dd->result_array();
				//gs($location_data);
				$stock_data = array();
				foreach ($location_data as $key => $value) {
					$location_id = $value['location_id'];
					$location_data[$key]['product_code'] = $product_data->bar_code;
					$sql_used = "SELECT SUM(quantity) as used_quantity from product_used where product_id=$id and location_id=$location_id";
					$qty_used = $this->db->query($sql_used);
					$used_qty = $qty_used->row();
					$location_data[$key]['stockout_quantity'] = $used_qty->used_quantity;
					$avl_qty = $value['stockin_quantity']-$used_qty->used_quantity;
					$location_data[$key]['avl_qty'] = $avl_qty;
					$location_data[$key]['total_price'] = $avl_qty*$product_data->purchase_price;
				}

				$this->db->select('*');
				$this->db->from('product_used');
				$this->db->where('flag_bit',1);
				$this->db->where('product_id',$id);
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
					$this->db->where('business_id',$admin_session['business_id']);
					$this->db->where('location_id',$admin_session['location_id']);			
				}
		$data['getproduct_used']=$this->db->get()->result_array();

				/*$this->db->select('location_id');
				$this->db->from('product_used');
				$this->db->where('flag_bit',1);
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=="location_owner") {
			$this->db->where('business_id',$admin_session['business_id']);
			$this->db->where('location_id',$admin_session['location_id']);
		}
		$this->db->group_by('location_id');
		$data['getCityproduct_used']=$this->db->get()->result_array();
		$total_city=[];
		foreach ($data['getCityproduct_used'] as $key => $value) {
			$total_city[] =$value['location_id'];
			
		}*/
		//$total_city = implode(",", $total_city);

		/*$this->db->select('IFNULL(COUNT("id"), 0) AS total_Salon');
				$this->db->from('product_used');
				$this->db->where('flag_bit',1);
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=="location_owner") {
			$this->db->where('business_id',$admin_session['business_id']);
			$this->db->where('location_id',$admin_session['location_id']);
		}
		$this->db->group_by('location_id,used_type');
		$this->db->where_in('location_id',$total_city);
		$this->db->where('used_type',1);
		$data['gettotal_Salon']=$this->db->get()->result_array();*/


		/*$this->db->select('IFNULL(COUNT("id"), 0) AS total_Tester');
				$this->db->from('product_used');
				$this->db->where('flag_bit',1);
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=="location_owner") {
			$this->db->where('business_id',$admin_session['business_id']);
			$this->db->where('location_id',$admin_session['location_id']);
		}
		$this->db->group_by('location_id,used_type');
		$this->db->where_in('location_id',$total_city);
		$this->db->where('used_type',7);
		$data['gettotal_Tester']=$this->db->get()->result_array();*/
		
				$this->db->select('*');
				$this->db->from('staff');
				$this->db->where('status',1);
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('business_id',$admin_session['business_id']);
				}

				if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
			$this->db->where('business_id',$admin_session['business_id']);
			$this->db->where('location_id',$admin_session['location_id']);				}
				$data['get_staff']=$this->db->get()->result_array();


				//print_r($this->db->last_query()); exit;
				$data['product_data'] = $product_data;
				$data['location_data'] = $location_data;
				$data['admin_session'] = $admin_session;
				$data['locations'] = $locations;
				$data['product_active_open']=true;
				//gs($location_data);
				$this->load->view('admin/product/product_view',$data);
			}else{
				$this->session->set_flashdata('error_msg', "No records found!");
				redirect(base_url('admin/customer'));		
			}
			
		}else{
			$this->session->set_flashdata('error_msg', "No records found!");
			redirect(base_url('admin/customer'));			
		}
	}
	
	public function categories()
	{
		$arr_search = array();

		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['c.business_id']= $admin_session['business_id'];
		}elseif ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
			$arr_search['c.business_id']= $admin_session['business_id'];
		}
		$this->load->library('pagination');				
		$arr_get = array();
        if ($this->input->get()) {
            foreach($this->input->get() as $key => $val) {
                if($key != 'offset' && $val != '') {
                    $arr_get[] = $key.'='.$val;
                }
            }
        }

        if ($this->input->post('record')) {
			$condition = "";
			if($admin_session['role']=="business_owner"){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";

			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("product_category","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Product category has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No product category are selected to delete!");
			}	
			redirect(base_url('admin/product/categories'));			
		}
        
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/product/categories') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;				
         		
		$all_records = $this->product_model->get_categories(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->product_model->get_categories(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;
		$this->load->view('admin/product/all_categories', $data);
	}
	
	public function add_category()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($this->input->post('action')){
			$business_id = $this->input->post('business_id');
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			$data['category_name'] = $this->input->post('category_name');
			$data['category_code'] = $this->input->post('category_code');
			if(!empty($business_id)){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
				if($locations)
					$data['locations'] = $locations;
			}
			$this->load->library('form_validation');
			if($admin_session['role']=="owner"){
				$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
				/*$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');*/
			}
			if($admin_session['role']=="business_owner"){
				//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('category_name', 'Category name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE) {															
				
				$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
				
				$insert_data = array('business_id'=>$b_id,
					'location_id'=>$this->input->post('location_id'),
					'category_name'=>$this->input->post('category_name'),
					'category_code'=>$this->input->post('category_code'),
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("product_category",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Category is added successfully!");
					redirect(base_url('admin/product/categories'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding cateory is failed!");
					redirect(base_url('admin/product/add_category'));
				}
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner"){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		$data['product_active_open']=true;
		$this->load->view('admin/product/add_category', $data);
	}
	
	public function edit_category($id="")
	{
	  //gs($id); die;
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != '' && is_numeric($id)) {			
			$category_detail = $this->others->get_all_table_value("product_category","*","id='".$id."'");
			if($category_detail){
				if($this->input->post('action')){					
					$business_id = $this->input->post('business_id');
					$data['business_id'] = $this->input->post('business_id');
					$data['location_id'] = $this->input->post('location_id');
					$data['category_name'] = $this->input->post('category_name');
					$data['category_code'] = $this->input->post('category_code');
					if(!empty($business_id)){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						if($locations)
							$data['locations'] = $locations;
					}
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
						/*$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');*/
					}
					if($admin_session['role']=="business_owner"){
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {						
						
						$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
						
						$update_data['business_id'] = $b_id;
						$update_data['location_id'] = $this->input->post('location_id');
						$update_data['category_name'] = $this->input->post('category_name');
						$update_data['category_code'] = $this->input->post('category_code');

						$success = $this->others->update_common_value("product_category",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "Category is updated successfully!");
						redirect(base_url('admin/product/categories'));
					}
				}
				$data['category_detail'] = $category_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
			$location_condition = "";
			if($admin_session['role']=="business_owner")
				$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		$data['product_active_open']=true;
		$this->load->view('admin/product/edit_category', $data);
	}
	
	public function brands()
	{
		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');

		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['c.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['c.business_id']= $admin_session['business_id'];
		}
		$this->load->library('pagination');				
		$arr_get = array();
        if ($this->input->get()) {
            foreach($this->input->get() as $key => $val) {
                if($key != 'offset' && $val != '') {
                    $arr_get[] = $key.'='.$val;
                }
            }
        }

        if ($this->input->post('record')) {
			$condition = "";
			if($admin_session['role']=="business_owner"){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";

			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("product_category","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Brand has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No brand are selected to delete!");
			}	
			redirect(base_url('admin/product/brands'));			
		}
        
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/product/brands') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;				
         		
		$all_records = $this->product_model->get_brands(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->product_model->get_brands(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;
		$this->load->view('admin/product/all_brands', $data);
	}
	
	public function add_brand()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($this->input->post('action')){
			$business_id = $this->input->post('business_id');
			$data['business_id'] = $this->input->post('business_id');
			$data['brand_name'] = $this->input->post('brand_name');
			$data['category_id'] = $this->input->post('category_id');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('brand_name', 'Brand name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE) {		
				$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
				$insert_data = array('business_id'=>$b_id,
					'brand_name'=>$this->input->post('brand_name'),
					'category_id'=>$this->input->post('category_id'),
					'type'=>2,
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("product_brand",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Brand is added successfully!");
					redirect(base_url('admin/product/brands'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding brand is failed!");
					redirect(base_url('admin/product/brands'));
				}
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;	
		$data['product_active_open']=true;
		$categories = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>1])->get()->result_array();
		$data['categories'] = $categories;
		$this->load->view('admin/product/add_brand', $data);
	}

	public function brand_category(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$categories = $this->db->select('*')->from('product_brand')->where(['type'=>1,'business_id'=>$admin_session['business_id']])->get()->result_array();
		$data['categories'] = $categories;
		$data['admin_session'] = $admin_session;
		$data['product_active_open']=true;
		$this->load->view('admin/product/brand_category', $data);
	}

	public function add_brand_category($id=null){
		$admin_session = $this->session->userdata('admin_logged_in');
		if($id){
			$category_data = $this->db->select('*')->from('product_brand')->where(['id'=>$id,'business_id'=>$admin_session['business_id']])->get()->row_array();
		}else{
			$category_data = array();
		}

		if($this->input->post('action')){ 
			if(!$id){
				$insert_data = array(
					'business_id'=>$this->input->post('business_id'),
					'brand_name'=>$this->input->post('brand_name'),
					'type'=>1,
					'status'=>1,
					'date_created'=>date("Y-m-d H:i:s")
				);
				$success = $this->others->insert_data("product_brand",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Category is added successfully!");
					redirect(base_url('admin/product/brand_category'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding Category is failed!");
					redirect(base_url('admin/product/brand_category'));
				}
			}else{				
				$update_data = array(
					'brand_name'=>$this->input->post('brand_name'),
				);
				$success = $this->others->update_common_value("product_brand",$update_data,"id='".$id."' ");
				if ($success) {
					$this->session->set_flashdata('success_msg', "Category is updated successfully!");
					redirect(base_url('admin/product/brand_category'));
				} else {
					$this->session->set_flashdata('error_msg', "Update Category is failed!");
					redirect(base_url('admin/product/brand_category'));
				}
			}	
		}
		$data['category_data'] = $category_data;
		$data['product_active_open']=true;
		$data['admin_session'] = $admin_session;
		$this->load->view('admin/product/add_brand_category', $data);
	}
	
	public function edit_brand($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != '' && is_numeric($id)) {			
			$brand_detail = $this->others->get_all_table_value("product_brand","*","id='".$id."'");
			if($brand_detail){
				if($this->input->post('action')){					
					$business_id = $this->input->post('business_id');
					
					$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
					
					$data['business_id'] = $b_id; 
					$data['brand_name'] = $this->input->post('brand_name'); 
					$data['category_id'] = $this->input->post('category_id');
					if(!empty($business_id)){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						if($locations)
							$data['locations'] = $locations;
					}
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
						$business_id = $this->input->post('business_id');
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					if($admin_session['role']=="business_owner"){
						$business_id = $b_id;
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {						
						$update_data['business_id'] = $business_id; 
						$update_data['brand_name'] = $this->input->post('brand_name'); 
						$update_data['category_id'] = $this->input->post('category_id');
						$success = $this->others->update_common_value("product_brand",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "Brand is updated successfully!");
						redirect(base_url('admin/product/brands'));
					}
				}
				$data['brand_detail'] = $brand_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
			$location_condition = "";
			if($admin_session['role']=="business_owner")
				$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		$data['product_active_open']=true;
		$categories = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>1])->get()->result_array();
		$data['categories'] = $categories;
		$this->load->view('admin/product/edit_brand', $data);
	}
	
	public function all_suppliers()
	{
		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['s.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['s.business_id']= $admin_session['business_id'];
		}
		$this->load->library('pagination');				
		$arr_get = array();
        if ($this->input->get()) {
            foreach($this->input->get() as $key => $val) {
                if($key != 'offset' && $val != '') {
                    $arr_get[] = $key.'='.$val;
                }
            }
        }
        
        if ($this->input->post('record')) {
			$condition = "";
			if($admin_session['role']=="business_owner"){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";

			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("product_supplier","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Supplier has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No supplier are selected to delete!");
			}	
			redirect(base_url('admin/product/all_suppliers'));			
		}

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/product/all_suppliers') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;				
         		
		$all_records = $this->product_model->get_suppliers(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->product_model->get_suppliers(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;
		$this->load->view('admin/product/all_suppliers', $data);
	}
	
	public function orders()
	{

		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['o.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['o.location_id']= $admin_session['location_id'];
		}
		$this->load->library('pagination');				
		$arr_get = array();
        if ($this->input->get()) {
            foreach($this->input->get() as $key => $val) {
                if($key != 'offset' && $val != '') {
                    $arr_get[] = $key.'='.$val;
                }
            }
        }
        
     	if ($this->input->post('record')) {
			$condition = "";
			if($admin_session['role']=="business_owner"){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";

			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("product_locationwise","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Oder has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No order are selected to delete!");
			}	
			redirect(base_url('admin/product/orders'));			
		}

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/product/orders') .'?'.$get_string;

        $this->db->select("o.*,s.first_name,s.last_name,w.warehouse_name,l.location_id AS supper_location_id");
		$this->db->from('orders o');
		$this->db->join('product_supplier s', 'o.supplier_id = s.id','left');
		$this->db->join('warehouse w', 'o.warehouse_id = w.id','left');
		$this->db->join('product_locationwise l', 'o.id = l.order_id','left');

		if($admin_session['business_id']!=''){
				$this->db->where('o.business_id',$admin_session['business_id']);
			}

			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('o.location_id',$admin_session['location_id']);
			}
			$this->db->group_by('o.id');
			$this->db->order_by('o.date_created','DESC');

        $data['all_records'] = $this->db->get()->result_array();
		
//print_r($this->db->last_query()); exit;
		
	/*	if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		         		
		$all_records = $this->product_model->get_orders(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		//echo "<pre>";print_r($all_records); echo "</pre>";die;
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->product_model->get_orders(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);	*/
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;

		$this->load->view('admin/product/all_orders',$data);
	}
	
	public function order_detail($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != "") {
			$dd = $this->db->select('*')
					->from('product_locationwise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();
			//print_r($dd); exit;
			if (empty($dd)) {

				$dd = $this->db->select('*,warehouse_quantity AS quantity')
					->from('product_warehousewise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();
			}

			if (empty($dd)) {

				$dd = $this->db->select('*')
					->from('product_used')
					->join('product','product.id=product_used.product_id','inner')
					->where('product_used.order_id',$id)
					->get();
			$dd = $dd->result_array();
			$dd[0]['supplier_id']=0;
			}

			$arr_search['o.id']=$id;
			$order = $this->product_model->get_orders(false,$arr_search);
			//print_r($order); exit;
			//Get Supplier Details
			if (isset($dd[0]['supplier_id'])) {
			$supplier_id = $dd[0]['supplier_id'];
			}
			else{
			$supplier_id = 0;

			}
			$business_id = $dd[0]['business_id'];

			
			

			$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$supplier_id."'");
			if (isset($dd[0]['warehouse_id'])) {
				$warehouse_id = $dd[0]['warehouse_id'];
			}
			else{
				$warehouse_id = 0;

			}
			
			$warehouse_detail = $this->others->get_all_table_value("warehouse","*","id='".$warehouse_id."'");
			$data['warehouse_detail'] = $warehouse_detail;
//print_r($data['warehouse_detail']); exit;

			$order_location = $this->others->get_all_table_value("orders","*","id='".$id."'");
			$data['order_location'] = $order_location;

			if (isset($dd[0]['location_id'])) {
				$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");	
			$data['location_detail'] = $location_detail;
			}
					
		}
		$data['data'] = $dd;
		
		
		$data['supplier_detail'] = $supplier_detail;
		
		$data['order'] = $order;
		$data['product_active_open']=true;
		$this->load->view('admin/product/order_detail', $data);
	}
	
	public function add_order()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		//echo $admin_session['business_id'];die;
		if($this->input->post('action')){						
			$post_data['post_data'] = $this->input->post();
			$post_data['admin_session'] = $admin_session;
			
			//print_r($_POST);  exit;
			/* Email will only be sent, if save button is clicked
			   Started from here	
			*/
			   if ($this->input->post('action')) {
			   	$location_id_val = $this->input->post('location_id_val');
				$location_id_type=substr($location_id_val,0,1);
				$supplier_id_val=$this->input->post('supplier_id_val');
				$supplier_id_type=$this->input->post('supplier_id_type');
				$product_id = $this->input->post('product_id');
				$quantity = $this->input->post('quantity');
				$product_price = $this->input->post('product_price');
				$ptax = $this->input->post('product_tax_percent');
				$total_tax_amount = $this->input->post('tax_amount');
				$total_amount = $this->input->post('cls_subtotal');
				$ptax_type = $this->input->post('ptax_type');
				$notes = $this->input->post('notes');
				$warehouse_id_val = $this->input->post('warehouse_id_val');
			   }



			if($this->input->post('action')){				
 

				if ($supplier_id_type=='l') {

					$total_qty = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($quantity[$i]!=""){
					$total_qty = $total_qty + $quantity[$i]; 
				}
			}
			$tax_amount = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_tax_amount[$i]!=""){
					$tax_amount = $tax_amount + $total_tax_amount[$i]; 
				}
			}
			$cls_subtotal = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_amount[$i]!=""){
					$cls_subtotal = $cls_subtotal + $total_amount[$i]; 
				}
			}
			
		    // $order_id  = rand(00000000,99999999);
			$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$admin_session['business_id'];
			$insert_data = array('business_id'=>$b_id,
				'location_id'=>$this->input->post('warehouse_id_val'),
				'supplier_id'=>0,
				'warehouse_id'=>0,
				'total_quantity'=>$total_qty,
				'notes'=>$notes,
				'sub_total'=>$this->input->post('sub_total'),
				'total_tax'=>$tax_amount,
				'total_amount'=>$cls_subtotal,
				'status'=>($this->input->post('action')== 'save')?1:0,
				'var_dump'=>json_encode($_REQUEST),
				'date_created' => date('Y-m-d H:i:s'));
				$order_id = $this->others->insert_data("orders",$insert_data);		


					for($i=0;$i< count((array)$product_id);$i++){
					$warehouse_id_val=$this->input->post('warehouse_id_val');
					$where=array(
						"location_id"=>$warehouse_id_val,
						"product_id"=>$product_id[$i],
						'business_id'=>$admin_session['business_id'],
						'warehouse_id'=>0,	
									

					);
					$this->db->select('*');
					$this->db->from('product_locationwise');
					$this->db->where($where);
					$locationwise_detail=$this->db->get()->row_array();

						$avil_quantity=$locationwise_detail['quantity']-$quantity[$i];


						$update_data=array(
							"quantity"=>$avil_quantity,
						);

						/*$success = $this->others->update_common_value("product_locationwise",$update_data,"id='".$locationwise_detail['id']."' ");*/

						$where=array(
						"location_id"=>$location_id_val,
						"product_id"=>$product_id[$i],
						'business_id'=>$admin_session['business_id'],
						'warehouse_id'=>0,	
									

					);
						$success = $this->others->get_all_table_value_count("product_locationwise","id",$where);						
						if ($success>0) {

					$this->db->select('*');
					$this->db->from('product_locationwise');
					$this->db->where($where);
					$get_locationwise_data=$this->db->get()->row_array();
					$get_locationwise_data_id=$get_locationwise_data['id'];
					$get_locationwise_data_quantity=$get_locationwise_data['quantity']+$quantity[$i];
					//echo $get_locationwise_data_quantity.''.$get_locationwise_data_id;

					/*$update_data=array(
						"quantity"=>$get_locationwise_data_quantity,
					);*/
					$insert_data=array(
					'business_id'=>$b_id,
					'order_id'=>$order_id,	
						'location_id'=>$this->input->post('warehouse_id_val'),	
						'used_type'=>4,						
						'product_id'=>$product_id[$i],
						'quantity'=>$quantity[$i],						
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_used",$insert_data);


					
					$insert_data=array(
					'business_id'=>$b_id,	
						'location_id'=>$this->input->post('location_id_val'),
						'supplier_id'=>0,
						'warehouse_id'=>0,
						'product_warehousewise_id'=>0,	
						'order_id'=>$order_id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);

				/*	$success = $this->others->update_common_value("product_locationwise",$update_data,"id='".$get_locationwise_data_id."' ");*/

					


					$this->session->set_flashdata('success_msg', "location to location  product quantity inserted  successfully!");
				redirect(base_url('admin/product/orders'));
							
						}

						else{						

				$insert_data = array(
						'business_id'=>$b_id,	
						'location_id'=>$this->input->post('location_id_val'),
						'supplier_id'=>0,
						'warehouse_id'=>0,
						'product_warehousewise_id'=>0,	
						'order_id'=>$order_id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);

						$this->session->set_flashdata('success_msg', "location to location  product quantity inserted  successfully!");
				redirect(base_url('admin/product/orders'));
						}


				}
					

				}




				if ($location_id_type=='w') {

					$total_qty = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($quantity[$i]!=""){
					$total_qty = $total_qty + $quantity[$i]; 
				}
			}
			$tax_amount = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_tax_amount[$i]!=""){
					$tax_amount = $tax_amount + $total_tax_amount[$i]; 
				}
			}
			$cls_subtotal = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_amount[$i]!=""){
					$cls_subtotal = $cls_subtotal + $total_amount[$i]; 
				}
			}
			
		    // $order_id  = rand(00000000,99999999);
			$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$admin_session['business_id'];
			$warehouse_id_val=preg_replace('/[^0-9]+/', '', $location_id_val);
			$supplier_id_val=preg_replace('/[^0-9]+/', '', $supplier_id_val);
			$insert_data = array('business_id'=>$b_id,
				'location_id'=>$this->input->post('location_id_val'),
				'supplier_id'=>$supplier_id_val,
				'warehouse_id'=>$warehouse_id_val,
				'total_quantity'=>$total_qty,
				'notes'=>$notes,
				'sub_total'=>$this->input->post('sub_total'),
				'total_tax'=>$tax_amount,
				'total_amount'=>$cls_subtotal,
				'status'=>($this->input->post('action')== 'save')?1:0,
				'var_dump'=>json_encode($_REQUEST),
				'date_created' => date('Y-m-d H:i:s'));
				$order_id = $this->others->insert_data("orders",$insert_data);	

						for($i=0;$i< count((array)$product_id);$i++){
				$warehouse_id_val=preg_replace('/[^0-9]+/', '', $location_id_val);
				$supplier_id_val=preg_replace('/[^0-9]+/', '', $supplier_id_val);
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],					
						'supplier_id'=>$supplier_id_val,
						'warehouse_id'=>$warehouse_id_val,
						'order_id'=>$order_id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_warehousewise",$insert_data);
					}

					$this->session->set_flashdata('success_msg', "supplier to warehouse  product assign  successfully!");
				redirect(base_url('admin/product/orders'));
				
			}

				

				
				$warehouse_id_val=$this->input->post('warehouse_id_val');
				$supplier_id_val=preg_replace('/[^0-9]+/', '', $supplier_id_val);
				$warehouse_id_val=preg_replace('/[^0-9]+/', '', $warehouse_id_val);
				
				if ($supplier_id_val>0) {

					$mail_content = $this->load->view('admin/templates/supplier-order-invoice',$post_data,true);
				$supplier_email = getProductSupplierEmail($this->input->post('supplier_id_val'));
				
				$mail = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.bookingintime.com',
					'smtp_port' => 2525,
					'smtp_user' => 'developer@bookingintime.com',
					'smtp_pass' => 'ye_0~u+t1y,0',
					'mailtype'  => 'html', 
					'charset' => 'utf-8',
					'wordwrap' => TRUE
				);
				$this->load->library('email', $mail);
				$this->email->set_newline("\r\n");
				$this->email->from('developer@bookingintime.com', 'Bookingintime.com');
				$list = array($supplier_email);
				$this->email->to($list);
				$this->email->subject('New Order from BookinginTime.com');
				$this->email->message($mail_content);
				$emailFlag = $this->email->send();
			}
				
				}
				
				
			
			/* Email will only be sent, if save button is clicked
			   Ends here	
			*/


			if(empty($warehouse_id_val) && empty($emailFlag)  &&$this->input->post('action') == 'save'){
				$this->session->set_flashdata('error_msg', "Error while sending order details to supplier, Please try again");
				redirect(base_url('admin/product/orders'));				
			}
 
			$product_id = $this->input->post('product_id');
			$quantity = $this->input->post('quantity');
			$product_price = $this->input->post('product_price');
			$ptax = $this->input->post('product_tax_percent');
			$total_tax_amount = $this->input->post('tax_amount');
			$total_amount = $this->input->post('cls_subtotal');
			$ptax_type = $this->input->post('ptax_type');
			$notes = $this->input->post('notes');
			
			$total_qty = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($quantity[$i]!=""){
					$total_qty = $total_qty + $quantity[$i]; 
				}
			}
			$tax_amount = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_tax_amount[$i]!=""){
					$tax_amount = $tax_amount + $total_tax_amount[$i]; 
				}
			}
			$cls_subtotal = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_amount[$i]!=""){
					$cls_subtotal = $cls_subtotal + $total_amount[$i]; 
				}
			}
			
		    // $order_id  = rand(00000000,99999999);
		   // print_r($warehouse_id_val); exit;
			$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$admin_session['business_id'];
			$insert_data = array('business_id'=>$b_id,
				'location_id'=>$this->input->post('location_id_val'),
				'supplier_id'=>$supplier_id_val,
				'warehouse_id'=>$warehouse_id_val>0?$warehouse_id_val:0,
				'total_quantity'=>$total_qty,
				'notes'=>$notes,
				'sub_total'=>$this->input->post('sub_total'),
				'total_tax'=>$tax_amount,
				'total_amount'=>$cls_subtotal,
				'status'=>($this->input->post('action')== 'save')?1:0,
				'var_dump'=>json_encode($_REQUEST),
				'date_created' => date('Y-m-d H:i:s'));
				
				// echo "<pre>"; print_r($_POST); 
				// echo "<pre>insert data=> "; print_r($insert_data); die;
				$success = $this->others->insert_data("orders",$insert_data);
				$order_id =$success;
			
				//Insert all ordered products ( order_type = 0 for Order Draft)
				for($i=0;$i< count((array)$product_id);$i++){
					if ($warehouse_id_val>0) {
						$warehousewise=$this->db->select("*")->from('product_warehousewise')->where('product_id',$product_id[$i])->where('warehouse_id',$warehouse_id_val)->get()->row_array();
					$total_warehouse_quantity=$warehousewise['warehouse_quantity'];
					$product_warehousewise_id=$warehousewise['id'];
					$last_quantity=$total_warehouse_quantity-$quantity[$i];
					$update_data = array(
						'warehouse_quantity'=>$last_quantity,
					 );
					/*$this->others->update_common_value("product_warehousewise",$update_data,"id='".$product_warehousewise_id."' ");*/

					$insert_data=array(
					'business_id'=>$b_id,
					'order_id'=>$order_id,	
						'warehouse_id'=>$this->input->post('warehouse_id_val'),	
						'used_type'=>4,						
						'product_id'=>$product_id[$i],
						'quantity'=>$quantity[$i],						
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_warehouse_used",$insert_data);

					}


					



					if($product_id[$i]!="" && $quantity[$i]!=""){
						$insert_data = array(
						'business_id'=>$b_id,	
						'location_id'=>$this->input->post('location_id_val'),
						'supplier_id'=>$supplier_id_val,
						'warehouse_id'=>$warehouse_id_val,
						'product_warehousewise_id'=>isset($product_warehousewise_id)?$product_warehousewise_id:0,	
						'order_id'=>$order_id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);
					}
				}
				
				$this->session->set_flashdata('success_msg', "Order is added successfully!");
				redirect(base_url('admin/product/orders'));
			 
		}
		
		if($admin_session['role']=="owner"){
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
				$data['all_business'] = $all_business;		
		}
		if($admin_session['role']=="business_owner" ){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$locations = $this->others->get_all_table_value("location","id,location_name","id='".$admin_session['location_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		
		//product supplier
		if($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner"  || $admin_session['role']=="staff"){
			$suppliers = $this->others->get_all_table_value("product_supplier","*","business_id='".$admin_session['business_id']."' ","first_name","ASC");
			if($suppliers)
				$data['suppliers'] = $suppliers;	
		}


		$this->db->from('warehouse');
			if ($admin_session['business_id']!='') {
				$this->db->where('business_id',$admin_session['business_id']);
			}			
			$data['warehouse']=$this->db->where('status!=',2)->order_by('warehouse_name','ASC')->get()->result_array();
		
		//products
		/*if($admin_session['role']=="business_owner"){
			$products = $this->others->get_all_table_value("product","id,product_name","business_id='".$admin_session['business_id']."'","product_name","ASC");
			if($products)
				$data['products'] = $products;	
		}*/
		
		$data['product_active_open']=true;

		
		/* All Products */
		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['p.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['p.business_id']= $admin_session['business_id'];
		}
		
		$all_products = $this->product_model->get_products(false,$arr_search,'','',"product_name","ASC");
		if($all_products){
			$data['all_products']= $all_products;
			//gs($all_products);		 
		}		
		$this->load->view('admin/product/add_order', $data);
	}

	
	/*public function order_received($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($id!=""){
			$arr_search['o.order_id']=$id;
			$record = $this->product_model->get_orders(false,$arr_search);
			if($record){
				$order_items = $this->product_model->get_ordered_products("order_id='".$id."' AND added_to_inventry='0' ");
				if($order_items){
					$record[0]['ordered_items'] = $order_items;
				}
				$data['record'] = $record;
				//echo "<pre>";print_r($record); echo "</pre>"; die;
				
				if($this->input->post('action')){
					$product_id = $this->input->post('product_id');
					$quantity = $this->input->post('quantity');
					$notes = $this->input->post('notes');
					$total_qty = 0;
					for($i=0;$i< count((array)$product_id);$i++){
						if($quantity[$i]!=""){
							$total_qty = $total_qty + $quantity[$i]; 
						}
					}
					$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
					$insert_data = array('business_id'=>$b_id,
						'location_id'=>$this->input->post('location_id_val'),
						'supplier_id'=>$this->input->post('supplier_id_val'),
						'total_quantity'=>$total_qty,
						'notes'=>$notes,
						'status'=>'ordered',
						'date_created' => date('Y-m-d H:i:s'));
					$success = $this->others->insert_data("order_products",$insert_data);
					$order_id = $this->db->insert_id();			
					if ($success) {
						//Insert all ordered products
						for($i=0;$i< count((array)$product_id);$i++){
							if($product_id[$i]!="" && $quantity[$i]!=""){
								$insert_data = array('order_id'=>$order_id,
								'product_id'=>$product_id[$i],
								'quantity'=>$quantity[$i],
								'date_created' => date('Y-m-d H:i:s'));
								$this->others->insert_data("order_products_detail",$insert_data);
							}
						}
						
						$this->session->set_flashdata('success_msg', "Oreder is added successfully!");
						redirect(base_url('admin/product/orders'));
					} else {
						$this->session->set_flashdata('error_msg', "Adding order is failed!");
						redirect(base_url('admin/product/add_order'));
					}
				}
				
				$location_detail = $this->others->get_all_table_value("location","*","id='".$record[0]['location_id']."' ");
				if($location_detail)
					$data['location_detail'] = $location_detail;	
				
				$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$record[0]['supplier_id']."' ");
				if($supplier_detail)
					$data['supplier_detail'] = $supplier_detail;	
			}
		
		}
		$data['product_active_open']=true;
		$this->load->view('admin/product/order_received', $data);
	}*/

	public function order_received($id=""){		
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != "") {
			$dd = $this->db->select('*')
					->from('product_locationwise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();

			if (empty($dd)) {

				$dd = $this->db->select('*,warehouse_quantity AS quantity')
					->from('product_warehousewise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();
			}

			if (empty($dd)) {

				$dd = $this->db->select('*')
					->from('product_used')
					->join('product','product.id=product_used.product_id','inner')
					->where('product_used.order_id',$id)
					->get();
			$dd = $dd->result_array();
			$dd[0]['supplier_id']=0;
			}


			$arr_search['o.id']=$id;
			$order = $this->product_model->get_orders(false,$arr_search);
			
			//Get Supplier Details
			$supplier_id = $dd[0]['supplier_id'];
			$business_id = $dd[0]['business_id'];
			$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$supplier_id."'");

			//Get Location Details
			/*$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");*/

			if (isset($dd[0]['location_id'])) {
				$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");	
			$data['location_detail'] = $location_detail;
			}

			//$warehouse_id = $dd[0]['warehouse_id'];
			if (isset($dd[0]['warehouse_id'])) {
				$warehouse_id = $dd[0]['warehouse_id'];
			}
			else{
				$warehouse_id = 0;

			}

			$warehouse_detail = $this->others->get_all_table_value("warehouse","*","id='".$warehouse_id."'");
			$data['warehouse_detail'] = $warehouse_detail;

			$order_location = $this->others->get_all_table_value("orders","*","id='".$id."'");
			$data['order_location'] = $order_location;

			if($this->input->post('action')){
				//gs($_POST);
				$product_locationwise_id = $this->input->post('product_locationwise_id');
				$quantity = $this->input->post('quantity');
				$tax_amount = $this->input->post('tax_amount');
				$free = $this->input->post('free');
				$discount_amount = $this->input->post('discount_amount');
				$purchase_cost = $this->input->post('purchase_cost');
				$notes = $this->input->post('notes');
				$total_qty = 0;

				$total_qty = 0;
				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($quantity[$i]!=""){
						$total_qty = $total_qty + $quantity[$i]; 
					}
				}
				$cls_subtotal = 0;
				$ttotal = 0;
				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($quantity[$i]!=""){
						$ttotal = $quantity[$i]*$purchase_cost[$i];
						$cls_subtotal = $cls_subtotal + $ttotal; 
					}
					$ttotal = 0;
				}
				$damount=0;
				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($discount_amount[$i]){
						$damount = $damount + $discount_amount[$i]; 
					}
				}
				$tamount=0;
				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($tax_amount[$i]){
						$tamount = $tamount + $tax_amount[$i]; 
					}
				}
				$tfree=0;
				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($free[$i]){
						$tfree = $tfree + $free[$i]; 
					}
				}

				$update_order = array(
					'status'=>$this->input->post('order_status'),
					'order_ref_number'=>$this->input->post('order_ref_number'),
					'total_quantity'=>$total_qty,
					'sub_total'=>$cls_subtotal,
					'total_discount'=>$damount,
					'total_tax'=>$tamount,
					'shipping_cost'=>$this->input->post('shipping'),
					'total_amount'=>$this->input->post('grand_total'),
					'notes'=>$this->input->post('notes'),
					'total_freegoods'=>$tfree,
					'var_dump_received'=>json_encode($_REQUEST),
					'date_order_received'=>date('Y-m-d H:i:s')
				);
				$order_success = $this->others->update_common_value("orders",$update_order,"id='".$id."' ");


				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($quantity[$i]!=""){
						$update_data = array(
							'quantity'=>$quantity[$i],
							'product_tax_amount'=>$tax_amount[$i],
							'product_free_goods'=>$free[$i],
							'product_disount'=>$discount_amount[$i],
						);
						$where=array(
							"id"=>$product_locationwise_id[$i],
							"order_id"=>$id,

						);
						//gs($update_data);
						$success = $this->others->update_common_value("product_locationwise",$update_data,$where);
					}
				}

				for($i=0;$i< count((array)$product_locationwise_id);$i++){
					if($quantity[$i]!=""){
						$update_data = array(
							'warehouse_quantity'=>$quantity[$i],
							'product_tax_amount'=>$tax_amount[$i],
							'product_free_goods'=>$free[$i],
							'product_disount'=>$discount_amount[$i],
						);

						$where=array(
							"id"=>$product_locationwise_id[$i],
							"order_id"=>$id,

						);
						//gs($update_data);
						$success = $this->others->update_common_value("product_warehousewise",$update_data,$where);
					}
				}

				if($_FILES['document']['name'] != ""){
					$this->load->library('image_lib');
					$uploadDir = $this->config->item('physical_url') . 'images/order-document/';
					$ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
					$file_name = rand() . rand() . "_" . time() . '.' . $ext;
					move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir . $file_name);

					$attachment_data = array(
						'order_id'=>$id,
						'business_id'=>$business_id,
						'file_name'=>$file_name,
						//'attechment_note'=>$this->input->post('attechment_note'),
						'created_at'=>date('Y-m-d H:i:s')
					);
					$this->others->insert_data("orders_attachments",$attachment_data);
				}

				$this->session->set_flashdata('success_msg', "Order is updated successfully!");
						redirect(base_url('admin/product/orders'));
			}

		}
		$data['data'] = $dd;
		//$data['location_detail'] = $location_detail;
		$data['supplier_detail'] = $supplier_detail;
		$data['order'] = $order;
		$data['product_active_open']=true;
		$this->load->view('admin/product/order_received',$data);
	}
	
	public function add_supplier()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post('action')){
			$business_id = $this->input->post('business_id');
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			$data['first_name'] = $this->input->post('first_name');
			$data['last_name'] = $this->input->post('last_name');
			$data['email'] = $this->input->post('email');
			$data['mobile_number'] = $this->input->post('mobile_number');
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['suburb'] = $this->input->post('suburb');
			//$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['country_id'] = $this->input->post('country_id');
			$data['postcode'] = $this->input->post('postcode');
			$data['website'] = $this->input->post('website');
			$data['description'] = $this->input->post('description');
			$data['supplier_company_name'] = $this->input->post('supplier_company_name');
			$data['supplier_abn'] = $this->input->post('supplier_abn');
									
			if(!empty($business_id)){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
				if($locations)
					$data['locations'] = $locations;
			}
			$this->load->library('form_validation');
			if($admin_session['role']=="owner"){
				$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			if($admin_session['role']=="business_owner"){
				//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean');
						
			if ($this->form_validation->run() == TRUE) {															
				
				$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
				
				$insert_data = array('business_id'=>$b_id,
					'location_id'=>$this->input->post('location_id'),
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'email'=>$this->input->post('email'),
					'mobile_number'=>$this->input->post('mobile_number'),
					'address1'=>$this->input->post('address1'),
					'address2'=> $this->input->post('address2'),
					'suburb'=>$this->input->post('suburb'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'postcode'=>$this->input->post('postcode'),					
					'website'=>$this->input->post('website'),
					'country_id'=>$this->input->post('country_id'),
					'description'=>$this->input->post('description'),
					'supplier_company_name'=>$this->input->post('supplier_company_name'),
					'supplier_abn'=>$this->input->post('supplier_abn'),
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("product_supplier",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Supplier is added successfully!");
					redirect(base_url('admin/product/all_suppliers'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding supplier is failed!");
					redirect(base_url('admin/product/add_supplier'));
				}
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner"){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		$data['admin_session']= $admin_session;
		
		$data['product_active_open']=true;
		$this->load->view('admin/product/add_supplier', $data);
	}
	
	public function edit_supplier($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		if ($id != '' && is_numeric($id)) {			
			$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$id."'");
			if($supplier_detail){
				if($this->input->post('action')){					
					$business_id = $this->input->post('business_id');
					$data['business_id'] = $this->input->post('business_id');
					$data['location_id'] = $this->input->post('location_id');
					$data['first_name'] = $this->input->post('first_name');
					$data['last_name'] = $this->input->post('last_name');
					$data['email'] = $this->input->post('email');
					$data['mobile_number'] = $this->input->post('mobile_number');
					$data['address1'] = $this->input->post('address1');
					$data['address2'] = $this->input->post('address2');
					//$data['suburb'] = $this->input->post('suburb');
					$data['city'] = $this->input->post('city');
					$data['state'] = $this->input->post('state');
					$data['postcode'] = $this->input->post('postcode');
					$data['country_id'] = $this->input->post('country_id');
					$data['website'] = $this->input->post('website');
					$data['description'] = $this->input->post('description');
					$data['supplier_company_name'] = $this->input->post('supplier_company_name');
					$data['supplier_abn'] = $this->input->post('supplier_abn');
										
					if(!empty($business_id)){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						if($locations)
							$data['locations'] = $locations;
					}
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
						/*$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');*/
					}
					if($admin_session['role']=="business_owner"){
						//$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean');
					
					if ($this->form_validation->run() == TRUE) {						
						
						$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ;
						
						$update_data['business_id'] = $b_id;
						$update_data['location_id'] = $this->input->post('location_id');
						$update_data['first_name'] = $this->input->post('first_name');
						$update_data['last_name'] =$this->input->post('last_name');
						$update_data['email'] = $this->input->post('email');
						$update_data['mobile_number'] = $this->input->post('mobile_number');
						$update_data['address1'] = $this->input->post('address1');
						$update_data['address2'] =  $this->input->post('address2');
						$update_data['suburb'] =  $this->input->post('suburb');
						$update_data['city'] = $this->input->post('city');
						$update_data['state'] = $this->input->post('state');
						$update_data['postcode'] = $this->input->post('postcode');
						$update_data['country_id'] = $this->input->post('country_id');
						$update_data['website'] = $this->input->post('website');
						$update_data['description'] = $this->input->post('description');
						$update_data['supplier_company_name'] = $this->input->post('supplier_company_name');
						$update_data['supplier_abn'] = $this->input->post('supplier_abn');
																							
						$success = $this->others->update_common_value("product_supplier",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "Supplier is updated successfully!");
						redirect(base_url('admin/product/all_suppliers'));
					}
				}
				$data['supplier_detail'] = $supplier_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
			$location_condition = "";
			if($admin_session['role']=="business_owner")
				$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		
		$data['admin_session']= $admin_session;
		$data['product_active_open']=true;
		$this->load->view('admin/product/edit_supplier', $data);
	}
	
	public function export_to_csv(){
		
		$admin_session = $this->session->userdata('admin_logged_in');
		$condition = "";
		
		$arr_search = array();
		if($admin_session['role']=="business_owner"){
			$arr_search['p.business_id'] = $admin_session['business_id'];
		}
		if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['p.location_id'] = $admin_session['location_id'];
		}
		
		$products = $all_records = $this->product_model->get_products(false,$arr_search,"","","p.date_created","DESC");
		//echo "<pre>";print_r($products); echo "</pre>"; die;
		$filename = "products_".time().".csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		$fp = fopen('php://output', 'w');
		//fputcsv($fp, $header);
		$row= array("SNO","Product Name","Bar Code","Sku","Retail Price","Special Price","Quantity","Alert Quantity","Category Name","Brand Name","Supplier Number","Description","Commission Enable");
		fputcsv($fp, $row);
		if($products){		
			$i=1;
			foreach($products as $row){
				$enable_commission = ($row['enable_commission']==1)?"Yes":"No" ; 
				$arr = array($i,$row['product_name'],$row['bar_code'],$row['sku'],'$'.$row['retail_price'],'$'.$row['special_price'],
				$row['quantity'],$row['alert_quantity'],$row['category_name'],$row['brand_name'],$row['first_name'].' '.$row['last_name'],$row['description'],$enable_commission);
				fputcsv($fp, $arr);
				$i++;
			}				
		}
		exit;		
	}

	public function stockin(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post())
		{
			$product_id = $this->input->post('product_id');
			$location_id = $this->input->post('location_id');
			$quantity = $this->input->post('quantity');
			$reason = $this->input->post('reason');
			$message = $this->input->post('message');
			$product_detail = $this->others->get_all_table_value("product","*","id='".$product_id."'");
			if( ($admin_session['role']=='owner') or ($admin_session['role']=='location_owner') or ( ($admin_session['business_id']==$product_detail[0]['business_id']) && ($admin_session['role']=='business_owner') )  )
			{
				if($quantity>0){
						$insert_data = array(
							'order_type'=>3,
							'business_id'=>$product_detail[0]['business_id'],
							'location_id'=>$location_id,
							'supplier_id'=>$product_detail[0]['supplier_id'],
							'product_id'=>$product_id,
							'quantity'=>$quantity,
							'stockin_reason'=>$reason,
							'stockin_message'=>$message,
							'date_created'=>date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);
					}
				$this->session->set_flashdata('success_msg', "Stock is updated successfully!");
				redirect(base_url('admin/product/view/'.$product_id));
			}else{
				$this->session->set_flashdata('error_msg', "Access Denied!");
				redirect(base_url('admin/product/'));
			}
		}else{
			redirect(base_url('admin/product/'));
		}
	}

	public function stockout(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post())
		{
			$product_id = $this->input->post('product_id');
			$id = $product_id;
			$location_id = $this->input->post('location_id');

			$quantity = $this->input->post('quantity');
			$reason = $this->input->post('reason');
			$message = $this->input->post('message');
			$product_detail = $this->others->get_all_table_value("product","*","id='".$product_id."'");
			if($quantity <= getProductStockQtyForLocation($location_id,$product_id)){
			if( ($admin_session['role']=='owner') or ($admin_session['role']=='location_owner') or ( ($admin_session['business_id']==$product_detail[0]['business_id']) && ($admin_session['role']=='business_owner') ) )
			{
				if($quantity>0){
					$insert_data = array(
						'used_type'=>$reason,
						'business_id'=>$product_detail[0]['business_id'],
						'location_id'=>$location_id,
						'product_id'=>$product_id,
						'quantity'=>$quantity,
						'message'=>$message,
						'date_created'=>date('Y-m-d H:i:s'));
					$this->others->insert_data("product_used",$insert_data);
					$this->session->set_flashdata('success_msg', "Stock quantity updated successfully!");
					redirect(base_url('admin/product/view/'.$id));
				}else{
					$this->session->set_flashdata('error_msg', "Quantity must be greator then 0");
					redirect(base_url('admin/product/view/'.$id));
				}
			}else{
				$this->session->set_flashdata('error_msg', "Access Denied!");
				redirect(base_url('admin/product/'));
			}
		}else{
				$this->session->set_flashdata('error_msg', "Quantity cannot be greator then available stock!");
				redirect(base_url('admin/product/view/'.$id));
		}
		}else{
			redirect(base_url('admin/product/'));
		}
	}

	public function order_attechments($id){
		$admin_session = $this->session->userdata('admin_logged_in');
		if(!$id)
		{
			redirect(base_url('admin/product/orders'));
		}
		$data = $this->db->get_where('orders_attachments',['order_id'=>$id]);
		$data = $data->result_array();
		if( ($admin_session['role']=="owner") || ( ($admin_session['role']=="business_owner") && ($admin_session['business_id']==$data[0]['business_id']) ) )
		{	
			$data['data'] = $data;
			$data['product_active_open']=true;
			$this->load->view('admin/product/order_attechments',$data);
		}else{
			$this->session->set_flashdata('error_msg','Access Denied');
			redirect(base_url('admin/product/orders'));
		}
		
	}

	public function order_invoice($id){
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != "") {
			$dd = $this->db->select('*')
					->from('product_locationwise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();

			$order_data = $this->db->select('*')
					->from('orders')
					->where('id',$id)
					->get();
			$order_data = $order_data->row_array();
			//gs($order_data);

			$arr_search['o.id']=$id;
			$order = $this->product_model->get_orders(false,$arr_search);
			
			//Get Supplier Details
			$supplier_id = $dd[0]['supplier_id'];
			$business_id = $dd[0]['business_id'];
			$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$supplier_id."'");

			//Get Location Details
			$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");
			//gs($data);
			$data['data'] = $dd;
			$data['location_detail'] = $location_detail;
			$data['supplier_detail'] = $supplier_detail;
			$data['order'] = $order;
			$data['order_data'] = $order_data;
			$data['product_active_open']=true;
		$this->load->view('admin/product/order_invoice',$data);
		}
	}

	
	public function getProductInventryDetails($product_id,$location_id,$type)
	{
		$data = array();
		if($type=="stockin"){
			$dd = $this->db->select('*')->from('product_locationwise')
				//->where(['order_type !='=>2,'location_id'=>$location_id,'product_id'=>$product_id])
				->where(['location_id'=>$location_id,'product_id'=>$product_id])
				->get()->result_array();
			$data['type'] = $type;	
		}else{
			$dd = $this->db->select('*')->from('product_used')
				->where(['location_id'=>$location_id,'product_id'=>$product_id])
				->get()->result_array();
			$data['type'] = $type;	
		}
		$data['data']	= $dd;
		return $this->load->view('admin/product/product_inventry_detail', $data);
	}

	
	public function edit_order($id){
		
		// If edit order (Order Drafts)
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		 
		if ($id != '' && is_numeric($id)) {	
			$dd = $this->db->select('*')
					->from('product_locationwise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();

			if (empty($dd)) {

				$dd = $this->db->select('*,warehouse_quantity AS quantity')
					->from('product_warehousewise')
					->where('order_id',$id)
					->get();
			$dd = $dd->result_array();
			}

			if (empty($dd)) {

				$dd = $this->db->select('*')
					->from('product_used')
					->join('product','product.id=product_used.product_id','inner')
					->where('product_used.order_id',$id)
					->get();
			$dd = $dd->result_array();
			$dd[0]['supplier_id']=0;
			}


			$arr_search['o.id']=$id;
			$order = $this->product_model->get_orders(false,$arr_search);
			
			//Get Supplier Details
			$supplier_id = $dd[0]['supplier_id'];
			$business_id = $dd[0]['business_id'];
			$supplier_detail = $this->others->get_all_table_value("product_supplier","*","id='".$supplier_id."'");

			//Get Location Details
		/*	$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");	
			$data['location_detail'] = $location_detail;*/

			if (isset($dd[0]['location_id'])) {
				$location_id = $dd[0]['location_id'];
			$location_detail = $this->others->get_all_table_value("location","*","id='".$location_id."' ");	
			$data['location_detail'] = $location_detail;
			}

			if (isset($dd[0]['warehouse_id'])) {
				$data['warehouse_id']=$warehouse_id = $dd[0]['warehouse_id'];
			}
			else{
				$warehouse_id = 0;

			}

			$warehouse_detail = $this->others->get_all_table_value("warehouse","*","id='".$warehouse_id."'");
			$data['warehouse_detail'] = $warehouse_detail;


			$data['data'] = $dd;
			
			$data['supplier_detail'] = $supplier_detail;
			$data['order'] = $order;

			$this->db->select('*');
			$this->db->from('orders');
			$this->db->where('id',$id);
			$data['order_details']=$this->db->get()->row_array();

				$this->db->from('warehouse');
			if ($admin_session['business_id']!='') {
				$this->db->where('business_id',$admin_session['business_id']);
			}			
			$data['warehouse']=$this->db->where('status!=',2)->order_by('warehouse_name','ASC')->get()->result_array();
			//print_r($this->db->last_query()); exit;

		}else{
			$this->session->set_flashdata('error_msg', "Invalid Order Found, Please Check");
			redirect(base_url('admin/product/orders'));				
		}			
		 
		if($this->input->post('action')){
			  
			//echo "<pre>";print_r($_REQUEST); echo "</pre>"; die;
			$post_data['post_data'] = $this->input->post();
			$post_data['admin_session'] = $admin_session;
			$location_id_val=$this->input->post('location_id_val');
			$location_id_type=substr($location_id_val,0,1);
			
			/* Email will only be sent, if save button is clicked
			   Started from here	
			*/
			if($this->input->post('action') == 'save' && $location_id_type!='w' ){
				//print_r($post_data); exit;
				$mail_content = $this->load->view('admin/templates/supplier-order-invoice',$post_data,true);
				$supplier_email = getProductSupplierEmail($this->input->post('supplier_id_val'));
				//gs($supplier_email);die;
				/*$mail = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.bookingintime.com',
					'smtp_port' => 2525,
					'smtp_user' => 'developer@bookingintime.com',
					'smtp_pass' => 'ye_0~u+t1y,0',
					'mailtype'  => 'html', 
					'charset' => 'utf-8',
					'wordwrap' => TRUE
				);*/
				$mail = $this->config->item('mail_data');
				$this->load->library('email', $mail);
				$this->email->set_newline("\r\n");
				 $this->email->from($this->config->item('default_mail'),'Bookingintime.com');
				//$this->email->from('developer@bookingintime.com', 'Bookingintime.com');
				$list = array($supplier_email);
				$this->email->to($list);
				$this->email->subject('New Order from BookinginTime.com');
				$this->email->message($mail_content);
				$emailFlag = $this->email->send();
			}
			
			/* Email will only be sent, if save button is clicked
			   Ends here	
			*/
			if(empty($emailFlag) &&  $location_id_type!='w' && ($this->input->post('action') == 'save')){
				$this->session->set_flashdata('error_msg', "Error while sending order details to supplier, Please try again");
				redirect(base_url('admin/product/orders'));				
			}
 
			$product_id = $this->input->post('product_id');
			$quantity = $this->input->post('quantity');
			$product_price = $this->input->post('product_price');
			$ptax = $this->input->post('product_tax_percent');
			$total_tax_amount = $this->input->post('tax_amount');
			$total_amount = $this->input->post('cls_subtotal');
			$ptax_type = $this->input->post('ptax_type');
			$notes = $this->input->post('notes');
			
			$total_qty = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($quantity[$i]!=""){
					$total_qty = $total_qty + $quantity[$i]; 
				}
			}
			$tax_amount = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_tax_amount[$i]!=""){
					$tax_amount = $tax_amount + $total_tax_amount[$i]; 
				}
			}
			$cls_subtotal = 0;
			for($i=0;$i< count((array)$product_id);$i++){
				if($total_amount[$i]!=""){
					$cls_subtotal = $cls_subtotal + $total_amount[$i]; 
				}
			}

		    // $order_id  = rand(00000000,99999999);
			$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$admin_session['business_id'] ;
			$insert_data = array('business_id'=>$b_id,
				'location_id'=>$this->input->post('location_id_val'),
				'supplier_id'=>$this->input->post('supplier_id_val'),
				'total_quantity'=>$total_qty,
				'notes'=>$notes,
				'sub_total'=>$this->input->post('sub_total'),
				'total_tax'=>$tax_amount,
				'total_amount'=>$cls_subtotal,
				'status'=>($this->input->post('action')== 'save')?1:0,
				'var_dump'=>json_encode($_REQUEST),
				'date_created' => date('Y-m-d H:i:s'));

			 /*$this->db->where('id', $id);
    $query = $this->db->update('orders', $insert_data);
*/
    $this->others->update_common_value("orders",$insert_data,"id='".$id."' ");

    //print_r($this->db->last_query()); exit;
					//$this->db->update('orders', $insert_data);
					//$this->db->where('id',$id);
					
				//$success = $this->others->insert_data("orders",$insert_data);
				//$order_id = $this->db->insert_id();
			
				//Insert all ordered products ( order_type = 0 for Order Draft)
    //$this->db->where('order_id', $id);
   //$this->db->delete('product_locationwise'); 

    //print_r($_POST); exit;


if ($location_id_type=='w') {
	$warehouse_id_val=preg_replace('/[^0-9]+/', '', $location_id_val);

	 $this->others->delete_record("product_warehousewise","order_id='".$id."'");

				for($i=0;$i< count((array)$product_id);$i++){
					if($product_id[$i]!="" && $quantity[$i]!=""){
						$insert_data = array(
						'business_id'=>$b_id,	
						'warehouse_id'=>$warehouse_id_val,
						'supplier_id'=>$this->input->post('supplier_id_val'),	
						'order_id'=>$id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_warehousewise",$insert_data);
					}
				}
				
				$this->session->set_flashdata('success_msg', "Warehouse Order is added successfully!");
				redirect(base_url('admin/product/orders'));


	
}

   $this->others->delete_record("product_locationwise","order_id='".$id."'");
				for($i=0;$i< count((array)$product_id);$i++){
					if($product_id[$i]!="" && $quantity[$i]!=""){
						$insert_data = array(
						'business_id'=>$b_id,	
						'location_id'=>$this->input->post('location_id_val'),
						'supplier_id'=>$this->input->post('supplier_id_val'),	
						'order_id'=>$id,
						'order_type'=>($this->input->post('action')== 'save')?1:0,
						'product_id'=>$product_id[$i],
						'ordered_qty'=>$quantity[$i],
						'purchase_price'=>$product_price[$i],
						'product_tax_amount'=>$total_tax_amount[$i],
						'product_tax '=>$ptax[$i],
						'product_tax_type'=>$ptax_type[$i],
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);
					}
				}
				
				$this->session->set_flashdata('success_msg', "Order is added successfully!");
				redirect(base_url('admin/product/orders'));
			 
		}
		
		if($admin_session['role']=="owner"){
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
				$data['all_business'] = $all_business;		
		}
		if($admin_session['role']=="business_owner" ){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$locations = $this->others->get_all_table_value("location","id,location_name","id='".$admin_session['location_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		
		//product supplier
		if($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner" ||  $admin_session['role']=="staff"){
			$suppliers = $this->others->get_all_table_value("product_supplier","*","business_id='".$admin_session['business_id']."' ","first_name","ASC");
			if($suppliers)
				$data['suppliers'] = $suppliers;	
		}
		
		//products
		/*if($admin_session['role']=="business_owner"){
			$products = $this->others->get_all_table_value("product","id,product_name","business_id='".$admin_session['business_id']."'","product_name","ASC");
			if($products)
				$data['products'] = $products;	
		}*/
		
		$data['product_active_open']=true;
		
		/* All Products */
		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$arr_search['p.business_id']= $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['p.business_id']= $admin_session['business_id'];
		}
		
		$all_products = $this->product_model->get_products(false,$arr_search,'','',"product_name","ASC");
		if($all_products){
			$data['all_products']= $all_products;		 
		}	
		
		$data['product_active_open']=true;
		$this->load->view('admin/product/edit_order', $data);
		
	}



		public function product_use_settings($select_location_id=null){

		$data = array();

		$admin_session = $this->session->userdata('admin_logged_in');

		if ($admin_session['business_id']=='') {
			//echo "hi"; exit;
			$this->session->set_flashdata('error_msg', "please select Business Owner!");
					redirect(base_url('admin/setup'));	
			
		}

		if($this->input->post('action'))
		{
			
			$this->load->library('form_validation');
		$this->form_validation->set_rules('internal_use', 'Internal Use', 'number|required|xss_clean');
			$this->form_validation->set_rules('tester_use','Tester Use',  'number|required|xss_clean');
			$product_use_id = $this->input->post('product_use_id');
			$internal_use = $this->input->post('internal_use');
			$tester_use = $this->input->post('tester_use');
			$location_id = $this->input->post('location_id');

			if ($this->form_validation->run() == TRUE && $product_use_id=='') 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'internal_use'=>$internal_use,
						'tester_use'=>$tester_use,
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("product_use_settings",$insert_data);

				$this->session->set_flashdata('success_msg', "Produc Use Limit is added successfully!");
					redirect(base_url('admin/product/product_use_settings'));				
			}


				if ($this->form_validation->run() == TRUE && $product_use_id!='') 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'internal_use'=>$internal_use,
						'tester_use'=>$tester_use,
						'date_created' => date('Y-m-d H:i:s'));

						//$this->db->set($insert_data);
				       // $this->db->where('id',$product_use_id);
				      //  $this->db->update('product_use_settings');

				        $this->others->update_common_value("product_use_settings",$insert_data,"id='".$product_use_id."' ");

				$this->session->set_flashdata('success_msg', "Product Use Limit is Updated successfully!");
					redirect(base_url('admin/product/product_use_settings'));				
			}


			
		}
		$this->db->select('*');
		$this->db->from('location');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('id',$admin_session['location_id']);
		}
		$data['location']=$this->db->get()->result_array();


		$this->db->select('*');
		$this->db->from('product_use_settings');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if (isset($select_location_id)) {
			$this->db->where('location_id',$select_location_id);
		}
		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('location_id',$admin_session['location_id']);
		}

		$data['getSetting']=$this->db->get()->row_array();
		$data['select_location_id']=$select_location_id;
		$data['admin_session']=$admin_session;
		//print_r($admin_session); exit;

			$data['setup_active_open']=true;
		$this->load->view('admin/product/product_use_settings', $data);

		
	}

	public function productUseTypes(){
		//print_r($_POST); exit;
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post())
		{
			$product_id = $this->input->post('product_id');
			$id = $product_id;
			$location_id = $this->input->post('location_id');
			
			$product_types = $this->input->post('product_types');
			$message = $this->input->post('message');
			$staff_id = $this->input->post('staff_id');
			$quantity = $this->input->post('quantity');


			$this->db->select('SUM(quantity) AS total_quantity ');
			$this->db->from('product_used');
			$this->db->where('business_id',$admin_session['business_id']);
			$this->db->where('flag_bit',1);
			$this->db->where('product_id',$product_id);
			$this->db->where('location_id',$location_id);
			$this->db->where('used_type',$product_types);
			$gettotal_quantity=$this->db->get()->row_array();
			$getCountproduct=$gettotal_quantity['total_quantity']+$quantity;
			$this->db->select('*');
			$this->db->from('product_use_settings');
			$this->db->where('business_id',$admin_session['business_id']);			
			$this->db->where('location_id',$location_id);
			$getLimitProduct=$this->db->get()->row_array();
			if (!isset($getLimitProduct)) {
				echo json_encode(array('status' => 'limit', 'response' =>  "Please Setup Open Product Limit !!"));
				exit;
			}
			if ($product_types == 1) {
				$productlimit=$getLimitProduct['internal_use'];
			}
			if ($product_types == 7) {
				$productlimit=$getLimitProduct['tester_use'];
			}			
			
			//echo $quantity.' '. $productlimit.'  '.$getCountproduct; exit;
			if($quantity <= getProductStockQtyForLocation($location_id,$product_id)){
				if($productlimit>=$getCountproduct){
					$insert_data = array(
						'used_type'=>$product_types,
						'business_id'=>$admin_session['business_id'],
						'location_id'=>$location_id,
						'product_id'=>$product_id,
						'staff_id'=>$staff_id,
						'message'=>$message,
						'quantity'=>$quantity,						
						'flag_bit'=>1,						
						'date_created'=>date('Y-m-d H:i:s'));
					$this->others->insert_data("product_used",$insert_data);
					echo json_encode(array('status' => 'success', 'response' =>  "product Use Types Data Insert successfully!"));
				}else{
					echo json_encode(array('status' => 'error', 'response' =>  "Already ".$productlimit." product opened. Please close before open new one.!!"));		
				}

				}else{
					echo json_encode(array('status' => 'error', 'response' =>  "Quantity cannot be greator then available stock!"));
		}


		}else{
			redirect(base_url('admin/product/'));
		}
	}

	public function updateProductUseTypes($id,$product_id){
		$admin_session = $this->session->userdata('admin_logged_in');
		if (isset($id)) {
			$updateData = array(
						'flag_bit' => 0,
						);

			/*$this->db->set('flag_bit',0);
			$this->db->where('id',$id);
			$this->db->update('product_used');*/
			$this->others->update_common_value("product_used",$updateData,"id='".$id."' ");

			$this->session->set_flashdata('success_msg', "Product Use Types Data close successfully!");
					redirect(base_url('admin/product/view/'.$product_id));
		}

		else{
			redirect(base_url('admin/product/'));
			$this->session->set_flashdata('error_msg','Access Denied');
		}	

	}

	public function all_expense()
	{
		$arr_search = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		$this->db->select('product_used.*,product.*');
				$this->db->from('product_used');
				$this->db->join('product','product.id=product_used.product_id','inner');
				$this->db->where('product_used.flag_bit',1);				
				if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
					$this->db->where('product_used.business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
			$this->db->where('product_used.business_id',$admin_session['business_id']);
			$this->db->where('product_used.location_id',$admin_session['location_id']);			
		}
		$data['getproduct_used']=$this->db->get()->result_array();      
		
		$data['product_active_open']=true;
		$data['admin_session']=$admin_session;
		$this->load->view('admin/product/all_expense', $data);
	}

	public function getStaffbyLocationId()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$location_id = $this->input->post('location_id');

		$this->db->select('*');
		$this->db->from('staff');
		$where = '(calendor_bookable_staff="1" or roaster_staff = "1")';		
		$this->db->where($where);
		$this->db->where('location_id',$location_id);
		$record=$this->db->get()->result_array();

		if(count((array)$record) > 0){

				$staff_html = '<select class="form-control staff"  name="staff_id" id="staff_id">';
				
				foreach($record as $cat){
					$staff_html .='<option value="'.$cat['id'].'">'.$cat['first_name']. ' ' .$cat['last_name'].'</option>';
				}
				$staff_html .='</select>';

				//echo json_encode($record);
			} else {
	           $staff_html = '<select class="form-control" name="staff_id" id="staff_id">';
				$staff_html .= '<option value="">Select Staff</option>';
				$staff_html .='</select>';
	        }
	        $status = 'success';
	         $jsonEncode = json_encode(array('status' => $status,'staff_html' => $staff_html));
                echo $jsonEncode;	
		//print_r($this->db->last_query()); exit;
		//echo json_encode($data);
		//exit;

	}

		public function pre_gst_settings($select_location_id=null){

		$data = array();

		$admin_session = $this->session->userdata('admin_logged_in');

		if ($admin_session['business_id']=='') {
			$this->session->set_flashdata('error_msg', "please select Business Owner!");
					redirect(base_url('admin/setup'));	
			
		}

		if($this->input->post('action'))
		{
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cash', 'Cash','number|required|xss_clean');
			$this->form_validation->set_rules('cards','Cards','number|required|xss_clean');
			$this->form_validation->set_rules('gift_voucher','Gift Voucher','number|required|xss_clean');
			$this->form_validation->set_rules('others','Others','number|required|xss_clean');

			$cash = $this->input->post('cash');
			$cards = $this->input->post('cards');
			$gift_voucher = $this->input->post('gift_voucher');
			$others = $this->input->post('others');
			$location_id = $this->input->post('location_id');
			$pre_gst_settings_id = $this->input->post('pre_gst_settings_id');

			if ($this->form_validation->run() == TRUE && $pre_gst_settings_id=='') 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'cash'=>$cash,
						'cards'=>$cards,
						'gift_voucher'=>$gift_voucher,
						'others'=>$others,
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("pre_gst_settings",$insert_data);

				$this->session->set_flashdata('success_msg', "Pre Gst Settings is added successfully!");
					redirect(base_url('admin/product/pre_gst_settings/'.$location_id));				
			}


				if ($this->form_validation->run() == TRUE && $pre_gst_settings_id>0) 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'cash'=>$cash,
						'cards'=>$cards,
						'gift_voucher'=>$gift_voucher,
						'others'=>$others,
						'date_created' => date('Y-m-d H:i:s'));

						/*$this->db->set($insert_data);
				        $this->db->where('id',$pre_gst_settings_id);
				        $this->db->update('pre_gst_settings');*/

	$this->others->update_common_value("pre_gst_settings",$insert_data,"id='".$pre_gst_settings_id."' ");


				$this->session->set_flashdata('success_msg', "Pre Gst Settings is Updated successfully!");
					redirect(base_url('admin/product/pre_gst_settings/'.$location_id));				
			}


			
		}
		$this->db->select('*');
		$this->db->from('location');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('id',$admin_session['location_id']);
		}
		$data['location']=$this->db->get()->result_array();


		$this->db->select('*');
		$this->db->from('pre_gst_settings');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if (isset($select_location_id)) {
			$this->db->where('location_id',$select_location_id);
		}
		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('location_id',$admin_session['location_id']);
		}

		$data['getSetting']=$this->db->get()->row_array();
		$data['select_location_id']=$select_location_id;
		$data['admin_session']=$admin_session;
		//print_r($admin_session); exit;

			$data['setup_active_open']=true;

		$this->load->view('admin/product/pre_gst_settings', $data);

		
	}


	public function gst_ato_settings($select_location_id=null){

		$data = array();

		$admin_session = $this->session->userdata('admin_logged_in');

		if ($admin_session['business_id']=='') {
			$this->session->set_flashdata('error_msg', "please select Business Owner!");
					redirect(base_url('admin/setup'));	
			
		}

		if($this->input->post('action'))
		{
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cash', 'Cash','number|required|xss_clean');
			$this->form_validation->set_rules('cards','Cards','number|required|xss_clean');
			$this->form_validation->set_rules('gift_voucher','Gift Voucher','number|required|xss_clean');
			$this->form_validation->set_rules('others','Others','number|required|xss_clean');

			$cash = $this->input->post('cash');
			$cards = $this->input->post('cards');
			$gift_voucher = $this->input->post('gift_voucher');
			$others = $this->input->post('others');
			$location_id = $this->input->post('location_id');
			$pre_gst_settings_id = $this->input->post('pre_gst_settings_id');

			if ($this->form_validation->run() == TRUE && $pre_gst_settings_id=='') 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'cash'=>$cash,
						'cards'=>$cards,
						'gift_voucher'=>$gift_voucher,
						'others'=>$others,
						'date_created' => date('Y-m-d H:i:s'));
						$this->others->insert_data("gst_ato_settings",$insert_data);

				$this->session->set_flashdata('success_msg', "Gst Ato Settings is added successfully!");
					redirect(base_url('admin/product/gst_ato_settings/'.$location_id));				
			}


				if ($this->form_validation->run() == TRUE && $pre_gst_settings_id>0) 
			{
				$insert_data = array(
						'business_id'=>$admin_session['business_id'],	
						'location_id'=>$location_id,
						'cash'=>$cash,
						'cards'=>$cards,
						'gift_voucher'=>$gift_voucher,
						'others'=>$others,
						'date_created' => date('Y-m-d H:i:s'));

						/*$this->db->set($insert_data);
				        $this->db->where('id',$pre_gst_settings_id);
				        $this->db->update('gst_ato_settings');
*/
				        $this->others->update_common_value("gst_ato_settings",$insert_data,"id='".$pre_gst_settings_id."' ");

				$this->session->set_flashdata('success_msg', "Gst Ato Settings is Updated successfully!");
					redirect(base_url('admin/product/gst_ato_settings/'.$location_id));				
			}


			
		}
		$this->db->select('*');
		$this->db->from('location');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('id',$admin_session['location_id']);
		}
		$data['location']=$this->db->get()->result_array();


		$this->db->select('*');
		$this->db->from('gst_ato_settings');
		if ($admin_session['business_id']!='') {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		if (isset($select_location_id)) {
			$this->db->where('location_id',$select_location_id);
		}
		if ($admin_session['role']=='location_owner' || $admin_session['role']=="staff") {
			$this->db->where('location_id',$admin_session['location_id']);
		}

		$data['getSetting']=$this->db->get()->row_array();
		$data['select_location_id']=$select_location_id;
		$data['admin_session']=$admin_session;
		//print_r($admin_session); exit;

			$data['setup_active_open']=true;

		$this->load->view('admin/product/gst_ato_settings', $data);

		
	}


	public function getwarehouseProductInventryDetails($product_id,$warehouse_id,$type)
	{
		$data = array();
		if($type=="stockin"){
			$dd = $this->db->select('*,warehouse_quantity AS quantity ')->from('product_warehousewise')
				->where(['order_type !='=>2,'warehouse_id'=>$warehouse_id,'product_id'=>$product_id])
				->get()->result_array();
			$data['type'] = $type;	
		}
		else{
			$dd = $this->db->select('*')->from('product_warehouse_used')
				->where(['warehouse_id'=>$warehouse_id,'product_id'=>$product_id])
				->get()->result_array();
			$data['type'] = $type;	
			//print_r($this->db->last_query()); exit;
		}

		$data['data']	= $dd;
		return $this->load->view('admin/product/product_inventry_detail', $data);
	}


	public function getProductWarehouseId()
	{	

		$warehouse_id = $this->input->post('warehouse_id');
		$type = $this->input->post('type');
		$warehouse_id=preg_replace('/[^0-9]+/', '', $warehouse_id);
		$this->db->select("p.*,c.category_name,b.brand_name,s.first_name,s.last_name");
		$this->db->from('product p');
		$this->db->join('product_category c', 'p.category_id = c.id','left');
		$this->db->join('product_brand b', 'p.brand_id = b.id','left');
		$this->db->join('product_supplier s', 'p.supplier_id = s.id','left');
		if ($type=='w') {
		$this->db->join('product_warehousewise w', 'p.id = w.product_id','inner');		
			$this->db->where('w.warehouse_id',$warehouse_id);
		}

		elseif($type=='l') {
			$this->db->join('product_locationwise l', 'p.id = l.product_id','inner');
				$this->db->where("l.location_id",$warehouse_id);
				$this->db->where("l.quantity >",0);
				

		}
		$this->db->where('p.status !=',2);
		$this->db->group_by('p.id');
		$warehousedetails=$this->db->get()->result_array();
		$arr=array();
		foreach($warehousedetails as $data){
				$arr[]=$data['product_name'];
			}
			echo json_encode($arr);
	}


	public function getProductquantity()
	{	
		//print_r($_POST); exit;
		$warehouse_id = $this->input->post('warehouse_id');
		$type = $this->input->post('type');
		$product_id = $this->input->post('product_id');
		
		$warehouse_id=preg_replace('/[^0-9]+/', '', $warehouse_id);				
		if ($type=='w') {
			$this->db->select('sum(w.warehouse_quantity) AS quantity,w.warehouse_id,p.id ');
		$this->db->from('product p');
		$this->db->join('product_warehousewise w', 'p.id = w.product_id','inner');		
			$this->db->where('w.warehouse_id',$warehouse_id);
			$this->db->where("p.id",$product_id);

		}
		elseif($type=='l') {
				$this->db->select('sum(l.quantity) AS quantity, l.location_id,p.id');
				$this->db->from('product p');
				$this->db->join('product_locationwise l', 'p.id = l.product_id','inner');
				$this->db->where("l.location_id",$warehouse_id);
				$this->db->where("p.id",$product_id);				

		}
		$this->db->where('p.status !=',2);
		$this->db->group_by('p.id');
		$product_detail=$this->db->get()->row_array();

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


		$quantity=$product_detail['quantity']-$used_quantity;
		
			echo json_encode($quantity);
	}

		public function product_unit_setting(){
			$admin_session = $this->session->userdata('admin_logged_in');			
			$data['admin_session'] = $admin_session;			
			$data['product_unit']=$this->db->select('*')->from('product_unit_setting')->where('business_id',$admin_session['business_id'])->get()->result_array();
			if($this->input->post('action')){
				$product_unit = $this->input->post('product_unit');
				$product_unit_id = $this->input->post('product_unit_id');
				 $this->others->delete_mutiple_record("product_unit_setting","business_id='".$admin_session['business_id']."'","id",$product_unit_id);				
				foreach ($product_unit as $key => $value) {
					$insert_array = array(
					"business_id"=>$admin_session['business_id'],					
					"product_unit"=>$product_unit[$key],					
					"date_updated"=>date('Y-m-d H:i:s'));
					if ($product_unit_id[$key]>0) {
						$this->others->update_common_value("product_unit_setting",$insert_array,"id='".$product_unit_id[$key]."' ");
					}
					else{						
					$this->others->insert_data("product_unit_setting",$insert_array);

					}
					
				}				
				$this->session->set_flashdata('success_msg', "Information saved successfully.");
				return redirect(base_url('admin/product/product_unit_setting'));
			}
			
			$this->load->view('admin/product/product_unit_setting',$data);
		}



		public function product_weight_scale_setting(){
			$admin_session = $this->session->userdata('admin_logged_in');			
			$data['admin_session'] = $admin_session;			
			$data['product_unit']=$this->db->select('*')->from('product_weight_scale_setting')->where('business_id',$admin_session['business_id'])->get()->result_array();
			if($this->input->post('action')){
				$product_scale = $this->input->post('product_scale');
				$product_scale_description = $this->input->post('product_scale_description');
				$product_scale_id = $this->input->post('product_scale_id');
				//echo count((array)$product_scale_id); exit;
				if (count((array)$product_scale_id)>0) {
					 $this->others->delete_mutiple_record("product_weight_scale_setting","business_id='".$admin_session['business_id']."'","id",$product_scale_id);
				}
								
				foreach ($product_scale as $key => $value) {
					$insert_array = array(
					"business_id"=>$admin_session['business_id'],					
					"product_scale"=>$product_scale[$key],
					"product_scale_description"=>$product_scale_description[$key],		
					"date_updated"=>date('Y-m-d H:i:s'));
					if ($product_scale_id[$key]>0) {
						$this->others->update_common_value("product_weight_scale_setting",$insert_array,"id='".$product_scale_id[$key]."' ");
					}
					else{						
					$this->others->insert_data("product_weight_scale_setting",$insert_array);

					}
					
				}				
				$this->session->set_flashdata('success_msg', "Information saved successfully.");
				return redirect(base_url('admin/product/product_weight_scale_setting'));
			}
			
			$this->load->view('admin/product/product_weight_scale_setting',$data);
		}



		public function product_distribution(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post())
		{	
			$product_id = $this->input->post('product_id');
			$id = $product_id;
			$location_id = $this->input->post('location_id');
			$quantity = $this->input->post('quantity');
			$reason = $this->input->post('reason');
			$message = $this->input->post('message');
			$product_detail = $this->others->get_all_table_value("product","*","id='".$product_id."'");
			$location_id_type=substr($location_id,0,1);

			//Warehouse Distribution
			if ($location_id_type=='w') {
				$warehouse_id=preg_replace('/[^0-9]+/', '', $location_id);
			if($quantity <= getProductStockQtyForWarehouse($warehouse_id,$product_id)){
			if( ($admin_session['role']=='owner') or ($admin_session['role']=='location_owner') or ( ($admin_session['business_id']==$product_detail[0]['business_id']) && ($admin_session['role']=='business_owner') ) )
			{
				if($quantity>0){


					$insert_data = array(
						'used_type'=>$reason,
						'business_id'=>$product_detail[0]['business_id'],
						'warehouse_id'=>$warehouse_id,
						'product_id'=>$product_id,
						'quantity'=>$quantity,
						'message'=>$message,
						'date_created'=>date('Y-m-d H:i:s'));
					$this->others->insert_data("product_warehouse_used",$insert_data);

					$totalquantity=$quantity*$product_detail[0]['box_product_unit'];
					$box_product_id=$quantity*$product_detail[0]['box_product_id'];
				$pre_quantity =getProductStockQtyForWarehouse($warehouse_id,$product_id);
				$avl_quantity = $pre_quantity-$quantity;
					$insert_data = array(
							'order_type'=>4,
							'business_id'=>$product_detail[0]['business_id'],
							'warehouse_id'=>$warehouse_id,
							'supplier_id'=>$product_detail[0]['supplier_id'],
							'product_id'=>$box_product_id,
							'warehouse_quantity'=>$totalquantity,
							'stockin_reason'=>$reason,
							'stockin_message'=>$message,
							'date_created'=>date('Y-m-d H:i:s'));
						$this->others->insert_data("product_warehousewise",$insert_data);

					$this->session->set_flashdata('success_msg', "Stock quantity updated successfully!");
					redirect(base_url('admin/product/view/'.$id));
				}else{
					$this->session->set_flashdata('error_msg', "Quantity must be greator then 0");
					redirect(base_url('admin/product/view/'.$id));
				}
			}else{
				$this->session->set_flashdata('error_msg', "Access Denied!");
				redirect(base_url('admin/product/'));
			}
		}else{
				$this->session->set_flashdata('error_msg', "Quantity cannot be greator then available stock!");
				redirect(base_url('admin/product/view/'.$id));
		}

				
			}

			//End

			//location Distribuation 
			if ($location_id_type=='l') {
				$location_id=preg_replace('/[^0-9]+/', '', $location_id);
				if($quantity <= getProductStockQtyForLocation($location_id,$product_id)){
			if( ($admin_session['role']=='owner') or ($admin_session['role']=='location_owner') or ( ($admin_session['business_id']==$product_detail[0]['business_id']) && ($admin_session['role']=='business_owner') ) )
			{
				if($quantity>0){


					$insert_data = array(
						'used_type'=>$reason,
						'business_id'=>$product_detail[0]['business_id'],
						'location_id'=>$location_id,
						'product_id'=>$product_id,
						'quantity'=>$quantity,
						'message'=>$message,
						'date_created'=>date('Y-m-d H:i:s'));
					$this->others->insert_data("product_used",$insert_data);

					$totalquantity=$quantity*$product_detail[0]['box_product_unit'];
					$box_product_id=$quantity*$product_detail[0]['box_product_id'];
				$pre_quantity =getProductStockQtyForLocation($location_id,$product_id);
				$avl_quantity = $pre_quantity-$quantity;
					$insert_data = array(
							'order_type'=>4,
							'business_id'=>$product_detail[0]['business_id'],
							'location_id'=>$location_id,
							'supplier_id'=>$product_detail[0]['supplier_id'],
							'product_id'=>$box_product_id,
							'quantity'=>$totalquantity,
							'stockin_reason'=>$reason,
							'stockin_message'=>$message,
							'date_created'=>date('Y-m-d H:i:s'));
						$this->others->insert_data("product_locationwise",$insert_data);

					$this->session->set_flashdata('success_msg', "Stock quantity updated successfully!");
					redirect(base_url('admin/product/view/'.$id));
				}else{
					$this->session->set_flashdata('error_msg', "Quantity must be greator then 0");
					redirect(base_url('admin/product/view/'.$id));
				}
			}else{
				$this->session->set_flashdata('error_msg', "Access Denied!");
				redirect(base_url('admin/product/'));
			}
		}else{
				$this->session->set_flashdata('error_msg', "Quantity cannot be greator then available stock!");
				redirect(base_url('admin/product/view/'.$id));
		}

				
			}

			



			
		}else{
			redirect(base_url('admin/product/'));
		}
	}





}
