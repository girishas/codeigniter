<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	use Twilio\Rest\Client;
	class Service extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('service_model', '', TRUE);
			$this->__clear_cache();
			$admin_session = $this->session->userdata('admin_logged_in');
			if($admin_session['admin_email'] =='') {
				redirect('admin');
			}
			$this->timezone();
			// date_default_timezone_set("US/Samoa");
			//date_default_timezone_set("US/Samoa");
			//   echo date_default_timezone_get();
			// $time =  Date('Y-m-d H:i:s');
			// echo $time;die;
		}
		
		private function __clear_cache() {
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		} 
		
		/*public function index()
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
			$this->others->delete_record("services","id='".$item."' ".$condition);
			// delete service_timing
			$this->others->delete_record("service_timing","service_id=".$item);
			// delete service_timing
			
			// delete staff_services
			$this->others->delete_record("staff_services","service_id=".$item);
			// delete staff_services
			
			$count_records ++;
			}
			if($count_records>0){
			$this->session->set_flashdata('success_msg', "Service has been deleted successfully!");
			}else{
			$this->session->set_flashdata('error_msg', "No service are selected to delete!");
			}	
			redirect(base_url('admin/service'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$arr_search['business_id'] = $admin_session['business_id'];
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			//$arr_search['location_id'] = $admin_session['location_id'];
			$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_services = $this->service_model->get_services(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
			if($all_services){
			$data['all_services']= $all_services;
			$count_all_records = $this->service_model->get_services(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/all_services', $data);
		}*/
		
		public function index()
		{					
			$admin_session = $this->session->userdata('admin_logged_in');
			$all_services = array();
			if($admin_session['role']=="owner"){
				
				if($admin_session['business_id'] ==""){
					$all_services = $this->db->select('id,service_name,description,service_category_id,service_resource_list,is_online,sku')->from('services')->where(['service_class_type'=>1])->order_by('sku','ASC')->get()->result_array();
					}else{
					$all_services = $this->db->select('id,service_name,description,service_category_id,service_resource_list,is_online,sku')->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->order_by('sku','ASC')->get()->result_array();
				}
				}else{
				$all_services = $this->db->select('id,service_name,description,service_category_id,service_resource_list,is_online,sku')->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->order_by('sku','ASC')->get()->result_array();
				
			}
			if(count((array)$all_services)>0){
				foreach ($all_services as $key => $value) {
					$all_services[$key]['service_timing'] = $this->db->select('*')->from('service_timing')->where(['service_id'=>$value['id'],'status'=>1])->group_by('service_id')->get()->result_array();
					/*foreach ($all_services[$key]['service_timing'] as $kkey => $vvalue) {
						$all_services[$key]['service_timing']['is_online'] = $value['is_online'];
					}*/
				}
			}
			
			$this->db->select('*,services.id,services.service_name,services.description,services.service_category_id,services.service_resource_list,services.is_online,services.sku');
			$this->db->from('services');
			$this->db->join('service_timing', 'services.id= service_timing.service_id','inner');
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner" || $admin_session['role']=="location_owner")){
				$this->db->where('service_timing.business_id',$admin_session['business_id']);
			}
			$this->db->where("service_timing.status",1);
			//$this->db->group_by('services.id');
			$this->db->order_by('services.sku','ASC');
			$data['all_services']=$this->db->get()->result_array();
			
			
			
			
			//gs($all_services);die;
			$data['service_active_open']=true;
			//$data['all_services']=$all_services;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_services', $data);
		}
		
		
		
		
		
		public function add_service()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			// if post add service form
			if($this->input->post('add_service'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id1', 'business_id1', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('service_name', 'service_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('service_category_id', 'service_category_id', 'required|xss_clean');
				//$this->form_validation->set_rules('service_resource_list', 'service_resource_list', 'required|xss_clean');
				//$this->form_validation->set_rules('is_gst_tax', 'is_gst_tax', 'required|xss_clean');
				
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id1'] = $business_id1 = $this->input->post('business_id1');
					}else{
					$data['business_id1'] = $business_id1 = $admin_session['business_id'];
				}
				
				$data['service_name'] 			= $service_name = $this->input->post('service_name');
				$data['description'] 			= $description = $this->input->post('description');
				$data['service_category_id'] 	= $service_category_id = $this->input->post('service_category_id');
				
				
				
				if( $this->input->post('is_online') == 'on' ){
					$data['is_online'] = $is_online = 1;
				}
				else{
					$data['is_online'] = $is_online = 0;
				}
				
				if( $this->input->post('is_gst_tax') == 'on' ){
					$data['is_gst_tax'] = $is_gst_tax = 1;
				}
				else{
					$data['is_gst_tax'] = $is_gst_tax = 0;
				}
				
				if( $this->input->post('is_extra_time') == 'on' ){
					$data['is_extra_time'] = $is_extra_time = 1;
				}
				else{
					$data['is_extra_time'] = $is_extra_time = 0;
				}
				if( $this->input->post('is_service_group') == 'on' ){
					$data['is_service_group'] = $is_service_group = 1;
				}
				else{
					$data['is_service_group'] = $is_service_group = 0;
				}
				
				
				$data['extra_time_before'] 		= $extra_time_before = $this->input->post('extra_time_before');
				$data['extra_time_after'] 		= $extra_time_after = $this->input->post('extra_time_after');
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					
					
					$inserData 	= array(
					'business_id' 			=> $business_id1,
					'service_name' 			=> $service_name, 
					'description' 			=> $description,
					'service_category_id'   => $service_category_id, 
					//'service_resource_list' => $service_resource_list, 
					'is_online'				=> $is_online, 
					'sku'					=> $this->input->post('sku'), 
					'is_gst_tax' 			=> $is_gst_tax,
					'is_extra_time'			=> $is_extra_time, 
					'is_service_group'		=> $is_service_group, 
					'extra_time_before' 	=> clockalize($extra_time_before),
					'extra_time_after'		=> clockalize($extra_time_after),
					'service_name'			=> $service_name,
					'date_created'  		=> date('Y-m-d H:i:s'),
					);
					//gs($inserData);die;
					
					if($this->input->post('service_resource_list')){
						
						$service_resource_list = array();
						$service_resource_list = $this->input->post('service_resource_list');
						$service_resource_list = implode(",",$service_resource_list);
						
						$inserData['service_resource_list'] = $service_resource_list; 
					}
					
					$return = $this->others->insert_data("services",$inserData);
					$service_id = $return;
					
					
					// start service timing 
					
					$data['caption'] 		= $caption = $this->input->post('caption');
					$data['duration'] 		= $duration = $this->input->post('duration');
					$data['retail_price'] 	= $retail_price = $this->input->post('retail_price');
					$data['special_price'] 	= $special_price = $this->input->post('special_price');
					
					
					
					$inserData = array();
					foreach ( $_POST as $key => $value )
					{
						$inserData[$key] = $this->input->post($key);
						unset($inserData['service_timing']);
						//$this->others->insert_data("service_timing",$inserData);
					}
					
					// count no of rows
					$temp =count((array)$this->input->post('caption'));
					
					for($i=0; $i<$temp;$i++){
						
						if($admin_session['role'] == 'owner') { 
							$data2 = array(
							'business_id' 	=> $business_id1,
							'service_id' 		=> $service_id,
							'caption' 		=> $caption[$i],
							//'duration' 		=> $duration[$i],
							'duration' 		=> clockalize($duration[$i]),
							'retail_price' 	=> $retail_price[$i],
							'special_price' 	=> $special_price[$i]
							);
							
							$return = $this->others->insert_data("service_timing",$data2);
						}
						else{
							$data2 = array(
			   				'business_id' 	=> $business_id1,
						  	'service_id' 	=> $service_id,
						  	'caption' 		=> $caption[$i],
						  	//'duration' 		=> $duration[$i],
						  	'duration' 		=> clockalize($duration[$i]),
						  	'retail_price' 	=> $retail_price[$i],
						  	'special_price' => $special_price[$i]
							);
							
							$return = $this->others->insert_data("service_timing",$data2);
						}
						
						
					}
					
					
					// end service timing
					
					if($return == true){
						$this->session->set_flashdata('success_msg', "Service added successfully!");
						redirect(base_url('admin/service'));
					}
				}
			}
			
			
			
			// get all business for add service
			if($admin_session['role'] == 'owner'){
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
			}
			
			// get all service category for add service
			$cat_type = 1;
			$all_service_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
			if($all_service_category) {
				$data['all_service_category'] = $all_service_category;
			}
			
			// get all resources for add service
			$all_resources = $this->others->get_all_table_value("resources","id,resource_name","","resource_name","ASC");
			if($all_resources) {
				$data['all_resources'] = $all_resources;
			}
			
			// get all business Service Timing
			$all_service = $this->others->get_all_table_value("services","id,service_name","","service_name","ASC");
			if($all_service) {
				$data['all_service'] = $all_service;
			}
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_service', $data);
		}
		
		
		public function edit_service($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			//$this->input->post('extra_time_after');die;
			// if post add service form
			
			if($this->input->post('edit_service'))
			{ 
				//print_r($_POST); exit;
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id1', 'business_id1', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('service_name', 'service_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('service_category_id', 'service_category_id', 'required|xss_clean');
				//$this->form_validation->set_rules('service_resource_list', 'service_resource_list', 'required|xss_clean');
				//$this->form_validation->set_rules('is_gst_tax', 'is_gst_tax', 'required|xss_clean');
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id1'] = $business_id1 = $this->input->post('business_id1');
					}else{
					$data['business_id1'] = $business_id1 = $admin_session['business_id'];
				}
				
				$data['service_name'] 			= $service_name = $this->input->post('service_name');
				$data['description'] 			= $description = $this->input->post('description');
				$data['service_category_id'] 	= $service_category_id = $this->input->post('service_category_id');
				
				$data['service_timing_id']  = $service_timing_id = $this->input->post('service_timing_id');
				
				
				if( $this->input->post('is_online') == 'on' ){
					$data['is_online'] = $is_online = 1;
				}
				else{
					$data['is_online'] = $is_online = 0;
				}
				
				if( $this->input->post('is_gst_tax') == 'on' ){
					$data['is_gst_tax'] = $is_gst_tax = 1;
				}
				else{
					$data['is_gst_tax'] = $is_gst_tax = 0;
				}
				
				if( $this->input->post('is_extra_time') == 'on' ){
					$data['is_extra_time'] = $is_extra_time = 1;
				}
				else{
					$data['is_extra_time'] = $is_extra_time = 0;
				}
				if( $this->input->post('is_service_group') == 'on' ){
					$data['is_service_group'] = $is_service_group = 1;
				}
				else{
					$data['is_service_group'] = $is_service_group = 0;
				}
				
				
				$data['extra_time_before'] 		= $extra_time_before = $this->input->post('extra_time_before');
				$data['extra_time_after'] 		= $extra_time_after = $this->input->post('extra_time_after');
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					
					
					$updateData 	= array(
					'business_id' 			=> $business_id1,
					'service_name' 			=> $service_name, 
					'description' 			=> $description,
					'service_category_id'   => $service_category_id, 
					//'service_resource_list' => $service_resource_list, 
					'is_online'				=> $is_online, 
					'sku'					=> $this->input->post('sku'), 
					'is_gst_tax' 			=> $is_gst_tax,
					'is_extra_time'			=> $is_extra_time, 
					'is_service_group'			=> $is_service_group, 
					'extra_time_before' 	=> clockalize($extra_time_before),
					'extra_time_after'		=> clockalize($extra_time_after),
					'service_name'			=> $service_name,
					'date_updated'  		=> date('Y-m-d H:i:s'),
					);
					
					if($this->input->post('service_resource_list')){
						
						$service_resource_list = array();
						$service_resource_list = $this->input->post('service_resource_list');
						$service_resource_list = implode(",",$service_resource_list);
						
						$updateData['service_resource_list'] = $service_resource_list; 
					}
					
					$where = array('id' => $id);
					$return = $this->others->update_common_value("services",$updateData,$where);
					
					// start service timing 
					
					$data['caption'] 		= $caption = $this->input->post('caption');
					$data['duration'] 		= $duration = $this->input->post('duration');
					$data['retail_price'] 	= $retail_price = $this->input->post('retail_price');
					$data['special_price'] 	= $special_price = $this->input->post('special_price');
					
					// start delete existing records
					//$where = array('service_id' => $id);
					//$this->others->delete_record("service_timing",$where);
					// end delete existing records
					
					
					/*$this->db->select('*');
						$this->db->from('service_timing');
						$this->db->where('service_id',$id);
						$this->db->where_not_in('id',$service_timing_id);
					$this->db->get()->row_array();*/
					
					
					$inserData = array();
					foreach ( $_POST as $key => $value )
					{
						$inserData[$key] = $this->input->post($key);
						unset($inserData['service_timing']);
						//$this->others->insert_data("service_timing",$inserData);
					}
					
					// count no of rows
					$temp =count((array)$this->input->post('caption'));
					//echo $temp; exit; 
					$id_service_timing =$this->input->post('service_timing_id');
					//print_r($id_service_timing); exit;
					
					$countservice_timing_id =count((array)$this->input->post('service_timing_id'));
					//echo $countservice_timing_id; exit;
					
					for($i=0; $i<$temp;$i++){
						$service_timing_id=	$id_service_timing[$i];
						//echo $service_timing_id; exit;
						//echo $countservice_timing_id.','.$i.'</br>';
						if($admin_session['role'] == 'owner' &&($i>=$countservice_timing_id)) { 
							$data2 = array(
							'business_id' 	=> $business_id1,
							'service_id' 		=> $id,
							'caption' 		=> $caption[$i],
							//'duration' 		=> $duration[$i],
							'duration' 		=> clockalize($duration[$i]),
							'retail_price' 	=> $retail_price[$i],
							'special_price' 	=> $special_price[$i]
							);
							
							$return = $this->others->insert_data("service_timing",$data2);
						}
						elseif ($i>=$countservice_timing_id){
							$data2 = array(
			   				'business_id' 	=> $business_id1,
						  	'service_id' 	=> $id,
						  	'caption' 		=> $caption[$i],
						  	//'duration' 		=> $duration[$i],
						  	'duration' 		=> clockalize($duration[$i]),
						  	'retail_price' 	=> $retail_price[$i],
						  	'special_price' => $special_price[$i]
							);
							
							$return = $this->others->insert_data("service_timing",$data2);
						}
						
						elseif (!empty($service_timing_id) || $service_timing_id>0) {
							//echo $service_timing_id;// exit;
							echo $id_service_timing[$i];
							$data2 = array(
			   				'business_id' 	=> $business_id1,
						  	'service_id' 	=> $id,
						  	'caption' 		=> $caption[$i],
						  	//'duration' 		=> $duration[$i],
						  	'duration' 		=> clockalize($duration[$i]),
						  	'retail_price' 	=> $retail_price[$i],
						  	'special_price' => $special_price[$i]
							);
							$this->db->where('id', $id_service_timing[$i]);
							$this->db->where('service_id', $id);
							$return=$this->db->update('service_timing', $data2);
						}
						//print_r($this->db->last_query()); echo "</br>"; 
						
						
					}
					
					//echo " hi"; exit;
					
					// end service timing
					
					if($return == true){
						$this->session->set_flashdata('success_msg', "Service updated successfully!");
						redirect(base_url('admin/service'));
					}
					
				}
			}
			
			// get template details
			if(!empty($id)){
				$service_details = $this->others->get_all_table_value("services","*","id='".$id."'");
				$data['service_details'] = $service_details;
			}
			//print_r($data['service_details']);die;
			
			
			// get service timing details
			if(!empty($id)){
				$con = array(
				"service_id"=>$id,
				"status"=>1
				);
				$service_timing_details = $this->others->get_all_table_value("service_timing","*",$con,"id","asc");
				$data['service_timing_details'] = $service_timing_details;
			}
			//print_r($data['service_timing_details']);die;
			
			// get all business for add service
			if($admin_session['role'] == 'owner'){
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
			}
			
			// get all service category for add service
			$cat_type = 1;
			$all_service_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
			//print_r($all_service_category); exit;
			if($all_service_category) {
				$data['all_service_category'] = $all_service_category;
			}
			
			// get all resources for add service
			$all_resources = $this->others->get_all_table_value("resources","id,resource_name","","resource_name","ASC");
			if($all_resources) {
				$data['all_resources'] = $all_resources;
			}
			
			// get all business Service Timing
			$all_service = $this->others->get_all_table_value("services","id,service_name","","service_name","ASC");
			if($all_service) {
				$data['all_service'] = $all_service;
			}
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/edit_service', $data);
		}
		
		public function all_service_category()
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
					$this->others->delete_record("service_category","id='".$item."' ".$condition);
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Service category has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No service category are selected to delete!");
				}	
				redirect(base_url('admin/service/all_service_category'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service/all_service_category') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner" || $admin_session['role']=="location_owner")){
				$arr_search['business_id'] = $admin_session['business_id'];
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$arr_search['location_id'] = $admin_session['location_id'];
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			$this->db->select('*');
			$this->db->from('service_category');
			$this->db->where('cat_type',1);
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner" || $admin_session['role']=="location_owner")){
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			$this->db->order_by('short_number', 'ASC');
			
	   		$data['all_service_category']= $this->db->get()->result_array();
			
			
			/*$all_service_category = $this->service_model->get_service_category(false,$arr_search,$per_page, $config['offset'],"short_number","ASC");*/
			//print_r($this->db->last_query()); exit;
			
			/*if($all_service_category){
				$data['all_service_category']= $all_service_category;
				$count_all_records = $this->service_model->get_service_category(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
				}
			$this->pagination->initialize($config);*/
			
			
			$data['service_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_service_categories', $data);
		}
		
		
		public function add_service_category()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post())
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('short_number', 'Short Number', 'numeric|required|xss_clean');
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				//echo $business_id;die;
				$data['name'] 	= $name = $this->input->post('name');
				$data['short_number'] 	= $short_number = $this->input->post('short_number');
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					$inserData 	= array(
					'business_id'	=> $business_id,
					'name' 			=> $name,
					'short_number' 	=> $short_number,
					'date_created'  => date('Y-m-d H:i:s'),
					);
					
					//gs($inserData);
					$return = $this->others->insert_data("service_category",$inserData);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Service Category added successfully!");
						redirect(base_url('admin/service/all_service_category'));
					}
				}
			}
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_service_categories', $data);
		}
		
		
		public function edit_service_category($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('edit_service_category'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('short_number', 'Short Number', 'numeric|required|xss_clean');
				
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				$data['name'] 	= $name = $this->input->post('name');
				$data['short_number'] 	= $short_number = $this->input->post('short_number');
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					$updateData 	= array(
					'business_id'	=> $business_id,
					'name' 			=> $name,
					'short_number' 	=> $short_number,
					'date_created'  => date('Y-m-d H:i:s'),
					);
					$where = array('id' => $id);
					$return = $this->others->update_common_value("service_category",$updateData,$where);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Service Category updated successfully!");
						redirect(base_url('admin/service/all_service_category'));
					}
				}
			}
			
			// get template details
			if(!empty($id)){
				$service_category_details = $this->others->get_all_table_value("service_category","*","id='".$id."'");
				$data['service_category_details'] = $service_category_details;
			}
			//print_r($data['service_category_details']);die;
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/edit_service_categories', $data);
		}
		
		public function all_packages()
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
					$this->others->delete_record("packages","id='".$item."' ".$condition);
					// delete package_services
					$record = $this->others->get_all_table_value("package_services","package_id","package_id='".$item."' ");
					
					if($record){
						$this->others->delete_record("package_services","package_id='".$item."' ");
					}
					
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Package has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No package are selected to delete!");
				}	
				redirect(base_url('admin/service/all_packages'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service/all_packages') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$arr_search['business_id'] = $admin_session['business_id'];
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$arr_search['location_id'] = $admin_session['location_id'];
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			$this->db->select('packages.*,package_services.service_id,package_services.visit_limit,package_services.service_timing_id');
			$this->db->from('packages');
			$this->db->join('package_services','packages.id=package_services.package_id','inner');
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner" || $admin_session['role']=="location_owner")){
				
				$this->db->where('packages.business_id',$admin_session['business_id']);
			}
			
			$this->db->where('packages.group_type',1);
			
			
			$this->db->group_by('packages.id');	
			$this->db->order_by("packages.date_created", "DESC");					
			$all_packages=$this->db->get()->result_array();
			//print_r($all_packages); exit;
			$data['all_packages']=$all_packages;
			//print_r($this->db->last_query()); exit;
			
			/*$all_packages = $this->service_model->get_packages(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
				
				
				if($all_packages){
				$data['all_packages']= $all_packages;
				$count_all_records = $this->service_model->get_packages(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
				}
			$this->pagination->initialize($config);*/
			
			//print_r($all_packages); exit;
			$data['service_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_packages', $data);
		}
		
		public function add_package($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('package_name', 'package_name', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('package_visit_limit', 'package_visit_limit', 'trim|required|xss_clean|numeric');
				$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('cost_price', 'cost_price', 'trim|required|xss_clean');
				$this->form_validation->set_rules('discounted_price', 'discounted_price', 'trim|required|xss_clean');
				
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				if( $this->input->post('is_online') == 'on' ){
					$data['is_online'] = $is_online = 1;
				}
				else{
					$data['is_online'] = $is_online = 0;
				}
				
				if( $this->input->post('is_gst_tax') == 'on' ){
					$data['is_gst_tax'] = $is_gst_tax = 1;
				}
				else{
					$data['is_gst_tax'] = $is_gst_tax = 0;
				}
				
				$data['package_name'] 		= $package_name = $this->input->post('package_name');
				//$data['package_visit_limit']= $package_visit_limit = $this->input->post('package_visit_limit');
				$data['sku'] 				= $sku = $this->input->post('sku');
				$data['description'] 		= $description = $this->input->post('description');
				$data['cost_price'] 		= $cost_price = $this->input->post('cost_price');
				$data['discounted_price'] 	= $discounted_price = $this->input->post('discounted_price');
				$data['start_date'] 		= $start_date = $this->input->post('start_date');
				$data['expire_date'] 		= $expire_date = $this->input->post('expire_date');
				$data['status'] 			= $status = $this->input->post('status');
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					$start_date = date("Y-m-d", strtotime($this->input->post('start_date')));
					$expire_date = date("Y-m-d", strtotime($this->input->post('expire_date')));
					
					// start image
					$photo ="";
					if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']!="")
					{
						$config['upload_path'] = 'uploads/services/packages/';
						$config['allowed_types'] = 'png|gif|jpg|jpeg';
						
						
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						
						if($this->upload->do_upload('photo')){
							$up_data = $this->upload->data();
							if(count((array)$up_data) > 0){
								$photo = "uploads/services/packages/".$up_data['file_name'];
								}else{
								$photo ="";
							}
						}
					}	
					// end image
					
					$inserData 	= array(
					'business_id'			=> $business_id,
					'package_name' 			=> $package_name,
					//'package_visit_limit' 	=> $package_visit_limit,
					'sku' 					=> $sku,
					'group_type'			=> 1,
					'description' 			=> $description,
					'cost_price' 			=> $cost_price,
					'discounted_price' 		=> $discounted_price,
					'is_online' 			=> $is_online,
					'is_gst_tax' 			=> $is_gst_tax,
					'start_date' 			=> $start_date,
					'expire_date' 			=> $expire_date,
					'photo' 				=> $photo,
					'status' 				=> $status,
					//'date_created'  		=> date('Y-m-d H:i:s'),
					);
					
					if(!empty($id)){
						
						$inserData['date_updated'] 	= date('Y-m-d H:i:s');
						
						$where = array('id' => $id);
						$return = $this->others->update_common_value("packages",$inserData,$where);
						
						
						if($return == true){
							
							// delete existing records from package_services
							$record = $this->others->get_all_table_value("package_services","package_id","package_id='".$id."' ");
							//print_r($record);die;
							if($record){
								$this->others->delete_record("package_services","package_id='".$id."' ");
							}
							
							// start insert data in package_service table
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['action']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							
							// count no of rows
							$temp =count((array)$this->input->post('service_id'));
							
							for($i=0; $i<$temp;$i++){
								
								$insertData1 = array(
								'package_id' 			=> $id,
								'service_id' 			=> $inserData['service_id'][$i],
								'service_timing_id' 	=> $inserData['service_timing_id'][$i],
								'amount' 				=> $inserData['amount'][$i],
								'visit_limit' 		=> $inserData['visit_limit'][$i],
								);
								
								$return = $this->others->insert_data("package_services",$insertData1);
								
							}
							// end insert data in package_service table
							
							$this->session->set_flashdata('success_msg', "Package updated successfully!");
							redirect(base_url('admin/service/all_packages'));
						}
						}else{
						
						$inserData['date_created'] 	= date('Y-m-d H:i:s');
						
						$return = $this->others->insert_data("packages",$inserData);
						$package_id = $return;
						
						if($return == true){
							
							// start insert data in package_service table
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['action']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							
							// count no of rows
							$temp =count((array)$this->input->post('service_id'));
							
							for($i=0; $i<$temp;$i++){
								
								$insertData1 = array(
								'package_id' 			=> $package_id,
								'service_id' 			=> $inserData['service_id'][$i],
								'service_timing_id' 	=> $inserData['service_timing_id'][$i],
								'amount' 				=> $inserData['amount'][$i],
								'visit_limit' 		=> $inserData['visit_limit'][$i],
								);
								
								$return = $this->others->insert_data("package_services",$insertData1);
								
							}
							// end insert data in package_service table
							
							$this->session->set_flashdata('success_msg', "Package added successfully!");
							redirect(base_url('admin/service/all_packages'));
						}
					}
					
					
				}
			}
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			
			// get all service_timing
			$all_service_timing = $this->service_model->getAllServiceTiming($admin_session);
			if($all_service_timing) {
				$data['all_service_timing'] = $all_service_timing;
			}
			//print_r($all_service_timing);die;
			
			// get package_details if $id exist
			if(!empty($id)){
				// package details
				$package_details = $this->others->get_all_table_value("packages","*","id=".$id."","","");
				if($package_details) {
					$data['package_details'] = $package_details;
				}
				
				// get service timing for $id
				$service_timing_details = $this->others->get_all_table_value("package_services","*","package_id='".$id."'","","");
				if($service_timing_details) {
					$data['service_timing_details'] = $service_timing_details;
				}
			}
			//print_r($data['package_details']);die;
			//print_r($data['service_timing_details']);die;
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_packages', $data);
		}
		
		
		public function all_service_group()
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
					$this->others->delete_record("packages","id='".$item."' ".$condition);
					
					// delete package_services
					$record = $this->others->get_all_table_value("package_services","package_id","package_id='".$item."' ");
					
					if($record){
						$this->others->delete_record("package_services","package_id='".$item."' ");
					}
					
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Service group has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No service group are selected to delete!");
				}	
				redirect(base_url('admin/service/all_service_group'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service/all_service_group') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$arr_search['location_id'] = $admin_session['location_id'];
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_service_group = $this->service_model->get_service_group(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
			if($all_service_group){
				$data['all_service_group']= $all_service_group;
				$count_all_records = $this->service_model->get_service_group(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			$data['service_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_service_group', $data);
		}
		
		public function add_service_group($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('service_group_name', 'service_group_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('cost_price', 'cost_price', 'trim|required|xss_clean');
				$this->form_validation->set_rules('discounted_price', 'discounted_price', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules('sequenceo_order', 'sequenceo_order', 'trim|required|xss_clean');
				
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				
				if( $this->input->post('is_online') == 'on' ){
					$data['is_online'] = $is_online = 1;
				}
				else{
					$data['is_online'] = $is_online = 0;
				}
				
				if( $this->input->post('is_gst_tax') == 'on' ){
					$data['is_gst_tax'] = $is_gst_tax = 1;
				}
				else{
					$data['is_gst_tax'] = $is_gst_tax = 0;
				}
				
				$data['service_group_name'] = $service_group_name = $this->input->post('service_group_name');
				$data['sku'] 				= $sku = $this->input->post('sku');
				$data['description'] 		= $description = $this->input->post('description');
				$data['cost_price'] 		= $cost_price = $this->input->post('cost_price');
				$data['discounted_price'] 	= $discounted_price = $this->input->post('discounted_price');
				$data['status'] 			= $status = $this->input->post('status');
				$data['sequenceo_order']  = $sequenceo_order = $this->input->post('sequenceo_order');
				
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					$inserData 	= array(
					'business_id'			=> $business_id,
					'package_name' 			=> $service_group_name,
					'sku' 					=> $sku,
					'group_type'			=> 2,
					'description' 			=> $description,
					'cost_price' 			=> $cost_price,
					'discounted_price' 		=> $discounted_price,
					'is_online' 			=> $is_online,
					'is_gst_tax' 			=> $is_gst_tax,
					'status' 				=> $status,
					'sequenceo_order' 		=> $sequenceo_order,
					//'date_created'  		=> date('Y-m-d H:i:s'),
					);
					
					if(!empty($id)){
						
						$inserData['date_updated'] 	= date('Y-m-d H:i:s');
						
						$where = array('id' => $id);
						$return = $this->others->update_common_value("packages",$inserData,$where);
						//print_r($this->db->last_query()); exit;
						
						if($return == true){
							
							// delete existing records from package_services
							$record = $this->others->get_all_table_value("package_services","package_id","package_id='".$id."' ");
							
							if($record){
								$this->others->delete_record("package_services","package_id='".$id."' ");
							}
							
							// start insert data in package_service table
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['action']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							//echo "<pre>"; print_r($inserData); die;
							// count no of rows
							$temp =count((array)$this->input->post('service_id'));
							
							for($i=0; $i<$temp;$i++){
								
								$insertData1 = array(
								'package_id' 			=> $id,
								'service_id' 			=> $inserData['service_id'][$i],
								'service_timing_id' 	=> $inserData['service_timing_id'][$i],
								'amount' 				=> $inserData['amount'][$i],
								//'visit_limit' 				=> $inserData['visit_limit'][$i],
								);
								
								$return = $this->others->insert_data("package_services",$insertData1);
								
							}
							// end insert data in package_service table
							
							$this->session->set_flashdata('success_msg', "Service group updated successfully!");
							redirect(base_url('admin/service/all_service_group'));
						}
						}else{
						
						$inserData['date_created'] 	= date('Y-m-d H:i:s');
						
						$return = $this->others->insert_data("packages",$inserData);
						$package_id = $return;
						
						if($return == true){
							
							// start insert data in package_service table
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['action']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							
							// count no of rows
							$temp =count((array)$this->input->post('service_id'));
							
							for($i=0; $i<$temp;$i++){
								
								$insertData1 = array(
								'package_id' 			=> $package_id,
								'service_id' 			=> $inserData['service_id'][$i],
								'service_timing_id' 	=> $inserData['service_timing_id'][$i],
								'amount' 				=> $inserData['amount'][$i],
								//'visit_limit' 		=> $inserData['visit_limit'][$i],
								);
								
								$return = $this->others->insert_data("package_services",$insertData1);
								
							}
							// end insert data in package_service table
							
							$this->session->set_flashdata('success_msg', "Service group added successfully!");
							redirect(base_url('admin/service/all_service_group'));
						}
					}
					
					
				}
			}
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			// get all service_timing
			$all_service_timing = $this->service_model->getAllServiceTimingServiceGroup($admin_session);
			if($all_service_timing) {
				$data['all_service_timing'] = $all_service_timing;
			}
			//print_r($all_service_timing);die;
			
			// get service_group_details if $id exist
			if(!empty($id)){
				// package details
				$service_group_details = $this->others->get_all_table_value("packages","*","id=".$id."","","");
				if($service_group_details) {
					$data['service_group_details'] = $service_group_details;
				}
				
				// get service timing for $id
				$service_timing_details = $this->others->get_all_table_value("package_services","*","package_id='".$id."'","id","asc");
				if($service_timing_details) {
					$data['service_timing_details'] = $service_timing_details;
				}
			}
			//print_r($data['service_group_details']);die;
			//print_r($data['service_timing_details']);die;
			
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_service_group', $data);
		}
		
		
		
		// start class here
		
		public function all_class()
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
					$this->others->delete_record("services","id='".$item."' ".$condition);
					
					// delete service_timing
					$this->others->delete_record("service_timing","service_id=".$item);
					// delete service_timing
					
					// delete staff_services
					///$this->others->delete_record("staff_services","service_id=".$item);
					// delete staff_services
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Class has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No class are selected to delete!");
				}	
				redirect(base_url('admin/service/all_class'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service/all_class') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$arr_search['business_id'] = $admin_session['business_id'];
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$arr_search['location_id'] = $admin_session['location_id'];
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_class = $this->service_model->get_class(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
			if($all_class){
				$data['all_class']= $all_class;
				$count_all_records = $this->service_model->get_class(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			
			$data['service_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_class', $data);
		}
		
		public function add_class($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('service_name', 'service_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
				$this->form_validation->set_rules('class_capacity', 'class_capacity', 'trim|required|xss_clean|numeric');
				$this->form_validation->set_rules('class_category_id', 'class_category_id', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('service_resource_list[]', 'service_resource_list', 'trim|required|xss_clean');
				$this->form_validation->set_rules('is_gst_tax', 'is_gst_tax', 'trim|required|xss_clean');
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				$data['service_name'] 			= $service_name = $this->input->post('service_name');
				$data['description'] 			= $description = $this->input->post('description');
				$data['class_capacity'] 		= $class_capacity = $this->input->post('class_capacity');
				$data['class_category_id'] 		= $class_category_id = $this->input->post('class_category_id');
				
				
				if( $this->input->post('is_online') == 'on' ){
					$data['is_online'] = $is_online = 1;
				}
				else{
					$data['is_online'] = $is_online = 0;
				}
				
				if( $this->input->post('is_gst_tax') == 'on' ){
					$data['is_gst_tax'] = $is_gst_tax = 1;
				}
				else{
					$data['is_gst_tax'] = $is_gst_tax = 0;
				}
				
				if( $this->input->post('is_extra_time') == 'on' ){
					$data['is_extra_time'] = $is_extra_time = 1;
				}
				else{
					$data['is_extra_time'] = $is_extra_time = 0;
				}
				
				
				$data['extra_time_before'] 		= $extra_time_before = $this->input->post('extra_time_before');
				$data['extra_time_after'] 		= $extra_time_after = $this->input->post('extra_time_after');
				
				// start service timing 
				$data['caption'] 		= $caption = $this->input->post('caption');
				$data['duration'] 		= $duration = $this->input->post('duration');
				$data['retail_price'] 	= $retail_price = $this->input->post('retail_price');
				$data['special_price'] 	= $special_price = $this->input->post('special_price');
				// end service timing 
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					$service_resource_list =array();
					$service_resource_list = $this->input->post('service_resource_list');
					$service_resource_list = implode(",",$service_resource_list);
					
					$inserData 	= array(
					'business_id' 			=> $business_id,
					'service_class_type'	=> 2,
					'service_name' 			=> $service_name, 
					'description' 			=> $description,
					'class_capacity'		=> $class_capacity,
					'service_category_id'   => $class_category_id, 
					//'service_resource_list' => $service_resource_list, 
					'is_online'				=> $is_online, 
					'is_gst_tax' 			=> $is_gst_tax,
					'is_extra_time'			=> $is_extra_time, 
					'extra_time_before' 	=> clockalize($extra_time_before),
					'extra_time_after'		=> clockalize($extra_time_after),
					'service_name'			=> $service_name,
					//'date_created'  		=> date('Y-m-d H:i:s'),
					);
					
					
					if($this->input->post('service_resource_list')){
						
						$service_resource_list = array();
						$service_resource_list = $this->input->post('service_resource_list');
						$service_resource_list = implode(",",$service_resource_list);
						
						$inserData['service_resource_list'] = $service_resource_list; 
					}
					
					if(!empty($id)){
						
						$inserData['date_updated'] 	= date('Y-m-d H:i:s');
						
						$where = array('id' => $id);
						$return = $this->others->update_common_value("services",$inserData,$where);
						
						
						if($return == true){
							
							// start delete existing records
							$record = $this->others->get_all_table_value("service_timing","service_id","service_id='".$id."' ");
							if($record){
								$where = array('service_id' => $id);
								$this->others->delete_record("service_timing",$where);
							}
							// end delete existing records
							
							
							// start service timing 
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['service_timing']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							
							// count no of rows
							$temp =count((array)$this->input->post('caption'));
							
							for($i=0; $i<$temp;$i++){
								
								if($admin_session['role'] == 'owner') { 
									$data2 = array(
									'business_id' 	=> $business_id,
									'service_id' 		=> $id,
									'caption' 		=> $caption[$i],
									'duration' 		=> clockalize($duration[$i]),
									'retail_price' 	=> $retail_price[$i],
									'special_price' 	=> $special_price[$i]
									);
									
									$return = $this->others->insert_data("service_timing",$data2);
								}
								else{
									$data2 = array(
					   				'business_id' 	=> $business_id,
								  	'service_id' 	=> $id,
								  	'caption' 		=> $caption[$i],
								  	'duration' 		=> clockalize($duration[$i]),
								  	'retail_price' 	=> $retail_price[$i],
								  	'special_price' => $special_price[$i]
									);
									
									$return = $this->others->insert_data("service_timing",$data2);
								}
								
							}
							// end service timing
							
							$this->session->set_flashdata('success_msg', "Class updated successfully!");
							redirect(base_url('admin/service/all_class'));
						}
						}else{
						
						$inserData['date_created'] 	= date('Y-m-d H:i:s');
						
						$return = $this->others->insert_data("services",$inserData);
						$service_id = $return;
						
						if($return>0){
							
							// start service timing 
							
							$inserData = array();
							foreach ( $_POST as $key => $value )
							{
								$inserData[$key] = $this->input->post($key);
								unset($inserData['service_timing']);
								//$this->others->insert_data("service_timing",$inserData);
							}
							
							// count no of rows
							$temp =count((array)$this->input->post('caption'));
							
							for($i=0; $i<$temp;$i++){
								
								if($admin_session['role'] == 'owner') { 
									$data2 = array(
									'business_id' 	=> $business_id,
									'service_id' 		=> $service_id,
									'caption' 		=> $caption[$i],
									'duration' 		=> clockalize($duration[$i]),
									'retail_price' 	=> $retail_price[$i],
									'special_price' 	=> $special_price[$i]
									);
									
									$return = $this->others->insert_data("service_timing",$data2);
								}
								else{
									$data2 = array(
					   				'business_id' 	=> $business_id,
								  	'service_id' 	=> $service_id,
								  	'caption' 		=> $caption[$i],
								  	'duration' 		=> clockalize($duration[$i]),
								  	'retail_price' 	=> $retail_price[$i],
								  	'special_price' => $special_price[$i]
									);
									
									$return = $this->others->insert_data("service_timing",$data2);
								}
								
								
							}
							
							
							// end service timing
							
							$this->session->set_flashdata('success_msg', "Class added successfully!");
							redirect(base_url('admin/service/all_class'));
						}
					}
					
					
				}
			}
			
			// get all business for add service
			if($admin_session['role'] == 'owner'){
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
			}
			
			// get all service category for add service
			$cat_type = 2;
			$all_class_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
			if($admin_session['role']=="owner"){
				
				if($admin_session['business_id'] ==""){
					$all_class_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
					}else{
					$all_class_category = $this->db->select('*')->from('service_category')->where(['business_id'=>$admin_session['business_id'],'cat_type'=>$cat_type])->get()->result_array();
				}
				}else{
				$all_class_category = $this->db->select('*')->from('service_category')->where(['business_id'=>$admin_session['business_id'],'cat_type'=>$cat_type])->get()->result_array();
				
			}
			//gs($all_class_category);
			if($all_class_category) {
				$data['all_class_category'] = $all_class_category;
			}
			
			// get all resources for add service
			$all_resources = $this->others->get_all_table_value("resources","id,resource_name","","resource_name","ASC");
			if($all_resources) {
				$data['all_resources'] = $all_resources;
			}
			
			// get package_details if $id exist
			if(!empty($id)){
				// package details
				$class_details = $this->others->get_all_table_value("services","*","id=".$id."","","");
				if($class_details) {
					$data['class_details'] = $class_details;
				}
				
				// package details
				$service_timing_details = $this->others->get_all_table_value("service_timing","*","service_id='".$id."'");
				if($service_timing_details) {
					$data['service_timing_details'] = $service_timing_details;
				}
				
				
			}
			//print_r($data['package_details']);die;
			//print_r($data['service_timing_details']);die;
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_class', $data);
		}
		
		
		public function all_class_category()
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
					$this->others->delete_record("service_category","id='".$item."' ".$condition);
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Class category has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No class category are selected to delete!");
				}	
				redirect(base_url('admin/service/all_class_category'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/service/all_class_category') .'?'.$get_string;
			
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
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$arr_search['business_id'] = $admin_session['business_id'];
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				//$arr_search['location_id'] = $admin_session['location_id'];
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_class_category = $this->service_model->get_class_category(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
			if($all_class_category){
				$data['all_class_category']= $all_class_category;
				$count_all_records = $this->service_model->get_class_category(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			
			
			$data['service_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/service/all_class_categories', $data);
		}
		
		
		public function add_class_category($id='')
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
				
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				$data['name'] 	= $name = $this->input->post('name');
				
				if ($this->form_validation->run() == TRUE) 
				{
					$inserData 	= array(
					'business_id'	=> $business_id,
					'cat_type'		=> 2,
					'name' 			=> $name,
					'date_created'  => date('Y-m-d H:i:s'),
					);
					
					
					if(!empty($id)){
						
						$where = array('id' => $id);
						$return = $this->others->update_common_value("service_category",$inserData,$where);
						
						if($return == true){
							
							$this->session->set_flashdata('success_msg', "Class category updated successfully!");
							redirect(base_url('admin/service/all_class_category'));
						}
						
					}
					else{
						
						$return = $this->others->insert_data("service_category",$inserData);
						
						if($return == true){
							
							$this->session->set_flashdata('success_msg', "Class category added successfully!");
							redirect(base_url('admin/service/all_class_category'));
						}
					}
					
					
				}
			}
			
			// get all business for add service
			if($admin_session['role'] == 'owner'){
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
			}
			
			// get package_details if $id exist
			if(!empty($id)){
				// package details
				$class_category_details = $this->others->get_all_table_value("service_category","*","id=".$id."","","");
				if($class_category_details) {
					$data['class_category_details'] = $class_category_details;
				}
				
			}
			//print_r($data['package_details']);die;
			//print_r($data['service_timing_details']);die;
			
			$data['service_active_open']=true;
			$this->load->view('admin/service/add_class_category', $data);
		}
		
		
		
		// end class here
		
		
		
		public function service_treatment_type()
		{
			$data['service_group_active_open']=true;
			$this->load->view('admin/service/all_service_treatment_type', $data);
		}
		
		public function add_service_treatment_type()
		{
			$data['service_group_active_open']=true;
			$this->load->view('admin/service/add_service_treatment_type', $data);
		}
		
		public function appointment_colors()
		{
			$data['appointment_colors_active_open']=true;
			$this->load->view('admin/service/appointment_colors', $data);
		}
		
		public function add_appointment_color()
		{
			$data['appointment_colors_active_open']=true;
			$this->load->view('admin/service/add_appointment_color', $data);
		}
		
		public function appointment_status()
		{
			$data['appointment_status_active_open']=true;
			$this->load->view('admin/service/appointment_status', $data);
		}
		
		public function add_appointment_status()
		{
			$data['appointment_status_active_open']=true;
			$this->load->view('admin/service/add_appointment_status', $data);
		}
		
		
		public function cancellation_reason()
		{
			$data['setup_active_open']=true;
			$this->load->view('admin/service/cancellation_reason', $data);
		}
		
		public function add_cancellation_reason()
		{
			$data['setup_active_open']=true;
			$this->load->view('admin/service/add_cancellation_reason', $data);
		}
		
		
		/*public function appointments()
			{	
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['business_id'] = $admin_session['business_id'];
			$data['appointment_active_open']=true;
			$this->load->view('admin/service/all_appointments', $data);
		}*/
		
		public function add_appointment()
		{
			$data['appointment_active_open']=true;
			$this->load->view('admin/service/add_appointment', $data);
		}
		
		public function all_payment_types()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['getallPaymentTypes'] = $this->others->get_all_table_value("payment_type","*","busniess_id='".$admin_session['business_id']."'");
			//print_r($data['getallPaymentTypes']);
			$data['setup_active_open']=true;
			$this->load->view('admin/service/all_payment_type', $data);
		}
		
		public function add_payment_type()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['business_id'] = $admin_session['business_id'];
			$data['setup_active_open']=true;
			$this->load->view('admin/service/add_payment_type', $data);
		}
		
		public function insert_payment_type()
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				$PaymentArr = array(
				'busniess_id' => $this->input->post('busniess_id'),
				'name' => $this->input->post('name'),
				);
				$PaymentInsert = $this->others->insert_data("payment_type",$PaymentArr);
			}
			redirect(base_url('admin/service/all_payment_types'));
		}
		
		public function edit_payment_type($id='')
		{
			if($id){
				$admin_session = $this->session->userdata('admin_logged_in');
				$data['getPaymentTypes'] = $this->others->get_all_table_value("payment_type","*","busniess_id='".$admin_session['business_id']."' AND id='".$id."'");
				$data['setup_active_open']=true;
				$this->load->view('admin/service/edit_payment_type', $data);
				}else{
				redirect(base_url('admin/service/all_payment_types'));
			}
		}
		
		public function update_payment_type($id='')
		{
			if($id){
				$PaymentArr = array(
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				);
				$paymentUpdate = $this->others->update_common_value("payment_type",$PaymentArr,"id='".$id."'");	
				redirect(base_url('admin/service/all_payment_types'));			
				}else{
				redirect(base_url('admin/service/all_payment_types'));
			}
		}	
		
		public function delete_payment_type($id='')
		{
			if($id){
				$paymentDelete = $this->others->delete_record("payment_type","id='".$id."'");	
				redirect(base_url('admin/service/all_payment_types'));			
				}else{
				redirect(base_url('admin/service/all_payment_types'));
			}
			
		}
		
		public function set_payment_active($id='')
		{
			if($id){
				$PaymentArr = array(
				'status' => 'active',
				);
				$paymentUpdate = $this->others->update_common_value("payment_type",$PaymentArr,"id='".$id."'");	
				redirect(base_url('admin/service/all_payment_types'));			
				}else{
				redirect(base_url('admin/service/all_payment_types'));
			}
			
		}
		
		public function set_payment_inactive($id='')
		{
			if($id){
				$PaymentArr = array(
				'status' => 'inactive',
				);
				$paymentUpdate = $this->others->update_common_value("payment_type",$PaymentArr,"id='".$id."'");	
				redirect(base_url('admin/service/all_payment_types'));			
				}else{
				redirect(base_url('admin/service/all_payment_types'));
			}
			
		}
		
		public function calendar()
		{
			if (isset($_GET['startDate']) && !empty($_GET['startDate']) ) {
				$a = explode('/',$_GET['startDate']);
				$service_start_date = trim($a[1]).'/'.trim($a[2]).'/'.trim($a[0]);
				$data['startDate']=$service_start_date;
				$data['location_id']=$_GET['location_id'];
				$data['staffid']=$_GET['staffid'];
			}
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['admin_session']= $admin_session;
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
			$data['all_business'] = $all_business;		
			if($admin_session['role']=="business_owner"){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
				}elseif($admin_session['role']=="owner"){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			//print_r($admin_session); exit;
			elseif ($admin_session['role']=="staff") {
				$this->db->select('location.*');
				$this->db->from('location');
				$this->db->join('roster','roster.location_id=location.id','inner');
				$this->db->where('staff_id',$admin_session['staff_id']);
				$this->db->group_by('location.id');
				$data['locations']=$this->db->get()->result_array();
				//print_r($this->db->last_query()); exit;

				
			}
			
			$business_id = $admin_session['business_id'];
			$view = $this->input->get('view');
			$data['view']=$view;		
			$data['calendar_active_open']=true;
			$calendar_setting = $this->db->select('*')->from('calendar_settings')->where('business_id',$business_id)->get()->row_array();
			$data['calendar_setting'] = $calendar_setting;	
			//print_r($admin_session);exit;
			$this->load->view('admin/service/appointment_calendar', $data);
		}
		public function calendar_settings()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['admin_session']= $admin_session;
			
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
			$data['all_business'] = $all_business;		
			if($admin_session['role']=="business_owner"){
				$locations = $this->others->get_all_table_value("location","id,location_name","business_id='".$admin_session['business_id']."' ","location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			$business_id = $admin_session['business_id'];
			$setting = $this->db->select('*')->from('calendar_settings')->where('business_id',$business_id)->get()->row_array();
			if($this->input->post('action')){
				//print_r($_POST); exit;

				if($setting){
					$update_array = array(
					'time_slot_interval'=>$this->input->post('time_slot_interval'),
					'start_time'=>$this->input->post('start_time'),
					'new_appointment_color'=>$this->input->post('new_appointment_color'),
					'completed_appointment_color'=>$this->input->post('completed_appointment_color'),
					'noshow_appointment_color'=>$this->input->post('noshow_appointment_color'),
					'arrived_appointment_color'=>$this->input->post('arrived_appointment_color'),
					'confirmed_appointment_color'=>$this->input->post('confirmed_appointment_color'),
					'started_appointment_color'=>$this->input->post('started_appointment_color'),
					'reconfirmed_appointment_color'=>$this->input->post('reconfirmed_appointment_color'),
					'cancel_appointment_color'=>$this->input->post('cancel_appointment_color'),
					'reschedule_appointment_color'=>$this->input->post('reschedule_appointment_color'),
					'booking_widget_status'=>$this->input->post('booking_widget_status'),
					);
					//gs($update_array);
					$this->others->update_common_value("calendar_settings",$update_array,"business_id='".$business_id."' ");
					}else{
					$insert_array = array(
					'business_id'=>$business_id,
					'time_slot_interval'=>$this->input->post('time_slot_interval'),
					'start_time'=>$this->input->post('start_time'),
					'new_appointment_color'=>$this->input->post('new_appointment_color'),
					'completed_appointment_color'=>$this->input->post('completed_appointment_color'),
					'noshow_appointment_color'=>$this->input->post('noshow_appointment_color'),
					'arrived_appointment_color'=>$this->input->post('arrived_appointment_color'),
					'confirmed_appointment_color'=>$this->input->post('confirmed_appointment_color'),
					'started_appointment_color'=>$this->input->post('started_appointment_color'),
					'reconfirmed_appointment_color'=>$this->input->post('reconfirmed_appointment_color'),
					'cancel_appointment_color'=>$this->input->post('cancel_appointment_color'),
					'reschedule_appointment_color'=>$this->input->post('reschedule_appointment_color'),
					'booking_widget_status'=>$this->input->post('booking_widget_status'),
					'date_created'=>date("Y-m-m H:i:s")
					);
					$this->others->insert_data("calendar_settings",$insert_array);
					
				}
				return redirect(base_url('admin/service/calendar_settings'));
			}		
			//$settings = $this->others->get_all_table_value("calendar_settings","*","business_id='".$business_id."' ","location_name","ASC");
			$data['settings']= $setting;
			$data['setup_active_open']=true;
			$this->load->view('admin/service/calendar_settings', $data);
		}
		
		public function booking_widget()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['admin_session']= $admin_session;		
			$data['booking_widget_active_open']=true;
			$this->load->view('admin/service/booking_widget', $data);
		}
		public function email_templates()
		{
			$data['email_template_active_open']=true;
			$this->load->view('admin/service/all_email_templates', $data);
		}
		public function email_templates_detail()
		{
			$data['appointment_active_open']=true;
			$this->load->view('admin/service/email_templates_layout', $data);
		}
		public function edit_template()
		{
			$data['appointment_active_open']=true;
			$this->load->view('admin/service/edit_template', $data);
		}
		public function membership_payment()
		{
			$stripe_keys = array(
			"secret_key"      => $this->config->item('secret_key'),
			"publishable_key" => $this->config->item('publishable_key')
			);

			$admin_session = $this->session->userdata('admin_logged_in');
			//gs($admin_session);die;
			$plans =  $this->db->select('*')->from('membership')->where('status',1)->order_by('plan_price','asc')->get()->result_array();
			$data['plans'] = $plans;
			$data['stripe_keys'] = $stripe_keys;
			$data['admin_session'] = $admin_session;
			$this->load->view('admin/service/membership_payment',$data);
		}
		
		public function make_payment(){
			$admin_session = $this->session->userdata('admin_logged_in');

			//print_r($admin_session); die;
			/*if($admin_session['payment_status']==1){
				return redirect('admin/service/active_membership');
			}*/
			$stripe_keys = array(
			"secret_key"      => $this->config->item('secret_key'),
			"publishable_key" => $this->config->item('publishable_key')
			);
			//gs($this->input->post());die;
			require_once(APPPATH.'stripe-php/init.php');
			$post_data = $this->input->post();
			//gs($post_data);die;
			\Stripe\Stripe::setApiKey($stripe_keys['secret_key']);
			if (isset($post_data['stripeToken']) && isset($post_data['plan'])){
				try
				{
					$customer = \Stripe\Customer::create(array(
					'email' => $post_data['stripeEmail'],
					'source'  => $post_data['stripeToken']
					));
					
					$subscription = \Stripe\Subscription::create(array(
					'customer' => $customer->id,
					'items' => array(array('plan' => $post_data['plan'])),
					));
					$res = json_encode($subscription);
					$success_data = json_decode($res,true);
					//gs($success_data);die;
				//	echo date('Y-m-d',strtotime($success_data['current_period_end']));exit;
					//echo $success_data['current_period_end']; exit;
					//$trial_expire_date = strtotime("+1 months", strtotime(date("Y-m-d")));
					$trial_expire_date = date("Y-m-d", strtotime("+1 month"));
					$current_period_start=time();
					$current_period_end = strtotime("+1 month", time());

					$insert_data = array(
					'business_id' => $admin_session['business_id'],
					'stripe_var_dump' => $res,
					'created_at' => date("Y-m-d H:i:s"),
					'stripe_id' => $success_data['id'],
					'stripe_plan_id'=>$success_data['plan']['id'],
					'payment_status' => $success_data['status'],
					'stripe_user_id' => $success_data['customer'],
					'stripe_start_date' => date("Y-m-d H:i:s"),
					'stripe_end_date' => date("Y-m-d H:i:s"),					
					'type' =>1,
					);
					$this->others->insert_data("business_membership",$insert_data);

					$update_data = array(
			    	'current_plan_name'=>$post_data['plan_name'],
			    	'current_plan_price'=>$post_data['plan_price'],
			    	'current_staff_limit'=>$post_data['plan_staff_limit'],
			    	'payment_status'=>1,
			    	'stripe_id'=>$success_data['id'],
			    	'stripe_plan_id'=>$success_data['plan']['id'],
			    	'stripe_customer'=>$success_data['customer'],
			    	'stripe_object'=>$success_data['object'],
			    	'stripe_amount'=>number_format($success_data['plan']['amount']/100,2),
			    	'stripe_vardump'=>$res,
			    	'stripe_start_date'=>$current_period_start,
			    	'stripe_end_date'=>$current_period_end,
			    	'stripe_status'=>$success_data['status'],
			    	'is_subscription_canceled'=>0,
			    	'trial_expire_date'=>$trial_expire_date,
					);

					//print_r($update_data); exit;

					$success = $this->others->update_common_value("admin_users",$update_data,"id='".$admin_session['admin_id']."' ");
					$this->session->set_flashdata('success_msg', "Your payment has been received successfully.");
					return redirect('admin/service/active_membership');
				}  
				catch(Exception $e)
				{
					$this->session->set_flashdata('success_msg', $e->getMessage());
					return redirect('admin/service/active_membership');
				}
			}
		}
		
		public function active_membership(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$stripe_keys = array(
			"secret_key"      => $this->config->item('secret_key'),
			"publishable_key" => $this->config->item('publishable_key')
			);
			$user_data = $this->db->select('*')->from('admin_users')->where('id',$admin_session['admin_id'])->get()->row_array();
				$data['allPlans'] =  $this->db->select('*')->from('membership')->where('status',1)->order_by('plan_price','asc')->get()->result_array();

			$data['admin_session']=$admin_session;
			$data['user_data']=$user_data;
			$data['setup_active_open']=true;
			$data['stripe_keys']=$stripe_keys;
			$this->load->view('admin/service/active_membership',$data);
		}
		
		public function cancelSubscription(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$post_data=$this->input->post();
			//print_r($post_data); exit;			
			$stripe_keys = array(
			"secret_key"      => $this->config->item('secret_key'),
			"publishable_key" => $this->config->item('publishable_key')
			);
			require_once(APPPATH.'stripe-php/init.php');
			\Stripe\Stripe::setApiKey($stripe_keys['secret_key']);
			$user_data = $this->db->select('*')->from('admin_users')->where('id',$admin_session['admin_id'])->get()->row_array();
			$at_period_end = true;
			try{
				$sub = \Stripe\Subscription::retrieve($user_data['stripe_id']);
				$cancel = $sub->cancel(array("at_period_end" => $at_period_end));
				$res = json_encode($cancel);
				$success_data = json_decode($res,true);
				
				if($success_data['cancel_at_period_end']==1){
					$update_data = array(
			    	'is_subscription_canceled'=>1
					);
					$success = $this->others->update_common_value("admin_users",$update_data,"id='".$admin_session['admin_id']."' ");

					$business_membership = $this->db->select('*')->from('business_membership')->where('stripe_plan_id',$user_data['stripe_plan_id'])->where('business_id',$user_data['business_id'])->where('type',1)->get()->row_array();


					

					// Add Data in business_membership
					$insert_data = array(
					'business_id' => $admin_session['business_id'],
					'stripe_var_dump' => $res,
					'created_at' => date("Y-m-d H:i:s"),
					'stripe_id' => $success_data['id'],
					'payment_status' => $success_data['status'],
					'stripe_user_id' => $success_data['customer'],
					'stripe_end_date' => date("Y-m-d H:i:s"),
					'type' =>2,
					);
					$this->others->update_common_value("business_membership",$insert_data,"id='".$business_membership['id']."' ");

					$insert_type_data=array(
						'type' =>2,
					);
					$this->others->update_common_value("business_membership",$insert_type_data,"business_id='".$user_data['business_id']."' ");



					//echo $user_data['stripe_plan_id'].'<br>';
					//print_r($post_data['plan']); exit;

					if ($post_data['plan']!=$user_data['stripe_plan_id'] || $user_data['is_subscription_canceled']==1) {

						$stripe_keys = array(
			"secret_key"      => $this->config->item('secret_key'),
			"publishable_key" => $this->config->item('publishable_key')
			);
			//gs($this->input->post());die;
			require_once(APPPATH.'stripe-php/init.php');
			$post_data = $this->input->post();
			\Stripe\Stripe::setApiKey($stripe_keys['secret_key']);

			if (isset($post_data['stripeToken']) && isset($post_data['plan'])){
				try
				{
					$customer = \Stripe\Customer::create(array(
					'email' => $post_data['stripeEmail'],
					'source'  => $post_data['stripeToken']
					));
					
					$subscription = \Stripe\Subscription::create(array(
					'customer' => $customer->id,
					'items' => array(array('plan' => $post_data['plan'])),
					));
					$res = json_encode($subscription);
					$success_data = json_decode($res,true);					
					$trial_expire_date = date("Y-m-d", strtotime("+1 month"));
					$current_period_start=time();
					$current_period_end = strtotime("+1 month", time());
					$insert_data = array(
					'business_id' => $admin_session['business_id'],
					'stripe_var_dump' => $res,
					'created_at' => date("Y-m-d H:i:s"),
					'stripe_id' => $success_data['id'],
					'payment_status' => $success_data['status'],
					'stripe_user_id' => $success_data['customer'],
					'stripe_plan_id' => $success_data['plan']['id'],
					'stripe_start_date' => date("Y-m-d H:i:s"),
					'stripe_end_date' => date("Y-m-d H:i:s"),
					'type' =>1,
					);
					$this->others->insert_data("business_membership",$insert_data);

					$update_data = array(
			    	'current_plan_name'=>$post_data['plan_name'],
			    	'current_plan_price'=>$post_data['plan_price'],
			    	'current_staff_limit'=>$post_data['plan_staff_limit'],
			    	'payment_status'=>1,
			    	'stripe_id'=>$success_data['id'],
			    	'stripe_plan_id'=>$success_data['plan']['id'],
			    	'stripe_customer'=>$success_data['customer'],
			    	'stripe_object'=>$success_data['object'],
			    	'stripe_amount'=>number_format($success_data['plan']['amount']/100,2),
			    	'stripe_vardump'=>$res,
			    	'stripe_start_date'=>$current_period_start,
			    	'stripe_end_date'=>$current_period_end,
			    	'stripe_status'=>$success_data['status'],
			    	'is_subscription_canceled'=>0,
			    	'trial_expire_date'=>$trial_expire_date,
					);

			//	echo "<pre>";	print_r($update_data); exit;

					$success = $this->others->update_common_value("admin_users",$update_data,"id='".$admin_session['admin_id']."' ");
					$this->session->set_flashdata('success_msg', "Your payment has been received successfully.");
					return redirect('admin/service/active_membership');
				}  
				catch(Exception $e)
				{
					$this->session->set_flashdata('success_msg', $e->getMessage());
					return redirect('admin/service/active_membership');
				}
			}






						
					}




					$this->session->set_flashdata('success_msg', "Your monthly subscription has been cancelled.");
					return redirect('admin/service/active_membership');
				}
			}
			catch(Exception $e){
				$this->session->set_flashdata('error_msg', $e->getMessage());
				return redirect('admin/service/active_membership');
			}
			
		}
		
		public function view($id){
			$data = [];
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if ($id != '' && is_numeric($id)) {	
				// get template details
				$service_details = $this->others->get_all_table_value("services","*","id='".$id."'");
				$data['service_details'] = $service_details;
				
				// get service timing details
				$fil = array(
				"service_id"=>$id,
				"status"=>1
				);
				$service_timing_details = $this->others->get_all_table_value("service_timing","*",$fil,"id","asc");
				$data['service_timing_details'] = $service_timing_details;
				
				// get all business for add service
				if($admin_session['role'] == 'owner'){
					$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
					if($all_business) {
						$data['all_business'] = $all_business;
					}
				}
				
				// get all service category for add service
				$cat_type = 1;
				$all_service_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
				if($all_service_category) {
					$data['all_service_category'] = $all_service_category;
				}
				
				// get all resources for add service
				$all_resources = $this->others->get_all_table_value("resources","id,resource_name","","resource_name","ASC");
				if($all_resources) {
					$data['all_resources'] = $all_resources;
				}
				
				//print_r($all_resources); exit;
				
				// get all business Service Timing
				$all_service = $this->others->get_all_table_value("services","id,service_name","","service_name","ASC");
				if($all_service) {
					$data['all_service'] = $all_service;
				}		
				$data['service_active_open']=true;					
				$this->load->view('admin/service/service_view',$data);
				}else{
				redirect(base_url('admin/service'));	
			}
		}
		
		public function service_group_view($id){
			$data = [];
			$admin_session = $this->session->userdata('admin_logged_in');
			if ($id != '' && is_numeric($id)) {				
				
				// get all business
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
				
				// get all service_timing
				$all_service_timing = $this->service_model->getAllServiceTiming($admin_session);
				if($all_service_timing) {
					$data['all_service_timing'] = $all_service_timing;
				}
				
				// get service_group_details if $id exist
				if(!empty($id)){
					// package details
					$service_group_details = $this->others->get_all_table_value("packages","*","id=".$id."","","");
					
					if($service_group_details) {
						$data['service_group_details'] = $service_group_details;
					}
					
					// get service timing for $id
					$service_timing_details = $this->others->get_all_table_value("package_services","*","package_id='".$id."'","id","asc");
					
					if($service_timing_details) {
						$data['service_timing_details'] = $service_timing_details;
					}
				}			 
				$data['service_active_open']=true;					
				$this->load->view('admin/service/servicegroup_view',$data);
				
				}else{
				redirect(base_url('admin/all_service_group'));	
			}
		}
		
		
		public function package_view($id){
			$data = [];
			$admin_session = $this->session->userdata('admin_logged_in');
			if ($id != '' && is_numeric($id)) {				
				
				// get all business
				$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
				if($all_business) {
					$data['all_business'] = $all_business;
				}
				
				// get all service_timing
				$all_service_timing = $this->service_model->getAllServiceTiming($admin_session);
				if($all_service_timing) {
					$data['all_service_timing'] = $all_service_timing;
				}
				//print_r($all_service_timing);die;
				
				// get package_details if $id exist
				if(!empty($id)){
					// package details
					$package_details = $this->others->get_all_table_value("packages","*","id=".$id."","","");
					if($package_details) {
						$data['package_details'] = $package_details;
					}
					
					// get service timing for $id
					$service_timing_details = $this->others->get_all_table_value("package_services","*","package_id='".$id."'","","");
					if($service_timing_details) {
						$data['service_timing_details'] = $service_timing_details;
					}
				}
				//print_r($data['package_details']);die;
				//print_r($data['service_timing_details']);die;
				
				$data['service_active_open']=true;			
				$this->load->view('admin/service/package_view',$data);
				
				}else{
				redirect(base_url('admin/all_packages'));	
			}		
		}
		
		public function class_view($id){
			$data = [];
			$admin_session = $this->session->userdata('admin_logged_in');
			if ($id != '' && is_numeric($id)) {				
				
				// get all business for add service
				if($admin_session['role'] == 'owner'){
					$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
					if($all_business) {
						$data['all_business'] = $all_business;
					}
				}
				
				// get all service category for add service
				$cat_type = 2;
				$all_class_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
				if($admin_session['role']=="owner"){
					
					if($admin_session['business_id'] ==""){
						$all_class_category = $this->others->get_all_table_value("service_category","id,name","cat_type='".$cat_type."'","name","ASC");
						}else{
						$all_class_category = $this->db->select('*')->from('service_category')->where(['business_id'=>$admin_session['business_id'],'cat_type'=>$cat_type])->get()->result_array();
					}
					}else{
					$all_class_category = $this->db->select('*')->from('service_category')->where(['business_id'=>$admin_session['business_id'],'cat_type'=>$cat_type])->get()->result_array();
					
				}
				//gs($all_class_category);
				if($all_class_category) {
					$data['all_class_category'] = $all_class_category;
				}
				
				// get all resources for add service
				$all_resources = $this->others->get_all_table_value("resources","id,resource_name","","resource_name","ASC");
				if($all_resources) {
					$data['all_resources'] = $all_resources;
				}
				
				// get package_details if $id exist
				if(!empty($id)){
					// package details
					$class_details = $this->others->get_all_table_value("services","*","id=".$id."","","");
					if($class_details) {
						$data['class_details'] = $class_details;
					}
					
					// package details
					$fil = array(
					"service_id"=>$id,
					"status"=>1
					);
					$service_timing_details = $this->others->get_all_table_value("service_timing","*",$fil);
					if($service_timing_details) {
						$data['service_timing_details'] = $service_timing_details;
					}
					
					
				}
				//print_r($data['package_details']);die;
				//print_r($data['service_timing_details']);die;
				
				$data['service_active_open']=true;				
				$this->load->view('admin/service/class_view',$data);
				
				}else{
				redirect(base_url('admin/all_class'));	
			}		
		}		
		
		public function calendar_set(){	

			//print_r($_GET); exit;
			if (isset($_GET['location_id'])) {
				$location_id = $_GET['location_id'];
			}	
			if (isset($_GET['staffid'])) {
				$staff_id = $_GET['staffid'];
			}	 
			
			
			//print_r($_POST); exit;
			//gs($location_id); exit;
			//gs($this->input->get());
			$admin_session = $this->session->userdata('admin_logged_in');
				//print_r($admin_session); exit;
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$options = array();
			$newArr = array();
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1,'is_service_group'=>0])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where('status',1)->get()->result_array();
			}	
			$options = array();
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->where('is_service_group',0)->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['caption_id'] = $value['id'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing);
			
			$data['options'] = $service_timing;
			$arr_search['business_id'] = $admin_session['business_id'];
			$all_service_group = $this->service_model->get_service_group(false,$arr_search,"", "","sequenceo_order","ASC");
			
			
			
			
			$data['options_gs'] = $all_service_group;
			if (isset($_GET['startDate']) && !$this->input->post('action')) {
				if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){
					$start_date =	implode("-", explode("/", $_GET['startDate']));
					//$start_date = ('Y-m-d', strtotime('dd/mm/yyyy',$_GET['startDate']));
					//echo $start_date; exit;
					$start_date = $_GET['startDate'];
					$end = $_GET['startDate'];
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
					
					/*$data4 = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/
					
					$staffs=array_merge($data1,$data2,$data3);
					//print_r($staffs); exit;
					
					/*$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/
					//print_r($staffs); exit;
					
					
					}elseif($admin_session['role']=='location_owner'){
					$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'id'=>$staff_id])->get()->result_array();
				}

				elseif ($admin_session['role']=='staff') {
					$staffs = $this->db->select('*')->from('staff')->where('id',$admin_session['staff_id'])->get()->result_array();
				}

				//echo "<pre>"; print_r($staffs); exit;
				$data['staff'] = $staffs;
				
				
			}
			
			
			
			if($this->input->post('action')){
				// echo "<pre>"; print_r($_POST); die;
				$customer_id = ($this->input->post('customer_id'))?$this->input->post('customer_id'):null;
				$location_id = $this->input->post('location_id');
				//echo $location_id;
				$description = $this->input->post('description');
				$date = date("Y-m-d",strtotime($this->input->post('date')));
				$start_time = $this->input->post('start_time');
				$service = $this->input->post('service');
				$duration = $this->input->post('duration');
				$staff = $this->input->post('staff');
				$calendar_staff = $this->input->post('calendar_staff');
				$group_service_id = $this->input->post('group_service_id');
				$appointment_total_amount = $this->input->post('appointment_total_amount');
				//gs($service);
				//print_r($duration); exit;
				
				// insert data into bookings table
				/*	$this->load->library('form_validation');
					$this->form_validation->set_rules('customer_id', 'Customer Id', 'trim|required|xss_clean');
					$this->form_validation->set_rules('location_id', 'Location Id', 'trim|required|xss_clean');
					$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
					$this->form_validation->set_rules('start_time', 'Start Time', 'trim|required|xss_clean');
					$this->form_validation->set_rules('service', 'Service', 'trim|required|xss_clean');
					$this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
					
					$this->form_validation->set_rules('staff', 'Staff', 'trim|required|xss_clean');
					$this->form_validation->set_rules('calendar_staff', 'Calendar Staff', 'trim|required|xss_clean');
					$this->form_validation->set_rules('appointment_total_amount', 'Appointment Total Amount', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) 
				{*/
				//gs($this->input->post());
				
				//print_r()
				//$service = preg_replace("/[^a-zA-Z]/", "", $service);
				//print_r($group_service_id); exit;
				
				$mail_confirmaion=$this->db->select('*')->from('email_confirmation_time')->where('business_id',$admin_session['business_id'])->get()->row_array();
				//print_r($mail_confirmaion['today_sms']); exit;
				
				if ($mail_confirmaion['today_sms']==0 && $date ==date('Y-m-d')) {
					$is_confirmation_sent=1;
					}else{
					$is_confirmation_sent=0;
				}
				
				$service=preg_replace('/[^0-9]/', '', $service);
				//print_r($service); exit;
				$appointment_booking_number=rand(10000000,99999999);
				$insert_array = [
				'booking_number'=>$appointment_booking_number,
				'customer_id'=>$customer_id,
				'business_id'=>$admin_session['business_id'],
				'location_id'=>$location_id,
				'staff_notes'=>$description,
				'start_date'=>$date,
				'staff_id'=>$calendar_staff,
				'start_time'=>$start_time[0],
				'booking_status'=>6,
				'is_confirmation_sent'=>$is_confirmation_sent,
				'date_created'=>date("Y-m-d H:i:s")
				];
				
				//print_r($insert_array); exit;
				
				$insert = $this->others->insert_data("bookings",$insert_array);
				if($insert){
					$booking_id =$insert;
					// Insert data into booking_services
					//print_r($service); exit;
					foreach ($service as $key => $value) {
						//$group_service_id=isset($group_service_id[$key])?$group_service_id[$key]:0;
						$insert_array = [
						'booking_id'=>$booking_id,
						'service_id'=>getmainServiceId($service[$key]),
						'service_timing_id'=>$service[$key],
						'staff_id'=>$staff[$key],
						'group_service_id'=>isset($group_service_id[$service[$key]])?$group_service_id[$service[$key]]:0,						
						'book_start_time'=>$start_time[$key],
						'book_duration'=>date('H:i:00', mktime(0,$duration[$key])),
						'book_end_time'=>sum_the_time($start_time[$key],date('H:i:00', mktime(0,$duration[$key]))),
						'date'=>$date
						];
						$this->others->insert_data("booking_services",$insert_array);
					}
					
					if($description !=null && $customer_id!=null){
						$insert_array = [
						'customer_id'=>$customer_id,
						'notes'=>$description,				
						'date_created'=>date("Y-m-d H:i:s"),
						];
						$insert = $this->others->insert_data("customer_notes",$insert_array);
					}
					if($customer_id !=null){
						$customer_data = $this->db->select('*')->from('customer')->where('id',$customer_id)->get()->row_array();
						
						// Send Message from twalio Api
						
						/*if($customer_data['mobile_number'] !="" && strlen($customer_data['mobile_number'])>2 && ($customer_data['notification']=='both' or $customer_data['notification']=='sms')){
							$smsaccount=getTwilioSmsAccounts($customer_data['business_id']);
							require_once(APPPATH.'twilio-php-master/Twilio/autoload.php');
							$twalio_keys = array(
							"sid"      => $smsaccount['account_sid'],						
							"token" => $smsaccount['auth_token'],
							"twalio_phone_number" => $smsaccount['mobile_number'],	
							//"sid"      => $this->config->item('sid'),
							//"token" => $this->config->item('token'),
							//"twalio_phone_number" => $this->config->item('twalio_phone_number'),
							"twalio_messaging_service_id" => $this->config->item('twalio_messaging_service_id'),
							);
							$mobile_number = str_replace(" ","",$customer_data['mobile_number']);
							//gs($mobile_number);
							$client = new Client($twalio_keys['sid'], $twalio_keys['token']);
							try{
							$client->messages->create(
							// the number you'd like to send the message to
							$mobile_number,
							//'+61450372103',
							array(
							// A Twilio phone number you purchased at twilio.com/console
							'from' => $twalio_keys['twalio_phone_number'],
							// the body of the text message you'd like to send
							//'messaging_service_sid'=>$twalio_keys['twalio_messaging_service_id'],
							'body' => "Your appointment has been booked successfully."
							)
							);
							}catch(Exception $e){
							//echo "<pre>",print_r($e->getMessage());die;
							}
						}*/
						
						
						//calendar set booking time mail send	
						
						if($customer_data['notification']=='both' or $customer_data['notification']=='email'){	
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
							
							$business_name = getBusinessNameById($admin_session['business_id']);
							$customer_name = getCustomerNameById($customer_id);
							$location_name = getLocationNameById($location_id);
							$location_deatils=getLocationData($location_id); 
							
							$service = $this->input->post('service');
							$service=preg_replace('/[^0-9]/', '', $service);
							$service_list='';
							$i=1;
							foreach ( $service as $key => $value) {
								//$service_name=getCaptionName($service[$key]);
								$caption_name=getCaptionName($service[$key]);
								$service_main_id=getmainServiceId($service[$key]);			 	
								$service_main_name=getServiceName($service_main_id);			 	
								$service_list.='<br>'.$i.'.  '.$service_main_name.' '.$caption_name;
								//	$service_list.='<br>'.$i.'.  '.$service_name;
								$i++;
							}  
							
							
							
							$date = date("d-m-Y",strtotime($this->input->post('date')));
							
							/* $appointment_email = $this->db->select('*')->from('templates')->where('slug','appointment')->get()->row_array();*/
							$appointment_email= getEmailTemplate($admin_session['business_id'],'appointment');
							
							$subject = str_replace("{BUSINESS_NAME}",$business_name,$appointment_email['subject']);
							$mail_data = str_replace(["{BUSINESS_NAME}","{CUSTOMER_NAME}","{APPOINTMENT_NUMBER}","{TOTAL_AMOUNT}","{location}","{date}","{time}","{service}","{LOCATION_PHONE}"],[$business_name,$customer_name,$appointment_booking_number,$appointment_total_amount,$location_name,$date,$start_time[0],$service_list, $location_deatils['phone_number']], $appointment_email['email_html']);
							$appointment['subject'] = $subject;
							$appointment['mail_data'] = $mail_data;
							
							$customer_email = $this->db->select('*')->from('customer')->where('id',$customer_id)->get()->row_array();
							// $mail_content = $this->load->view('admin/templates/appointment',$appointment,true);
							
							$mail_content = $this->load->view('booking-confirmation',$appointment,true);
							$data['business_id'] = $admin_session['business_id'];
							$data['customer_id'] = $customer_id;
							$data['appointment_booking_number'] = $appointment_booking_number;
							$data['date'] = $date;
							$data['service'] = $service;
							$data['staff'] = $staff;
							$data['duration'] = $duration;
							$data['start_time'] = $start_time;
							$data['appointment_total_amount'] = $appointment_total_amount;
							$this->load->helper('dompdf');
							$this->load->library('dompdf_gen');
							$this->load->view("admin/calendar/appointment_pdf",$data);
							$html = $this->output->get_output();
							$this->dompdf->load_html($html);
							$this->dompdf->render();
							file_put_contents('uploads/calendar/'.$appointment_booking_number.".pdf", $this->dompdf->output());
							$email =$customer_email['email'];	
							$this->db->select('*');
							$this->db->from('location');
							$this->db->where('id',$location_id);
							$getlocation=$this->db->get()->row_array();
							$locationmail=$getlocation['email'];
							$mail = $this->config->item('mail_data');			
							//$mail_content ='dummy content';
							$mail = $this->config->item('mail_data');
							$this->load->library('email', $mail);
							$this->email->set_newline("\r\n");
							$this->email->from($this->config->item('default_mail'),$business_name.'/'.$location_name);
							$list = array($email);
							$this->email->to($list);
							$this->email->to($list);
							$this->email->subject($subject);
							$this->email->message($mail_content);
							$file_name = $appointment_booking_number.".pdf";
							//	$this->email->attach(base_url('uploads/calendar/'.$file_name));
							$this->email->send();
							if (isset($locationmail) && $locationmail!='') {
								$welcome_email = getEmailTemplate($admin_session['business_id'],'email-for-location');
								$mail_data = str_replace(["{CUSTOMER_NAME}","{APPOINTMENT_NUMBER}","{BUSINESS_NAME}","{LOCATION_NAME}","{LOCATION_PHONE}"],[$customer_name,$appointment_booking_number,$business_name,$location_name,$location_deatils['phone_number']], $welcome_email['email_html']);
								$data['subject'] =$welcome_email['subject'];
								$data['mail_data'] = $mail_data;
								$subject = $welcome_email['subject'];
								$mail_content = $this->load->view('booking-confirmation',$data,true);
								$mail = $this->config->item('mail_data');
								$this->load->library('email', $mail);
								$this->email->set_newline("\r\n");
								$this->email->from($this->config->item('default_mail'),$business_name);
								$list = array($locationmail);
								$this->email->to($list);
								$this->email->subject($subject);
								$this->email->message($mail_content);
								$this->email->send();
							}
						}
					}
				}
				
				//print_r($mail); die;
				$date = date("Y/m/d",strtotime($this->input->post('date')));
				redirect(base_url('admin/service/calendar?startDate='.$date.'&startTime='.$start_time[0].'&staffid='.$calendar_staff.'&location_id='.$location_id.''));	
			}
			
			
			//}
			$this->load->view('admin/calendar/appointment',$data);
		}
		
		public function calendar_edit($booking_id){
			$admin_session = $this->session->userdata('admin_logged_in');
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$options = array();
			$newArr = array();
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where("status",1)->get()->result_array();
			}	
			$options = array();
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['caption_id'] = $value['id'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing);
			$data['options'] = $service_timing;		
			$data['booking'] = $booking = $this->db->select('*')->from('bookings')->where('id',$booking_id)->get()->row_array();
			$data['booking_services'] = $this->db->select('*')->from('booking_services')->where('booking_id',$booking_id)->order_by('id','asc')->get()->result_array();
			$booking_services = array();
			if(!empty($data['booking_services'])){
				foreach($data['booking_services'] as $booking_service_val){
					if(empty($booking_service_val['service_timing_id'])){
						$booking_service_val['service_timing_id'] = $booking_service_val['service_id'];
					}
					$booking_services[] = $booking_service_val;
				}
			}
			$data['booking_services'] = $booking_services;
			if($booking['customer_id'] !=""){
				$id = $booking['customer_id'];
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
			}
			$location_id = $booking['location_id'];
			$start_date = $booking['start_date'];
			$end = $booking['start_date'];
 			$week_day = getWeekDay($start_date);
			if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){
				
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
				
				//print_r($staffs); exit;
				/*$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/
				
				
				}else{
				$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'id'=>$staff_id])->get()->result_array();
			}
			//print_r($staffs); exit;
			$data['staff'] = $staffs;
			if($this->input->post('action')){
				//gs($this->input->post());
				$customer_id = ($this->input->post('customer_id'))?$this->input->post('customer_id'):null;
				$location_id = $this->input->post('location_id');
				$description = $this->input->post('description');
				$date = date("Y-m-d",strtotime($this->input->post('date')));
				$start_time = $this->input->post('start_time');
				$service = $this->input->post('service');
				$duration = $this->input->post('duration');
				$staff = $this->input->post('staff');
				$calendar_staff = $this->input->post('calendar_staff');
				$group_service_id = $this->input->post('group_service_id');
				$service=preg_replace('/[^0-9]/', '', $service);
				//gs($this->input->post());
				// insert data into bookings table
				$update_array = [
				'customer_id'=>$customer_id,
				'location_id'=>$location_id,
				'staff_notes'=>$description,
				'start_date'=>$date,
				'staff_id'=>$calendar_staff,
				'start_time'=>$start_time[0],
				'date_updated'=>date("Y-m-d H:i:s"),
				]; 
				$update = $this->others->update_common_value("bookings",$update_array,"id='".$booking_id."' ");
				if($update){
					$existing_staffs = $this->db->select('*')->from('booking_services')->where(['booking_id'=>$booking_id])->get()->result_array();
					$old_staff = array();
					foreach($existing_staffs as $staff_val){
						$old_staff[] = $staff_val['staff_id'];
					}
					$count_diff1 = count((array)array_diff($staff, $old_staff));
					$count_diff2 = count((array)array_diff($old_staff, $staff));
					if($count_diff1 || $count_diff2){
						insertBookingLog($booking_id,'Reassignment',implode(',',$staff),implode(',',$old_staff));
					}
					//die;
				
					//Delete old records
					//$this->db->delete('booking_services', array('booking_id' => $booking_id));
					$this->others->delete_record("booking_services","booking_id='".$booking_id."'");	

					// Insert data into booking_services
					foreach ($service as $key => $value) {
						$insert_array = [
						'booking_id'=>$booking_id,
						'group_service_id'=>isset($group_service_id[$service[$key]])?$group_service_id[$service[$key]]:0,
						'service_id'=>getmainServiceId($service[$key]),
						'service_timing_id'=>$service[$key],
						'staff_id'=>$staff[$key],
						'book_start_time'=>$start_time[$key],
						'book_duration'=>date('H:i:00', mktime(0,$duration[$key])),
						'book_end_time'=>sum_the_time($start_time[$key],date('H:i:00', mktime(0,$duration[$key]))),
						'date'=>$date
						];
						$this->others->insert_data("booking_services",$insert_array);
					}
				}
				
				
				
				$date = date("Y/m/d",strtotime($this->input->post('date')));
				redirect(base_url('admin/service/calendar?startDate='.$date.'&startTime='.$start_time[0].'&staffid='.$calendar_staff.'&location_id='.$location_id.''));
				
				//redirect(base_url('admin/service/calendar'));
			}
			//gs($data ); die;
			//print_r($data); exit;
			$this->load->view('admin/calendar/calendar_edit',$data);
		}
		
		public function calendar_view($booking_id){
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['admin_session'] = $admin_session;
			$data['booking'] = $booking = $this->db->select('*')->from('bookings')->where('id',$booking_id)->get()->row_array();

			$data['total_reference_booking_id']  = $this->db->select('count(*) AS total_reference_booking_id')->from('invoices')->where('reference_booking_id',$booking_id)->get()->row()->total_reference_booking_id;
			
			$data['booking_services'] = $this->db->select('*')->from('booking_services')->where('booking_id',$booking_id)->order_by('id','asc')->get()->result_array();
			$booking_services = array();
			if(!empty($data['booking_services'])){
				foreach($data['booking_services'] as $booking_service_val){
					if(empty($booking_service_val['service_timing_id'])){
						$booking_service_val['service_timing_id'] = $booking_service_val['service_id'];
					}
					$booking_services[] = $booking_service_val;
				}
			}
			$data['booking_services'] = $booking_services;
			if($booking['customer_id'] !=""){
				$id = $booking['customer_id'];
				$data['personal_information'] = $this->db->select('*')->from('customer')->where(['id'=>$id])->get()->row_array();
				$data['invoices'] = $this->db->select('*')->from('invoices')->where(['customer_id'=>$id])->get()->result_array();
				$data['bookings'] = $this->db->select('*')->from('bookings')->where(['customer_id'=>$id])->get()->result_array();
			}
			// check previous invoices
			$booking_invoices = $this->db->select('*')->from('invoices')->where('booking_id',$booking_id)->get()->row_array();
			//print_r($booking_invoices); exit;

			if($booking_invoices){
				$invoice_payments = $this->db->select('*')->from('invoice_payments')->where(['invoice_id'=>$booking_invoices['id'],'pay_process_type'=>0])->get()->result_array();
				$data['booking_invoices'] = $booking_invoices;		
				$data['invoice_payments'] = $invoice_payments;
			}

			$data['booking_logs']= $this->db->select('*')->from('booking_logs')->where('booking_id',$booking_id)->order_by('id','desc')->get()->result_array();
			
			//echo "<pre>"; print_r($data['booking_logs']); exit;
			$this->load->view('admin/calendar/calendar_view',$data);
		}
		
		public function appointment_row(){
			$start_time_array = $this->input->post('start_time_array');
			$duration_array = $this->input->post('duration_array');
			$extra_time_array = $this->input->post('extra_time_arr');
			$start_date = $this->input->post('select_start_date');
			$location_id =  $this->input->post('location_id');
			//print_r($duration_array); //exit;
			foreach ($duration_array as $key => $value) {
				$duration_arr[] = date('H:i:00', mktime(0,$value));
			}
			foreach ($extra_time_array as $key => $value) {
				$extra_time_arr[] = date('H:i:00', mktime(0,$value));
			}
			// Get Time for next appointment
			foreach ($start_time_array as $key => $value) {
				$next_time = sum_the_time3($value,$duration_arr[$key],$extra_time_arr[$key]);
			}
			$data['next_time'] = $next_time;
			$data['staff_id'] = $this->input->post('staff_id');
			$data['get_hours_range'] = get_hours_range();
			$admin_session = $this->session->userdata('admin_logged_in');
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$options = array();
			$newArr = array();
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1,'is_service_group'=>0])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where("status",1)->get()->result_array();
			}	
			$options = array();
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['caption_id'] = $value['id'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing); 
			$data['options'] = $service_timing;	
			
			if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){
				/*$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/
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
				
				}elseif($admin_session['role']=='location_owner'){
				$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'id'=>$staff_id])->get()->result_array();
			}
			elseif ($admin_session['role']=='staff') {
					$staffs = $this->db->select('*')->from('staff')->where('id',$admin_session['staff_id'])->get()->result_array();
				}
			$data['staff'] = $staffs;
			$data['x'] = $this->input->post('x');
			/*$all_service_group = $this->service_model->get_service_group(false,"","", "","date_created","DESC");*/
			
			$arr_search['business_id'] = $admin_session['business_id'];
			$all_service_group = $this->service_model->get_service_group(false,$arr_search,"", "","sequenceo_order","ASC");
			
			$data['options_gs']=$all_service_group;
			
			
			$view = $this->load->view('admin/calendar/appointment_row',$data,true);
			echo $view;
		}
		
		/*public function all_event_data(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$booking = array();
			$record = $this->db->from('bookings')->where(['business_id'=>$admin_session['business_id']])->get()->result_array();
			$events = array();
			$eventArray['resourceId'] = 29;
			$eventArray['title'] =  'Head shyam Massage';
			$eventArray['start'] = '2018-09-02T10:30:00';
			$eventArray['end'] = '2018-09-03T12:35:00';
			$events[] = $eventArray;
			
			echo json_encode($events);
		}*/
		
		public function all_event_data(){
			//print_r($_POST); exit;
			$admin_session = $this->session->userdata('admin_logged_in');
			$eventArray = array();
			$start_date = explode("T",$this->input->post('start'));
			$end_date = explode("T",$this->input->post('end'));
			$location_id = $this->input->post('location_id');
			$staff_id = $this->input->post('staff_id');
			$available_staff = array();
			$staff_arr = array();
			$booking = $this->db->select('id')->from('bookings')->where(['location_id'=>$location_id,'start_date >='=>$start_date[0],'start_date <='=>$end_date[0],'booking_status <>'=>2])->get()->result_array();
			// get blocked time
			$blocked_times = $this->db->select("*")->from("blocked_time")->where(['date >='=>$start_date[0],'date <='=>$end_date[0],'location_id'=>$location_id])->get()->result_array();
			//echo json_encode($booking);die;
			if($staff_id !=""  && $staff_id!=0){
				/*$booking =  $this->db->select('booking_id as id')->from('booking_services')->where(['staff_id'=>$staff_id ,'date >='=>$start_date[0],'date <='=>$end_date[0]])->get()->result_array();*/
				
				$this->db->select('booking_services.booking_id as id');
				$this->db->from('booking_services');
				$this->db->join('bookings','booking_services.booking_id=bookings.id','inner');
				$this->db->where(['booking_services.staff_id'=>$staff_id ,'booking_services.date >='=>$start_date[0],'booking_services.date <='=>$end_date[0],'bookings.booking_status <>'=>2]);
				$booking = $this->db->get()->result_array();
				
				// get blocked time
				$blocked_times = $this->db->select("*")->from("blocked_time")->where(['staff_id'=>$staff_id,'date >='=>$start_date[0],'date <='=>$end_date[0]])->get()->result_array();
				
			}
			if($staff_id==0 && $staff_id !=""){
				/*$staffs = $this->db->select('id')->from('staff')->where(['location_id'=>$location_id,'calendor_bookable_staff'=>1,'status'=>1])->get()->result_array();*/
				//gs($staffs);
				
				$start_date = $start_date[0];
				$week_day = getWeekDay($start_date);
				// case 1 (is_repeat=1)
				
				$query = $this->db->query("SELECT staff.id AS id  FROM  roster
				JOIN staff ON staff.id =roster.staff_id 
				where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.is_repeat=1 and roster.is_break=0");
				$data1 = $query->result_array();
				// case 2 (is_repeat=0)
				
				$query = $this->db->query("SELECT staff.id AS id
 				FROM  roster
 				JOIN staff ON staff.id =roster.staff_id
				where  roster.location_id=$location_id and roster.week_day_date='$start_date' and roster.is_repeat=0 and roster.is_break=0");
				$data2 = $query->result_array();
				//case 3 (is_repest=2)
				
 				$query = $this->db->query("SELECT staff.id AS id
				FROM  roster
				JOIN staff ON staff.id =roster.staff_id
				where  roster.location_id=$location_id and roster.week_day=$week_day and roster.week_day_date<='$start_date' and roster.end_repeat_date>='$start_date' and roster.is_repeat=2 and roster.is_break=0");
 				$data3 = $query->result_array();
				
				$staffs=array_merge($data1,$data2,$data3);
				
 				// print_r($staffs); exit;
				if(count((array)$staffs)>0){
					foreach ($staffs as $key => $value) {
						//echo $value['id'].' '.$start_date[0].' '.$location_id; exit;
						$check = checkStaffAvailablityNew($value['id'],$start_date[0],$location_id);
						if($check){
							$available_staff[]=$check;
						}
					}
					if(count((array)$available_staff)>0){
						foreach ($available_staff as $key => $value) {
							$staff_arr[] = $value['staff_id'];
						}
					}
					//gs($staff_arr);
					if($staff_arr){
						
						/*$booking = $this->db->select('booking_id as id')->from('booking_services')->where(['date >='=>$start_date[0],'date <='=>$end_date[0]])->where_in('staff_id',$staff_arr)->get()->result_array();*/
						
						$this->db->select('booking_services.booking_id as id');
						$this->db->from('booking_services');
						$this->db->join('bookings','booking_services.booking_id=bookings.id','inner');
						$this->db->where(['booking_services.date >='=>$start_date[0],'booking_services.date <='=>$end_date[0],'bookings.booking_status <>'=>2])->where_in('booking_services.staff_id',$staff_arr);
						$booking = $this->db->get()->result_array();
						
						//print_r($this->db->last_query()); exit;
						
						// get blocked time
						$blocked_times = $this->db->select("*")->from("blocked_time")->where(['date >='=>$start_date[0],'date <='=>$end_date[0]])->where_in('staff_id',$staff_arr)->get()->result_array();
					}
				}
			}
			$i=0;
			//gs($booking);
			if($booking){
				foreach ($booking as $key => $value) {
					$booking_ids[] = $value['id'];
				}
				/*$this->db->select('booking_services.*');
					$this->db->from('booking_services');
					$this->db->join('booking','booking_services.booking_id=booking.id','inner');
					$this->db->where('booking.booking_status <>',2);				
					$this->db->where_in('booking_id',$booking_ids);				
				$booking_services =$this->db->get()->result_array();*/
				
				$booking_services = $this->db->from('booking_services')->where_in('booking_id',$booking_ids)->get()->result_array();
				//gs($booking_services);
				//print_r($booking_services); exit;
				foreach ($booking_services as $key => $value) {
					$booking_data = $this->db->select('*')->from('bookings')->where('id',$value['booking_id'])->get()->row_array();
					if($value['date']!=""){
						$sum_time = sum_the_time2($value['book_start_time'],$value['book_duration']);	
						//echo $sum_time."<br>"; 			
						$eventArray[$i]['id'] = $value['booking_id'];
						$eventArray[$i]['booking_service_id'] = $value['id'];
						$eventArray[$i]['resourceId'] = $value['staff_id'];
						if ($value['service_timing_id']>0) {
							$eventArray[$i]['title'] = getServiceName(getmainServiceId($value['service_timing_id'])).' '.getCaptionName($value['service_timing_id']);
						}
						else{
							$eventArray[$i]['title']=" ";
						}
						
						
						$eventArray[$i]['start'] = $value['date'].'T'.$value['book_start_time'];
						$eventArray[$i]['end'] = $value['date'].'T'.$sum_time;
						$eventArray[$i]['status'] = getBookingStatus($booking_data['booking_status']);
						$eventArray[$i]['customer_name'] = ($booking_data['customer_id'])?getCustomerNameById($booking_data['customer_id']):"Walk-In";
						$eventArray[$i]['customer_number'] = ($booking_data['customer_id'])?getCustomerNumberById($booking_data['customer_id']):"";
						$eventArray[$i]['start_time'] = date("h:i a",strtotime($value['book_start_time']));
						$eventArray[$i]['end_time'] = date("h:i a",strtotime($sum_time));
						$eventArray[$i]['staff'] = getStaffName($value['staff_id']);
						$eventArray[$i]['price'] = serviceprice($value['service_id']);
						$eventArray[$i]['Advance'] = advancePriceByBooking_id($booking_data['id']);
						if ($value['service_timing_id']>0) {
							$eventArray[$i]['price'] = serviceprice($value['service_timing_id']);
						}
						if ($eventArray[$i]['Advance']>0) {
						$eventArray[$i]['price']=$eventArray[$i]['price'].'/ $'.$eventArray[$i]['Advance'].' Advance';
						}
						$eventArray[$i]['color'] = setEventColor($booking_data['booking_status']);
						$eventArray[$i]['nstatus'] = $booking_data['booking_status'];
						$eventArray[$i]['amount_ouststanding'] = getBookingOutstandingAmount($booking_data['id']);
						$eventArray[$i]['type'] = "event";
						$i++;
					}
				}
			}
			
			if($blocked_times){
				foreach ($blocked_times as $key => $value) {
					$eventArray[$i]['id'] = $value['id'];
					$eventArray[$i]['resourceId'] = $value['staff_id'];
					$eventArray[$i]['title'] = "Blocked Time"; 
					$eventArray[$i]['start'] = $value['date'].'T'.$value['start_time'];
					$eventArray[$i]['end'] = $value['date'].'T'.$value['end_time'];
					$eventArray[$i]['status'] = "Blocked Time";
					$eventArray[$i]['start_time'] = date("h:i a",strtotime($value['start_time']));
					$eventArray[$i]['end_time'] = date("h:i a",strtotime($value['end_time']));
					$eventArray[$i]['staff'] = getStaffName($value['staff_id']);
					$eventArray[$i]['color'] = "#24334A";
					$eventArray[$i]['type'] = "blocked_time";
					$eventArray[$i]['description'] = $value['description'];
					$i++;
				}
			}
			
			
			//gs($eventArray);
			echo json_encode($eventArray);
		}
		
		public function updateBookingStatus(){
			$status_array = array(1=>"New Appointment",5=>"Arrived",6=>"Confirmed",7=>"Started",4=>"No Show",2=>"Cancelled",8=>"Re-confirmed",3=>"Completed");
			$booking_id = $this->input->post('booking_id');
			$status = $this->input->post('status');
			$old_booking_data =  $this->db->query("SELECT * FROM bookings where id=$booking_id")->row_array();
			$update = $this->others->update_common_value("bookings",array("booking_status"=>$status),"id='".$booking_id."' ");
			if($update){
				insertBookingLog($booking_id,'Status',$status_array[$status],$status_array[$old_booking_data['booking_status']]);
			}
			
			if($status==2 or $status==6 or $status==3){
				$bookings = $this->db->query("SELECT * FROM bookings where id=$booking_id")->row_array();
				if($bookings['customer_id']!=""){
					$customer_data = $this->db->select('*')->from('customer')->where('id',$bookings['customer_id'])->get()->row_array();				
					$email = $customer_data['email'];
					if($email !='' && ($customer_data['notification']=='both' or $customer_data['notification']=='email')){
						$customer_name = $customer_data['first_name'].' '.$customer_data['last_name'];		
						$customer_number = $customer_data['mobile_number'];		
						$booking_referance = $bookings['booking_number'];		
						$business_name = getBusinessNameById($bookings['business_id']);	
						$booking_date_time = date("d M,Y",strtotime($bookings['start_date']));	
						$location_data = getLocationData($bookings['location_id']);
						$location_name = $location_data['location_name'];
						$location_phone = $location_data['phone_number'];
						$location_email = $location_data['email'];
						if($status==2){
							$welcome_email = getEmailTemplate($bookings['business_id'],'appointment-cancelled');
							}elseif($status==6){
							$welcome_email = getEmailTemplate($bookings['business_id'],'appointment-confirmed');
							}elseif($status==3){
							$welcome_email = getEmailTemplate($bookings['business_id'],'thankyou');
						}
						$booking_services = $this->db->query("SELECT * FROM booking_services where booking_id=$booking_id")->result_array();
						$i=1;
						$service_list='';
						foreach ($booking_services as $key => $value) {
							$caption_name=getCaptionName($value['service_id']);
								$service_main_id=getmainServiceId($value['service_id']);			 	
								$service_main_name=getServiceName($service_main_id);			 	
								$service_list.='<br>'.$i.'.  '.$service_main_name.' '.$caption_name;
								$i++;
						}
								

						$mail_data = str_replace(["{CLIENT_FIRST_NAME}","{BOOKING_REFERENCE}","{BUSINESS_NAME}","{BOOKING_DATE_TIME}","{LOCATION_NAME}","{LOCATION_PHONE}","{service}","{LOCATION_EMAIL}"],[$customer_name,$booking_referance,$business_name,$booking_date_time,$location_name,$location_phone,$service_list,$location_email], $welcome_email['email_html']);
						$data['subject'] =$welcome_email['subject'];
						$data['mail_data'] = $mail_data;
						$subject = $welcome_email['subject'];
						$mail_content = $this->load->view('booking-confirmation',$data,true);
						$mail = $this->config->item('mail_data');
						$this->load->library('email', $mail);
						$this->email->set_newline("\r\n");
						$this->email->from($this->config->item('default_mail'),$business_name.'/'.$location_name);
						$list = array($email);
						$this->email->to($list);
						$this->email->subject($subject);
						$this->email->message($mail_content);
						$this->email->send();
					}
				}
			}
			
			if($status){
				echo json_encode(["type"=>"success","status"=>$status_array[$status]]);
				}else{
				echo json_encode(["type"=>"error"]);
			}
		}
		
		public function appointments()
		{
			$admin_session = $this->session->userdata('admin_logged_in');		
			$this->db->select('staff.first_name AS staff_first_name,staff.last_name AS staff_last_name,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,booking_services.book_start_time,booking_services.book_duration,bookings.date_created,bookings.start_date,bookings.booking_number,bookings.id');		
			$this->db->from('bookings');
			$this->db->join('booking_services','bookings.id=booking_services.booking_id','inner');
			$this->db->join('staff','staff.id=booking_services.staff_id','inner');
			$this->db->join('customer','customer.id=bookings.customer_id','Left');
			if ($admin_session['role']=='business_owner') {
				$this->db->where('bookings.business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='staff') {
				$this->db->where('booking_services.staff_id',$admin_session['staff_id']);
			}
			if ($admin_session['role']=='location_owner') {
				$this->db->where('bookings.location_id',$admin_session['location_id']);
			}
			$this->db->group_by('booking_services.booking_id');
			$this->db->order_by('booking_services.id','desc');
			$query = $this->db->get()->result();
			$data['appointment']=$query;
			$data['appointment_active_open']=true;
			$this->load->view('admin/service/all_appointments', $data);
		}
		
		public function setsession($key){
			$this->session->set_userdata("default_view",$key);
		}
		
		public function updateCalendarBooking(){
			$start = explode("T",$this->input->post('start'));
			$end = explode("T",$this->input->post('end'));
			$start_date = $start[0];
			$start_time = $start[1];
			$end_time = $end[1];
			$staff_id = $this->input->post('resourceId');
			$booking_id = $this->input->post('event_id');
			$booking_service_id = $this->input->post('booking_service_id');
			
			//update booking_service
			$update_data = array(
 			"staff_id"=>$staff_id,
 			"book_start_time"=>$start_time,
 			"book_end_time"=>$end_time,
 			"date"=>$start_date
			);
			$update = $this->others->update_common_value("booking_services",$update_data,"id='".$booking_service_id."'");
			if($update){
				echo json_encode(["type"=>"success"]);
				}else{
				echo json_encode(["type"=>"error"]);
			}
		}
		
		public function gsstaff(){
			$data = $this->db->select("*")->from('admin_users')->get()->result_array();
			gs($data);
		}
		
		public function booking_confirmation_slot(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$time = $this->db->select('*')->from('email_confirmation_time')->where('business_id',$admin_session['business_id'])->get()->row_array();
			$data['settings'] = $time;
			$data['setup_active_open']=true;
			if($this->input->post('action')){
				$time_data = $this->input->post('time');
				$email_time_data = $this->input->post('email_time');
				$today_sms_data = $this->input->post('today_sms');
				if(count((array)$time)>0){
					$update_data = array(
		 			"time"=>$time_data,
		 			"email_time"=>$email_time_data,
		 			"today_sms"=>$today_sms_data,
					);
					$update = $this->others->update_common_value("email_confirmation_time",$update_data,"business_id='".$admin_session['business_id']."'");
					}else{
					$add_data = array(
		 			"time"=>$time_data,
		 			"email_time"=>$email_time_data,
		 			"today_sms"=>$today_sms_data,
		 			"business_id"=>$admin_session['business_id'],
					);
					$this->others->insert_data("email_confirmation_time",$add_data);
				}
				$this->session->set_flashdata('success_msg', "Record Saved successfully.");
				return redirect(base_url('admin/service/booking_confirmation_slot'));
			}
			$this->load->view('admin/service/booking_confirmation_slot',$data);
		}
		
		public function client_notification(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$data['active'] = "setup_active_open";
			
			// Get Reminder Email
			$reminder_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'appointment-reminder'])->get()->row_array();
			if(count((array)$reminder_email)==0){
				$reminder_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'appointment-reminder'])->get()->row_array();
			}
			$data['reminder_email'] = $reminder_email;
			
			//Widget Booking Email
			$widget_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'onlinebookings'])->get()->row_array();
			if(count((array)$widget_booking_email)==0){
				$widget_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'onlinebookings'])->get()->row_array();
			}
			$data['widget_booking_email'] = $widget_booking_email;


			//Pencilled In Widget Booking Email
			$pencilled_in_widget_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'onlinepencilledbookings'])->get()->row_array();
			if(count((array)$pencilled_in_widget_booking_email)==0){
				$pencilled_in_widget_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'onlinepencilledbookings'])->get()->row_array();
			}
			$data['pencilled_in_widget_booking_email'] = $pencilled_in_widget_booking_email;

			
			//Calendar Booking Email
			$calendar_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'appointment'])->get()->row_array();
			if(count((array)$calendar_booking_email)==0){
				$calendar_booking_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'appointment'])->get()->row_array();
			}
			$data['calendar_booking_email'] = $calendar_booking_email;
			
			//Invoice Receipt Email
			$invoice_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'invoice'])->get()->row_array();
			if(count((array)$invoice_email)==0){
				$invoice_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'invoice'])->get()->row_array();
			}
			$data['invoice_email'] = $invoice_email;
			
			//Gift Voucher Email
			$voucher_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'gift-voucher'])->get()->row_array();
			if(count((array)$voucher_email)==0){
				$voucher_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'gift-voucher'])->get()->row_array();
			}
			$data['voucher_email'] = $voucher_email;
			
			//Appointment Confirmed
			$confirm_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'appointment-confirmed'])->get()->row_array();
			if(count((array)$confirm_email)==0){
				$confirm_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'appointment-confirmed'])->get()->row_array();
			}
			$data['confirm_email'] = $confirm_email;
			
			//Appointment Cancelled
			$cancel_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'appointment-cancelled'])->get()->row_array();
			if(count((array)$cancel_email)==0){
				$cancel_email = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'appointment-cancelled'])->get()->row_array();
			}
			$data['cancel_email'] = $cancel_email;
			
			//thankyou
			$thankyou = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'thankyou'])->get()->row_array();
			if(count((array)$thankyou)==0){
				$thankyou = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'thankyou'])->get()->row_array();
			}
			$data['thankyou'] = $thankyou;
			
			//Booking email for location
			$email_for_location = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'email-for-location'])->get()->row_array();
			if(count((array)$email_for_location)==0){
				$email_for_location = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'email-for-location'])->get()->row_array();
			}
			$data['email_for_location'] = $email_for_location;
			
			
			//pre gst email 
			$email_pre_gst = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'pre-gst'])->get()->row_array();
			if(count((array)$email_pre_gst)==0){
				$email_pre_gst = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'pre-gst'])->get()->row_array();
			}
			$data['email_pre_gst'] = $email_pre_gst;
			
			
			// gst ato email 
			$email_gst_ato = $this->db->select('*')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>'gst_ato'])->get()->row_array();
			if(count((array)$email_gst_ato)==0){
				$email_gst_ato = $this->db->select('*')->from('business_templates')->where(['business_id'=>0,'slug'=>'gst_ato'])->get()->row_array();
			}
			$data['email_gst_ato'] = $email_gst_ato;
			
			
			
			
			if($this->input->post('slug')){
				$slug = $this->input->post('slug');
				$check = $this->db->select('id')->from('business_templates')->where(['business_id'=>$admin_session['business_id'],'slug'=>$slug])->count_all_results();

				//print_r($this->db->last_query()); exit;
				if($check==0){
					$create = array(
					"slug"=>$slug,
					"business_id"=>$admin_session['business_id'],
					"subject"=>$this->input->post('subject'),
					"email_html"=>$this->input->post('email_html'),
					"created_at"=>date("Y-m-d H:i:s"),
					"updated_at"=>date("Y-m-d H:i:s")
					);
					$this->others->insert_data("business_templates",$create);
					}else{
					$update = array(
					"subject"=>$this->input->post('subject'),
					"email_html"=>$this->input->post('email_html'),
					"updated_at"=>date("Y-m-d H:i:s")
					);
					$where=array(
						"business_id"=>$admin_session['business_id'],
						"slug"=>$slug,
					);
					/*$this->db->where(['business_id'=>$admin_session['business_id'],'slug'=>$slug]);
					$this->db->update('business_templates', $update);*/
				$this->others->update_common_value("business_templates",$update,$where);

				}
				$this->session->set_flashdata('success_msg', "Record Saved successfully.");
				return redirect(base_url('admin/service/client_notification'));
				
			}
			
			$this->load->view('admin/service/client_notification',$data);
		}
		
		public function reset($slug){
			$admin_session = $this->session->userdata('admin_logged_in');
			$where=array(
				"slug"=>$slug,
				"business_id"=>$admin_session['business_id']
			);
			
			//$this->db->where(['slug'=>$slug,'business_id'=>$admin_session['business_id']]);
		//	$this->db->delete('business_templates'); 

			$paymentDelete = $this->others->delete_record("business_templates",$where);	

			$this->session->set_flashdata('success_msg', "Record Saved successfully.");
			return redirect(base_url('admin/service/client_notification'));
		}
		
		public function timezone(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$timezone = "";
			if($admin_session['role']=="location_owner" or $admin_session['role']=="staff"){
				$timezone_id = $this->db->select('timezone_id')->from('location')->where('id',$admin_session['location_id'])->get()->row_array();
				$timezone = $timezone_id['timezone_id'];
				}elseif($admin_session['role']=="business_owner"){
				$timezone_id = $this->db->select('time_zone_id')->from('business')->where('id',$admin_session['business_id'])->get()->row_array();
				$timezone = $timezone_id['time_zone_id'];
			}
			if($timezone !=""){
				$tzone= $this->db->select('*')->from('time_zones')->where('id',$timezone)->get()->row_array();
				$t_zone = $tzone['name'];
				}else{
				$t_zone = "Australia/Melbourne";
			}	 	
			date_default_timezone_set($t_zone);
		}
		
		public function free_services(){
			$admin_session = $this->session->userdata('admin_logged_in');
			if(!$admin_session['role']=="business_owner"){
				return redirect(base_url('/admin/dashboard'));
			}
			$data['admin_session'] = $admin_session;
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$newArr = array();
			$options = array();
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where("status",1)->get()->result_array();
			}
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing);
			$data['options'] = $service_timing;
			$check=$this->db->select('*')->from('free_services')->where('business_id',$admin_session['business_id'])->get()->result_array();
			$data['free_services']=$check;
			if($this->input->post('action')){
				//gs($this->input->post());
				$this->db->from('free_services')->where('business_id',$admin_session['business_id'])->delete();
				$number = $this->input->post('number');
				$service = $this->input->post('service');
				$percent = $this->input->post('percent');
				foreach ($number as $key => $value) {
					$insert_array = array(
					"business_id"=>$admin_session['business_id'],
					"number"=>$value,
					"services"=>$service[$key],
					"percent"=>$percent[$key]
					);
					$this->others->insert_data("free_services",$insert_array);
				}				
				$this->session->set_flashdata('success_msg', "Information saved successfully.");
				return redirect(base_url('admin/service/free_services'));
			}
			
			$this->load->view('admin/service/free_services',$data);
		}
		
		
		public function customer_packages($package_id=null){
			
			$admin_session = $this->session->userdata('admin_logged_in');		
			$data['admin_session'] = $admin_session;
			
			$this->db->select('invoices.id AS invoices_id, invoice_package_services.used_invoice_id,invoices.invoice_number AS invoices_invoice_number,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,customer.id AS customer_id,count((array)invoice_package_services.service_id) AS total_service, packages.cost_price AS packages_cost_price, packages.start_date AS packages_start_date, packages.expire_date AS packages_expire_date,packages.id AS packages_id, invoice_package_services.service_id, invoice_package_services.complited_visits,packages.id AS packages_id,package_services.service_timing_id');
			$this->db->from('invoice_package_services');
			$this->db->join('invoices','invoices.id=invoice_package_services.invoice_id','left');
			$this->db->join('packages','packages.id=invoice_package_services.package_id','left');
			$this->db->join('customer','customer.id=invoice_package_services.customer_id','left');
			$this->db->join('package_services','packages.id=package_services.package_id','left');
			$this->db->where('packages.id',$package_id);
			if ($admin_session['business_id']!='') {
				$this->db->where('invoices.business_id',$admin_session['business_id']);
			}
			
			if ($admin_session['role']=='location_owner') {
				$this->db->where('invoices.location_id',$admin_session['location_id']);
			}
			$this->db->group_by('invoice_package_services.customer_id');
			
			$data['get_customber_package']=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit; 
			$this->load->view('admin/service/customer_packages',$data);
		}
		
		public function remove_loyality_programs(){
			$admin_session = $this->session->userdata('admin_logged_in');
			if(!$admin_session['role']=="business_owner"){
				return redirect(base_url('/admin/dashboard'));
			}
			$this->db->from('free_services')->where('business_id',$admin_session['business_id'])->delete();
			$this->session->set_flashdata('success_msg', "All programs has been removed successfully.");
			return redirect(base_url('admin/service/free_services'));
		}
		
		
		public function staff_commission(){
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if(!$admin_session['role']=="business_owner"){
				return redirect(base_url('/admin/dashboard'));
			}
			$data['admin_session'] = $admin_session;
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$newArr = array();
			$options = array();
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where("status",1)->get()->result_array();
			}
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing);
			$data['options'] = $service_timing;
			$check=$this->db->select('*')->from('free_services')->where('business_id',$admin_session['business_id'])->get()->result_array();
			$data['free_services']=$check;
			
			$this->db->select('*');
			$this->db->from('staff');
			$this->db->where('status',1);
			if($admin_session['business_id']!=""){
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=='location_owner'){
				$this->db->where('location_id',$admin_session['location_id']);
			}
			
			
			$data['getstaff']=$this->db->get()->result_array(); 
			
			
			
			if($this->input->post('action')){
				//gs($this->input->post());
				$this->db->from('free_services')->where('business_id',$admin_session['business_id'])->delete();
				$number = $this->input->post('number');
				$service = $this->input->post('service');
				foreach ($number as $key => $value) {
					$insert_array = array(
					"business_id"=>$admin_session['business_id'],
					"number"=>$value,
					"services"=>$service[$key]
					);
					$this->others->insert_data("free_services",$insert_array);
				}				
				$this->session->set_flashdata('success_msg', "Information saved successfully.");
				return redirect(base_url('admin/service/staff_commission'));
			}
			
			$this->load->view('admin/service/staff_commission',$data);
		}
		
		public function add_busy_time($id=null){
			if($id){
				$ev_data = $this->db->select("*")->from("blocked_time")->where('id',$id)->get()->row_array();
				$data['start_time'] = $ev_data['start_time'];
				$data['end_time'] = $ev_data['end_time'];
				$data['staff_id'] = $ev_data['staff_id'];
				$data['location_id'] = $ev_data['location_id'];
				$data['date'] = $ev_data['date'];
				$data['description'] = $ev_data['description'];
				$location_id = $ev_data['location_id'];
				}else{
				$start_time = $this->input->post('start');
				$end_time = $this->input->post('end');
				$staff_id = $this->input->post('staff_id');
				$location_id = $this->input->post('location_id');
				$date = $this->input->post('date');
				$data['start_time'] = $start_time;
				$data['end_time'] = $end_time;
				$data['staff_id'] = $staff_id;
				$data['location_id'] = $location_id;
				$data['date'] = $date;
				$data['description'] = "";
			}
			$data['id']=$id;
			$staffs = $this->db->select("*")->from("staff")->where(["location_id"=>$location_id,"calendor_bookable_staff"=>1])->get()->result_array();
			$data['staffs'] = $staffs;
			$load_view = $this->load->view('admin/service/add_busy_time',$data,true);
			$return['html'] = $load_view;
			echo json_encode($return);
		}
		
		public function save_busy_time(){
			$input_data = $this->input->post();
			if($input_data['id']==""){
				$this->others->insert_data("blocked_time",$input_data);
				}else{
				$id = $input_data['id'];
				unset($input_data['id']);
				$this->others->update_common_value("blocked_time",$input_data,"id='".$id."'");
			}
		}
		
		public function delete_busy_time($id){
			$this->db->from("blocked_time")->where("id",$id)->delete();
		}
		
		
		public function twilio_accounts($business_id=null){
			$data['business_id']=$business_id;
			//$this->db->from("blocked_time")->where("id",$id)->delete();
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			/*if($admin_session['role']!="owner"){
				$this->session->set_flashdata('error_msg', "only owner access !");
				return redirect(base_url('/admin/dashboard'));
			}*/
			
			if ($this->input->post('action')) {
				$data=$this->input->post();
				$this->load->library('form_validation');
				$this->form_validation->set_rules('sub_account_name', 'Sub Account Name', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules('account_sid', 'Account SID', 'trim|required|xss_clean');
				$this->form_validation->set_rules('auth_token', 'Auth Token', 'trim|required|xss_clean');
				$this->form_validation->set_rules('mobile_number', 'Auth Token', 'trim|required|xss_clean');
				if ($this->form_validation->run() == TRUE) 
				{
					
					//echo $data['id']; exit;
					if ($data['id']>0) {
						$insert_array = array(
						"business_id"=>$business_id,
						"sub_account_name"=>$data['sub_account_name'],
						"account_sid"=>$data['account_sid'],
						"auth_token"=>$data['auth_token'],
						"mobile_number"=>$data['mobile_number'],
						);
						
						/*$this->db->where('id', $data['id']);
						$query = $this->db->update('twilio_sms_accounts_setting', $insert_array);*/
						$this->others->update_common_value("twilio_sms_accounts_setting",$insert_array,"id='".$data['id']."' ");


						$this->session->set_flashdata('success_msg', "Twilio Accounts updated successfully!!");
						redirect(base_url('admin/service/twilio_accounts/'.$business_id));
						
					}
					$insert_array = array(
					"business_id"=>$business_id,
					"sub_account_name"=>$data['sub_account_name'],
					"account_sid"=>$data['account_sid'],
					"auth_token"=>$data['auth_token'],
					"mobile_number"=>$data['mobile_number'],
					);
					$this->others->insert_data("twilio_sms_accounts_setting",$insert_array);
					$this->session->set_flashdata('success_msg', "Twilio Accounts saved successfully!!");
					redirect(base_url('admin/service/twilio_accounts/'.$business_id));
					
				}	
				
				
			}
			$this->db->select('*');
			$this->db->from('twilio_sms_accounts_setting');
			if (isset($business_id)) {
				$this->db->where('business_id',$business_id);
			}			
			$this->db->where('status',1);
			$data['twilio_accounts']=$this->db->get()->row_array();
			$this->db->select('*');
			$this->db->from('business');
			$this->db->where('status',1);
			$data['all_business']=$this->db->get()->result_array();
			$data['setup_active_open']=true;
			$this->load->view('admin/service/twilio_accounts',$data);
			
		}
		
		public function getIp(){
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		    {
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}
		    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		    {
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		    else
		    {
				$ip=$_SERVER['REMOTE_ADDR'];
			}
		    echo $ip;
		} 
		
		
		public function calendar_rebook($booking_id){
			$admin_session = $this->session->userdata('admin_logged_in');
			$services = array();
			$service_timing = array();
			$service_ids = array();
			$options = array();
			$newArr = array();
			
			$services = $this->db->select(['id','service_category_id'])->from('services')->where(['business_id'=>$admin_session['business_id'],'service_class_type'=>1])->get()->result_array();
			foreach ($services as $key => $value) {
				$service_ids[] = $value['id'];
			}
			if($service_ids){
				$service_timing = $this->db->select(['id','caption','service_id','special_price'])->from('service_timing')->where_in('service_id',$service_ids)->where("status",1)->get()->result_array();
			}	
			$options = array();
			if($service_timing){
				foreach ($service_timing as $key => $value) {
					$sdata = $this->db->select('*')->from('services')->where('id',$value['service_id'])->get()->row_array();
					$service_timing[$key]['sku'] = $sdata['sku'];
					$service_timing[$key]['caption_id'] = $value['id'];
					$service_timing[$key]['service_name'] = $sdata['service_name'];
				}
			}
			//gs($service_timing);
			$data['options'] = $service_timing;		
			$data['booking'] = $booking = $this->db->select('*')->from('bookings')->where('id',$booking_id)->get()->row_array();
			$data['booking_services'] = $this->db->select('*')->from('booking_services')->where('booking_id',$booking_id)->order_by('id','asc')->get()->result_array();
			$booking_services = array();
			if(!empty($data['booking_services'])){
				foreach($data['booking_services'] as $booking_service_val){
					if(empty($booking_service_val['service_timing_id'])){
						$booking_service_val['service_timing_id'] = $booking_service_val['service_id'];
					}
					$booking_services[] = $booking_service_val;
				}
			}
			$data['booking_services'] = $booking_services;
			if($booking['customer_id'] !=""){
				$id = $booking['customer_id'];
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
			}
			$location_id = $data['booking']['location_id'] = isset($_GET['location_id'])?$_GET['location_id']:$booking['location_id'];
			$start_date = $data['booking']['start_date'] = isset($_GET['startDate'])?$_GET['startDate']:$booking['start_date'];
			$data['booking']['staff_id'] = isset($_GET['staffid'])?$_GET['staffid']:$booking['staff_id'];
			$data['booking']['start_time'] = isset($_GET['startTime'])?$_GET['startTime']:$booking['start_time'];
			$end = isset($_GET['startDate'])?$_GET['startDate']:$booking['start_date'];
 			$week_day = getWeekDay($start_date);
			if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){
				
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
				
				//print_r($staffs); exit;
				/*$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'calendor_bookable_staff'=>1])->get()->result_array();*/
				
				
				}else{
				$staffs = $this->db->select('*')->from('staff')->where(['status'=>1,'business_id'=>$admin_session['business_id'],'location_id'=>$location_id,'id'=>$staff_id])->get()->result_array();
			}
			//print_r($staffs); exit;
			$data['staff'] = $staffs;
			if($this->input->post('action')){
				//gs($this->input->post());
				$customer_id = ($this->input->post('customer_id'))?$this->input->post('customer_id'):null;
				$location_id = $this->input->post('location_id');
				$description = $this->input->post('description');
				$date = date("Y-m-d",strtotime($this->input->post('date')));
				$start_time = $this->input->post('start_time');
				$service = $this->input->post('service');
				$duration = $this->input->post('duration');
				$staff = $this->input->post('staff');
				$calendar_staff = $this->input->post('calendar_staff');
				$group_service_id = $this->input->post('group_service_id');
				$service=preg_replace('/[^0-9]/', '', $service);
				//gs($this->input->post());
				// insert data into bookings table
				$mail_confirmaion=$this->db->select('*')->from('email_confirmation_time')->where('business_id',$admin_session['business_id'])->get()->row_array();
				//print_r($mail_confirmaion['today_sms']); exit;
				
				if ($mail_confirmaion['today_sms']==0 && $date ==date('Y-m-d')) {
					$is_confirmation_sent=1;
					}else{
					$is_confirmation_sent=0;
				}
				
				$appointment_booking_number=rand(10000000,99999999);
				$insert_array = [
				'booking_number'=>$appointment_booking_number,
				'customer_id'=>$customer_id,
				'business_id'=>$admin_session['business_id'],
				'location_id'=>$location_id,
				'staff_notes'=>$description,
				'start_date'=>$date,
				'staff_id'=>$calendar_staff,
				'start_time'=>$start_time[0],
				'booking_status'=>6,
				'is_confirmation_sent'=>$is_confirmation_sent,
				'date_created'=>date("Y-m-d H:i:s")
				
				]; 
				//$update = $this->others->update_common_value("bookings",$update_array,"id='".$booking_id."' ");
				//$this->others->insert_data("bookings",$insert_array);
				$insert = $this->others->insert_data("bookings",$insert_array);
				$booking_id= $insert;
				if($insert){
					//Delete old records
					//$this->db->delete('booking_services', array('booking_id' => $booking_id));
					// Insert data into booking_services
					foreach ($service as $key => $value) {
						$insert_array = [
						'booking_id'=>$booking_id,
						'group_service_id'=>isset($group_service_id[$service[$key]])?$group_service_id[$service[$key]]:0,
						'service_id'=>getmainServiceId($service[$key]),
						'service_timing_id'=>$service[$key],
						'staff_id'=>$staff[$key],
						'book_start_time'=>$start_time[$key],
						'book_duration'=>date('H:i:00', mktime(0,$duration[$key])),
						'book_end_time'=>sum_the_time($start_time[$key],date('H:i:00', mktime(0,$duration[$key]))),
						'date'=>$date
						];
						$this->others->insert_data("booking_services",$insert_array);
					}
				}
				if($description !=null){
					$insert_array = [
					'customer_id'=>$customer_id,
					'notes'=>$description,				
					'date_created'=>date("Y-m-d H:i:s"),
					];
					$insert = $this->others->insert_data("customer_notes",$insert_array);
				}
				
				
				
				$date = date("Y/m/d",strtotime($this->input->post('date')));
				redirect(base_url('admin/service/calendar?startDate='.$date.'&startTime='.$start_time[0].'&staffid='.$calendar_staff.'&location_id='.$location_id.''));
				
				//redirect(base_url('admin/service/calendar'));
			}
			
			//print_r($data); exit;
			$this->load->view('admin/calendar/calendar_rebook',$data);
		}
		
		
		
	}		