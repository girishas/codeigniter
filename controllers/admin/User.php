<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
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
	
	public function change_password()
	{
		$data = array();
		$admin_session = $this->session->userdata('admin_logged_in');

		if($this->input->post('action'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('admin_retype_password', 'Re-enter password', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) 
			{

				$password = $this->input->post('password');
				$re_password = $this->input->post('admin_retype_password');

				if($password == $re_password)
				{
					
					$updateData = array('password' => md5($this->input->post('password')));
					$this->user_model->update_user($admin_session['admin_id'],$updateData);
					$this->session->set_flashdata('success_msg', "Password has been changed successfully!");
					redirect('admin/user/change_password');
				}
				else
				{
					$this->session->set_flashdata('error_msg', "Password & Verify Password not matched!");
					redirect('admin/user/change_password');

				}
			}
			
		}

		$data['setup_active_open']=true;
	 	$this->load->view('admin/user/change_password', $data);
	}
	 
	public function index()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		
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
        $config['base_url'] = base_url('user') .'?'.$get_string;
		
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
		/*if($admin_session['role']=="business_owner"){
			$arr_search['role'] = 'location_owner'; 
		}*/		
		
		$all_users = $this->user_model->get_admin_users(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_users){
			$data['all_users']= $all_users;
			$count_all_users = $this->user_model->get_admin_users(true,$arr_search);
            $config['total_rows'] = $count_all_users;
			$data['total_records'] = $count_all_users;
		}
		$this->pagination->initialize($config);		
		
		$data['admin_active_open']=true;
		if($admin_session['role']=="owner"){
			$this->load->view('admin/user/all_admin', $data);
		}/*else{
			$this->load->view('admin/user/all_admin_user', $data);
		}*/
		
	}
	
	public function add_admin()
	{
		if($this->input->post('action')){
			
			$role = $this->input->post('role');
			$business_id = $this->input->post('business_id');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
			$this->form_validation->set_rules('business_id', 'Business', 'trim|required|xss_clean');
			if($role=="location_owner"){
				$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			$data['role'] = $this->input->post('role');
			$data['admin_name'] = $this->input->post('admin_name');
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			if($role=="location_owner" && $business_id!=""){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
				$data['locations'] = $locations;
			}
			if ($this->form_validation->run() == TRUE) {
				$insert_data = array('admin_name'=>$this->input->post('admin_name'),
					'email'=>$this->input->post('email'),
					'password'=>md5($this->input->post('password')),
					'role'=>$this->input->post('role'),
					'business_id'=>$this->input->post('business_id'),
					'location_id'=>$this->input->post('location_id'),
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("admin_users",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Admin is added successfully!");
					redirect(base_url('admin/user'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding admin is failed!");
					redirect(base_url('admin/user/add_admin'));
				}
			}
		}		
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;
		$data['admin_active_open']=true;
		$this->load->view('admin/user/add_admin', $data);
	}
	
	public function edit_admin($id='')
	{
		if ($id != '' && is_numeric($id)) {			
			$admin_detail = $this->others->get_all_table_value("admin_users","*","id='".$id."'");
			if($admin_detail){
				if($this->input->post('action')){					
					$role = $this->input->post('role');
					$business_id = $this->input->post('business_id');
					$password = $this->input->post('password');
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
					$this->form_validation->set_rules('business_id', 'Business', 'trim|required|xss_clean');
					if($role=="location_owner"){
						$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
					}
					$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
										
					if($role=="location_owner" && $business_id!=""){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
						$data['locations'] = $locations;
					}
					if ($this->form_validation->run() == TRUE) {
						$update_data['role'] = $this->input->post('role');
						$update_data['admin_name'] = $this->input->post('admin_name');
						$update_data['email'] = $this->input->post('email');
						if(!empty($password)){
							$update_data['password'] = $this->input->post('password');
						}
						$update_data['business_id'] = $this->input->post('business_id');
						$update_data['location_id'] = $this->input->post('location_id');
										
						$success = $this->others->update_common_value("admin_users",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "User is updated successfully!");
						redirect(base_url('admin/user'));
					}
				}
				if($admin_detail[0]['role']=="location_owner" && $admin_detail[0]['business_id']!=""){
						$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_detail[0]['business_id']."' ","location_name","ASC");
						$data['locations'] = $locations;
					}
				$data['admin_detail'] = $admin_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;
		
		$data['admin_active_open']=true;
		$this->load->view('admin/user/edit_admin', $data);
	}
	
	public function add_admin_user()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		$business_id = $admin_session['business_id'];
		if($this->input->post('action')){
			
			$this->load->library('form_validation');			
			$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			$data['role'] = $this->input->post('role');
			$data['admin_name'] = $this->input->post('admin_name');
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');
			$data['location_id'] = $this->input->post('location_id');
			
			if ($this->form_validation->run() == TRUE) {
				$insert_data = array('admin_name'=>$this->input->post('admin_name'),
					'email'=>$this->input->post('email'),
					'password'=>md5($this->input->post('password')),
					'role'=>'location_owner',
					'business_id'=>$business_id,
					'location_id'=>$this->input->post('location_id'),
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("admin_users",$insert_data);
				if ($success) {
					$this->session->set_flashdata('success_msg', "Admin is added successfully!");
					redirect(base_url('admin/user'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding admin is failed!");
					redirect(base_url('admin/user/add_admin_user'));
				}
			}
		}		
		
		$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
		$data['locations'] = $locations;
		
		$this->load->view('admin/user/add_admin_user', $data);
	}
	
	public function edit_admin_user($id='')
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$data['admin_session']= $admin_session;
		$business_id = $admin_session['business_id'];
		if ($id != '' && is_numeric($id)) {			
			$admin_detail = $this->others->get_all_table_value("admin_users","*","id='".$id."'");
			if($admin_detail){
				if($this->input->post('action')){					
					$role = $this->input->post('role');
					$business_id = $this->input->post('business_id');
					$password = $this->input->post('password');
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
					$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {
						$update_data['admin_name'] = $this->input->post('admin_name');
						$update_data['email'] = $this->input->post('email');
						if(!empty($password)){
							$update_data['password'] = $this->input->post('password');
						}
						$update_data['location_id'] = $this->input->post('location_id');
						$success = $this->others->update_common_value("admin_users",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "User is updated successfully!");
						redirect(base_url('admin/user'));
					}
				}
				$data['admin_detail'] = $admin_detail;
			}
		}
		
		$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$business_id."' ","location_name","ASC");
		$data['locations'] = $locations;
		
		$data['admin_active_open']=true;
		$this->load->view('admin/user/edit_admin_user', $data);
	}

	public function change_staff_profile(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$user_id = $admin_session['staff_id'];
		$staff_detail = $this->others->get_all_table_value("staff","*","id='".$user_id."'");
			if($staff_detail){
				if($this->input->post('action')){
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
					$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean');
					//$this->form_validation->set_rul
					$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
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
						if($picture!=""){

							$update_data['picture'] = $picture;
						}																	
						$success = $this->others->update_common_value("staff",$update_data,"id='".$user_id."' ");
						$updateData 	= array(
						'admin_name' 			=> $this->input->post('first_name')." ".$this->input->post('last_name'),
						'email' 				=> $this->input->post('email'),
					);

					$where = array('id' => $admin_session['admin_id']);
					$this->others->update_common_value("admin_users",$updateData,$where);

					$this->session->set_flashdata('success_msg', "Profile updated successfully!");
						redirect(base_url('admin/user/change_staff_profile'));
					}
				}
				//echo "<pre>";print_r($staff_detail); echo "</pre>";die;
				$data['staff_detail'] = $staff_detail;
			}
			$all_countries = $this->others->get_all_table_value("country","name,iso_code","","name","ASC");
		if($all_countries) {
			$data['all_countries'] = $all_countries;
		}
		$data['admin_session']= $admin_session;
		$this->load->view('admin/user/change_staff_profile',$data);
	}

	public function change_owner_profile(){
		$admin_session = $this->session->userdata('admin_logged_in');
		$user_id = $admin_session['admin_id'];
		$get_data = $this->others->get_all_table_value("admin_users","*","id='".$user_id."'");
		$data['data'] = $get_data[0];
		if($this->input->post('action')){
					
					$this->load->library('form_validation');
					$this->form_validation->set_rules('admin_name', 'Name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {
						$updateData 	= array(
						'admin_name' 			=> $this->input->post('admin_name')." ".$this->input->post('last_name'),
						'email' 				=> $this->input->post('email'),
					);

					$where = array('id' => $admin_session['admin_id']);
					$this->others->update_common_value("admin_users",$updateData,$where);
					$this->session->set_flashdata('success_msg', "Profile updated successfully!");
						redirect(base_url('admin/user/change_owner_profile'));
					}
				}
		$this->load->view('admin/user/change_owner_profile',$data);
	}
	
	public function access()
	{
		$data['admin_active_open']=true;
		$this->load->view('admin/user/access', $data);
	}
		
}
