<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('user_model', '', TRUE);
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
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff" ){
				$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				//$this->others->delete_record("customer","id='".$item."' ".$condition);
				$this->others->update_common_value("customer",array("status"=>'2'),"id='".$item."' ");
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Customer has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No records are selected to delete!");
			}	
			redirect(base_url('admin/customer'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/customer/index') .'?'.$get_string;
		
		if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['s.business_id']= $business_id;
        } else {
             $business_id = '';
        }
		$data['business_id']= $business_id;
		
		if($this->input->get('offset')) {
            $config['offset'] = $this->input->get('offset');
        } else {
            $config['offset'] = '';
        }
		
		if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        } else {
            $per_page = '';
        }
		$config['per_page'] = $per_page;
		$data['per_page']= $per_page;


		if($this->input->post('customer_search')){

			$customer_name = $this->input->post('customer_search');
			$this->session->set_userdata(['customer_search'=>$customer_name]);
			$customer_name = rtrim($customer_name,"1");
			$data['customer_search']=$this->input->post('customer_search');
	
		}else{

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			if($page != 0 ){
				$customer_name = $this->session->userdata('customer_search');
			$data['customer_search']=$this->session->userdata('customer_search');
		}else{
			$customer_name = null;
			$data['customer_search']=null;
		}

			
			
			

			
		}	

		$record_num = $this->uri->segment_array();
		$last_segment=$record_num[count((array)$record_num)];

		
		//echo $this->uri->segment(4);	

		//exit;
		
		/*if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="business_owner")){
			$arr_search['business_id'] = $admin_session['business_id'];
		}*/
 		//$per_page = 10;	
	/*	$all_records = $this->user_model->get_customer(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->user_model->get_customer(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
*/

		/*$this->db->select('*');
		$this->db->from('customer');
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$this->db->where('business_id',$admin_session['business_id']);		
		}
		if($admin_session['role']=="location_owner"){
			$this->db->where('location_id',$admin_session['location_id']);
		}

		$data['all_records']=$this->db->get()->result_array();*/




		$config = array();
 
        /*$config["base_url"] = base_url() . "admin/customer/index";
 
        $config["total_rows"] = $this->user_model->get_customer(true,$arr_search);
 
        $config["per_page"] = 10;
 
      
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
	    $config['last_link'] = FALSE;*/
	    //print_r($admin_session); exit;
	    if ($admin_session['role']=='owner' || $admin_session['role']=='business_owner') {
	    	
	    	$where=array(
	    		"business_id"=>$admin_session['business_id'],
	    	);
	    }

	    if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff' ) {
	    	$where=array(
	    	"business_id"=>$admin_session['business_id'],
	    	"location_id"=>$admin_session['location_id'],
	    	);
	    }

	    $count = $this->user_model->getrecordCount($customer_name,$where);
	   // print_r($this->db->last_query()); exit;
	    $data['count'] = $count;

	   // gs($count);



	    $config["base_url"] = base_url() . "admin/customer/index";
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

       if($customer_name){

       	 $page =$page;
       }
       if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"  )){
			$arr_search['business_id'] = $admin_session['business_id'];
		}

		if($admin_session['business_id'] !="" and ($admin_session['role']=="location_owner"  || $admin_session['role']=="staff")){
			$arr_search['business_id'] = $admin_session['business_id'];
			//$arr_search['location_id'] = $admin_session['location_id'];
		}


       $data["all_records"] = $this->user_model->get_customer(false,$arr_search,$config["per_page"],$page,"date_created","DESC",$customer_name);

      // print_r($this->db->last_query()); exit;

       $data["links"] = $this->pagination->create_links();


		$data['customer_active_open']=true;
		$this->load->view('admin/customer/all_customers', $data);
	}

	
	public function marge_customers_id(){

		$ids = $this->input->post('abc');
		$ids = implode(',', $ids);
		echo $ids;
	
	}

	public function merge_customers(){
		
		$data = array();
		//print_r($_POST); exit;
		
		if($this->input->post('m_id')){
			$ids = $this->input->post('m_id');
			$ids = explode(",",$ids);
			//print_r($ids);echo "<br>";
			//print_r(array_map('trim',$ids));die;
			$ids = preg_replace('/\s+/','',$ids);
			//$ids = str_replace(' ','',$ids);
			//$ids=trim($ids);
			//print_r($ids); exit;
			$this->db->where_in('id',$ids);
			$result = $this->db->get('customer');
			$data['all_records'] = $result->result_array();
			//print_r($this->db->last_query()); exit;
			//echo "<pre>";
			//print_r($data['all_records']); exit;
			//echo "inn-";die;
		}
		
		if($this->input->post('merge_customer'))
		{
			if($this->input->post('record') && $this->input->post('radio')){
				$all_id = $this->input->post('record');
				$single_id = $this->input->post('radio');
				//print_r($all_id);
				//echo "hi ";
				// print_r($single_id); exit;
				
				// find all customer id 
				$this->db->where_in('id',$all_id);
				$result = $this->db->get('customer');
				$update_id = $result->result_array();	
				

				// update invoice table with selected id
				foreach ($update_id as $key => $value) {
					$ad[]= $value['id'];
					
				}

				/*$this->db->set('customer_id', $single_id);
				$this->db->where_in('customer_id',$ad);
				$this->db->update('invoices');*/
				$update_data=array(
					"customer_id"=>$single_id,
				);
				$success =$this->others->update_common_value("invoices",$update_data,"","customer_id",$ad);


				$this->others->update_common_value("invoice_services",$update_data,"","customer_id",$ad);

			/*	$this->db->set('customer_id', $single_id);
				$this->db->where_in('customer_id',$ad);
				$this->db->update('invoice_services');*/

				/*$this->db->set('customer_id', $single_id);
				$this->db->where_in('customer_id',$ad);
				$this->db->update('invoice_payments');*/
					$this->others->update_common_value("invoice_payments",$update_data,"","customer_id",$ad);

			/*	$this->db->set('customer_id', $single_id);
				$this->db->where_in('customer_id',$ad);
				$this->db->update('bookings');*/

				$this->others->update_common_value("bookings",$update_data,"","customer_id",$ad);

				/*$this->db->set('customer_id', $single_id);
				$this->db->where_in('customer_id',$ad);
				$this->db->update('customer_notes');*/

				$this->others->update_common_value("customer_notes",$update_data,"","customer_id",$ad);				
				
				//print_r($ad);
				//echo "<br>";

				// remove records from customer
				$search_index = array_search($single_id,$ad);
				unset($ad[$search_index]);
				if(!empty($ad)){
					/*$this->db->where_in('id',$ad);
					$return = $this->db->delete('customer');*/

					$return=$this->others->delete_record("customer","","id",$ad);


					if($return == true){
						$this->session->set_flashdata('success_msg', "Records merge successfully!");
						redirect(base_url('admin/customer'));	
					}
				}
				else
				{
					$this->session->set_flashdata('error_msg', "No Records to merge!");
					redirect(base_url('admin/customer'));
				}
			}
			
			
		}
		if(count((array)$data)>0){
			$this->load->view('admin/customer/marge_customers',$data);	
		}else{
			$this->session->set_flashdata('error_msg', "Please select at least two customers!");
					redirect(base_url('admin/customer'));
		}
	}

	public function view_customer($id=null){
		$admin_session = $this->session->userdata('admin_logged_in');
		if ($id != '' && is_numeric($id)) {	
			$query = $this->db->get_where('customer', array('id' => $id));
			$data = $query->row();
			if($data)
			{
				$this->load->view('admin/customer/view_customer',compact('data'));
			}else{
				$this->session->set_flashdata('error_msg', "No records found!");
				redirect(base_url('admin/customer'));		
			}
			
		}else{
			$this->session->set_flashdata('error_msg', "No records found!");
			redirect(base_url('admin/customer'));			
		}
	}
	
	public function detail($customer_id=null)
	{

		//print_r($this->config->item("base_url")); exit;
		//print_r($_POST); exit;
		if($this->input->post('action')){
			$notes=$this->input->post('notes');
			$insert_array = [
				'customer_id'=>$customer_id,
				'notes'=>$notes,				
				'date_created'=>date("Y-m-d H:i:s"),
			];
			$insert = $this->others->insert_data("customer_notes",$insert_array);

			$this->session->set_flashdata('success_msg', "Notes is added successfully!");
					redirect(base_url('admin/customer/detail/'.$customer_id));
					//redirect(base_url('admin/customer/'));
		}
		$data['customer_id'] = $customer_id;
		if ($customer_id) {
			$customer_detail = $this->others->get_all_table_value("customer","*","id='".$customer_id."' ");
			if($customer_detail){
				$data['customer_detail'] = $customer_detail;
			}
		}elseif($_GET['customer_id'])
		{	
			$customer_id = $this->input->get('customer_id');
			$customer_detail = $this->others->get_all_table_value("customer","*","id='".$customer_id."' ");
			if($customer_detail){
				$data['customer_detail'] = $customer_detail;
			}
		}
		if($this->input->get('customer_search')){
			$customer_name = $this->input->get('customer_search');
			$customer_name = explode(" ",$customer_name);
			$search_first_name = trim($customer_name[0]);
			$search_last_name = trim($customer_name[1]);
			$name_search_condition="";
			if(!empty($search_first_name))
				$name_search_condition .="first_name ='".$search_first_name."' ";
			if(!empty($search_last_name)){
				if(empty($name_search_condition))
					$name_search_condition .=" last_name ='".$search_first_name."' ";
				else
					$name_search_condition .=" AND last_name ='".$search_last_name."' ";
			}
			$customer_detail = $this->others->get_all_table_value("customer","*",$name_search_condition);
			if($customer_detail){
				redirect(base_url('admin/customer/detail?customer_id='.$customer_detail[0]['id']));
			}		

		}

		// Appointment part
		 $this->db->select('staff.first_name AS staff_first_name,staff.last_name AS staff_last_name,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,booking_services.book_start_time,booking_services.book_duration,bookings.date_created,bookings.start_date,bookings.booking_number,bookings.id,service_timing.caption,invoices.invoice_number,invoices.id AS invoices_id');		
		$this->db->from('bookings');
		$this->db->join('booking_services','bookings.id=booking_services.booking_id','inner');
		$this->db->join('staff','staff.id=booking_services.staff_id','inner');
		$this->db->join('customer','customer.id=bookings.customer_id','inner');
		$this->db->join('service_timing','service_timing.id=booking_services.service_id','inner');
		$this->db->join('invoices','bookings.id=invoices.booking_id','left');
		$this->db->where('customer.id',$customer_id);
		$this->db->group_by('booking_services.booking_id');
		$this->db->order_by('booking_services.id','desc');
       $data['appintments'] = $this->db->get()->result();
      //End
       // invoices part
        $data['invoices'] = $this->db->select('*')->from('invoices')
       ->where('customer_id',$customer_id)
       ->order_by('id','desc')->get()->result_array();
       //End

       // invoices part
        $data['products'] = $this->db->select('invoices.*,product.product_name')->from('invoices')
        ->join('invoice_services','invoices.id=invoice_services.invoice_id','inner')
        ->join('product','product.id=invoice_services.product_id','inner')
       ->where('invoices.customer_id',$customer_id)
       ->where('invoice_services.pay_service_type',4)
       ->order_by('invoice_services.id','desc')->get()->result_array();


       /*Wallet payment History*/
       $data['wallet'] = $this->db->select('invoices.id,invoices.invoice_number,customer_wallet_history.created_date,customer_wallet_history.wallet_amount')->from('invoices')
       ->join('customer_wallet_history','customer_wallet_history.customer_id=invoices.customer_id AND customer_wallet_history.invoice_id=invoices.id ')       
       ->where('invoices.customer_id',$customer_id)
       ->group_by('customer_wallet_history.id')
       ->order_by('customer_wallet_history.id','desc')->get()->result_array();

       //End
       	//total sale
          $data['total_sale'] = $this->db->select('IFNULL(sum(total_price),0) as total_amount')->from('invoices')
       ->where('customer_id',$customer_id)
      ->get()->row_array();
      //print_r($data['total_sale']); exit;
       //End

      //total outstanding      
          $data['outstanding'] = $this->db->select('IFNULL(sum(total_price),0) as total_amount')->from('invoices')
       ->where('customer_id',$customer_id)
       ->where('invoice_status',4)
      ->get()->row_array();
       //End

      //total bookings      
          $data['count_all_booking'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
       ->where('customer_id',$customer_id)
      ->get()->row_array();
      //print_r($data['count_all_booking']); exit;
       //End

      //total cancelled      
          $data['count_all_cancelled'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
       ->where('customer_id',$customer_id)
       ->where('booking_status',2)
      ->get()->row_array();
       //End

       //total completed      
          $data['count_all_completed'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
       ->where('customer_id',$customer_id)
       ->where('booking_status',3)
      ->get()->row_array();
       //End

       //total no show      
          $data['count_all_no_show'] = $this->db->select('IFNULL(count(*),0) as total_booking')->from('bookings')
       ->where('customer_id',$customer_id)
       ->where('booking_status',4)
      ->get()->row_array();
       //End


       //customber by all notes show     
          $data['customer_notes'] = $this->db->select('*')->from('customer_notes')
       ->where('customer_id',$customer_id)
      ->get()->result_array();
       //End

      

      

		$data['customer_active_open']=true;
		$this->load->view('admin/customer/detail', $data);
	}
	
	public function add_customer()
	{
		//print_r($_POST); exit;
		$admin_session = $this->session->userdata('admin_logged_in');
		$this->session->unset_userdata('customer_search');
		//echo "<pre>";print_r($admin_session); echo "</pre>"; die;
		if($this->input->post('action')){
			$day = $this->input->post('day');
			$month = $this->input->post('month');
			//$year = '0000';
			$dob= $day.'-'.$month;
			//$dob = date("Y-m-d", strtotime($customer_dob));
			$business_id = $this->input->post('business_id');
			$data['dob'] = $dob;
			$data['country_code'] = $this->input->post('country_code');
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
			$data['postcode'] = $this->input->post('postcode');
			$data['gender'] = $this->input->post('gender');
			$data['occupation'] = $this->input->post('occupation');
			$data['referred_by'] = $this->input->post('referred_by');
			$data['is_vip'] = $this->input->post('is_vip');
			$data['customer_number'] = $this->input->post('customer_number');
			
			$notification = $this->input->post('notification');
			if(count((array)$notification)==2){
				$notification_value = 'both';
			}elseif($notification[0]=="email"){
				$notification_value = 'email';
			}elseif($notification[0]=="sms"){
				$notification_value = 'sms';
			}else{
				$notification_value = '';
			}
			$data['notification'] = $notification_value;
			
			$reminders = $this->input->post('reminders');
			if(count((array)$reminders)==2){
				$reminders_value = 'both';
			}elseif($reminders[0]=="email"){
				$reminders_value = 'email';
			}elseif($reminders[0]=="sms"){
				$reminders_value = 'sms';
			}else{
				$reminders_value = '';
			}
			$data['reminders'] = $reminders_value;
			
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
			//$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('postcode', 'Post Code', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean|min_length[8]');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
			

			//$this->form_validation->set_rules('customer_number', 'Customer Number', 'trim|required|xss_clean|is_unique[customer.customer_number]');
			
			$this->form_validation->set_message('is_unique', 'Customer number is already taken');
			$this->form_validation->set_message('min_length', 'Please enter valid mobile number');


			if ($this->form_validation->run() == TRUE) {
				
				$notification = $this->input->post('notification');
				if(count((array)$notification)==2){
					$notification_value = 'both';
				}elseif($notification[0]=="email"){
					$notification_value = 'email';
				}elseif($notification[0]=="sms"){
					$notification_value = 'sms';
				}else{
					$notification_value = '';
				}
				
				
				$picture = "";
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
					if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
						$this->load->library('image_lib');
						$uploadDir = $this->config->item('physical_url') . 'images/customer/';
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
				
				$b_id = ($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner")?$admin_session['business_id']:$this->input->post('business_id') ; 
				$loc_id = ($admin_session['role']=="location_owner")?$admin_session['location_id']:$this->input->post('location_id') ; 

				//$c_number = $this->input->post('customer_number');
				//$customer_number = $this->check_unique_customer_number($c_number,$c_number,$b_id);
				/*$validate_cus_num = $this->db->where(['customer_number'=>$customer_number,'business_id'=>$b_id])->from("customer")->count_all_results();
				if($validate_cus_num>0){
					$this->session->set_flashdata('error_msg', "Customer Number already exist! Try something different");
					redirect(base_url('admin/customer/add_customer'));
				}*/
						
				$insert_data = array(
					'business_id'=>$b_id,
					'location_id'=>$loc_id,
					'dob'=> $dob,
					//'country_code'=>$this->input->post('country_code'),
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'email'=>$this->input->post('email'),
					'mobile_number'=>str_replace(" ","",$this->input->post('mobile_number')),
					'address1'=>$this->input->post('address1'),
					'address2'=> $this->input->post('address2'),
					'suburb'=>$this->input->post('suburb'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'postcode'=>$this->input->post('postcode'),					
					'gender'=>$this->input->post('gender'),
					'notification'=>$notification_value,
					'reminders'=>$reminders_value,
					'occupation'=>$this->input->post('occupation'),
					'referred_by'=>$this->input->post('referred_by'),
					'is_vip'=>$this->input->post('is_vip'),
					'photo'=>$picture,
					//'customer_number'=>$customer_number,
					'date_created' => date('Y-m-d H:i:s'));
				$success = $this->others->insert_data("customer",$insert_data);
				//echo $success; exit;
				$insert_id = $success;
				//echo $insert_id; exit;
				$update_data = array(
					'customer_number'=>$b_id.'0'.$insert_id
				);
				$this->others->update_common_value("customer",$update_data,"id='".$insert_id."' ");
				if ($success) {
					$this->session->set_flashdata('success_msg', "Customer is added successfully!");
					redirect(base_url('admin/customer'));
				} else {
					$this->session->set_flashdata('error_msg', "Adding customer is failed!");
					redirect(base_url('admin/customer/add_customer'));
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
		/*$sql='SELECT * FROM `customer` ORDER BY `customer`.`id` DESC';
		$customer_last_id=$this->db->query($sql)->get()->row_array()->id+1;
		echo $customer_last_id; exit;*/
		$customer_last_id=generateCustID($admin_session['business_id']);

		//print_r($customer_last_id); exit;
		$data['customer_last_id']= $customer_last_id;

		$data['admin_session']= $admin_session;
		$data['customer_active_open']=true;
		$this->load->view('admin/customer/add_customer', $data);
	}

	public function check_unique_customer_number($main_name,$uniq_username=null,$b_id,$count=1){
		$check = $this->db->where(['customer_number'=>$uniq_username,'business_id'=>$b_id])->from("customer")->count_all_results();
		if($check){
            $uniq_username = $main_name+$count;
            $count++;
            $uniq_username = self::check_unique_customer_number($main_name,$uniq_username,$b_id,$count);
        }
        return $uniq_username;  
	}

	public function check_unique_customer_number_edit($main_name,$uniq_username=null,$b_id,$id,$count=1){
		$check = $this->db->where(['customer_number'=>$uniq_username,'business_id'=>$b_id])->where_not_in('id',$id)->from("customer")->count_all_results();
		if($check){
            $uniq_username = $main_name+$count;
            $count++;
            $uniq_username = self::check_unique_customer_number($main_name,$uniq_username,$b_id,$id,$count);
        }
        return $uniq_username;  
	}
	
	public function edit_customer($id='')
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		//gs($admin_session); die;
		if ($id != '' && is_numeric($id)) {			
			//$customer_detail = $this->others->get_all_table_value("customer","*","id='".$id."'");
			$this->db->select('customer.*,business.name AS business_name');
			$this->db->from('customer');
			$this->db->join('business','business.id=customer.business_id','inner');
			$this->db->where('customer.id',$id);
			$customer_detail = $this->db->get()->result_array();
			if($customer_detail){
				if($this->input->post('action')){
				$day = $this->input->post('day');
				$month = $this->input->post('month');
				//$year = '0000';
					$dob= $day.'-'.$month;	
					//$business_id = $this->input->post('business_id');
					//$data['business_id'] = $this->input->post('business_id');
					$data['dob'] =	$dob;
					$data['country_code'] = $this->input->post('country_code');
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
					$data['postcode'] = $this->input->post('postcode');
					$data['gender'] = $this->input->post('gender');
					$data['occupation'] = $this->input->post('occupation');
					$data['referred_by'] = $this->input->post('referred_by');
					$data['is_vip'] = $this->input->post('is_vip');
					//$data['customer_number'] = $this->input->post('customer_number');


				
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
					$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
					$this->form_validation->set_rules('postcode', 'Post Code', 'trim|required|xss_clean');
					$this->form_validation->set_rules('mobile_number', 'Mobile number', 'trim|required|xss_clean||min_length[8]');
					$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
					//$this->form_validation->set_rules('customer_number', 'Customer Number', 'trim|required|xss_clean');
					$this->form_validation->set_message('min_length', 'Please enter valid mobile number');
					if ($this->form_validation->run() == TRUE) {						
						
						$notification = $this->input->post('notification');
						if(count((array)$notification)==2){
							$notification_value = 'both';
						}elseif($notification[0]=="email"){
							$notification_value = 'email';
						}elseif($notification[0]=="sms"){
							$notification_value = 'sms';
						}else{
							$notification_value = '';
						}
						
						$reminders = $this->input->post('reminders');
						if(count((array)$reminders)==2){
							$reminders_value = 'both';
						}elseif($reminders[0]=="email"){
							$reminders_value = 'email';
						}elseif($reminders[0]=="sms"){
							$reminders_value = 'sms';
						}else{
							$reminders_value = '';
						}
						
						$b_id = ($admin_session['role']=="business_owner")?$admin_session['business_id']:$this->input->post('business_id') ; 
						$picture = "";
						if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"]== "image/jpg") || ($_FILES["image"]["type"]== "image/pjpeg") || ($_FILES["image"]["type"]== "image/x-png") || ($_FILES["image"]["type"]== "image/png")) {
							if (($_FILES['image']["error"] <= 0) && ($_FILES['image']['name']!="")) {
								$this->load->library('image_lib');
								$uploadDir = $this->config->item('physical_url') . 'images/customer/';
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
								if(file_exists($uploadDir.'thumb/'.$customer_detail[0]['photo'])){
									unlink($uploadDir.'thumb/'.$customer_detail[0]['photo']);							
								}
								if(file_exists($uploadDir.$imgname)){
									unlink($uploadDir.$imgname);						
								}
							}
						}
						/*$customer_number = $this->input->post('customer_number');
						$validate_cus_num = $this->db->where(['customer_number'=>$customer_number,'business_id'=>$b_id])->where_not_in('id',$id)->from("customer")->count_all_results();
						if($validate_cus_num>0){
							$this->session->set_flashdata('error_msg', "Customer Number already exist! Try something different");
							redirect(base_url('admin/customer/edit_customer/'.$id));
						}*/
						///$c_number = $this->input->post('customer_number');
						//$customer_number = $this->check_unique_customer_number_edit($c_number,$c_number,$b_id,$id);
						
						//$update_data['business_id'] = $b_id;
						//$data['dob'] =	$dob;
						$update_data['dob'] = $dob;
						$update_data['country_code'] = $this->input->post('country_code');
						$update_data['location_id'] = $this->input->post('location_id');
						$update_data['first_name'] = $this->input->post('first_name');
						$update_data['last_name'] =$this->input->post('last_name');
						$update_data['email'] = $this->input->post('email');
						$update_data['mobile_number'] =str_replace(" ","",$this->input->post('mobile_number'));
						$update_data['address1'] = $this->input->post('address1');
						$update_data['address2'] =  $this->input->post('address2');
						$update_data['suburb'] =  $this->input->post('suburb');
						$update_data['city'] = $this->input->post('city');
						$update_data['state'] = $this->input->post('state');
						$update_data['postcode'] = $this->input->post('postcode');
						$update_data['gender'] = $this->input->post('gender');
						$update_data['notification'] = $notification_value;
						$update_data['reminders'] = $reminders_value;

						$update_data['referred_by'] = $this->input->post('referred_by');
						$update_data['is_vip'] = $this->input->post('is_vip');
						//$update_data['customer_number'] = $customer_number;
						if($picture!=""){
						$update_data['photo'] = $picture;
						}
						$update_data['occupation'] = $this->input->post('occupation');
																	
						$success = $this->others->update_common_value("customer",$update_data,"id='".$id."' ");
						$this->session->set_flashdata('success_msg', "Customer is updated successfully!");
						redirect(base_url('admin/customer'));
					}
				}
				$data['customer_detail'] = $customer_detail;
			}
		}
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;		
		if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			/*$location_condition = "";
				$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");*/
			//print_r($locations); exit;
			//sprint_r($admin_session['business_id']); exit;
			$this->db->select('id,location_name');
			$this->db->from('location');
			if (($admin_session['business_id'])=='') {
				
				$this->db->where('business_id',$customer_detail[0]['business_id']);
			}
			else{
				
				$this->db->where('business_id',$admin_session['business_id']);
			}

			$locations=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;

			if($locations)
				$data['locations'] = $locations;	
		}
		
		$data['admin_session']= $admin_session;
		$data['customer_active_open']=true;
		$this->load->view('admin/customer/edit_customer', $data);
	}
	
	public function export_to_csv(){

		
		$admin_session = $this->session->userdata('admin_logged_in');
		//print_r($admin_session);die;
		
		
		if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){
			//echo "business";die;
			$this->db->where("business_id",$admin_session['business_id']);

			
		}else if($admin_session['role']=="location_owner"){
			
			$this->db->where("location_id",$admin_session['location_id']);
			
		}

		/*$customers = $this->others->get_all_table_value("customer","*",$condition);*/

		$customers = $this->others->get_all_table_value("customer","*");
		//print_r($this->db->last_query());die;
		//print_r(count((array)$customers));die;

		$filename = "customers_".time().".csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		$fp = fopen('php://output', 'w');
		//fputcsv($fp, $header);

		//$row = array("Cust Number","First Name","Last Name","Email","Mobile Number","Street/area","City","State","Post Code","Gender","Occupation","Location");

		$row = array("Cust Number","Business","Location","First Name","Last Name","Email","DOB","Mobile Number","Occupation","Street/area","City","State","Post Code","Gender","Notification","Reminders","Referred By","IS VIP","Status");
		fputcsv($fp, $row);


		if($customers){		
			$i=1;
			foreach($customers as $row){
				
				$business_name = getBusinessNameById($row['business_id']);
				$location_name = getLocationNameById($row['location_id']);
				$dob = ($row['dob']=='0000-00-00')?"":$row['dob']; 
				$notification = ($row['notification']=='both')?"Email and SMS":ucfirst($row['notification']) ; 
				$reminders = ($row['reminders']=='both')?"Email and SMS":ucfirst($row['reminders']) ; 
				$is_vip = ($row['is_vip']=='0')?"No":"Yes";
				if($row['status']=='0'){ 
					$status = "Deactive";
				}else if($row['status']=='1'){ 
					$status = "Active"; 
				}else{ 
					$status = "Removed"; 
				}

				$arr = array( $row['customer_number'], $business_name, $location_name, $row['first_name'], $row['last_name'], $row['email'], $row['dob'], $row['mobile_number'], $row['occupation'], $row['address1'], $row['city'], $row['state'], $row['postcode'], $row['gender'], $notification, $reminders, $row['referred_by'], $is_vip, $status );

				fputcsv($fp, $arr);

				$i++;
				
			}				
		}
		//print_r(fputcsv($fp, $arr));die;
		exit;
	}
	

	public function import_to_csv(){
		
		$data = array();
		$file_data = array();

		$admin_session = $this->session->userdata('admin_logged_in');
		
		if($this->input->post('action'))
		{


			//$total_customers = $this->db->select('id')->from('customer')->where(['business_id'=>$admin_session['business_id']])->count_all_results();

			$this->load->library('form_validation');
			if($admin_session['role'] == 'owner'){
				$this->form_validation->set_rules('business_id', 'Business', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('location_id', 'Location', 'required|trim|xss_clean');
			//$this->form_validation->set_rules('file', 'File', 'trim|required|xss_clean');
			//echo $this->form_validation->run(); die();
			

			if ($this->form_validation->run() == TRUE || $admin_session['role'] == 'location_owner' ) 
			{


				
				if($admin_session['role'] == 'business_owner') {
					$b_id = $admin_session['business_id'];
				}
				elseif ($admin_session['role'] == 'location_owner') {
					$b_id = $admin_session['business_id'];
					$l_id = $admin_session['location_id'];

				}
				else{
					$b_id = $this->input->post('business_id');
				}
				if ($this->input->post('location_id')) {
					$l_id = $this->input->post('location_id');
				}

				

				
				$filename=$_FILES["file"]["tmp_name"];
				$path = $_FILES['file']['name'];
				
				$ext = pathinfo($path, PATHINFO_EXTENSION);

				if( $ext == 'csv') {
					$config['upload_path']          = './uploads/importcsv/';
	                $config['allowed_types']        = 'csv';
	                
	                $this->load->library('upload', $config);
	                if ( ! $this->upload->do_upload('file'))
	                {
                        $error = array('error' => $this->upload->display_errors());
                       	$this->session->set_flashdata('error_msg', " Please select .csv file!");
						redirect(base_url('admin/customer/import_to_csv'));
                        //print_r("errror");die();
                        //print_r($error);die();
	                }
	                else
	                {
	                	//print_r("okkk");die();
                        $data = array('upload_data' => $this->upload->data());
                        $file_name = $data['upload_data']['file_name'];
                        $data['file_name'] = 'uploads/importcsv/'.$file_name;
                        //$file_path = 'uploads/import'.$logo;
                        //
	                }
	                //print_r($data);die();
					if($_FILES["file"]["size"] > 0)
					{
						$file = fopen($filename, "r");
						
						//$ii= $total_customers;
						//$i=1;
						$custCount = getCustCountBusinessId($admin_session['business_id']);
						while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) 
						{
							
							//$autocustomber_id= $admin_session['business_id'].'0'.$custCount+$i;
							
							$csv_data = array(
								//'customer_number' 	=> $importdata[0],
								'business_id'		=> $b_id,
								'location_id'		=> $l_id,
								//'customer_number'	=> $autocustomber_id,
								'first_name' 		=> $importdata[0],
								'last_name' 		=> $importdata[1],
								'email' 			=> $importdata[2],
								'dob' 				=> $importdata[3],
								'mobile_number' 	=> "+".$importdata[4],
								'occupation' 		=> $importdata[5],
								'address1' 			=> $importdata[6],
								'city' 				=> $importdata[7],
								'state' 			=> $importdata[8],
								'postcode' 			=> $importdata[9],
								'gender' 			=> $importdata[10],
								'notification' 		=> $importdata[11],
								'reminders' 		=> $importdata[12],
								'referred_by' 		=> $importdata[13],
								'is_vip'			=> $importdata[14],
								'is_csv_uploaded'	=> '1',
								'status'			=> '1',
								'date_created'		=> date("Y-m-d H:i:s")							
							);
							
							$file_data[] = $csv_data;
				           	unset($file_data[0]);
				           	//print_r($csv_data);die;
							//print_r($importdata[2]);die;
				           	//$ii++;
				           	//$i++;
			           	}  // end of while


		           							
			  		}
			  		//echo "<pre>",print_r($file_data);die;
			  		foreach ($file_data as $key => $value) {
			  			//echo "<pre>",print_r($value);die;
		  				$this->db->where('email',$value['email']);
		  				$this->db->where('mobile_number',$value['mobile_number']);
		  				$this->db->where('business_id',$value['business_id']);
		  				$this->db->where('location_id',$value['location_id']);
		  				
			  			$count = $this->db->get('customer')->row_array();
			  			$cust_found = array();
			  			if(count((array)$count) > 0){
			  				$cust_found[] =  $value['email'];
			  				//echo "found";die;
			  			}else{
			  				//echo "Not found";die;
			  				$insert_id=$this->others->insert_data('customer',$value);
			  				//$insert_id = $this->db->insert_id();
			  				$update_data = array(
								'customer_number'=>$b_id.'0'.$insert_id
							);
							$this->others->update_common_value("customer",$update_data,"id='".$insert_id."' ");
			  			}	
			  			//echo "<pre>",print_r($this->db->last_query());//die;
			  			//echo "-**--<pre>",print_r($value);die;
			  			if(!empty($cust_found)){
			  				$cust_str = implode(' , ', $cust_found);
		  					$this->session->set_flashdata('success_msg', "Customer Data Imported successfully! Except these emails: ".$cust_str);
			  			}else{
			  				$this->session->set_flashdata('success_msg', "Customer Data Imported successfully!");
			  			}
			  			
			  		}
			  		
			  		$data['b_id'] = $b_id;
					$data['l_id'] = $l_id;
		  			redirect(base_url('admin/customer/import_to_csv'));
					
					///echo "endddd";die;
				} // end if
				else 
				{
					//echo "notformat";die;
					$this->session->set_flashdata('error_msg', "Please select .csv file!");
					redirect(base_url('admin/customer/import_to_csv'));
				} // end of else
			}
		}
		//print_r($file_data);DIE;  	

		//Get business List
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business) {
			$data['all_business'] = $all_business;
		}

		//Get location List
		if($admin_session['role'] == 'business_owner'){
			$this->db->where('business_id',$admin_session['business_id']);
		}
		$all_location = $this->others->get_all_table_value("location","id,location_name","","location_name","ASC");
		if($all_location) {
			$data['all_location'] = $all_location;
		}

		// get csv file data
		$data['csv_data'] = $file_data;
		//print($file_data);

		$data['customer_active_open']=true;
		$this->load->view('admin/customer/import_csv', $data); 		
	}

	public function insert_csv_data($csv_data='')
	{

		if($this->input->post('file_path')) {

			$file_path = $this->input->post('file_path');
			$new_path = base_url().$file_path;
			//echo "<pre>";
			//print_r($new_path);die;
			$b_id = $this->input->post('b_id');
			$l_id = $this->input->post('l_id');

			$file = fopen($new_path, "r");
			$file_data = array();
			$i=0;
			while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) 
			{
				$csv_data = array(
					'customer_number' 	=> $importdata[0],
					'business_id'		=> $b_id,
					'location_id'		=> $l_id,
					'first_name' 		=> $importdata[1],
					'last_name' 		=> $importdata[2],
					'email' 			=> $importdata[3],
					'mobile_number' 	=> $importdata[4],
					'address1' 			=> $importdata[5],
					'city' 				=> $importdata[6],
					'state' 			=> $importdata[7],
					'postcode' 			=> $importdata[8],
					'gender' 			=> $importdata[9],
					'occupation' 		=> $importdata[10],
					'is_csv_uploaded'	=> 1,
					'status'			=> 1,
					'date_created' 		=> date('Y-m-d H:i:s'),
				
				);

		       	if($i>0)
		       	{
					$return = $this->others->insert_data('customer',$csv_data);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Customer inserted into db successfully!");
					}
		       	}
				$i++;
				
		   	}  
		}
		
		$this->load->helper("file");
		delete_files($new_path);	
		redirect('admin/customer');
	}


		
}
