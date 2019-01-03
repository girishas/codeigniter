<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {
	 
	 public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('business_model', '', TRUE);
		$this->load->model('user_model', '', TRUE);
        $admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['admin_email'] =='') {
			redirect(base_url('admin'));
	    }
    }

    private function __clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    } 
	 
	public function index()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$arr_search = array();
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
			}elseif($admin_session['role']=="location_owner"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("business","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Business has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No business are selected to delete!");
			}	
			redirect(base_url('admin/business'));			
		}
		

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('staff') .'?'.$get_string;
		
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
         
		if($this->input->get('customer_search')){
			$customer_name = $this->input->get('customer_search');
			$customer_name = explode(" ",$customer_name);
			$search_first_name = trim($customer_name[0]);
			$search_last_name = trim($customer_name[1]);
			if(!empty($search_first_name))
				$arr_search['first_name'] = $search_first_name;
			if(!empty($search_last_name))
				$arr_search['last_name'] = $search_last_name;
		}		 
		
		if($admin_session['role']=="business_owner"){
			$arr_search['business_id'] = $admin_session['business_id'];
		}
		if($admin_session['role']=="location_owner"){
			//$arr_search['location_id'] = $admin_session['location_id'];
			$arr_search['business_id'] = $admin_session['business_id'];
		}
		 		
		$all_business = $this->business_model->get_business(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_business){
			$data['all_business']= $all_business;
			$count_all_records = $this->business_model->get_business(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);

		
		$data['business_active_open']=true;
		$this->load->view('admin/business/all_business', $data);
	}


	public function add_business()
	{

		if($this->input->post('action')){
			//gs($_FILES['logo']);die;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admin_users.email]');
			//$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('passwd', 'Password', 'trim|required||min_length[4]|max_length[12]');
			$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('owner_first_name', 'Owner first name', 'trim|required|xss_clean');

		$this->form_validation->set_rules('abn_number', 'ABN Number', 'trim|required|xss_clean');
			$data['abn_number'] = $this->input->post('abn_number');
			$data['name'] = $this->input->post('name');
			$data['email'] = $this->input->post('email');
			$data['address1'] = $this->input->post('address1');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['website'] = $this->input->post('website');
			$data['phone_number'] = $this->input->post('phone_number');
			$data['owner_first_name'] = $this->input->post('owner_first_name');
			$data['owner_last_name'] = $this->input->post('owner_last_name');
			$data['business_category_id'] = $this->input->post('business_category_id');
			$data['country_id'] = $this->input->post('country_id');
			$data['post_code'] = $this->input->post('post_code');
			$data['currency_id'] = $this->input->post('currency_id');
			$data['time_zone_id'] = $this->input->post('time_zone_id');
			$data['time_format'] = $this->input->post('time_format');
			$data['description'] = $this->input->post('description');
			$data['logo'] = $this->input->post('logo');
			$data['facebook_url'] = $this->input->post('facebook_url');
			$data['twitter_url'] = $this->input->post('twitter_url');

			if ($this->form_validation->run() == TRUE) {

				$picture = "";
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
					if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
						$this->load->library('image_lib');
						$uploadDir = $this->config->item('physical_url') . 'images/staff/';
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
				
				
				$insert_data = array(
					'abn_number'=>$this->input->post('abn_number'),
					'name'=>$this->input->post('name'),
					'email'=>$this->input->post('email'),
					'password'=>$this->input->post('passwd'),
					'address1'=>$this->input->post('address1'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'website'=>$this->input->post('website'),
					'phone_number'=>$this->input->post('phone_number'),
					'owner_first_name'=>$this->input->post('owner_first_name'),
					'owner_last_name'=>$this->input->post('owner_last_name'),
					'business_category_id'=>$this->input->post('business_category_id'),
					'country_id'=>$this->input->post('country_id'),
					'post_code'=>$this->input->post('post_code'),
					'currency_id'=>$this->input->post('currency_id'),
					'time_zone_id'=>$this->input->post('time_zone_id'),
					'time_format'=>$this->input->post('time_format'),
					'description'=>$this->input->post('description'),
					'logo'=>$picture,
					'facebook_url'=>$this->input->post('facebook_url'),
					'twitter_url'=>$this->input->post('twitter_url'),
					'date_created' => date('Y-m-d H:i:s'));

				$success = $this->others->insert_data("business",$insert_data);
				if ($success) {
					$admin_name = $this->input->post('owner_first_name');
					if(!empty($this->input->post('owner_last_name'))){
						$admin_name .=' '.$this->input->post('owner_last_name');
					}
					$insert_id = $success;
					//Create a business owner account
					$insert_admin = array(
						'email'=>$this->input->post('email'),
						'password'=>md5($this->input->post('passwd')),
						'admin_name'=>$admin_name,
						'role'=>'business_owner',
						'business_id'=>$insert_id,
						'date_created' => date('Y-m-d H:i:s'),
						'trial_expire_date' => date("Y-m-d", strtotime('+14 days',time())),
						'payment_status'=>0,
						'status'=>1
					);
				    $this->others->insert_data("admin_users",$insert_admin);
					
					
					$this->session->set_flashdata('success_msg', "Business is added successfully!");
					redirect(base_url('admin/business'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding business is failed!");
					redirect(base_url('admin/business/add_business'));
				}
			}
		}
		
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		
		$all_categories = $this->others->get_all_table_value("business_category","id,name","","name","ASC");
		if($all_categories) {
			$data['all_categories'] = $all_categories;
		}
		
		$all_currency = $this->others->get_all_table_value("currency","id,symbol,name","","name","ASC");
		if($all_currency) {
			$data['all_currency'] = $all_currency;
		}

		//Get Time Zones List
		$dbtimeZones = $this->others->get_all_table_value("time_zones","*","","id","ASC");
		//print_r($dbtimeZones);die;

		$timezone_offsets = array();
		foreach($dbtimeZones as $key => $singleZone)
		{
			$tz = new DateTimeZone($singleZone['name']);
        	$timezone_offsets[$singleZone['id']."_".$singleZone['name']] = $tz->getOffset(new DateTime);
        	//print_r($singleZone['id']."_".$singleZone['name']);die;
		}
		asort($timezone_offsets);
		
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{	$timezone = explode('_',$timezone);
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone[0]] = "(${pretty_offset}) $timezone[1]";
		}
		$data['time_zones'] = $timezone_list;
		
		$data['business_active_open']=true;
		$this->load->view('admin/business/add_business', $data);
	}
	
	public function edit_business($id='')
	{
		if ($id != '' && is_numeric($id)) {			
			$business_detail = $this->others->get_all_table_value("business","*","id='".$id."'");
			if($business_detail){
				if($this->input->post('action')){					
					$data['name'] = $this->input->post('name');
					$data['email'] = $this->input->post('email');
					$data['password'] = $this->input->post('passwd');
					$data['address1'] = $this->input->post('address1');
					$data['city'] = $this->input->post('city');
					$data['state'] = $this->input->post('state');
					$data['website'] = $this->input->post('website');
					$data['phone_number'] = $this->input->post('phone_number');
					$data['owner_first_name'] = $this->input->post('owner_first_name');
					$data['owner_last_name'] = $this->input->post('owner_last_name');
					$data['business_category_id'] = $this->input->post('business_category_id');
					$data['country_id'] = $this->input->post('country_id');
					$data['post_code'] = $this->input->post('post_code');
					$data['currency_id'] = $this->input->post('currency_id');
					$data['time_zone_id'] = $this->input->post('time_zone_id');
					$data['time_format'] = $this->input->post('time_format');
					$data['description'] = $this->input->post('description');
					$data['logo'] = $this->input->post('logo');
					$data['facebook_url'] = $this->input->post('facebook_url');
					$data['twitter_url'] = $this->input->post('twitter_url');
					$data['abn_number'] = $this->input->post('abn_number');

			
			
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					// $this->form_validation->set_rules('passwd', 'Password', 'trim|required|xss_clean');
					$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
					$this->form_validation->set_rules('owner_first_name', 'Owner first name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('abn_number', 'ABN Number', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {
						$picture = "";
						if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
							if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
								$this->load->library('image_lib');
								$uploadDir = $this->config->item('physical_url') . 'images/staff/';
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
								if(file_exists($uploadDir.'thumb/'.$staff_detail[0]['picture'])){
									unlink($uploadDir.'thumb/'.$staff_detail[0]['picture']);							
								}
								if(file_exists($uploadDir.$imgname)){
									unlink($uploadDir.$imgname);						
								}
							}
						}
						$update_data['abn_number'] = $this->input->post('abn_number');
						$update_data['name'] = $this->input->post('name');
						$update_data['email'] = $this->input->post('email');
						$update_data['password'] = $this->input->post('passwd');
						$update_data['address1'] =$this->input->post('address1');
						$update_data['city'] = $this->input->post('city');
						$update_data['state'] =  $this->input->post('state');
						$update_data['website'] =  $this->input->post('website');
						$update_data['phone_number'] = $this->input->post('phone_number');
						$update_data['owner_first_name'] = $this->input->post('owner_first_name');
						$update_data['owner_last_name'] = $this->input->post('owner_last_name');
						$update_data['business_category_id'] = $this->input->post('business_category_id');
						$update_data['country_id'] = $this->input->post('country_id');
						$update_data['post_code'] = $this->input->post('post_code');
						$update_data['currency_id'] = $this->input->post('currency_id');
						$update_data['time_zone_id'] = $this->input->post('time_zone_id');
						$update_data['time_format'] =  $this->input->post('time_format');
						$update_data['description'] = $this->input->post('description');
						$update_data['logo'] = $picture;
						$update_data['facebook_url'] = $this->input->post('facebook_url');
						$update_data['twitter_url'] = $this->input->post('twitter_url');
											
						$success = $this->others->update_common_value("business",$update_data,"id='".$id."' ");
						if($success == true){
							$admin_name = $this->input->post('owner_first_name');
							if(!empty($this->input->post('owner_last_name'))){
								$admin_name .=' '.$this->input->post('owner_last_name');
							}
							
							//Update a business owner account
							$update_admin = array(
								'email'=>$this->input->post('email'),
								'password'=>md5($this->input->post('passwd')),
								'admin_name'=>$admin_name,
								'role'=>'business_owner',
								'business_id'=>$id);


						    $this->others->update_common_value("admin_users",$update_admin,"business_id='".$id."' ");

						    $this->session->set_flashdata('success_msg', "Business is updated successfully!");
							redirect(base_url('admin/business'));
						}
						
					}
				}
				$data['business_detail'] = $business_detail;
			}
		}
		
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		
		$all_categories = $this->others->get_all_table_value("business_category","id,name","","name","ASC");
		if($all_categories) {
			$data['all_categories'] = $all_categories;
		}
		
		$all_currency = $this->others->get_all_table_value("currency","id,symbol,name","","name","ASC");
		if($all_currency) {
			$data['all_currency'] = $all_currency;
		}
		
		//Get Time Zones List
		$dbtimeZones = $this->others->get_all_table_value("time_zones","*","","id","ASC");
		//print_r($dbtimeZones);die;

		$timezone_offsets = array();
		foreach($dbtimeZones as $key => $singleZone)
		{
			$tz = new DateTimeZone($singleZone['name']);
        	$timezone_offsets[$singleZone['id']."_".$singleZone['name']] = $tz->getOffset(new DateTime);
        	//print_r($singleZone['id']."_".$singleZone['name']);die;
		}
		asort($timezone_offsets);
		
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{	$timezone = explode('_',$timezone);
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone[0]] = "(${pretty_offset}) $timezone[1]";
		}
		$data['time_zones'] = $timezone_list;

		$data['business_active_open']=true;
		$this->load->view('admin/business/edit_business', $data);
	}


	public function taxes()
	{

		$data = array();
		$admin_session = $this->session->userdata('admin_logged_in');
		//print_r($admin_session);die();

		if($this->input->post('invoice_tax'))
		{
			$this->load->library('form_validation');
			
			if($admin_session['role'] == 'owner'){
				$this->form_validation->set_rules('business_id1', 'Business', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('tax_service_percent', 'Tax service percent', 'trim|required|xss_clean');
			$this->form_validation->set_rules('tax_service_method', 'Tax service method', 'trim|required|xss_clean');
			
			
			if ($this->form_validation->run() == TRUE) 
			{
				$updateData = array(
					'tax_service_percent' 	=> $this->input->post('tax_service_percent'),
					'tax_service_method' 	=> $this->input->post('tax_service_method'),
				);

				if($admin_session['role'] == 'owner')
				{
					echo $id = $this->input->post('business_id1');
				}
				if($admin_session['role'] == 'business_owner')
				{
					$id = $admin_session['business_id'];
				}
				//print_r($updateData);die;
				
				$success = $this->others->update_common_value("business",$updateData,"id='".$id."' ");

				if($success){
					$this->session->set_flashdata('success_msg', "Tax on Service and Invoicing is updated successfully!");
					//redirect(base_url('admin/business/taxes'));
				}
				
			}
		}

		

		$data['business_id1'] = $this->input->post('business_id1');
		$data['tax_service_percent'] = $this->input->post('tax_service_percent');
		$data['tax_service_method'] = $this->input->post('tax_service_method');

		
		// get all business
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business) {
			$data['all_business'] = $all_business;
		}

		// get single record if business owner
		if($admin_session['role'] == 'business_owner')
		{
			$id = $admin_session['business_id'];
			if(!empty($id)){
				$business_details = $this->others->get_all_table_value("business","*","id='".$id."'");
				$data['business_details'] = $business_details;
			}
		}

		
		//print_r($business_details[0]);die;

		$data['setup_active_open'] = true;
		$this->load->view('admin/business/taxes', $data);
		
	}
	
	
	
	public function locations()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$this->load->library('pagination');
		$arr_search = array();		
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
			}elseif($admin_session['role']=="location_owner"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("location","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Location has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No location are selected to delete!");
			}	
			redirect(base_url('admin/business/locations'));			
		}


        
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/business/locations') .'?'.$get_string;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['business_id'] = $business_id;
			$business_detail = $this->others->get_all_table_value("business","id,name","id='".$business_id."' ");
			if($business_detail){
				$data['business_detail'] = $business_detail;
			}
        } 

        if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
        {
        	$arr_search['business_id'] = $admin_session['business_id'];
        }elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
        	$arr_search['business_id'] = $admin_session['business_id'];
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;				
        		
		
		$all_records = $this->business_model->get_business_locations(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->business_model->get_business_locations(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/business/all_locations', $data);
	}
	
	public function add_location()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($this->input->post('action')){
			
			$data['business_id'] = $this->input->post('business_id');
			$data['email'] = $this->input->post('email');
			$data['location_name'] = $this->input->post('location_name');
			$data['phone_number'] = $this->input->post('phone_number');
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['postcode'] = $this->input->post('postcode');
			$data['weekday'] = $weekday= $this->input->post('weekday');
			$data['start_time'] = $start_time= $this->input->post('start_time');
			$data['end_time'] = $end_time= $this->input->post('end_time');

			
			$this->load->library('form_validation');
			if($admin_session['role']=="owner"){
				$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('email', 'Email Field', 'required|email|valid_email|is_unique[location.email]');
			$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {															
				
				if($admin_session['role']=="business_owner")
					$business_id = $admin_session['business_id'];
				else
					$business_id = $this->input->post('business_id');
				
				$insert_data = array(
					'business_id'=>$business_id,
					'location_name'=>$this->input->post('location_name'),
					'phone_number'=>$this->input->post('phone_number'),
					'email'=>$this->input->post('email'),
					'address1'=>$this->input->post('address1'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'postcode'=>$this->input->post('postcode'),
					'timezone_id'=>$this->input->post('timezone_id'),
					'date_created' => date('Y-m-d H:i:s'));
				
				$success = $this->others->insert_data("location",$insert_data);

				$location_id=$success;
				//echo count((array)$weekdaya); exit;
				for ($i=0; $i <count((array)$weekday) ; $i++) { 
					$insert_data = array(
					'business_id'=>$business_id,
					'location_id'=>$location_id,
					'weekday'=>$weekday[$i],
					'start_time'=>$start_time[$i],
					'end_time'=>$end_time[$i],
					'created_date' => date('Y-m-d H:i:s'));				
				$success = $this->others->insert_data("location_weekdays",$insert_data);
				}

				if ($success) {
					$this->session->set_flashdata('success_msg', "Location is added successfully!");
					redirect(base_url('admin/business/locations'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding location is failed!");
					redirect(base_url('admin/business/add_location'));
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
		$data['timezones'] = $this->db->select('*')->from('time_zones')->get()->result_array();
		$data['setup_active_open']=true;
		$this->load->view('admin/business/add_location', $data);
	}
	
	public function edit_location($id="")
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if ($id != '' && is_numeric($id)) {			
			$location_detail = $this->others->get_all_table_value("location","*","id='".$id."'");
			if($location_detail){
				if($this->input->post('action')){

					//print_r($this->input->post('location_weekdays_id')); exit;

					$data['email'] = $email = $this->input->post('email');
					$data['timezone_id'] = $timezone_id = $this->input->post('timezone_id');
					$data['business_id'] = $this->input->post('business_id');			
					$data['business_id'] = $this->input->post('business_id');
					$data['location_name'] = $this->input->post('location_name');
					$data['phone_number'] = $this->input->post('phone_number');
					$data['address1'] = $this->input->post('address1');
					$data['address2'] = $this->input->post('address2');
					$data['city'] = $this->input->post('city');
					$data['state'] = $this->input->post('state');
					$data['postcode'] = $this->input->post('postcode');
					$data['weekday'] = $weekday= $this->input->post('weekday');
					$data['start_time'] = $start_time= $this->input->post('start_time');
					$data['end_time'] = $end_time= $this->input->post('end_time');
					$data['location_weekdays_id'] = $location_weekdays_id= $this->input->post('location_weekdays_id');
					
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|edit_unique[location.email.'.$id.']');
					
					$this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required|xss_clean');
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					
					if ($this->form_validation->run() == TRUE) {	

						if($admin_session['role']=="owner"){
							$update_data['business_id'] =$business_id= $this->input->post('business_id');
						}else{
							$update_data['business_id'] =$business_id= $admin_session['business_id'];
						}
						$update_data['email'] = $this->input->post('email');
						$update_data['location_name'] = $this->input->post('location_name');
						$update_data['phone_number'] = $this->input->post('phone_number');
						$update_data['address1'] =$this->input->post('address1');
						$update_data['address2'] = $this->input->post('address2');
						$update_data['city'] = $this->input->post('city');
						$update_data['state'] =  $this->input->post('state');						
						$update_data['postcode'] =  $this->input->post('postcode');
						$update_data['timezone_id'] =  $this->input->post('timezone_id');
						$success = $this->others->update_common_value("location",$update_data,"id='".$id."' ");
						
						if (!$location_weekdays_id) {
					for ($i=0; $i <count((array)$weekday) ; $i++) {
					$insert_data = array(
					'business_id'=>$business_id,
					'location_id'=>$id,
					'weekday'=>$weekday[$i],
					'start_time'=>$start_time[$i],
					'end_time'=>$end_time[$i],
					'created_date' => date('Y-m-d H:i:s'));				
				$success = $this->others->insert_data("location_weekdays",$insert_data);
							
						}
					}
						elseif (isset($location_weekdays_id)){
							for ($i=0; $i <count((array)$weekday) ; $i++) {
					$data = array(					
					'weekday'=>$weekday[$i],
					'start_time'=>$start_time[$i],
					'end_time'=>$end_time[$i],
				);
					$this->db->where('location_id', $id);
					$this->db->where('id', $location_weekdays_id[$i]);					
					$this->db->update('location_weekdays', $data);
				}
			}
					


						$this->session->set_flashdata('success_msg', "Location is updated successfully!");
						redirect(base_url('admin/business/locations'));
					}
				}
				$data['location_detail'] = $location_detail;
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

		$this->db->select('*');
		$this->db->from('location_weekdays');
		$this->db->where('location_id',$id);
		$data['location_weekdays']=$location_weekdays=$this->db->get()->result_array();

		$data['timezones'] = $this->db->select('*')->from('time_zones')->get()->result_array();
		$data['setup_active_open']=true;
		$this->load->view('admin/business/edit_location', $data);
	}
	
	public function categories()
	{
		$data['setup_active_open']=true;
		$this->load->library('pagination');
		
		$arr_search = array();		
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
			}elseif($admin_session['role']=="location_owner"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";

			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("business_category","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Business category has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No business category are selected to delete!");
			}	
			redirect(base_url('admin/business/categories'));			
		}

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/business/categories') .'?'.$get_string;
		
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
        		
		$arr_search = array();
		$all_categories = $this->business_model->get_business_categories(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_categories){
			$data['all_categories']= $all_categories;
			$count_all_categories = $this->business_model->get_business_categories(true,$arr_search);
            $config['total_rows'] = $count_all_categories;
			$data['total_records'] = $count_all_categories;
		}
		$this->pagination->initialize($config);
		
		$data['settings_active_open']=true;
		$this->load->view('admin/business/all_categories', $data);
	}
	
	public function add_category()
	{
		$data = array();
		$data['setup_active_open']=true;
		if($this->input->post('action')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category_name', 'Category name', 'trim|required|xss_clean');
			$category_name = $this->input->post('category_name');
			if ($this->form_validation->run() == TRUE) {
				$insert_data = array('name'=>$category_name,
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("business_category",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Category is added successfully!");
					redirect(base_url('admin/business/categories'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding category is failed!");
					redirect(base_url('admin/business/add_category'));
				}
			}
		}
		$data['settings_active_open']=true;
		$this->load->view('admin/business/add_category', $data);
	}
	
	public function edit_category($id='')
	{
		if ($id != '' && is_numeric($id)) {			
			$category_detail = $this->others->get_all_table_value("business_category","*","id='".$id."'");
			if($category_detail){
				if($this->input->post('action')){					
					$category_name = $this->input->post("category_name");
					$data['category_name'] = $category_name;
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('category_name', 'Category name', 'trim|required|xss_clean');
					
					if ($this->form_validation->run() == TRUE) {
						$update_data = array('name'=>$category_name);					
						$success = $this->others->update_common_value("business_category",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "Category is updated successfully!");
						redirect(base_url('admin/business/categories'));
					}
				}
				$data['category_detail'] = $category_detail;
			}
		}
		$data['settings_active_open']=true;
		$this->load->view('admin/business/edit_category', $data);
	}
	
	public function company_detail()
	{
		$data['business_details'] = [];
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","country_id,name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		
		//Get Session data
		$admin_session = $this->session->userdata('admin_logged_in');
		if(empty($admin_session)) redirect('admin');
		
		//Get Business Details
		$getBusinessDeatils = $this->others->get_all_table_value("business","*","id='".$admin_session['business_id']."'");
		if($getBusinessDeatils)  
		$data['business_details'] = $getBusinessDeatils[0];
		
		//Get Business Categories
		$all_categories = $this->business_model->get_business_categories();
		$data['business_cats'] = $all_categories;
		
		//Get Currency List
		$all_currencies = $this->others->get_all_table_value("currency","*","","id","ASC");
		$data['currencies'] = $all_currencies;
		
		//Get Time Zones List
		$dbtimeZones = $this->others->get_all_table_value("time_zones","*","","id","ASC");
		//print_r($dbtimeZones);die;

		$timezone_offsets = array();
		foreach($dbtimeZones as $key => $singleZone)
		{
			$tz = new DateTimeZone($singleZone['name']);
        	$timezone_offsets[$singleZone['id']."_".$singleZone['name']] = $tz->getOffset(new DateTime);
        	//print_r($singleZone['id']."_".$singleZone['name']);die;
		}
		asort($timezone_offsets);
		
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{	$timezone = explode('_',$timezone);
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone[0]] = "(${pretty_offset}) $timezone[1]";
		}
		$data['time_zones'] = $timezone_list;
		//print_r($timezone_list);die;

		$data['setup_active_open']=true;
		$this->load->view('admin/business/company_detail', $data);
	}
	
	public function insertandupdate()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{

			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('passwd', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('owner_first_name', 'Owner first name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('abn_number', 'ABN Number', 'trim|required|xss_clean');
			$ImgArr = array();
			if ($this->form_validation->run() == TRUE) 
			{

				if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!="")
				{
					//$config['source_path'] = 'images/staff/';
					$config['upload_path'] = 'images/staff/';					
					$config['allowed_types'] = 'png|gif|jpg|jpeg';
				
				
					$this->load->library('upload',$config);

					$upload=$this->upload->initialize($config);
				
					if(!$this->upload->do_upload('logo')){
					
						return $this->upload->display_errors();
						
					}			

					$upload= $this->upload->data();
					//print_r($upload); exit;
					$config['image_library'] = 'gd2';
				    $config['source_image'] = $upload['full_path'];
				    $config['maintain_ratio'] = TRUE;
				    $config['width']         = 200;
				    $config['height']       = 200;
				    $config['new_image'] = $upload['file_path']."/thumb/".$upload['file_name'];
					

					$this->load->library('image_lib', $config);
					//$this->load->library('image_lib', $config);
					$this->image_lib->initialize($config); 
					//$resize=$this->image_lib->resize();
					if (!$this->image_lib->resize()){
					echo $this->image_lib->display_errors(); exit;
					}

					//print_r($resize); exit;

				
					//print_r($upload); exit;
					$ImgArr = array(
							//'logo' =>$_FILES['logo']['name'],
						'logo' =>$upload['file_name'],

							
					);		 
					
				}	
				
				$PostArr = array(
								'abn_number' => $this->input->post('abn_number'),
								'name' => $this->input->post('name'),
								'phone_number' => $this->input->post('phone_number'),
								'email' => $this->input->post('email'),
								'address1' => $this->input->post('address1'),
								'address2' => $this->input->post('address2'),
								'subrub' => $this->input->post('subrub'),
								'city' => $this->input->post('city'),
								'state' => $this->input->post('state'),
								'country_id' => $this->input->post('country_id'),
								'post_code' => $this->input->post('post_code'),
								'business_category_id' => $this->input->post('business_category_id'),
								'currency_id' => $this->input->post('currency_id'),
								'time_zone_id' => $this->input->post('time_zone_id'),
								'time_format' => $this->input->post('time_format'),
								'facebook_url' => $this->input->post('facebook_url'),
								'twitter_url' => $this->input->post('twitter_url'),
								'description' => $this->input->post('description'),
								'owner_first_name' => $this->input->post('owner_first_name'),
								'owner_last_name' => $this->input->post('owner_last_name'),
							);
				
				if($this->input->post('business_id') > 0)
				{
					$this->session->set_flashdata('success_msg', "Busniess is updated successfully!");
					$update_business =$this->others->update_common_value("business",$PostArr,"id='".$this->input->post('business_id')."'");

					//$update_business = $this->business_model->update_business($this->input->post('business_id'),$PostArr);

					if($ImgArr){
					//$this->business_model->update_business($this->input->post('business_id'),$ImgArr);
						$this->others->update_common_value("business",$ImgArr,"id='".$this->input->post('business_id')."'");

					}
				}else
				{
					$this->session->set_flashdata('success_msg', "Busniess is updated successfully!");
					
					$insert_business = $this->others->insert_data("business",$PostArr);
					//$insert_business = $this->business_model->insert_business($PostArr);


					if($ImgArr){
						$this->others->update_common_value("business",$ImgArr,"id='".$insert_business."'");

						//$this->business_model->update_business($insert_business,$ImgArr);
					}
				}
				
				$admin_name = $this->input->post('owner_first_name');
				if(!empty($this->input->post('owner_last_name'))){
					$admin_name .=' '.$this->input->post('owner_last_name');
				}
				
				$AdminArr = array('email' => $this->input->post('email'),'admin_name' =>$admin_name );
				//$this->user_model->update_user($admin_session['admin_id'],$AdminArr);

				$this->others->update_common_value("admin_users",$AdminArr,"id='".$admin_session['admin_id']."' ");
				
				if($this->input->post('password') != ''){
					$PassArr = array('password' => md5($this->input->post('password')));
					//$this->user_model->update_user($admin_session['admin_id'],$PassArr);
					$this->others->update_common_value("admin_users",$PassArr,"id='".$admin_session['admin_id']."' ");
				}
			
				redirect(base_url('admin/business/company_detail'));
			}
			
		}
			
		$data['abn_number'] = $this->input->post('abn_number');
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');
		$data['address1'] = $this->input->post('address1');
		$data['address2'] = $this->input->post('address2');
		$data['subrub'] = $this->input->post('subrub');
		$data['city'] = $this->input->post('city');
		$data['state'] = $this->input->post('state');
		$data['website'] = $this->input->post('website');
		$data['phone_number'] = $this->input->post('phone_number');
		$data['owner_first_name'] = $this->input->post('owner_first_name');
		$data['owner_last_name'] = $this->input->post('owner_last_name');
		$data['business_category_id'] = $this->input->post('business_category_id');
		$data['country_id'] = $this->input->post('country_id');
		$data['post_code'] = $this->input->post('post_code');
		$data['currency_id'] = $this->input->post('currency_id');
		$data['time_zone_id'] = $this->input->post('time_zone_id');
		$data['time_format'] = $this->input->post('time_format');
		$data['description'] = $this->input->post('description');
		//$data['logo'] = $this->input->post('logo');
		$data['facebook_url'] = $this->input->post('facebook_url');
		$data['twitter_url'] = $this->input->post('twitter_url');
		//echo "innn";die;

		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","country_id,name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		
		//Get Session data
		$admin_session = $this->session->userdata('admin_logged_in');
		if(empty($admin_session)) redirect('admin');
		
		//Get Business Details
		$getBusinessDeatils = $this->others->get_all_table_value("business","*","id='".$admin_session['business_id']."'");
		if($getBusinessDeatils)  
		$data['business_details'] = $getBusinessDeatils[0];
		
		//Get Business Categories
		$all_categories = $this->business_model->get_business_categories();
		$data['business_cats'] = $all_categories;
		
		//Get Currency List
		$all_currencies = $this->others->get_all_table_value("currency","*","","id","ASC");
		$data['currencies'] = $all_currencies;
		
		//Get Time Zones List
		$dbtimeZones = $this->others->get_all_table_value("time_zones","*","","id","ASC");
		//print_r($dbtimeZones);die;

		$timezone_offsets = array();
		foreach($dbtimeZones as $key => $singleZone)
		{
			$tz = new DateTimeZone($singleZone['name']);
        	$timezone_offsets[$singleZone['id']."_".$singleZone['name']] = $tz->getOffset(new DateTime);
        	//print_r($singleZone['id']."_".$singleZone['name']);die;
		}
		asort($timezone_offsets);
		
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{	$timezone = explode('_',$timezone);
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone[0]] = "(${pretty_offset}) $timezone[1]";
		}
		$data['time_zones'] = $timezone_list;
		//print_r($timezone_list);die;
		
		$data['setup_active_open']=true;
		$this->load->view('admin/business/company_detail', $data);
	}
	
	public function export_to_csv(){
		
		$admin_session = $this->session->userdata('admin_logged_in');
		$all_business = $this->business_model->get_business(false,"","","","b.date_created","DESC");
		$filename = "business_".time().".csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		$fp = fopen('php://output', 'w');
		$row= array("SNO","Business Name","Email","Phone Number","Street/area","City","State","Post Code","Country","Owner First Name","Owner Last Name","Website","Facebook Url","Twitter Url","Business Category","Date Created");
		fputcsv($fp, $row);
		if($all_business){		
			$i=1;
			foreach($all_business as $row){
				$arr = array($i,$row['name'],$row['email'],$row['phone_number'],$row['address1'],$row['city'],$row['state'],$row['post_code'],$row['country_id'],$row['owner_first_name'],$row['owner_last_name'],$row['website'],$row['facebook_url'],$row['twitter_url'],$row['business_category'],$row['date_created']);
				fputcsv($fp, $arr);
				$i++;
			}				
		}
		exit;		
	}

		public function warehouse($id=null)
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if($this->input->post('action')){	
			$data['id'] = $id=$this->input->post('id');
			$data['business_id'] = $admin_session['business_id'];
			$data['email'] = $this->input->post('email');
			$data['warehouse_name'] = $this->input->post('warehouse_name');
			$data['phone_number'] = $this->input->post('phone_number');
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['postcode'] = $this->input->post('postcode');
			$data['weekday'] = $weekday= $this->input->post('weekday');
			$data['start_time'] = $start_time= $this->input->post('start_time');
			$data['end_time'] = $end_time= $this->input->post('end_time');			
			$this->load->library('form_validation');			
			$this->form_validation->set_rules('email', 'Email Field', 'required|email|valid_email');
			$this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {
			if ($id>0) {
							
						$insert_data = array(
					'business_id'=>$admin_session['business_id'],
					'warehouse_name'=>$this->input->post('warehouse_name'),
					'phone_number'=>$this->input->post('phone_number'),
					'email'=>$this->input->post('email'),
					'address1'=>$this->input->post('address1'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'postcode'=>$this->input->post('postcode'),
					'timezone_id'=>$this->input->post('timezone_id'),
					'date_created' => date('Y-m-d H:i:s'));	
						$this->db->where('id',$id);
						$success=$this->db->update('warehouse',$insert_data);
						if ($success) {
					$this->session->set_flashdata('success_msg', "Warehouse is edit successfully!");
					redirect(base_url('admin/business/all_warehouse'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding Warehouse is failed!");
					redirect(base_url('admin/business/all_warehouse'));
				}

						}
						else{
							$insert_data = array(
					'business_id'=>$admin_session['business_id'],
					'warehouse_name'=>$this->input->post('warehouse_name'),
					'phone_number'=>$this->input->post('phone_number'),
					'email'=>$this->input->post('email'),
					'address1'=>$this->input->post('address1'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'postcode'=>$this->input->post('postcode'),
					'timezone_id'=>$this->input->post('timezone_id'),
					'date_created' => date('Y-m-d H:i:s'));				
				$success = $this->others->insert_data("warehouse",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Warehouse is added successfully!");
					redirect(base_url('admin/business/all_warehouse'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding Warehouse is failed!");
					redirect(base_url('admin/business/all_warehouse'));
				}

						}				
				
				
			}
		}
		
		$data['warehouse'] = $this->db->select('*')->from('warehouse')->where('id',$id)->get()->row_array();	
	
		$data['timezones'] = $this->db->select('*')->from('time_zones')->get()->result_array();
		$data['setup_active_open']=true;
		$this->load->view('admin/business/warehouse', $data);
	}

	public function all_warehouse()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$this->load->library('pagination');
		$arr_search = array();		
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
			}elseif($admin_session['role']=="location_owner"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->update_common_value("warehouse",array("status"=>2),"id='".$item."' ");
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Warehouse has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No Warehouse are selected to delete!");
			}	
			redirect(base_url('admin/business/all_warehouse'));			
		}


        
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/business/all_warehouse') .'?'.$get_string;
		
		if ($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['business_id'] = $business_id;
			$business_detail = $this->others->get_all_table_value("business","id,name","id='".$business_id."' ");
			if($business_detail){
				$data['business_detail'] = $business_detail;
			}
        } 

        if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
        {
        	$arr_search['business_id'] = $admin_session['business_id'];
        }elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
        	$arr_search['business_id'] = $admin_session['business_id'];
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = 20;
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;				
        		
		
		$all_records = $this->business_model->get_business_warehouse(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->business_model->get_business_warehouse(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/business/all_warehouse', $data);
	}

	public function business_membership($id=null)
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		$data['all_business_membership']=$this->db->select("*")->from('membership')->join("business_membership","membership.stripe_plan_id=business_membership.stripe_plan_id")->where("business_membership.business_id",$id)->get()->result_array();
		$data['business_active_open']=true;
		$this->load->view('admin/business/business_membership', $data);
	}

	public function assign_plan(){
	$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
		$data['plans']=$plans=$this->db->from('membership')->get()->result_array();	
		$data['plan_active_open']=true;
		$this->load->view('admin/business/assign_plan', $data);
	}


	public function edit_plan($id=null){
	$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
		$data['plans']=$plans=$this->db->from('membership')->where('id',$id)->get()->row_array();	
		if ($this->input->post('action')) {

			$data_post=$this->input->post();
			unset($data_post['action']);
			//print_r($data_post); exit;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('staff_allowed', 'The field', 'numeric|required|xss_clean');
			$this->form_validation->set_message('numeric', '%s is numerical. Please enter a numerical value.');
			
			if ($this->form_validation->run() == TRUE) {				
			$success =$this->others->update_common_value("membership",$data_post,"id='".$id."' ");
			$this->session->set_flashdata('success_msg', "Plan has been updated successfully!");
			redirect(base_url('admin/business/assign_plan'));	

			}
		}
		$data['plan_active_open']=true;
		$this->load->view('admin/business/edit_plan', $data);
	}


	
}
