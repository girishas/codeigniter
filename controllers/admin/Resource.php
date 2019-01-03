<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('resources_model', '', TRUE);
        $this->__clear_cache();
		$admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['admin_email'] =='') {
			redirect('admin');
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
				///$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("resources","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Resource are deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No records are selected to delete!");
			}	
			redirect(base_url('admin/resource'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/resource') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = $admin_session['business_id'];
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
		
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$arr_search['business_id'] = $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			//$arr_search['location_id'] = $admin_session['location_id'];
			$arr_search['location_id'] = $admin_session['location_id'];
		}
		 		
		$all_records = $this->resources_model->get_resources(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->resources_model->get_resources(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/resource/all_resources', $data);
	}
	
	public function add_resource()
	{
		
		$admin_session = $this->session->userdata('admin_logged_in');

        if($this->input->post('action')){
			
			$this->load->library('form_validation');
			if($admin_session['role'] == 'owner'){
				$this->form_validation->set_rules('business_id', 'Business', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			$this->form_validation->set_rules('resource_name', 'Resource Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
			

			if ($this->form_validation->run() == TRUE) {
				
				if($admin_session['role'] == 'owner'){
					$business_id = $this->input->post('business_id');
				}else if($admin_session['role'] == 'business_owner'){
					$business_id = $admin_session['business_id'];
				}else{
					$business_id = $admin_session['business_id'];
				} 

				$insert_data = array(

					'business_id'=> $business_id,
					'location_id'=> $this->input->post('location_id'),
					'resource_name'=> $this->input->post('resource_name'),
					'quantity'=> $this->input->post('quantity'),
					'description'=> $this->input->post('description'),
					'date_created'=> date('Y-m-d H:i:s')
				);
				
				$success = $this->others->insert_data("resources",$insert_data);

				if ($success) {
					$this->session->set_flashdata('success_msg', "Resource is added successfully!");
					redirect(base_url('admin/resource'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding resource is failed!");
					redirect(base_url('admin/resource'));
				}
			}
			
		}
		
		$data['business_id'] = $this->input->post('business_id');
		$data['location_id'] = $this->input->post('location_id');
		$data['resource_name'] = $this->input->post('resource_name');
		$data['quantity'] = $this->input->post('quantity');
		$data['description'] = $this->input->post('description');

		// Get Business List
		$where = array('role' => 'business_owner');
		$this->db->where($where);
		$all_business = $this->others->get_all_table_value("admin_users","id,business_id,admin_name","","admin_name","ASC");
		if($all_business) {
			$data['all_business'] = $all_business;
		}
		
		// Get Location List
		$search = array();
		if($admin_session['role']!='owner')
		{
			$search = array('business_id'=>$admin_session['business_id']);
		}
		 $all_location = $this->others->get_all_table_value("location","id,location_name",$search,"location_name","ASC");
		 if($all_location) {
		 	$data['all_location'] = $all_location;
		 }

		$data['setup_active_open']=true;
		$this->load->view('admin/resource/add_resource', $data);
	}

	public function edit_resource($id='')
	{
			$data['setup_active_open']=true;
		$admin_session = $this->session->userdata('admin_logged_in');

        if($this->input->post('action')){
			
			$this->load->library('form_validation');
			if($admin_session['role'] == 'owner'){
				$this->form_validation->set_rules('business_id', 'Business', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('location_id', 'Location', 'trim|required|xss_clean');
			$this->form_validation->set_rules('resource_name', 'Resource Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
			

			if ($this->form_validation->run() == TRUE) {

				if($admin_session['role'] == 'owner'){
					$business_id = $this->input->post('business_id');
				}else if($admin_session['role'] == 'business_owner'){
					$business_id = $admin_session['business_id'];
				}else{
					$business_id = $admin_session['business_id'];
				}  
				
				$updateData = array(

					'business_id'=> $business_id,
					'location_id'=> $this->input->post('location_id'),
					'resource_name'=> $this->input->post('resource_name'),
					'quantity'=> $this->input->post('quantity'),
					'description'=> $this->input->post('description'),
					'date_created'=> date('Y-m-d H:i:s')
				);

				
				$where = array('id'=>$this->uri->segment(4));
				$success = $this->others->update_common_value("resources",$updateData,$where);

				if ($success) {
					$this->session->set_flashdata('success_msg', "Resource is updated successfully!");
					redirect(base_url('admin/resource'));
				} 
			}
			
		}
		
		$data['business_id'] = $this->input->post('business_id');
		$data['location_id'] = $this->input->post('location_id');
		$data['resource_name'] = $this->input->post('resource_name');
		$data['quantity'] = $this->input->post('quantity');
		$data['description'] = $this->input->post('description');

		// Get Business List
		$where = array('role' => 'business_owner');
		$this->db->where($where);
		$all_business = $this->others->get_all_table_value("admin_users","id,business_id,admin_name","","admin_name","ASC");
		if($all_business) {
			$data['all_business'] = $all_business;
		}

		// Get Location List	
		$all_location = $this->others->get_all_table_value("location","id,location_name","","location_name","ASC");
		if($all_location) {
			$data['all_location'] = $all_location;
		}

		//Get Resources List
		$where = array('id'=>$id);
		$all_resources = $this->others->get_all_table_value("resources","",$where,"","");
		if($all_resources) {
			$data['all_resources'] = $all_resources;
		}
		//print_r($all_resources);die;
		
		$data['resource_active_open']=true;
		$this->load->view('admin/resource/edit_resource', $data);
	}


	// invoice list all************
	public function all_invoice()
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
				///$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("invoices","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Invoice has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No invoice are selected to delete!");
			}	
			redirect(base_url('admin/resource/all_invoice'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/resource/all_invoice') .'?'.$get_string;
		
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
		 		
		$all_records = $this->resources_model->get_invoices(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->resources_model->get_invoices(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['invoice_active_open']=true;
		$this->load->view('admin/resource/all_invoices', $data);
	}
	// invoice list all************







}
