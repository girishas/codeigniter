<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('staff_model', '', TRUE);
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
	 
	public function index()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		
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
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND location_id='".$admin_session['location_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("staff","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Staff has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No staff are selected to delete!");
			}	
			redirect(base_url('admin/staff'));			
		}
        

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/staff') .'?'.$get_string;

        if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
        {
        	$arr_search['s.business_id']= $admin_session['business_id'];
        }elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['s.location_id']= $admin_session['location_id'];
		}
		
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

				$this->db->select('*');
				$this->db->from('staff');
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$this->db->where('business_id',$admin_session['business_id']);
			}elseif($admin_session['role']=="location_owner" ||$admin_session['role']=="staff" ){
				$this->db->where('location_id',$admin_session['location_id']);
			}
			
			$this->db->order_by('date_created','DESC');
			$data['all_records']=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
					
         		//print_r($admin_session); exit;
		/*$all_records = $this->staff_model->get_staff(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->staff_model->get_staff(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}*/
		
		//$this->pagination->initialize($config);
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;
		
		
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/all_staff', $data);
	}
	
	public function manage_permission($id)
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		if(empty($id)){
			$this->session->set_flashdata('error_msg', "User not selected.");
			redirect(base_url('admin/staff'));
		}	
		$data['staff_id']= $id;
		
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
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/staff') .'?'.$get_string;

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
		$config['per_page'] = $data['per_page'] = $per_page;
		
		$this->db->select('p.*');
		$this->db->from('permissions p');
		$this->db->where('p.parent_id',0);
		$data['all_records']=$this->db->get()->result_array();
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/manage_permission', $data);
	}
	
	public function update_permission($user_id){
		
		$permission_ids = $this->input->post('permission_id');
		$is_permit  = $this->input->post('is_permit');
		if(!empty($user_id)){
			foreach($permission_ids as $val){
				$permission_id = $val;
				$currentDate = date('Y-m-d H:i:s');
				$SQL = "INSERT INTO user_permissions(permission_id,user_id,is_permit,created_at)  VALUES ('$permission_id','$user_id','$is_permit','$currentDate') ON DUPLICATE KEY UPDATE is_permit = '$is_permit',updated_at='$currentDate'";
				$query = $this->db->query($SQL);
			}
			echo json_encode(["type"=>"success","message"=>"Permission Saved Successfully."]); die;
		}else{
			echo json_encode(["type"=>"Error","message"=>"User Id not selected."]); die;
		}
		
	}
	
	public function add($type)
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;		
			if($this->input->post('action')){
				$this->db->select('*, IFNULL(SUM(current_staff_limit), 0) AS current_staff_limit' )
				->from('admin_users')
				->where('business_id', $admin_session['business_id'])
				->where('role', 'business_owner');
				$staff_limit = $this->db->get()->row();
			//print_r($this->db->last_query()); exit;
				$total_staff_limit= $staff_limit->current_staff_limit;
				$this->db->select('COUNT(id) as num')
				->from('staff')
				->where('business_id', $admin_session['business_id'])
				->where('status',1);
				$total_staff= $this->db->get()->row()->num+1;
				$trial_expire_date=$staff_limit->trial_expire_date;
				$current_date=date('Y-m-d');
				if ($total_staff>$total_staff_limit) {
						$this->session->set_flashdata('error_msg', "You have reached to the maximum limit of staff. If you want to add more staffs, Please upgrade your plan.");
						redirect(base_url('admin/staff/'));
						exit;
					}



						/*if ($total_staff>$total_staff_limit && $this->input->post() && $trial_expire_date<$current_date ) {
						$this->session->set_flashdata('error_msg', "You have reached to the maximum limit of staff. If you want to add more staffs, Please upgrade your plan.");
						redirect(base_url('admin/staff/'));
						exit;
					}*/


/*
			$data['email'] = $this->input->post('email');
			$business_id = $this->input->post('business_id');
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			$data['first_name'] = $this->input->post('first_name');
			$data['last_name'] = $this->input->post('last_name');			
			$data['mobile_number'] = $this->input->post('mobile_number');
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['suburb'] = $this->input->post('suburb');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['country_id'] = $this->input->post('country_id');
			$data['post_code'] = $this->input->post('post_code');
			$data['job_title'] = $this->input->post('job_title');
			$data['employment_start_date'] = $this->input->post('employment_start_date');
			$data['employment_end_date'] = $this->input->post('employment_end_date');
			$data['notes'] = $this->input->post('notes');
			$data['password'] = $this->input->post('password');
			$data['applocation_access'] = $this->input->post('applocation_access');
			$data['calendor_bookable_staff'] = $this->input->post('calendor_bookable_staff');
			$data['roaster_staff'] = $this->input->post('roaster_staff');*/
			$data=$this->input->post();
			//print_r($data); exit;
			
			if(!empty($business_id)){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
				if($locations)
					$data['locations'] = $locations;
			}
			$this->load->library('form_validation');
			if($admin_session['role']=="owner"){
				$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			if($admin_session['role']=="business_owner"){
				$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mobile_number', 'Mobile number', 'numeric|required|xss_clean');
			//$this->form_validation->set_rules('job_title_id', 'Job title', 'trim|required|xss_clean');
			//$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|regex_match[/^[0-9]$/]'); //{10} for 10 digits number
			$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');

			$this->form_validation->set_rules('service_commission', 'Service Commission', 'trim|required|xss_clean');
			$this->form_validation->set_rules('product_commission', 'Product Commission', 'trim|required|xss_clean');
			$this->form_validation->set_rules('vouchar_commission', 'Vouchar Commission', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('target_service_value', 'target_service_value', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('target_product_value', 'target_product_value', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('target_voucher_value', 'target_voucher_value', 'trim|required|xss_clean');

			$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('employment_start_date', 'Employment start date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {
				
				$employment_start_date = $this->input->post('employment_start_date');
				$employment_start_date = !empty($employment_start_date)?date("Y-m-d",strtotime($employment_start_date)):"" ; 				
				$employment_end_date = $this->input->post('employment_end_date');
				$employment_end_date = !empty($employment_end_date)?date("Y-m-d",strtotime($employment_end_date)):"" ; 
				
				if($admin_session['role']=="owner"){
					$b_id = $this->input->post('business_id');
				}else{
					$b_id = $admin_session['business_id'];
				}
				if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){
					$l_id = $this->input->post('location_id');
				}else{
					$l_id = $admin_session['location_id'];
				}
				
				
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

				if( $this->input->post('applocation_access') == 'on' ){
				    $data['applocation_access'] = $applocation_access = 1;
				}
				else{
					$data['applocation_access'] = $applocation_access = 0;
				}

				if( $this->input->post('calendor_bookable_staff') == 'on' ){
					$data['calendor_bookable_staff'] = $calendor_bookable_staff = 1;
				}
				else{
					$data['calendor_bookable_staff'] = $calendor_bookable_staff = 0;
				}

				if( $this->input->post('roaster_staff') == 'on' ){
					$data['roaster_staff'] = $roaster_staff = 1;
				}
				else{
					$data['roaster_staff'] = $roaster_staff = 0;
				}
				
				$insert_data = array('business_id'=>$b_id,
					'location_id'=>$l_id,
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'email'=>$this->input->post('email'),
					'mobile_number'=>$this->input->post('mobile_number'),
					'address1'=>$this->input->post('address1'),
					'address2'=> $this->input->post('address2'),
					'suburb'=>$this->input->post('suburb'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'country_id'=>$this->input->post('country_id'),
					'post_code'=>$this->input->post('post_code'),					
					'job_title'=>$this->input->post('job_title'),
					'picture'=>$picture,
					'notes'=>$this->input->post('notes'),
					'employment_start_date'=>$employment_start_date,
					'employment_end_date'=>$employment_end_date,
					'staff_type'=>$type,
					'service_commission'=>$this->input->post('service_commission'),
					'product_commission'=>$this->input->post('product_commission'),
					'vouchar_commission'=>$this->input->post('vouchar_commission'),
					'target_service_value'=>$this->input->post('target_service_value'),
					'target_product_value'=>$this->input->post('target_product_value'),
					'target_voucher_value'=>$this->input->post('target_voucher_value'),
					'date_created' => date('Y-m-d H:i:s'),
					'calendor_bookable_staff'  		=> $calendor_bookable_staff,
					'roaster_staff'  		=> $roaster_staff,
					'applocation_access'  		=> $applocation_access);
					//gs($insert_data); die;
				$success = $this->others->insert_data("staff",$insert_data);
				$insert_id = $success;
				if ($success) {
					if($type==0){
						$role = "staff";
					}else{
						$role = "location_owner";
					}
					$admin_name = $this->input->post('first_name')." ".$this->input->post('last_name');
					$insert_data_users = array(
					'admin_name'=>$admin_name,
					'email'=>$this->input->post('email'),
					'password'=>md5($this->input->post('password')),
					'role'=>$role,
					'staff_id'=>$insert_id,
					'business_id'=>$b_id,
					'location_id'=>$l_id,
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("admin_users",$insert_data_users);
					$this->session->set_flashdata('success_msg', "Staff is added successfully!");
					redirect(base_url('admin/staff'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding staff is failed!");
					redirect(base_url('admin/staff/add_staff'));
				}
			}
		}
		
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner"){
			$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
			if($locations)
				$data['locations'] = $locations;	
		}
		
		$job_title_condition="";
		if($admin_session['role']=="business_owner"){
			$job_title_condition ="business_id='".$admin_session['business_id']."' ";
		}
		$all_job_titles = $this->others->get_all_table_value("staff_job_title","*",$job_title_condition,"job_title","ASC");
		if($all_job_titles)
			$data['all_job_titles'] = $all_job_titles;	
		
		$data['admin_session']= $admin_session;
		$data['type'] = $type;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/add_staff', $data);
	}

	public function change_password($staff_id){
		if($this->input->post('action')){
			$password = $this->input->post('password');
			$update_data = array(
				"password"=>md5($password)
			);
			$success = $this->others->update_common_value("admin_users",$update_data,"staff_id='".$staff_id."' ");
			if($success){
				$this->session->set_flashdata('success_msg', "Password has been changed successfully!");
				redirect(base_url('admin/staff'));
			} else {
				$this->session->set_flashdata('error_msg', "Password could not be changed, Please try again.");
				redirect(base_url('admin/staff'));
			}
		}
		$this->load->view('admin/staff/change_password');
	}
	
	public function edit_staff($id='')
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		if ($id != '' && is_numeric($id)) {			
			$staff_detail = $this->others->get_all_table_value("staff","*","id='".$id."'");
			if($staff_detail){
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
					$data['city'] = $this->input->post('city');
					$data['state'] = $this->input->post('state');
					$data['country_id'] = $this->input->post('country_id');
					$data['post_code'] = $this->input->post('post_code');
					$data['job_title'] = $this->input->post('job_title');
					$data['employment_start_date'] = $this->input->post('employment_start_date');
					$data['employment_end_date'] = $this->input->post('employment_end_date');
					$data['notes'] = $this->input->post('notes');
					$data['applocation_access'] = $this->input->post('applocation_access');
					$data['calendor_bookable_staff'] = $this->input->post('calendor_bookable_staff');
					$data['roaster_staff'] = $this->input->post('roaster_staff');
					
					if(!empty($business_id)){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						if($locations)
							$data['locations'] = $locations;
					}

					$original_value = $this->db->query("select email from admin_users where staff_id = ".$id)->row()->email ;
        if($this->input->post('email') != $original_value) {
            $is_unique =  '|is_unique[admin_users.email]';
        } else {
            $is_unique =  '';
        }
					
					$this->load->library('form_validation');
					if($admin_session['role']=="owner"){
						$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
						$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					if($admin_session['role']=="business_owner"){
						$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					 $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean'.$is_unique);
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('job_title_id', 'Job title', 'trim|required|xss_clean');
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					$this->form_validation->set_rules('service_commission', 'Service Commission', 'trim|required|xss_clean');
					$this->form_validation->set_rules('product_commission', 'Product Commission', 'trim|required|xss_clean');
					$this->form_validation->set_rules('vouchar_commission', 'Vouchar Commission', 'trim|required|xss_clean');
					$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
					$this->form_validation->set_rules('employment_start_date', 'Employment start date', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {
						$employment_start_date = $this->input->post('employment_start_date');
						$employment_start_date = !empty($employment_start_date)?date("Y-m-d",strtotime($employment_start_date)):"" ; 				
						$employment_end_date = $this->input->post('employment_end_date');
						$employment_end_date = !empty($employment_end_date)?date("Y-m-d",strtotime($employment_end_date)):"" ; 
						
						$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ; 
						//print_r($admin_session); exit;
						
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

						if( $this->input->post('applocation_access') == 'on' ){
							$data['applocation_access'] = $applocation_access = 1;
						}
						else{
							$data['applocation_access'] = $applocation_access = 0;
						}

						if( $this->input->post('calendor_bookable_staff') == 'on' ){
							$data['calendor_bookable_staff'] = $calendor_bookable_staff = 1;
						}
						else{
							$data['calendor_bookable_staff'] = $calendor_bookable_staff = 0;
						}

						if( $this->input->post('roaster_staff') == 'on' ){
							$data['roaster_staff'] = $roaster_staff = 1;
						}
						else{
							$data['roaster_staff'] = $roaster_staff = 0;
						}
						if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
							$update_data['business_id']=$admin_session['business_id'];
							$update_data['location_id']=$admin_session['location_id'];
						}

						if ($admin_session['role']=="owner" || $admin_session['role']=="business_owner") {
							$update_data['business_id'] = $b_id;
							$update_data['location_id'] = $this->input->post('location_id');
						}
						
						$update_data['first_name'] = $this->input->post('first_name');
						$update_data['last_name'] =$this->input->post('last_name');
						$update_data['email'] = $this->input->post('email');
						$update_data['mobile_number'] = $this->input->post('mobile_number');
						$update_data['address1'] = $this->input->post('address1');
						$update_data['address2'] =  $this->input->post('address2');
						$update_data['suburb'] =  $this->input->post('suburb');
						$update_data['city'] = $this->input->post('city');
						$update_data['state'] = $this->input->post('state');
						$update_data['country_id'] = $this->input->post('country_id');
						$update_data['post_code'] = $this->input->post('post_code');
						$update_data['job_title'] = $this->input->post('job_title');
						$update_data['notes'] = $this->input->post('notes');
						$update_data['service_commission'] = $this->input->post('service_commission');
						$update_data['product_commission'] = $this->input->post('product_commission');
						$update_data['vouchar_commission'] = $this->input->post('vouchar_commission');
						$update_data['target_service_value'] = $this->input->post('target_service_value');
						$update_data['target_product_value'] = $this->input->post('target_product_value');
						$update_data['target_voucher_value'] = $this->input->post('target_voucher_value');
						$update_data['employment_start_date'] = $employment_start_date;
						$update_data['employment_end_date'] = $employment_end_date;
						$update_data['calendor_bookable_staff'] = $calendor_bookable_staff;
						$update_data['applocation_access'] = $applocation_access;
						$update_data['roaster_staff'] = $roaster_staff;
						if($picture!=""){
							$update_data['picture'] = $picture;
						}			

						$success = $this->others->update_common_value("staff",$update_data,"id='".$id."' ");

						$update_admin_data['email'] = $this->input->post('email');
						$update_admin_data['location_id'] = $this->input->post('location_id');
						if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
							$update_admin_data['location_id']=$admin_session['location_id'];
						}
						$first_nam = $this->input->post('first_name');
						$last_name =$this->input->post('last_name');
						$update_admin_data['admin_name'] = $first_nam.' '.$last_name;

						$success = $this->others->update_common_value("admin_users",$update_admin_data,"staff_id='".$id."' ");

						$this->session->set_flashdata('success_msg', "Staff is updated successfully!");
						redirect(base_url('admin/staff'));
					}
				}
				//echo "<pre>";print_r($staff_detail); echo "</pre>";die;
				$data['staff_detail'] = $staff_detail;
			}
		}
		
		//Get Country List
		$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
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
		$job_title_condition="";
		if($admin_session['role']=="business_owner"){
			$job_title_condition ="business_id='".$admin_session['business_id']."' ";
		}
		$all_job_titles = $this->others->get_all_table_value("staff_job_title","*",$job_title_condition,"job_title","ASC");
		if($all_job_titles)
			$data['all_job_titles'] = $all_job_titles;	
		
		$data['admin_session']= $admin_session;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/edit_staff', $data);
	}
	
	public function assigned_services()
	{
		$staff_name = $this->input->get('staff', TRUE);
		$data['staff_name']=$staff_name;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/assigned_services', $data);
	}
	
	public function assign_new_service()
	{
		$staff_name = $this->input->get('staff', TRUE);
		$data['staff_name']=$staff_name;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/assign_new_service', $data);
	}
	
	public function all_job_title()
	{
		$data['settings_active_open']=true;
		$this->load->view('admin/staff/all_job_title', $data);
	}
	
	public function add_job_title()
	{
		$data['settings_active_open']=true;
		$this->load->view('admin/staff/add_job_title', $data);
	}

	public function view($id){
		$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
		if(!$id)
			redirect(base_url('admin/staff'));

		//Get Staff Information
		$qry = $this->db->select('*')->from('staff')->where('id',$id)->get()->row_array();

		//Get Staff Services Information
		$this->db->select("j.service_name");
		$this->db->from('staff_services s');
		$this->db->join('services j', 's.service_id = j.id','left');
		$this->db->where('s.staff_id',$id);
		$query = $this->db->get();
		$result = $query->result_array();
		//gs($result);

		//Get Working Hours
		$staff_working_hours = $this->db->select('*')->from('staff_working_hours')->where(['staff_id'=>$id,'is_break'=>0])->order_by("id", "asc")->get()->result_array();
		foreach ($staff_working_hours as $key => $value) {
			if($value['is_work']==0)
			{
				$staff_working_hours[$value['week_day']] = $value;
			}else{
				$staff_working_hours[$value['week_day']]['work'][] = $value;
			}
		}

		// Get Another Working Details
		$qryy = "SELECT id,week_day, min(start_hours) as start_hours,max(end_hours) as end_hours from staff_working_hours where (staff_id=$id and is_break=0) GROUP BY week_day ORDER BY week_day asc";
		$staff_data = $this->db->query($qryy);
		$staff_data = $staff_data->result_array();
		//gs($staff_data);
		$ddata = array();
		if($staff_data){
		foreach ($staff_data as $key => $value) {
			$ddata[$value['week_day']] = $value;
		}
	}
		$data['staff_working_hours'] = $staff_working_hours;
		$data['staff_data'] = $ddata;
		$data['assigned_services'] = $result;
		$data['staff_detail'] = $qry;
		$data['id'] = $id;
		$data['staff_active_open']=true;
		
		$this->load->view('admin/staff/view',$data);		
	}

	public function getWorkDetails($day,$user_id){
		$working_details = $this->db->select('*')->from('staff_working_hours')->where(['staff_id'=>$user_id,'week_day'=>$day])->order_by("id", "asc")->get()->result_array();
		$data['working_details'] = $working_details;
		$this->load->view('admin/staff/get_work_details',$data);
	}

	public function services($id)
	{
		if(!$id)
			redirect(base_url('admin/staff'));
		if($this->input->post('action')){

			//$this->db->delete('staff_services', array('staff_id' => $id));
			$this->others->delete_record('staff_services', array('staff_id' => $id));
			

			foreach ($this->input->post('service_id') as $key => $value) {
				$insert_data = array(
					'staff_id'=>$id,
					'service_id'=>getmainServiceId($value),
					'service_timing_id'=>$value
				);
				$this->others->insert_data("staff_services",$insert_data);
			}
			$this->session->set_flashdata('success_msg', "Services assigned to staff successfully");
			redirect(base_url('admin/staff/services/'.$id));
		}

		$admin_session = $this->session->userdata('admin_logged_in');

		if($admin_session['role']=="business_owner"){
			$business_id = $admin_session['business_id'];
		}else{
			$business_id = getStaffBusinessId($id);
		}

		$this->db->select("s.*,j.name as category_name,t.id as service_timing_id, t.caption");
		$this->db->from('services s');
		$this->db->join('service_category j', 's.service_category_id = j.id','left');
		$this->db->join('service_timing t', 's.id = t.service_id','left');

		$this->db->where('s.business_id',$business_id);
		$query = $this->db->get();
		$result = $query->result_array();
		
		//echo "<pre>"; print_r($result); die;
		$cats = array();
		$arr = array();
		$this->db->select('service_category_id');
		$this->db->from('services');
		$this->db->where('business_id',$business_id);
		$query2 = $this->db->get();
		$result2 = $query2->result_array();
		foreach ($result2 as $key => $value) {
			$cats[] = $value['service_category_id'];
		}
		$i=0;
		
		if(count((array)$cats)>0){
			foreach ($cats as $catskey => $catsvalue) {
				foreach ($result as $key => $value) {
					if($catsvalue==$value['service_category_id'])
					{
						$arr[$catsvalue][$value['id']][$value['service_timing_id']] = $value['service_name']." ".$value['caption'];
					}
					$i++;
				}
			}
		}

		//Get Previous assigned services
		$ass_ser = array();
		$this->db->select('service_timing_id');
		$this->db->from('staff_services');
		$this->db->where('staff_id',$id);
		$query3 = $this->db->get();
		$result3 = $query3->result_array();
		foreach ($result3 as $key => $value) {
			$ass_ser[$key] = $value['service_timing_id'];
		}
		//gs($ass_ser);
		$data['assigned_services'] = $ass_ser;
		$data['services'] = $arr;
		$data['id'] = $id;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/services',$data);
	}

	public function working_hours($id)
	{
		if(!$id)
			redirect(base_url('admin/staff'));
		$admin_session = $this->session->userdata('admin_logged_in');
		$staff_data = array();
		if($admin_session['role']=="business_owner"){
			$business_id = $admin_session['business_id'];
		}else{
			$business_id = getStaffBusinessId($id);
		}

		if($this->input->post('action'))
		{
			//gs($this->input->post());
			//$this->db->delete('staff_working_hours', array('staff_id' => $id));

			$this->others->delete_record('staff_working_hours', array('staff_id' => $id));
			

			$day = $this->input->post('day');
			$start_hours = $this->input->post('start_hours');
			$end_hours = $this->input->post('end_hours');
			$location_id = $this->input->post('location_id');
			$break = $this->input->post('break');
			$work = $this->input->post('work');
			// Insert work records (Is_Break=0)
			foreach ($day as $key => $value) {
				$insert_data = array(
					'staff_id'=>$id,
					'business_id'=>$business_id,
					'location_id'=>$location_id[$value],
					'is_break'=>0,
					'week_day'=>$value,
					'start_hours'=>date("G:i", strtotime($start_hours[$value])),
					'end_hours'=>date("G:i", strtotime($end_hours[$value])),
					'date_created'=>date("Y-m-d H:i:s")
				);
				$this->others->insert_data("staff_working_hours",$insert_data);
			}

			//Insert Work Records
			// Insert Break Records
			foreach ($work as $key => $value) {
				foreach ($value as $k => $val) {
					$insert_data = array(
						'staff_id'=>$id,
						'business_id'=>$business_id,
						'location_id'=>$val['location_id'],
						'is_break'=>0,
						'is_work'=>1,
						'week_day'=>$key,
						'start_hours'=>date("G:i", strtotime($val['start_hours'])),
						'end_hours'=>date("G:i", strtotime($val['end_hours'])),
						'date_created'=>date("Y-m-d H:i:s")
					);
					$this->others->insert_data("staff_working_hours",$insert_data);
				}
			}

			// Insert Break Records
			foreach ($break as $key => $value) {
				foreach ($value as $k => $val) {
					$insert_data = array(
						'staff_id'=>$id,
						'business_id'=>$business_id,
						'location_id'=>$val['break_location_id'],
						'is_break'=>1,
						'week_day'=>$key,
						'start_hours'=>$val['break_start_hours'],
						'end_hours'=>date("G:i", strtotime($val['break_end_hours'])),
						'break_name'=>date("G:i", strtotime($val['break_name'])),
						'date_created'=>date("Y-m-d H:i:s")
					);
					$this->others->insert_data("staff_working_hours",$insert_data);
				}
			}
			redirect(base_url('admin/staff/working_hours/'.$id));
		}

		//Get Old Records of staff working hours
		$staff_data = $this->db->select('*')->from('staff_working_hours')->where('staff_id',$id)->order_by("id", "asc")->get()->result_array();
		foreach ($staff_data as $key => $value) {
			if($value['is_break']==0 and $value['is_work']==0)
			{
				$staff_data[$value['week_day']] = $value;
			}elseif($value['is_break']==0 and $value['is_work']==1){
				$staff_data[$value['week_day']]['work'][] = $value;
			}else{
				$staff_data[$value['week_day']]['break'][] = $value;
			}
		}
		//gs($staff_data);
		$data['staff_data'] = $staff_data;
		$this->db->select("s.id,s.location_name");
		$this->db->from('location s');
		$this->db->where('s.business_id',$business_id);
		$query = $this->db->get();
		$result = $query->result_array();
		$data['locations'] = $result;
		$data['id'] = $id;
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/working_hours',$data);
	}

	public function roster(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$where = array();
          
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
		{
			$business_id = $admin_session['business_id'];
			$where = array('business_id'=>$business_id,'is_break'=>0);
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$location_id = $admin_session['location_id'];
			$where = array('location_id'=>$location_id,'is_break'=>0);
		}
	    $this->db->select('id,staff_id,week_day, min(start_hours) as start_hours,max(end_hours) as end_hours');
	    $this->db->from('staff_working_hours');
	    $this->db->where($where);
	    if ($this->input->get('business_id')) {
	    	$business_id = $this->input->get('business_id');
           $this->db->where('business_id',$business_id);
           $data['business_id']= $business_id;
        }
	    $this->db->group_by('staff_id');
	    $this->db->group_by('week_day');
	    $this->db->order_by('week_day','asc');
	    $query = $this->db->get();
		$result = $query->result_array();
		$ddata = array();
		$dd = array();
		if($result){
			$staff_id = null;
			foreach ($result as $key => $value) {					
				$ddata[$value['staff_id']][] = $value;
			}
		}
		if($ddata)
		{
			foreach ($ddata as $key => $value) {
				foreach ($value as $kkey => $vvalue) {
					$dd[$key][$vvalue['week_day']] = $vvalue;
				}
			}
		}
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;
		$data['data'] = $dd;
		$data['roster_active_open'] = true;
		$data['admin_session'] = $admin_session;
		$this->load->view('admin/staff/roster',$data);
	}

	function roster_new(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if ($admin_session['business_id'] =="") {
		$this->session->set_flashdata('error_msg', "please Choose a Business!!");
					redirect(base_url('admin/dashboard'));					
				}
		$this->db->select('*');
		$this->db->from('location');
		$this->db->where('status',1);
		if ($admin_session['business_id'] !="") {
			$this->db->where('business_id',$admin_session['business_id']);
		}

		$data['getlocation']=$this->db->get()->result_array();

		//gs($admin_session); die;

		$data['admin_session'] = $admin_session;
		$data['roster_active_open'] = true;
		$this->load->view('admin/staff/roster_new',$data);
	}


	public function changeRoster(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$request = $this->input->post();
		$business_id = $admin_session['business_id'];
		$select_date = $request['select_date'];
		/*if (isset($request['count_plus']) ) {
			$count_plus = $request['count_plus'];
			$increase = $count_plus." sunday";
		$monday = strtotime($increase);

		$data['selected_week'] = $monday;
		$monday = (date('w', $monday)==date('w')) ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		}*/
		
		$location_id = $request['location_id'];
		if (isset($request['select_date'])) {
			$count_plus = $request['count_plus'];
			$start_date = $request['select_date'];
		$select_date= date("d-m-Y", strtotime("$start_date +".$count_plus." week"));
			$data['selected_week'] = $monday = strtotime('saturday -6 day', strtotime($select_date));
			$sunday = strtotime('+6 day', $monday);

		}
		
		$this_week_sd = date("d",$monday);
		$this_week_ed = date("d",$sunday);
		$this_week_md = date("M",$sunday);
		$this_week_mdn = date("m",$sunday);
		$this_week_yr = date("Y",$sunday);
		$new_date = $this_week_sd." - ".$this_week_ed." ".$this_week_md.", ".$this_week_yr;
		$data['new_date'] = $new_date;
		$first_date = $this_week_yr."-".$this_week_mdn."-".$this_week_sd;
		$last_date = $this_week_yr."-".$this_week_mdn."-".$this_week_ed;
		$date_range = date_range($first_date,$last_date);
		$data['date_ranges'] = $date_range;
		$data['current_month'] = $this_week_mdn;
		
		//$first_date =  date($last_date, strtotime("+30 days"));
		
		//print_r($first_date); exit;
	//	exit;
		// Get Staff Information
		/*$staffs = $this->db->select(['id','location_id','first_name','last_name'])->from('staff')->where(['business_id'=>$business_id,'roaster_staff'=>'1'])->get()->result_array();*/

		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			 $this->db->select('id,location_id,first_name,last_name');
			 $this->db->from('staff');
			$this->db->where(['business_id'=>$admin_session['business_id'],'status'=>1,'roaster_staff'=>1]);
			if ($location_id>0 && $location_id!='') {
				$this->db->where('location_id',$location_id);
			}

			$staffs =$this->db->get()->result_array();
			}
			elseif($admin_session['role']=="location_owner"){
			$staffs = $this->db->select('*')->from('staff')->where(['location_id'=>$admin_session['location_id'],'status'=>1,'roaster_staff'=>1])->get()->result_array();
			}

			elseif($admin_session['role']=="staff"){
			$staffs = $this->db->select('*')->from('staff')->where(['id'=>$admin_session['staff_id'],'status'=>1,'roaster_staff'=>1])->get()->result_array();
			}
			/*$this->db->select('staff.*');
			$this->db->from('roster');
			$this->db->join('staff','staff.id=roster.staff_id','inner');
			$this->db->where('roster.location_id',$location_id);*/
			//echo $location_id; exit;

			$roster_last_date=date('Y-m-d', strtotime($last_date));
			$roster_first_date=date('Y-m-d', strtotime($last_date. ' - 6 day'));
			$sql="SELECT staff.* from  roster
			JOIN staff ON staff.id=roster.staff_id
			WHERE roster.location_id='".$location_id."'
			AND ((roster.is_repeat=1 AND roster.week_day_date <= '".$roster_last_date."' ) OR ( roster.is_repeat=2 AND ((roster.end_repeat_date >= '".$roster_last_date."' AND roster.week_day_date <= '".$roster_last_date."') OR ( roster.end_repeat_date >= '".$roster_first_date."' AND roster.end_repeat_date <= '".$roster_last_date."' ))  ) OR (roster.is_repeat =0 AND week_day_date >= '".$roster_first_date."' AND roster.week_day_date <= '".$roster_last_date."' ))";
			//echo $sql; exit;
			$roster_staffs=$this->db->query($sql)->result_array();
			$staffs=(array_merge_recursive($staffs,$roster_staffs));
			$staffs = array_values(array_column( $staffs , null, 'id' ));
			//print_r($roster_staffs); exit;
			//$staffs = array_map("unserialize", array_unique(array_map("serialize", $staffs)));
			
			//$staffs = array_merge($staffs,$roster_staffs); 

			//print_r($staffs); exit;
	 //$staffs=array_unique($staffs);
			/*$staffs = $this->db->select('staff_id AS id')->from('roster')->where(['location_id'=>$location])->get()->result_array();*/

			//echo $location_id; exit;
		$data['staff'] = $staffs;
		//gs($staffs);die;
		//Get Data From rosters for each Day
		# 0 = Sunday , 6=Saturday
		$rosters_array = array();
		if($staffs){
		foreach ($staffs as $key => $value) {
			$staff_id = $value['id'];
			for ($i=0; $i <7 ; $i++) {
				$date_ranges = $date_range[$i];
					$find_in_roster = $this->db->select(['count(*) as total','is_repeat','week_day_date'])->from('roster')->where(['staff_id'=>$value['id'],'week_day'=>$i,'is_repeat'=>0, 'location_id'=>$location_id,'week_day_date'=>$date_range[$i]])->get()->row_array();
					if($find_in_roster['total']==0){
						$find_in_roster = $this->db->query("SELECT count(*) as total, `is_repeat`, `week_day_date` FROM `roster` WHERE `staff_id` = $staff_id AND `week_day` = $i AND `is_repeat` = 2 AND location_id= $location_id AND (`end_repeat_date` >= '$date_ranges' and week_day_date <= '$date_ranges' )")->row_array();
						//gs($find_in_roster);die;
						if($date_range[$i]<$find_in_roster['week_day_date']){
							$find_in_roster['total']=0;
							$find_in_roster['is_repeat'] = "";
						}
					}
					if($find_in_roster['total']==0){
						$find_in_roster = $this->db->select(['count(*) as total','is_repeat','week_day_date'])->from('roster')->where(['staff_id'=>$value['id'],'week_day'=>$i,'location_id'=>$location_id, 'is_repeat'=>1])->get()->row_array();
						if($date_range[$i]<$find_in_roster['week_day_date']){
							$find_in_roster['total']=0;
							$find_in_roster['is_repeat'] = "";
						}
					}
					//gs($find_in_roster);die;
					if(isset($find_in_roster['total']) && $find_in_roster['total']>0){
						//echo "<br>first-".$key."-".$i;
						if($find_in_roster['is_repeat']==1){
							//echo "<br>sec-".$key."-".$i;
							$wor_hrs = $this->db->select('*')->from("roster")->where(['staff_id'=>$value['id'],'is_repeat'=>1,'location_id'=>$location_id,'week_day'=>$i])->get()->result_array();
						}elseif($find_in_roster['is_repeat']==0){
							$day = $i;
							$date = $date_range[$i];
							$wor_hrs = $this->db->select('*')->from("roster")->where(['staff_id'=>$value['id'],'is_repeat'=>0,'location_id'=>$location_id,'week_day'=>$i,'week_day_date'=>$date])->get()->result_array();
						}elseif($find_in_roster['is_repeat']==2){
							//echo "<br>fur-".$key."-".$i;
							$day = $i;
							$date = $date_range[$i];
							$wor_hrs = $this->db->query("SELECT * FROM `roster` WHERE `staff_id` = $staff_id AND `week_day` = $day AND `is_repeat` = 2 AND location_id= $location_id AND (`end_repeat_date` >= '$date' and week_day_date <= '$date' )")->result_array();
						}else{
							//echo "<br>fiv-".$key."-".$i;
							$wor_hrs = array();
						}
					}else{
						//echo "<br>six-".$key."-".$i;
						$wor_hrs = array();
					}

					$rosters_array[$key][] = $wor_hrs;
			}
		}
		}
		//gs($rosters_array);die;
		$data['rosters_array'] = $rosters_array;
		//gs($data);die;
		echo $this->load->view('admin/staff/all_roster',$data,true);
		//echo json_encode($data);

	}

	public function createRoster(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $admin_session['business_id'];
		$locations = $this->db->select(['id','location_name'])->from('location')->where(['business_id'=>$business_id])->get()->result_array();
		$data['locations'] = $locations;
		$data['business_id'] = $business_id;
		$request = $this->input->post();
		$day = $request['day'];
		$date = $request['date'];
		$staff_id = $request['staff_id'];
		$data['location_id'] = $request['location_id'];

		## Get Data from rosters table
		//$rosters = $this->db->select('*')->from('roster')->where(['staff_id'=>$staff_id,'week_day'=>$day])->get()->result_array();
		//$data['roster'] = $rosters;
		$data['day'] = $day;
		$data['date'] = $date;
		$data['date_formated'] = date("l, j M Y",strtotime($date));
		$data['staff_id'] = $staff_id;
		$data['staff_name'] = getStaffName($staff_id);
		$view = $this->load->view('admin/staff/create-roster',$data,true);
		echo $view;
		die;
	}

	public function saveRoster(){
		$post_data = $this->input->post();
		// gs($post_data); die;
		$start_hour_array = $post_data['start_hours'];
		$staff_id = $post_data['staff_id'];
		$week_day = $post_data['day'];
		$repeat = $post_data['repeat'];
		$week_day_date = $post_data['week_day_date'];


		if($post_data['end_repeat_date'] !=""){
			$end_repeat_date = date("Y-m-d",strtotime($post_data['end_repeat_date']));
		}else{
			$end_repeat_date = null;
		}

		$common_number = rand() . rand() . "_" . time();
		// Check for existing hours if change
		if($repeat==1 or $repeat==2){
			if($repeat==1){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and week_day_date>'$week_day_date')")->row();
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}elseif($repeat==2){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and week_day_date>'$week_day_date')")->row();
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}
			
		}
		foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['repeat'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);

	}

	public function saveEditRoster(){
		$post_data = $this->input->post();
		
		$common_number_new = rand() . rand() . "_" . time();
		$start_hour_array = $post_data['start_hours'];
		$staff_id = $post_data['staff_id'];
		$week_day = $post_data['day'];
		$repeat = $post_data['repeat'];
		$week_day_date = $post_data['week_day_date'];
		$is_repeat_old = $post_data['is_repeat_old'];
		$common_number = $post_data['common_number'];
		if($post_data['end_repeat_date'] !=""){
			$end_repeat_date = date("Y-m-d",strtotime($post_data['end_repeat_date']));
		}else{
			$end_repeat_date = null;
		}

		if($repeat==1 or $repeat==2){
			if($repeat==1){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and (week_day_date<='$week_day_date' or end_repeat_date>='$week_day_date'))")->row();
				//gs($ros);die;
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}elseif($repeat==2){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and (week_day_date<='$week_day_date' or end_repeat_date>='$week_day_date'))")->row();
				//gs($ros);die;
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}
			
		}
		if($post_data['is_repeat_old']==0){
			
			$this->others->delete_record('roster',array('common_number'=>$common_number));
			//$this->db->delete('roster',array('common_number'=>$common_number));
		}
	//	gs($post_data);
		foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['repeat'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);

	}

	public function saveEditRosterRepeatingShift(){
		$post_data = $this->input->post();	
		$common_number_new = rand() . rand() . "_" . time();
		$start_hour_array = $post_data['start_hours'];
		$staff_id = $post_data['staff_id'];
		$week_day = $post_data['day'];
		$repeat = $post_data['repeat'];
		$week_day_date = $post_data['week_day_date'];
		$is_repeat_old = $post_data['is_repeat_old'];
		$common_number = $post_data['common_number'];
		$common_number_new1 = rand() . rand() . "_" . time();
		$common_number_new2 = rand() . rand() . "_" . time();
		$common_number_new3 = rand() . rand() . "_" . time();
		$common_number_new4 = rand() . rand() . "_" . time();
		if($post_data['end_repeat_date'] !=""){
			$end_repeat_date = date("Y-m-d",strtotime($post_data['end_repeat_date']));
			$is_repeat=2;
		}else{
			$end_repeat_date = null;
			$is_repeat=0;
		}
		if($post_data['repeatAction']==0){
			$preData =$this->db->select('*')->from('roster')->where('staff_id',$staff_id)->where('common_number',$common_number)->get()->result_array();
			foreach ($preData as $key => $ros) {
				if ($ros['is_repeat']==2) {
				$update_data = array(							
							"common_number"=> $common_number_new1,
							"end_repeat_date"=>date("Y-m-d",strtotime('-7 day',strtotime($week_day_date))),
							"is_repeat"=>2
						);
					 $this->others->update_common_value("roster",$update_data,"id='".$ros['id']."' ");				
					 $insert_data = array(
						'week_day'=> $post_data['day'],
						'week_day_date'=> date("Y-m-d",strtotime('+7 day',strtotime($week_day_date))),
						'staff_id'=> $post_data['staff_id'],
						'business_id'=> $post_data['business_id'],
						'location_id'=> $ros['location_id'],
						'start_hours'=> $ros['start_hours'],
						'end_hours'=> $ros['end_hours'],
						'is_break'=> $ros['is_break'],
						'break_name'=> $ros['break_name'],
						'is_repeat'=> 2,
						'end_repeat_date'=> $ros['end_repeat_date'],
						'common_number'=> $common_number_new2,
					);
				$this->others->insert_data("roster",$insert_data);				
			}

			if ($ros['is_repeat']!=2) {
				$update_data = array(
							"end_repeat_date"=>date("Y-m-d",strtotime('-7 day',strtotime($week_day_date))),
							"common_number"=> $common_number_new3,
							"is_repeat"=>2
						);
					//foreach($ros as $preData){
					 $this->others->update_common_value("roster",$update_data,"id='".$ros['id']."' ");	
					//} 

					 $insert_data = array(
						'week_day'=> $post_data['day'],
						'week_day_date'=> date("Y-m-d",strtotime('+7 day',strtotime($week_day_date))),
						'staff_id'=> $post_data['staff_id'],
						'business_id'=> $post_data['business_id'],
						'location_id'=> $ros['location_id'],
						'start_hours'=> $ros['start_hours'],
						'end_hours'=> $ros['end_hours'],
						'is_break'=> $ros['is_break'],
						'break_name'=> $ros['break_name'],
						'is_repeat'=> 1,
						'end_repeat_date'=> $ros['end_repeat_date'],
						'common_number'=> $common_number_new4,
					);
				$this->others->insert_data("roster",$insert_data);

				
		}

				
			}

			foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> 0,
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number_new,
				);
			$this->others->insert_data("roster",$insert_data);				
			}

		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}else{
			//echo "Hrerer";die;

			$ros = $this->db->query("SELECT id FROM roster where(staff_id=$staff_id and week_day=$week_day and ( week_day_date < '$week_day_date' and ( is_repeat=1 or ( is_repeat=2 and end_repeat_date > '$week_day_date') ) ))")->result_array();
			//gs($ros);die;
				if($ros){
					// Update old dates with repeat or specific date
					$update_data = array(
							"end_repeat_date"=>date("Y-m-d",strtotime('-1 day',strtotime($week_day_date))),
							"is_repeat"=>2
						);
					foreach($ros as $preData){
					 $this->others->update_common_value("roster",$update_data,"id='".$preData['id']."' ");	
					}
				}

			//$this->db->delete('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'week_day_date >='=>$week_day_date)); 
				$this->others->delete_record('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'week_day_date >='=>$week_day_date)); 


			

			foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['repeatAction'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number_new,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}
		
	}

	public function saveAddRosterRepeatingShift(){
		$post_data = $this->input->post();
		$common_number_new = rand() . rand() . "_" . time();
		$start_hour_array = $post_data['start_hours'];
		$staff_id = $post_data['staff_id'];
		$week_day = $post_data['day'];
		$repeat = $post_data['repeat'];
		$week_day_date = $post_data['week_day_date'];

		//print_r($post_data); exit;
		if($post_data['end_repeat_date'] !=""){
			$end_repeat_date = date("Y-m-d",strtotime($post_data['end_repeat_date']));
		}else{
			$end_repeat_date = null;
		}

		if($post_data['repeatAction']==0){
			foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['repeatAction'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number_new,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}else{


			$ros = $this->db->query("SELECT id FROM roster where(staff_id=$staff_id and week_day=$week_day and ( week_day_date < '$week_day_date' and ( is_repeat=1 or ( is_repeat=2 and end_repeat_date > '$week_day_date') ) ))")->result_array();
			//gs($ros);die;
				if($ros){
					// Update old dates with repeat or specific date
					$update_data = array(
							"end_repeat_date"=>date("Y-m-d",strtotime('-1 day',strtotime($week_day_date))),
							"is_repeat"=>2
						);
					foreach($ros as $preData){
					 $this->others->update_common_value("roster",$update_data,"id='".$preData['id']."' ");	
					}
				}

			//$this->db->delete('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'week_day_date >='=>$week_day_date));

			$this->others->delete_record('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'week_day_date >='=>$week_day_date));

			 

			foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=> $post_data['week_day_date'],
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['repeatAction'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number_new,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}
		
	}

	public function EditRoster(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $admin_session['business_id'];
		$locations = $this->db->select(['id','location_name'])->from('location')->where(['business_id'=>$business_id])->get()->result_array();
		$data['locations'] = $locations;
		$data['business_id'] = $business_id;
		$request = $this->input->post();
		//gs($request);
		$day = $request['day'];
		$date = $request['date'];
		$staff_id = $request['staff_id'];
		$is_repeat = $request['is_repeat'];
		$common_number = $request['common_number'];

		## Get Data from rosters table
		$rosters = $this->db->select('*')->from('roster')->where(['staff_id'=>$staff_id,'week_day'=>$day,'is_repeat'=>$is_repeat,'common_number'=>$common_number])->get()->result_array();
		//gs($rosters);
		$data['roster'] = $rosters;
		$data['day'] = $day;
		$data['is_repeat'] = $is_repeat;
		$data['common_number'] = $common_number;
		$data['date'] = $date;
		$data['date_formated'] = date("l, j M Y",strtotime($date));
		$data['staff_id'] = $staff_id;
		$data['staff_name'] = getStaffName($staff_id);
		$view = $this->load->view('admin/staff/edit-roster',$data,true);
		echo $view;
		die;
	}

	public function deleteRos(){
		$data = $this->input->post();
		//gs($data);die;
		$repeat=$data['is_repeat_old'];
		$staff_id=$data['staff_id'];
		$week_day_date=$data['week_day_date'];
		$week_day=$data['day'];
		//$ros = $this->db->query("SELECT COUNT(ID) AS total FROM bookings where(staff_id=$staff_id and week_day=$week_day and (start_date<='$week_day_date' or end_repeat_date>='$week_day_date'))")->row();
		if($repeat==1 or $repeat==2){
			if($repeat==1){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and (week_day_date<='$week_day_date' or end_repeat_date>='$week_day_date'))")->row();
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}elseif($repeat==2){
				$ros = $this->db->query("SELECT COUNT(ID) AS total FROM roster where(staff_id=$staff_id and week_day=$week_day and (week_day_date<='$week_day_date' or end_repeat_date>='$week_day_date'))")->row();
				if($ros->total>0){
					echo json_encode(["type"=>"Error","message"=>"You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.","repeat"=>$repeat]);
					die;
				}
			}
			
		}
		//$this->db->delete('roster',array("common_number"=>$data['common_number']));
		$this->others->delete_record('roster',array("common_number"=>$data['common_number']));

		
		echo json_encode(["type"=>"success","message"=>"Shift Deleted Successfully"]);
					die;
	}

	public function deleteRepeatingShift(){
		$post_data = $this->input->post();
		$common_number_new = rand() . rand() . "_" . time();
		$start_hour_array = $post_data['start_hours'];
		$staff_id = $post_data['staff_id'];
		$week_day = $post_data['day'];
		$repeat = $post_data['repeat'];
		$week_day_date = $post_data['week_day_date'];
		$common_number = $post_data['common_number'];


		if ($repeat==2 && $post_data['repeatAction']!=0) {
			$week_day_date = strtotime($post_data['week_day_date']);
			$start = strtotime("-7 days", $week_day_date);			
			$end = strtotime($post_data['end_repeat_date']);
			$weekelydate=[];
			while($start < $end)
			{
			 $weekelydate[]=date("Y-m-d",strtotime("+7 days", $start));
			$start = strtotime("+7 days", $start);
			}
			
		}

		if ($repeat==1 && $post_data['repeatAction']!=0) {			
			$week_day_date = strtotime($post_data['week_day_date']);
			$start = strtotime("-7 days", $week_day_date);
			$end = strtotime("+3 month", $week_day_date);


			$weekelydate=[];
			while($start < $end)
			{
			 $weekelydate[]=date("Y-m-d",strtotime("+7 days", $start));
			$start = strtotime("+7 days", $start);
			}
			
		}

		if ($repeat==0 && $post_data['repeatAction']!=0) {
			$weekelydate[] = strtotime($post_data['week_day_date']);
			
		}

		//  print_r($weekelydate); exit;
	
		$this->db->select('count(bookings.id) AS booking_id')->from('bookings')->join('booking_services','bookings.id = booking_services.booking_id','inner');		
    	$this->db->where('booking_services.staff_id',$staff_id);
    	$this->db->where('bookings.location_id',$post_data['location'][0]);
    	if ($post_data['repeatAction']==0) {
    	 $this->db->where('bookings.start_date',$week_day_date);
    	    	}  
    	 else {
    	   $this->db->where_in('bookings.start_date',$weekelydate);
    	    	  	}  	
    	
    	//$this->db->where('start_time',$post_data['start_hours'][0]);    	
    	$this->db->where('bookings.business_id',$post_data['business_id']);     	
		$alreadybooking=$this->db->get()->row_array();

		//print_r($this->db->last_query()); exit;

		if ($alreadybooking['booking_id']>0) {
			echo json_encode(["type"=>"alreadybooking","message"=>"Seems like you have booking on the roaster you are trying to modify. Please re-allocate the booking first."]);
		die;
		}

		if($post_data['end_repeat_date'] !=""){
			$end_repeat_date = date("Y-m-d",strtotime($post_data['end_repeat_date']));
		}else{
			$end_repeat_date = null;
		}

		if($post_data['repeatAction']==0){
			$ros = $this->db->query("SELECT id FROM roster where(staff_id=$staff_id and week_day=$week_day and ( week_day_date <= '$week_day_date' and ( is_repeat=1 or ( is_repeat=2 and end_repeat_date >='$week_day_date') ) ))")->result_array();
			//print_r($this->db->last_query()); exit;
			
				//gs($ros);die;
				if($ros){
					// Update old dates with repeat or specific date
					$update_data = array(
							"end_repeat_date"=>date("Y-m-d",strtotime('-7 day',strtotime($week_day_date))),
							"is_repeat"=>2
						);
					foreach($ros as $preData){
					 $this->others->update_common_value("roster",$update_data,"id='".$preData['id']."' ");	
					}
				}
				//$this->db->select('*')->from('roster')->where('staff_id',$staff_id)->where('week_day',$week_day)->where('common_number',$common_number)->get()->result_array();				
             //print_r($this->db->last_query()); exit;

				//$this->db->delete('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'common_number'=>$common_number));
				

			foreach ($start_hour_array as $key => $value) {
				$insert_data = array(
					'week_day'=> $post_data['day'],
					'week_day_date'=>date("Y-m-d",strtotime('+7 day',strtotime($post_data['week_day_date']))),
					'staff_id'=> $post_data['staff_id'],
					'business_id'=> $post_data['business_id'],
					'location_id'=> $post_data['location'][$key],
					'start_hours'=> $post_data['start_hours'][$key],
					'end_hours'=> $post_data['end_hours'][$key],
					'is_break'=> $post_data['is_break'][$key],
					'break_name'=> $post_data['break_name'][$key],
					'is_repeat'=> $post_data['is_repeat_old'],
					'end_repeat_date'=> $end_repeat_date,
					'common_number'=> $common_number_new,
				);
			$this->others->insert_data("roster",$insert_data);	
		}
		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}else{

			$ros = $this->db->query("SELECT id FROM roster where(staff_id=$staff_id and week_day=$week_day and ( week_day_date <= '$week_day_date' and ( is_repeat=1 or ( is_repeat=2 and end_repeat_date >= '$week_day_date') ) ))")->result_array();
			//gs($ros);die;
				if($ros){
					// Update old dates with repeat or specific date
					$update_data = array(
							"end_repeat_date"=>date("Y-m-d",strtotime('-7 day',strtotime($week_day_date))),
							"is_repeat"=>2,
							"common_number"=>$common_number_new."_".rand(00,99)
						);
					foreach($ros as $preData){
					 $this->others->update_common_value("roster",$update_data,"id='".$preData['id']."' ");	
					}
				}

			//$this->db->delete('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'common_number'=>$post_data['common_number']));

			$this->others->delete_record('roster', array('staff_id' => $staff_id,'week_day'=>$week_day,'common_number'=>$post_data['common_number']));


		echo json_encode(["type"=>"success","message"=>"Roster Saved Successfully"]);
		die;
		}

	}

	public function set_attendence(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$post_data =$this->input->post();
		if(isset($post_data['location_id']) and $post_data['location_id'] !=""){
			$today_date = date("Y-m-d");
			$today_day = date("w");
			//date_default_timezone_set('Asia/Kolkata');
			$current_time = date("H:i:s",time());
			$insert_data = array(
				"posted_by"=>$admin_session['admin_id'],
				"staff_id"=>$admin_session['staff_id'],
				"business_id"=>$admin_session['business_id'],
				"location_id"=>$post_data['location_id'],
				"checkin_date"=>$today_date,
				"week_day"=>$today_day,
				"start_hours"=>$current_time,
				"status"=>0
			);
			$this->others->insert_data("staff_attendence",$insert_data);	
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			//date_default_timezone_set('Asia/Kolkata');
			$current_time = date("H:i:s",time());
			$attendence_id = $post_data['attendence_id'];
			$update_data = array(
				"end_hours"=>$current_time,
				"status"=>1
			);
			$success = $this->others->update_common_value("staff_attendence",$update_data,"id='".$attendence_id."' ");	
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/*public function attendence(){
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
  		$search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['attendence_active_open'] = true;
		$data['admin_session'] = $admin_session;
		$locations = $this->db->select(['id','location_name'])->from('location')->where(['business_id'=>$admin_session['business_id'],'status'=>1])->get()->result_array();
		$staffs = $this->db->select(['id','first_name','last_name'])->from('staff')->where(['business_id'=>$admin_session['business_id'],'status'=>1])->get()->result_array();
		//gs($staffs);
		$data['staffs'] = $staffs;
		$data['locations'] = $locations;
		$post_data = array();
		$records = array();
		$rec = array();
		if($admin_session['role']=="staff" && $this->input->post('action')==""){
			$records = $this->db->select('*')->from('staff_attendence')->where('business_id',$admin_session['business_id']);
			$records = $records->where(['staff_id'=>$admin_session['staff_id'],'checkin_date >='=>$search_form,'checkin_date <='=>$search_to]);
			$post_data['staff_id'] = $admin_session['staff_id'];
			$records = $records->get()->result_array();
		}

		if($this->input->post('action')){
			$records = $this->db->select('*')->from('staff_attendence')->where('business_id',$admin_session['business_id']);
			$post_data = $this->input->post();
			if($this->input->post('staff_id')){
				$staff_id = $this->input->post('staff_id');
				$records = $records->where('staff_id',$staff_id);
			}
			if($this->input->post('date_from')){
				$date_from = $this->input->post('date_from');
				$records = $records->where('checkin_date >=',$date_from);
			}
			if($this->input->post('date_to')){
				$date_to = $this->input->post('date_to');
				$records = $records->where('checkin_date <=',$date_to);
			}
			$records = $records->get()->result_array();			
		}
		foreach ($records as $key => $value) {
			$rec[$value['checkin_date']][] = $value;
		}
		$data['records'] = $rec;
		$data['post_data'] = $post_data;
		
		$this->load->view('admin/staff/attendence',$data);
	}*/

	public function attendence(){
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
  		$search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
		$date = date("Y-m-d");
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['attendence_active_open'] = true;
		$data['admin_session'] = $admin_session;
		$locations = $this->db->select(['id','location_name'])->from('location')->where(['business_id'=>$admin_session['business_id'],'status'=>1])->get()->result_array();
		//echo "<pre>"; print_r($locations); die;
		/*$staffs = $this->db->select(['id','first_name','last_name'])->from('staff')->where(['business_id'=>$admin_session['business_id'],'status'=>1])->get()->result_array();*/

		 $this->db->select('id,first_name,last_name');
		 $this->db->from('staff');
		 $this->db->where('status',1);
		 if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
		 	$this->db->where('business_id',$admin_session['business_id']);
		 }
		 if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
		 	$this->db->where('location_id',$admin_session['location_id']);
		 }		 
		 $staffs =$this->db->get()->result_array(); 
		//gs($staffs);
		
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.business_id'=>$admin_session['business_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
			$location_id = isset($locations[0])?$locations[0]['id']:'';
		}elseif($admin_session['role']=="location_owner"){
			$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
			$location_id = $admin_session['location_id'];
		}elseif($admin_session['role']=="staff"){
			$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.id'=>$admin_session['staff_id'],'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
			$location_id = $admin_session['location_id'];
		}
		//gs($staff_Data);
		$new_staff_data = array();
		if(count((array)$staff_Data)>0){
			foreach ($staff_Data as $key => $value) {
				$is_work  =  checkStaffAvailablityNew($value['id'],$date,$location_id);
				if(count((array)$is_work)>0){
					$new_staff_data[] = $value;
				}
			}
		}
		$data['all_staffs'] = $staffs;
		$data['staffs'] = $new_staff_data;
		//gs($data['staffs']);
		// $data['staffs'] = $staffs;
		$data['locations'] = $locations;
		$post_data['duration'] =null;
		$post_data['staff_id'] =null;
		$attendences = array();
		if($this->input->post('action')){
			$post_data = $this->input->post();

			if($post_data['duration']!=10){
				if($post_data['duration']==1){
					$dates_array = getLastWeekDates();
				}else{
					$dates_array = getPrevDates($post_data['duration']);
					//gs($dates_array);die;
				}
			}else{
				$dates_array = date_range($post_data['date_from'],$post_data['date_to']);
			}

			foreach ($dates_array as $key => $value) {
				$attendences[$value] = $this->db->select('*')->from('staff_attendence')->where(['staff_id'=>$post_data['staff_id'],'checkin_date'=>$value])->get()->result_array();
			}
		}
		$data['attendences']=$attendences;
		$data['post_data']=$post_data;
		
		$this->load->view('admin/staff/attendence',$data);
	}
	
	public function add_attendence_popup($date_on,$location_id ){
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
  		$search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
		$date = isset($date_on)?$date_on:date("Y-m-d");
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['attendence_active_open'] = true;
		$data['admin_session'] = $admin_session;
		$locations = $this->db->select(['id','location_name'])->from('location')->where(['business_id'=>$admin_session['business_id'],'status'=>1])->get()->result_array();
//echo $date; exit;
		/*$staff_Data = $this->db->select('*')->from('staff')->join('staff_attendence','staff_attendence.staff_id=staff.id','inner');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$this->db->where('staff_attendence.business_id',$admin_session['business_id']);
		}
		if ($admin_session['role']=="location_owner") {
	$this->db->where('staff_attendence.location_id',$admin_session['location_id']);			
		}
		$this->db->where(['staff.status'=>1,'staff_attendence.checkin_date'=>$date]);
		$this->db->group_by('staff.id')->get()->result_array();*/
		

		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){

			$staff_Data = $this->db->select('staff_attendence.*,staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->join('staff_attendence','staff.id=staff_attendence.staff_id','left')->where(['roster.business_id'=>$admin_session['business_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1,'staff_attendence.checkin_date'=>$date])->group_by('staff.id')->get()->result_array();
			if (count((array)$staff_Data)==0) {
				$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.business_id'=>$admin_session['business_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
			}

			


			if(empty($location_id)){
				$location_id = isset($locations[0])?$locations[0]['id']:'';
			}
		}elseif($admin_session['role']=="location_owner"){

			$staff_Data = $this->db->select('staff_attendence.*,staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->join('staff_attendence','staff.id=staff_attendence.staff_id','left')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1,'staff_attendence.checkin_date'=>$date])->group_by('staff.id')->get()->result_array();

			if (count((array)$staff_Data)==0) {
			$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
		}

			$location_id = $admin_session['location_id'];
		}elseif($admin_session['role']=="staff"){

			$staff_Data = $this->db->select('staff_attendence.*,staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->join('staff_attendence','staff.id=staff_attendence.staff_id','left')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.id'=>$admin_session['staff_id'],'staff.calendor_bookable_staff'=>1,'staff_attendence.checkin_date'=>$date])->group_by('staff.id')->get()->result_array();

			if (count((array)$staff_Data)==0) {
			$staff_Data = $this->db->select('staff.*')->from('staff')->join('roster','roster.staff_id=staff.id','inner')->where(['roster.location_id'=>$admin_session['location_id'],'staff.status'=>1,'staff.id'=>$admin_session['staff_id'],'staff.calendor_bookable_staff'=>1])->group_by('staff.id')->get()->result_array();
		}

			$location_id = $admin_session['location_id'];
		}
		//gs($staff_Data);
		$new_staff_data = array();
		if(count((array)$staff_Data)>0){
			foreach ($staff_Data as $key => $value) {
				$is_work  =  checkStaffAvailablityNew($value['id'],$date,$location_id);
				if(count((array)$is_work)>0){
					$new_staff_data[] = $value;
				}
			}
		}
		$data['staffs'] = $new_staff_data;
		
		// $data['staffs'] = $staffs;
		$data['locations'] = $locations;
		$post_data['duration'] =null;
		$post_data['staff_id'] =null;
		$attendences = array();
		if($this->input->post('action')){
			$post_data = $this->input->post();

			if($post_data['duration']!=10){
				if($post_data['duration']==1){
					$dates_array = getLastWeekDates();
				}else{
					$dates_array = getPrevDates($post_data['duration']);
					//gs($dates_array);die;
				}
			}else{
				$dates_array = date_range($post_data['date_from'],$post_data['date_to']);
			}

			foreach ($dates_array as $key => $value) {
				$attendences[$value] = $this->db->select('*')->from('staff_attendence')->where(['staff_id'=>$post_data['staff_id'],'checkin_date'=>$value])->get()->result_array();
			}
		}
		$data['attendences']=$attendences;
		$data['post_data']=$post_data;
		echo json_encode($data['staffs']);
		//$this->load->view('admin/staff/attendence',$data);
	}

	function add_manual_attendence(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if($this->input->post('action')){
			//echo "<pre>"; print_r($_POST);
			$post_data = $this->input->post();
			$today_date = $post_data['date'];
			$today_day = date("w",strtotime($post_data['date']));
			for ($i=0; $i <count((array)$post_data['staff_id']) ; $i++) { 
				if (!empty($post_data['location_id']) && !empty($post_data['staff_id'][$i])) {		
					
					$end_hours = date("H:i:s",strtotime($post_data['end_hours'][$i]));
					$start_hours = date("H:i:s",strtotime($post_data['start_hours'][$i]));		
			
			$business_id = getStaffBusinessId($post_data['staff_id'][$i]);

		$checkStaffAttandace=$this->db->select('*')->from('staff_attendence')->where(['staff_id'=>$post_data['staff_id'][$i],'checkin_date'=>$today_date,'location_id'=>$post_data['location_id']])->get()->num_rows();

		if ($checkStaffAttandace>0) {

			$insert_data = array(
				"posted_by"=>$admin_session['admin_id'][$i],
				"staff_id"=>$post_data['staff_id'][$i],
				"business_id"=>$business_id,
				"location_id"=>$post_data['location_id'],
				"checkin_date"=>$today_date,
				"week_day"=>$today_day,
				"start_hours"=>empty($post_data['start_hours'][$i]) ? NULL : $start_hours,
				"end_hours"=>empty($post_data['end_hours'][$i]) ? NULL : $end_hours, 
				"status"=>1
			);
			$where=array(
				"staff_id"=>$post_data['staff_id'][$i],
				"checkin_date"=>$today_date,
				"location_id"=>$post_data['location_id']
			);
			/*$this->db->where('staff_id',$post_data['staff_id'][$i]);
			$this->db->where('checkin_date',$today_date);
			$this->db->update('staff_attendence',$insert_data);*/
			$this->others->update_common_value("staff_attendence",$insert_data,$where);
			
		} else {
			$insert_data = array(
				"posted_by"=>$admin_session['admin_id'][$i],
				"staff_id"=>$post_data['staff_id'][$i],
				"business_id"=>$business_id,
				"location_id"=>$post_data['location_id'],
				"checkin_date"=>$today_date,
				"week_day"=>$today_day,
				"start_hours"=>empty($post_data['start_hours'][$i]) ? NULL : $start_hours,
				"end_hours"=>empty($post_data['end_hours'][$i]) ? NULL : $end_hours, 
				"status"=>1
			);
			
			$this->others->insert_data("staff_attendence",$insert_data);
		}
		

			
			}
			}

			
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	function saveUncompletedShift(){
		if($this->input->post('action')){
			$post_data = $this->input->post();
			$current_time = date("H:i:s",strtotime($post_data['end_hours']));
			$attendence_id = $post_data['attendence_id'];
			$update_data = array(
				"end_hours"=>$current_time,
				"status"=>1
			);
			$success = $this->others->update_common_value("staff_attendence",$update_data,"id='".$attendence_id."' ");	
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	function check_email($email)
    { 
                $this->db->select('email');
                $this->db->from('admin_users');
                $this->db->where('email',$email);

       $return_value = $this->db->get()->result_array();
      //  $this->db->get()->row();
        if ($return_value)
        {
            $this->form_validation->set_message('email_check', 'Sorry, This username is already used by another user please select another one');
            return FALSE;
        }
        else
        {
        return TRUE;
        }
    }

    public function default_staff(){
    	$admin_session = $this->session->userdata('admin_logged_in');
    	$data['admin_session']=$admin_session;
    	$locations = $this->db->select('*')->from('location')->where('business_id',$admin_session['business_id']);
    	if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
    		$locations = $locations->where('id',$admin_session['location_id']);
    	}
    	$locations = $locations->get()->result_array();
    	if($locations){
    		foreach ($locations as $key => $value) {
    			$staffs = $this->db->select('*')->from('staff')->where('location_id',$value['id'])->get()->result_array();
    			if($staffs){
    				$locations[$key]['staffs'] = $staffs;
    			}else{
    				unset($locations[$key]);
    			}
    		}
    	}
    	$data['locations'] = $locations;
    	$old_data = $this->db->select('*')->from('default_staff')->where('business_id',$admin_session['business_id'])->get()->result_array();
    	$default_staff = array();
    	if($old_data){
    		foreach ($old_data as $key => $value) {
    			$default_staff[$value['location_id']] = $value['status']; 
    		}
    	}
    	$data['default_staff'] = $default_staff;
		if($this->input->post('action')){
			$staffs = $this->input->post('status'); 
			foreach ($staffs as $key => $value) {

				//$this->db->delete('default_staff', array('location_id' => $key)); 
				$this->others->delete_record("default_staff","location_id='".$key."'");

				$insert_data = array(
					"business_id"=>$admin_session['business_id'],
					"location_id"=>$key,
					"status"=>$value
				);
				$this->others->insert_data("default_staff",$insert_data);
			}
			return redirect(base_url('admin/staff/default_staff'));
		}    	
    	$this->load->view('admin/staff/default_staff',$data);
    }

		
}
 