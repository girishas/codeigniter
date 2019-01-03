<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Voucher extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('voucher_model', '', TRUE);
			
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
					$this->others->delete_record("vouchers","id='".$item."' ".$condition);
					$count_records ++;
				}
				if($count_records>0){
					$this->session->set_flashdata('success_msg', "Voucher has been deleted successfully!");
					}else{
					$this->session->set_flashdata('error_msg', "No voucher are selected to delete!");
				}	
				redirect(base_url('admin/voucher'));			
			}
			
			if ($this->input->post('action') && $this->input->post('type')=="voucher") {
				
				$voucher_category_id= $this->input->post('id');			
				$voucher_code= $this->input->post('voucher_code');
				$vouchar_name= $this->input->post('vouchar_name');
				$vouchar_amount= $this->input->post('unit_price');
				$available_amount= $this->input->post('unit_price');
				$description= $this->input->post('description');
				$vourchar_terms= $this->input->post('vourchar_terms');
				$business_id= $this->input->post('business_id');
				$location_id= $this->input->post('location_id');
				$voucher_satus= $this->input->post('voucher_satus');
				if (empty($location_id)) {
					$locations=getLocationsForStaff($business_id);
					$location_id=$locations[0]["id"];
				}
				
                $FILE = $_FILES['stmfile']; 
				$file = fopen($FILE['tmp_name'], 'r');
				$i=0;
				$voucher_error='';
				while (($line = fgetcsv($file)) !== FALSE) {
					if($i>0)
					{

						$customber_number=$line[0];
						$voucher_code=$line[1];
						if ($line[2]!='') {
							$voucher_exp_a = explode('-',$line[2]);
						$voucher_expiry = $voucher_exp_a[2].'-'.$voucher_exp_a[1].'-'.$voucher_exp_a[0];

						$voucher_expiry=date("Y-m-d", strtotime($voucher_expiry) );
						}
						else{
							$voucher_expiry=$line[2];
						}
						
							$message = $line[3];
							
							$customer_id=getcustomerIdByCustomerNumber($customber_number);
							if ($customer_id<1) {
						$voucher_error.="Please verify below customer Numbers :- ".$customber_number." Voucher Code :- ".$voucher_code."<br/> ";
						
							}
							else{
								$insert_data = array(
								"voucher_category_id"=>$voucher_category_id,
								"business_id"=>$business_id,
								"location_id"=>$location_id,
								"customer_id"=>$customer_id,								
								"voucher_code"=>$voucher_code,
								"vouchar_name"=>$vouchar_name,
								"voucher_amount"=>$vouchar_amount,
								"available_amount"=>$available_amount,
								"expiry_date"=>$voucher_expiry,
								"description"=>$message,
								"vourchar_terms"=>$vourchar_terms,
								"status"=>5,	
								'date_created'  => date('Y-m-d H:i:s'),	);
							$this->others->insert_data("vouchers",$insert_data);
							$last_voucher_count=$this->db->from('voucher_category')->where('id',$voucher_category_id)->get()->row_array();

							$voucher_count=$last_voucher_count['voucher_count']+1;

							$update_array= array(
								"voucher_count"=>$voucher_count,
							);
							 $this->db->where('id', $voucher_category_id);
    					$query = $this->db->update('voucher_category', $update_array);

							}

							
	                }
					$i++;
				}
				fclose($file);				
				//echo $voucher_error; exit;
				if (!empty($voucher_error)) {
					$this->session->set_flashdata('error_msg', $voucher_error);
				redirect(base_url('admin/voucher'));
				}
				$this->session->set_flashdata('success_msg', "Vouchers imported successfully!");
				redirect(base_url('admin/voucher'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/voucher') .'?'.$get_string;
			
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
				$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_vouchers = $this->voucher_model->get_vouchers(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
			if($all_vouchers){
				$data['all_vouchers']= $all_vouchers;
				$count_all_records = $this->voucher_model->get_vouchers(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			
			$last_vouchers=$this->db->select('*')->order_by('id',"desc")->limit(1)->get('vouchers')->row();
			
			$voucher_setting =$this->db->select('*')->order_by('id',"desc")->limit(1)->get('voucher_setting')->row();
			$data['voucher_setting']=$voucher_setting;
			$data['last_vouchers']=$last_vouchers;		
			$data['voucher_business_id']= $admin_session['business_id'];
			//echo $data['voucher_business_id']; exit;
			
			$data['admin_session']=$admin_session;
			$data['voucher_active_open']=true;
			//echo "<pre>"; print_r($data); die;
			$this->load->view('admin/voucher/all_voucher', $data);
		}
		
		public function add_voucher()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				/*$this->form_validation->set_rules('voucher_code', 'voucher_code', 'trim|required|xss_clean');*/
				$this->form_validation->set_rules('vouchar_name', 'vouchar_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('voucher_amount', 'voucher_amount', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description','shortcodes', 'trim|required|xss_clean');
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				$data['vouchar_name'] 	= $vouchar_name = $this->input->post('vouchar_name');
				$data['voucher_amount'] = $voucher_amount = $this->input->post('voucher_amount');
				$data['description'] 	= $description 	= $this->input->post('description');
				$data['vourchar_terms'] = $vourchar_terms = $this->input->post('vourchar_terms');
				$data['status'] = $status = $this->input->post('status');
				
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					$inserData 	= array(
					'business_id'	=> $business_id,
					'vouchar_name' 	=> $vouchar_name,
					'voucher_amount'=> $voucher_amount,
					'description' 	=> $description,
					'vourchar_terms'=> $vourchar_terms,
					'status'        => $status,
					'date_created'  => date('Y-m-d H:i:s'),
					);
					
					$return = $this->others->insert_data("voucher_category",$inserData);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Voucher added successfully!");
						redirect(base_url('admin/voucher'));
					}
				}
			}
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			$data['voucher_active_open']=true;
			$this->load->view('admin/voucher/add_voucher', $data);
		}
		
		public function edit_voucher($id='')
		{
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('action'))
			{
				
				$this->load->library('form_validation');
				
				if($admin_session['role'] == 'owner') { 
					$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
				}
				
				
				$this->form_validation->set_rules('vouchar_name', 'vouchar_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('voucher_amount', 'voucher_amount', 'trim|required|xss_clean');
				$this->form_validation->set_rules('description','shortcodes', 'trim|required|xss_clean');
				
				if($admin_session['role'] == 'owner') { 
					$data['business_id'] = $business_id = $this->input->post('business_id');
					}else{
					$data['business_id'] = $business_id = $admin_session['business_id'];
				}
				
				
				$data['vouchar_name'] 	= $vouchar_name = $this->input->post('vouchar_name');
				$data['voucher_amount'] = $voucher_amount = $this->input->post('voucher_amount');		
				$data['description'] 	= $description 	= $this->input->post('description');
				$data['vourchar_terms'] = $vourchar_terms = $this->input->post('vourchar_terms');		
				$data['status'] 		= $status 		= $this->input->post('status');
				
				
				if ($this->form_validation->run() == TRUE) 
				{
					
					
					$updateData 	= array(
					'business_id'	=> $business_id,					
					'vouchar_name' 	=> $vouchar_name,
					'voucher_amount'=> $voucher_amount,
					'description' 	=> $description,
					'vourchar_terms'=> $vourchar_terms,					
					'status' 		=> $status,
					'date_updated'  => date('Y-m-d H:i:s'),
					);
					
					$where = array('id' => $id);
					$return = $this->others->update_common_value("voucher_category",$updateData,$where);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Voucher updated successfully!");
						redirect(base_url('admin/voucher'));
					}
				}
			}
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			// get template details
			if(!empty($id)){
				$template_details = $this->others->get_all_table_value("voucher_category","*","id='".$id."'");
				$data['template_details'] = $template_details;
			}
			//print_r($data['template_details']);die;
			
			
			$data['voucher_active_open']=true;
			$this->load->view('admin/voucher/edit_voucher', $data);
		}
		
		
		
		public function view_voucher($id='')
		{
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
				$data['all_business'] = $all_business;
			}
			
			// get template details
			if(!empty($id)){
				$template_details = $this->others->get_all_table_value("voucher_category","*","id='".$id."'");
				$data['template_details'] = $template_details;
			}
			$data['voucher_active_open']=true;
			$this->load->view('admin/voucher/view_voucher', $data);
		}
		
		public function voucher_setting()
		{
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			// get all business
			if($this->input->post('action'))
			{
				$status=$this->input->post('status');
				$id=$this->input->post('id');
				
				$updateData 	= array(									
				'status' 		=> $status,
				'date_updated'  => date('Y-m-d H:i:s'),
				);
				$where = array('id' => $id);
				$return = $this->others->update_common_value("voucher_setting",$updateData,$where);
				$this->session->set_flashdata('success_msg', "Voucher setting updated successfully!");
				
			}
			if(!empty($id)){
				$this->db->select('*')
				->from('voucher_setting')
				->where('id',$id);
				$status = $this->db->get()->row_array();	
			}
			else{
				$this->db->select('*')
				->from('voucher_setting');
				$status = $this->db->get()->row_array();				
			}
			$data['setting'] = $status;
			$data['setup_active_open']=true;
			
			$this->load->view('admin/voucher/voucher_setting', $data);
		}
		
		public function voucher_customer($id='')
		{
			//echo $id; exit;
			if($this->input->post('search_filter')){
				$id=$this->input->post('voucher_id');
			}
			
			
			$admin_session = $this->session->userdata('admin_logged_in');		
			if(!empty($id)){
				/*$this->db->select('invoices.total_price,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,vouchers.voucher_code,invoices.invoice_number,voucher_category.vouchar_name,vouchers.status AS vouchers_status,vouchers.available_amount AS vouchers_available_amount, vouchers.voucher_amount AS vouchers_voucher_amount')
				->from('invoice_services')
				->join('customer','customer.id=invoice_services.customer_id','inner')
				->join('vouchers','vouchers.id=invoice_services.voucher_id','inner')
				->join('voucher_category','voucher_category.id=vouchers.voucher_category_id','inner')
				->join('invoices','invoices.id=invoice_services.invoice_id','inner')
				
				->where('voucher_category.id',$id)
				->where('invoice_services.pay_service_type',5);
				$invoice_voucher_customer = $this->db->get()->result_array();


				$this->db->select('vouchers.*,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,vouchers.voucher_code,voucher_category.vouchar_name,vouchers.status AS vouchers_status,vouchers.available_amount AS vouchers_available_amount, vouchers.voucher_amount AS vouchers_voucher_amount')
				->from('vouchers')
				->join('customer','customer.id=vouchers.customer_id','inner')			
				->join('voucher_category','voucher_category.id=vouchers.voucher_category_id','inner')
				->where('voucher_category.id',$id);
				$voucher_customer = $this->db->get()->result_array();

				$get_all_voucher_customer=array_merge($invoice_voucher_customer,$voucher_customer);*/


				//print_r($this->db->last_query()); exit;

				$get_all_voucher_customer=$this->db->select('*')->from('vouchers')->where('voucher_category_id',$id)->get()->result_array();
				//print_r($this->db->last_query()); exit;

			}
			//print_r($get_all_voucher_customer); exit;
			$this->db->select('*');
			$this->db->from('voucher_category');
			
			if ($admin_session['business_id']!='') {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			
			$get_all_voucher=$this->db->get()->result_array();
			
			$this->db->select('*');
			$this->db->from('voucher_category');
			$this->db->where('id',$id);
			$get_voucher=$this->db->get()->row();
			$data['vouchers_list']=$get_all_voucher;
			$data['all_vouchers']=$get_all_voucher_customer;
			$data['get_voucher']=$get_voucher;
			//echo"<pre>"; print_r($get_all_voucher_customer); exit;
			$data['voucher_active_open']=true;
			$this->load->view('admin/voucher/voucher_customer', $data);
		}
		
		public function terms(){ 
		
			$admin_session = $this->session->userdata('admin_logged_in');
			if(!$admin_session['role']=="business_owner"){
				return redirect(base_url('admin/dashboard'));
			}
			if($this->input->post('action')){
				$this->db->from('voucher_terms')->where('business_id',$admin_session['business_id'])->delete();
				$terms = $this->input->post('voucher_terms');
				if(count((array)$terms)>0){
					foreach ($terms as $key => $value) {
						$inserData 	= array(
						'business_id'	=> $admin_session['business_id'],
						'detail' =>$value
						);
						$return = $this->others->insert_data("voucher_terms",$inserData);
					}
				}
				
				$status=$this->input->post('status');
				$id=$this->input->post('id');
				
				$updateData 	= array(									
				'status' 		=> $status,
				'date_updated'  => date('Y-m-d H:i:s'),
				);
				$where = array('id' => $id);
				$return = $this->others->update_common_value("voucher_setting",$updateData,$where);
				
				$this->session->set_flashdata('success_msg', "Voucher terms & settings saved successfully!");
				return redirect(base_url('admin/voucher/terms'));
			}
			$terms = $this->db->select('*')->from('voucher_terms')->where('business_id',$admin_session['business_id'])->get()->result_array();
			$data['setup_active_open']=true;
			$data['terms'] = $terms;
			if(!empty($id)){
				$this->db->select('*')
				->from('voucher_setting')
				->where('id',$id);
				$status = $this->db->get()->row_array();	
			}
			else{
				$this->db->select('*')
				->from('voucher_setting');
				$status = $this->db->get()->row_array();				
			}
			$data['setting'] = $status;
			//$data['setup_active_open']=true;
			$this->load->view('admin/voucher/terms', $data);
		}
		
		
		
	}
