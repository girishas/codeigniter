<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
		$this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('security');

        $this->load->model('others', '', TRUE);

    }

    
	public function index() {	
		
		$data = array();
		if($this->input->post('email')){
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			$this->form_validation->set_message('required', 'Field is required!!');
			$this->form_validation->set_message('valid_email', 'Plese enter valid email!!');

			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
		 		$result = array("type"=>"error","message"=>"Please correct this errors!!","data"=>$errors);
	 			echo json_encode($result);die;
		 	}else{
		 		$email 		= $this->input->post('email');
				$password 	= $this->input->post('password');
		 		$result = $this->others->admin_available($email, $password);
		 		
		 		if($result){
		 			$user_array = array(
		                'admin_id' => $result[0]->id,
		                'admin_name' => $result[0]->admin_name,
						'admin_email' => $result[0]->email,
		                'role' => $result[0]->role,
		                'staff_id'=>$result[0]->staff_id,
						'business_id' => $result[0]->business_id,
						'location_id' => $result[0]->location_id,
						'status' => $result[0]->status,
						'trial_expire_date' => $result[0]->trial_expire_date,
						'payment_status' => $result[0]->payment_status,
		            );

		            // get image of user
		            if( $user_array['role'] == 'owner' ){
		            	$user_array["logo"] = "";
		            } else if( $user_array['role'] == 'business_owner' ){
		            	$this->db->select("logo");
		            	$this->db->where("id",$user_array['business_id']);
		            	$user_logo = $this->db->get("business");
		            	$logo = $user_logo->row();
		            	$user_array["logo"] = $logo->logo;
		 			} else if( $user_array['role'] == 'location_owner' || $user_array['role'] == 'staff' ) {
		 				$this->db->select("picture");
		            	$this->db->where("id",$user_array['staff_id']);
		            	$user_logo = $this->db->get("staff");
		            	$logo = $user_logo->row();
		            	$user_array["logo"] = $logo->picture;
		 			} 
		 			
		 			//$admin_session = $this->session->set_userdata('admin_logged_in', $user_array);
		 			$dashboard_data = $this->getDashboardData($user_array);
		 			//gs($dashboard_data);
		 			$data = array("user_data"=>$user_array,"dashboard_data"=>$dashboard_data);
		 			$result = array("type"=>"success","message"=>"Login successfully!!","data"=>$data);
	 				echo json_encode($result);die;
		 		}else{
		 			$result = array("type"=>"error","message"=>"Your email & password not match with our system!!","data"=>array());
	 				echo json_encode($result);die;
		 		}
		 	}
	 	}else{
	 		$result = array("type"=>"error","message"=>"Please enter valid email & password!!","data"=>array());
	 		echo json_encode($result);die;
	 	}
	 	die;
 	}


 	public function getDashboardData($admin_session=array()){

		$admin_session = $this->session->userdata('admin_logged_in');
		if( empty($admin_session) ){
			$result = array("type"=>"error","message"=>"No Dashboard data found!!","data"=>array());
	 		return $result;die;
		}

	    if(($admin_session['role']=='business_owner' or $admin_session['role']=='location_owner' or $admin_session['role']=='staff' or $admin_session['role']=='owner') && $admin_session['business_id']!=''){      

	        //total sales  
	        $this->db->select('IFNULL(sum(total_price),0) as total_amount');
	        $this->db->from('invoices');
	        if ($admin_session['business_id']!='') {
          		$this->db->where('business_id',$admin_session['business_id']);
	        }
	        $this->db->where('MONTH(date_created)',date('m'));
	        $data['total_sale'] = $this->db->get()->row_array();
	        //End
	        
	        //total bookings      
	        $this->db->select('IFNULL(count(*),0) as total_booking');
	        $this->db->from('bookings');
	        if ($admin_session['business_id']!='') {
     	 		$this->db->where('business_id',$admin_session['business_id']);
	        }
     		$this->db->where('MONTH(start_date)',date('m'));
	        $data['count_all_booking'] = $this->db->get()->row_array();
	        //End

	        //total bookings      
	        $this->db->select('IFNULL(count(*),0) as total_customer');
	        $this->db->from('customer');
	        if ($admin_session['business_id']!='') {
          		$this->db->where('business_id',$admin_session['business_id']);
	        }
	        $data['count_all_customer'] = $this->db->get()->row_array();
	        //End

	        // Total Services
	        $this->db->select('IFNULL(count(*),0) as total_services');
	        $this->db->from('services');
	        if ($admin_session['business_id']!='') {
          		$this->db->where('business_id',$admin_session['business_id']);
	        }
	        $data['count_all_services'] = $this->db->get()->row_array();
	        //End
	        
	        // CURRENT MONTH ACTIVITY
	        $current_month_activity =  $this->getMothActivity($admin_session);
	        if($current_month_activity){
          		$data['current_month_activity'] = $current_month_activity;
	        }
	        //End

	        // TODAY'S NEXT APPOINTMENTS
	        $next_appointments =  $this->getTodaysNextAppointments($admin_session);
	        if($next_appointments){
          		$data['next_appointments'] = $next_appointments;
	        }
	        //End

	        // TOP SERVICES 
	        $top_service =  $this->getTopService($admin_session);
	        if($top_service){
          		$data['top_service'] = $top_service;
	        }
	        //End

	        // TOP STAFFS
	        $top_staff =  $this->getTopStaff($admin_session);
	        if($top_staff){
          		$data['top_staff'] = $top_staff;
	      	}
	      	//End

			// UPCOMING NEXT FIVE DAY APPOINTMENTS
			$fromdate=date('Y-m-d');
			$todate = date('Y-m-d', strtotime('+5 day', strtotime($fromdate)));
			$this->db->select('count(*) AS total_booking,start_date');
			$this->db->from('bookings');
			$this->db->where_in('booking_status','1,0');
			$this->db->where('start_date BETWEEN "'.$fromdate. '" and "'.$todate.'"');
			$this->db->group_by('start_date');
			if ($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")) {
				$this->db->where('business_id',$admin_session['business_id']);
			}

			if($admin_session['role']=="location_owner") {
				$this->db->where('location_id',$admin_session['location_id']);
			}

	      	$get_next_appointments	= $this->db->get()->result_array();
			$currentday_new_booking	= 0;
			$firstday_new_booking	= 0;
			$second_new_booking		= 0;
			$thirday_new_booking	= 0;
			$fourday_new_booking	= 0;
			$fiveday_new_booking	= 0;
			
			foreach ($get_next_appointments as $key => $value) {
				if (date('Y-m-d')== $value['start_date']) {
				   $currentday_new_booking=+$value['total_booking'];
				}
				 if (date('Y-m-d', strtotime('+1 day', strtotime($fromdate)))== $value['start_date']) {
				   $firstday_new_booking=+$value['total_booking'];
				}
				 if (date('Y-m-d', strtotime('+2 day', strtotime($fromdate)))== $value['start_date']) {
				   $second_new_booking=+$value['total_booking'];
				}
				 if (date('Y-m-d', strtotime('+3 day', strtotime($fromdate)))== $value['start_date']) {
				   $thirday_new_booking=+$value['total_booking'];
				}
				 if (date('Y-m-d', strtotime('+4 day', strtotime($fromdate)))== $value['start_date']) {
				   $fourday_new_booking=+$value['total_booking'];
				}
				 if (date('Y-m-d', strtotime('+5 day', strtotime($fromdate)))== $value['start_date']) {
				   $fiveday_new_booking=+$value['total_booking'];
				}
			}   

			$data['currentday_new_booking']	= $currentday_new_booking;
			$data['firstday_new_booking']	= $firstday_new_booking;
			$data['second_new_booking']		= $second_new_booking;
			$data['thirday_new_booking']	= $thirday_new_booking;
			$data['fourday_new_booking']	= $fourday_new_booking;
			$data['fiveday_new_booking']	= $fiveday_new_booking;
	      	//End


         	// UPCOMING Confirmed NEXT FIVE DAY APPOINTMENTS
			$fromdate=date('Y-m-d');
			$todate = date('Y-m-d', strtotime('+5 day', strtotime($fromdate)));
			$this->db->select('count(*) AS total_booking,start_date');
			$this->db->from('bookings');
			$this->db->where('booking_status',6);
			$this->db->where('start_date BETWEEN "'.$fromdate. '" and "'.$todate.'"');
			$this->db->group_by('start_date');
			
			if ($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner") {
				$this->db->where('location_id',$admin_session['location_id']);
			}

			$getConfirmedAppointments		= $this->db->get()->result_array();
			$currentday_confirmed_booking	= 0;
			$firstday_confirmed_booking		= 0;
			$second_confirmed_booking		= 0;
			$thirday_confirmed_booking		= 0;
			$fourday_confirmed_booking		= 0;
			$fiveday_confirmed_booking		= 0;

			foreach ($getConfirmedAppointments as $key => $value) {
				if (date('Y-m-d') == $value['start_date']) {
					$currentday_confirmed_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+1 day', strtotime($fromdate)))== $value['start_date']) {
					$firstday_confirmed_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+2 day', strtotime($fromdate)))== $value['start_date']) {
					$second_confirmed_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+3 day', strtotime($fromdate)))== $value['start_date']) {
					$thirday_confirmed_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+4 day', strtotime($fromdate)))== $value['start_date']) {
					$fourday_confirmed_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+5 day', strtotime($fromdate)))== $value['start_date']) {
					$fiveday_confirmed_booking=+$value['total_booking'];
				}
			}   

			$data['currentday_confirmed_booking']	= $currentday_confirmed_booking;
			$data['firstday_confirmed_booking']		= $firstday_confirmed_booking;
			$data['second_confirmed_booking']		= $second_confirmed_booking;
			$data['thirday_confirmed_booking']		= $thirday_confirmed_booking;
			$data['fourday_confirmed_booking']		= $fourday_confirmed_booking;
			$data['fiveday_confirmed_booking']		= $fiveday_confirmed_booking;
			//End

			// UPCOMING cancelled NEXT FIVE DAY APPOINTMENTS
			$fromdate=date('Y-m-d');
			$todate = date('Y-m-d', strtotime('+5 day', strtotime($fromdate)));
			$this->db->select('count(*) AS total_booking,start_date');
			$this->db->from('bookings');
			$this->db->where('booking_status',2);
			$this->db->where('start_date BETWEEN "'.$fromdate. '" and "'.$todate.'"');
			$this->db->group_by('start_date');
			
			if ($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if($admin_session['role']=="location_owner") {
				$this->db->where('location_id',$admin_session['location_id']);
			}

			$getCancelledAppointments		= $this->db->get()->result_array();
			$currentday_cancelled_booking	= 0;
			$firstday_cancelled_booking		= 0;
			$second_cancelled_booking		= 0;
			$thirday_cancelled_booking		= 0;
			$fourday_cancelled_booking		= 0;
			$fiveday_cancelled_booking		= 0;

			foreach ($getCancelledAppointments as $key => $value) {
				if (date('Y-m-d')== $value['start_date']) {
					$currentday_cancelled_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+1 day', strtotime($fromdate)))== $value['start_date']){
					$firstday_cancelled_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+2 day', strtotime($fromdate)))== $value['start_date']) {
					$second_cancelled_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+3 day', strtotime($fromdate)))== $value['start_date']) {
					$thirday_cancelled_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+4 day', strtotime($fromdate)))== $value['start_date']) {
					$fourday_cancelled_booking=+$value['total_booking'];
				}
				if (date('Y-m-d', strtotime('+5 day', strtotime($fromdate)))== $value['start_date']) {
					$fiveday_cancelled_booking=+$value['total_booking'];
				}
			}

			$data['currentday_cancelled_booking']	= $currentday_cancelled_booking;
			$data['firstday_cancelled_booking']		= $firstday_cancelled_booking;
			$data['second_cancelled_booking']		= $second_cancelled_booking;
			$data['thirday_cancelled_booking']		= $thirday_cancelled_booking;
			$data['fourday_cancelled_booking']		= $fourday_cancelled_booking;
			$data['fiveday_cancelled_booking']		= $fiveday_cancelled_booking;
			//End

	     	// sales Details
			$fromdate=date('Y-m-d');
			$todate = date('Y-m-d', strtotime('-5 day', strtotime($fromdate)));
			$this->db->select('count(*) AS total_services,DATE_FORMAT(date_created, "%Y-%m-%d") AS start_date ');
			$this->db->from('invoice_services');
			// $this->db->where('booking_status',6);
			$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d") BETWEEN "'.$todate. '" and "'.$fromdate.'"');
			$this->db->group_by('DATE_FORMAT(date_created, "%Y-%m-%d")');
			
			if ($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if($admin_session['role']=="location_owner") {
				$this->db->where('location_id',$admin_session['location_id']);
			}

			$this->db->where('pay_service_type',1);        
			$getservice=$this->db->get()->result_array();

			$currentday_services_booking	= 0;
			$firstday_services_booking		= 0;
			$second_services_booking		= 0;
			$thirday_services_booking		= 0;
			$fourday_services_booking		= 0;
			$fiveday_services_booking		= 0;

			foreach ($getservice as $key => $value) {
				if (date('Y-m-d')== $value['start_date']) {
					$currentday_services_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-1 day', strtotime($fromdate)))== $value['start_date']) {
					$firstday_services_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-2 day', strtotime($fromdate)))== $value['start_date']) {
					$second_services_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-3 day', strtotime($fromdate)))== $value['start_date']) {
					$thirday_services_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-4 day', strtotime($fromdate)))== $value['start_date']) {
					$fourday_services_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-5 day', strtotime($fromdate)))== $value['start_date']) {
					$fiveday_services_booking=+$value['total_services'];
				}
			}   

			$data['currentday_services_booking']= $currentday_services_booking;
			$data['firstday_services_booking']	= $firstday_services_booking;
			$data['second_services_booking']	= $second_services_booking;
			$data['thirday_services_booking']	= $thirday_services_booking;
			$data['fourday_services_booking']	= $fourday_services_booking;
			$data['fiveday_services_booking']	= $fiveday_services_booking;
			//End


	      	// sales product Details
			$fromdate=date('Y-m-d');
			$todate = date('Y-m-d', strtotime('-5 day', strtotime($fromdate)));
			$this->db->select('count(*) AS total_services,DATE_FORMAT(date_created, "%Y-%m-%d") AS start_date ');
			$this->db->from('invoice_services');
			// $this->db->where('booking_status',6);
			$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d") BETWEEN "'.$todate. '" and "'.$fromdate.'"');
			$this->db->group_by('DATE_FORMAT(date_created, "%Y-%m-%d")');
			
			if ($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if($admin_session['role']=="location_owner") {
				$this->db->where('location_id',$admin_session['location_id']);
			}

			$this->db->where('pay_service_type',4);        
			$getProduct=$this->db->get()->result_array();

			$currentday_product_booking	= 0;
			$firstday_product_booking	= 0;
			$second_product_booking		= 0;
			$thirday_product_booking	= 0;
			$fourday_product_booking	= 0;
			$fiveday_product_booking	= 0;

			foreach ($getProduct as $key => $value) {
				if (date('Y-m-d')== $value['start_date']) {
					$currentday_product_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-1 day', strtotime($fromdate)))== $value['start_date']) {
					$firstday_product_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-2 day', strtotime($fromdate)))== $value['start_date']) {
					$second_product_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-3 day', strtotime($fromdate)))== $value['start_date']) {
					$thirday_product_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-4 day', strtotime($fromdate)))== $value['start_date']) {
					$fourday_product_booking=+$value['total_services'];
				}
				if (date('Y-m-d', strtotime('-5 day', strtotime($fromdate)))== $value['start_date']) {
					$fiveday_product_booking=+$value['total_services'];
				}
			}   

			$data['currentday_product_booking']	= $currentday_product_booking;
			$data['firstday_product_booking']	= $firstday_product_booking;
			$data['second_product_booking']		= $second_product_booking;
			$data['thirday_product_booking']	= $thirday_product_booking;
			$data['fourday_product_booking']	= $fourday_product_booking;
			$data['fiveday_product_booking']	= $fiveday_product_booking;
			//End

			$data['dashboard_active_open']=true;
			//echo "<pre>"; print_r($data['top_staff']); exit;
			///$this->load->view('admin/dashboard',$data);
			//$this->load->view('admin/service/appointment_calendar');
			$result = array("type"=>"error","message"=>$admin_session['role']." Dashboard!!","data"=>$data);
	 		return $result;die;

	    }else{
			$current_month =  date("m");
			$year = date("Y");
			
			// Dashboard for owner (Super admin)
			$data['dashboard_active_open']=true;

			// Calculate Total revenue of all time 
			$revenue = $this->db->query("select SUM(paid_amount) AS revenue,MONTH(paid_date) as month from invoice_payments where MONTH(paid_date)=$current_month and year(paid_date)=$year and pay_process_type=0 GROUP BY month")->row_array();
			$refund = $this->db->query("select SUM(paid_amount) AS refund,MONTH(paid_date) as month from invoice_payments where MONTH(paid_date)=$current_month and year(paid_date)=$year and pay_process_type=4 GROUP BY month")->row_array();
			$total_revenue = $revenue['revenue']-$refund['refund'];
			$data['total_revenue'] = number_format($total_revenue,2);

			//count all customers
			$customer = $this->db->query("select COUNT(id) as total_customer,MONTH(date_created) as month from customer where MONTH(date_created)=$current_month and year(date_created)=$year GROUP BY month")->row_array();      
			$data['total_customer'] = ($customer['total_customer'])?$customer['total_customer']:0;

			// total businesses
			$businesses = $this->db->query("select COUNT(id) as total_businesses,MONTH(date_created) as month from business where MONTH(date_created)=$current_month and year(date_created)=$year GROUP BY month")->row_array();  
			$data['total_businesses'] = ($businesses['total_businesses'])?$businesses['total_businesses']:0;

			// total appointments
			$appointments = $this->db->select("COUNT(id) AS total_appointments")->from("bookings")->get()->row_array();
			$data['total_appointments'] = $appointments['total_appointments'];

			// total staffs
			$staffs = $this->db->query("select COUNT(id) as total_staff,MONTH(date_created) as month from business where MONTH(date_created)=$current_month and year(date_created)=$year GROUP BY month")->row_array(); 
			$data['total_staff'] = ($staffs['total_staff'])?$staffs['total_staff']:0;

			// Current Year sales
			$months = array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dec");
			$mary = array();
			$cary = array();
			
			foreach($months as $key => $value){
				$qry = $this->db->query("select SUM(paid_amount) as total,MONTH(paid_date) as month from invoice_payments where MONTH(paid_date)=$key and year(paid_date)=$year and pay_process_type=0 GROUP BY month")->row_array();
				$rqry = $this->db->query("select SUM(paid_amount) as total,MONTH(paid_date) as month from invoice_payments where MONTH(paid_date)=$key and year(paid_date)=$year and pay_process_type=4 GROUP BY month")->row_array();
				$mary[$key]['value'] =($qry['total'])?round($qry['total']-$rqry['total']):0; 
			} 
			//gs($mary);
			$data['revenue_data'] = $mary;

			// Current year Clients

			foreach($months as $key => $value){
				$qry = $this->db->query("select COUNT(id) as total,MONTH(date_created) as month from business where MONTH(date_created)=$key and year(date_created)=$year GROUP BY month")->row_array();
				$cary[$key]['value'] =($qry['total'])?round($qry['total']):0; 
			} 

			$data['client_data'] = $cary;
			///$this->load->view('admin/dashboard_owner',$data);
			$result = array("type"=>"error","message"=>"Owner Dashboard.","data"=>$data);
	 		return $result;die;
	    }    

		$result = array("type"=>"error","message"=>"No Dashboard data found!!","data"=>array());
 		return $result;die;

 	}

 	// CURRENT MONTH ACTIVITY
  	public function getMothActivity($admin_session=array()) {

  		if(!empty($admin_session)){

			$select = array('id','customer_id','staff_id','service_id','customer_id','business_id','date_created');
			$this->db->select($select);    
			if($admin_session['role'] == 'owner'){
				if($admin_session['business_id']){
					$this->db->where('business_id',$admin_session['business_id']);
				}
			}else if($admin_session['role'] == 'business_owner'){
				$this->db->where('business_id',$admin_session['business_id']);
			}else if($admin_session['role'] == 'location_owner'){
				$this->db->where('location_id',$admin_session['location_id']);
			}else{
				$this->db->where('staff_id',$admin_session['staff_id']);
			}

			$data = date('m');
			$this->db->where('month(date_created)',$data);
			$this->db->where('service_id !=',NULL);
			$this->db->order_by('date_created ','desc');
			$this->db->limit(5);
			$result =  $this->db->get('invoice_services')->result_array();
			//print_r($this->db->last_query());die;
			return $result;
		}else{
			return false;
		}
  	}


  	// TODAY'S NEXT APPOINTMENTS
  	public function getTodaysNextAppointments($admin_session=array()) {

  		if(!empty($admin_session)){

			if($admin_session['role'] == 'owner'){
				if($admin_session['business_id']){
					$this->db->where('t2.business_id',$admin_session['business_id']);
				}
			}else if($admin_session['role'] == 'business_owner'){
				$this->db->where('t2.business_id',$admin_session['business_id']);
			}else if($admin_session['role'] == 'location_owner'){
				$this->db->where('t2.location_id',$admin_session['location_id']);
			}else{
				$this->db->where('t2.staff_id',$admin_session['staff_id']);
			}

		    $select = array(
		      't1.id as id',
		      't1.book_start_time as book_start_time',
		      't1.booking_id as booking_id',
		      't1.service_id as service_id',
		      't1.staff_id as staff_id',
		    );

			$data = date('Y-m-d');
			$whree_in = array( 't2.booking_status'=>0, 't2.booking_status'=>1,'t2.booking_status'=>6);
			$result = $this->db->select($select)
			->from('booking_services as t1')
			->where('date',$data)
			->where_in('t2.booking_status',array(0,1,6))
			->join('bookings as t2', 't1.booking_id = t2.id', 'INNER')
			->limit(5)->get()->result_array();
		    //print_r($this->db->last_query());die;
	    	return $result;
	    }else{
	    	return false;
	    }
  	}


  	// TOP SERVICES 
  	public function getTopService($admin_session=array()) {

  		if(!empty($admin_session)){

			if($admin_session['role'] == 'owner'){
				if($admin_session['business_id']){
					$this->db->where('business_id',$admin_session['business_id']);
				}
			}else if($admin_session['role'] == 'business_owner'){
				$this->db->where('business_id',$admin_session['business_id']);
			}else if($admin_session['role'] == 'location_owner'){
				$this->db->where('location_id',$admin_session['location_id']);
			}else{
				$this->db->where('staff_id',$admin_session['staff_id']);
			}

		    $this->db->select('service_id');
		    $this->db->select('sum(service_total_price) as top');
		    $this->db->where('service_id !=',NULL);
		    $this->db->group_by('service_id');
		    $this->db->order_by('top','desc');
		    $this->db->limit(5);
		    $result =  $this->db->get('invoice_services')->result_array();
		    //print_r($this->db->last_query());die;
		    return $result;
	   	}else{
	   		return false;
	   	}
  	}


	// TOP STAFFS
	public function getTopStaff($admin_session=array()) {

		if(!empty($admin_session)){
			if($admin_session['role'] == 'owner'){
				if($admin_session['business_id']){
					$this->db->where('business_id',$admin_session['business_id']);
				}
			}else if($admin_session['role'] == 'business_owner'){
				$this->db->where('business_id',$admin_session['business_id']);
			}else if($admin_session['role'] == 'location_owner'){
				$this->db->where('location_id',$admin_session['location_id']);
			}else{
				$this->db->where('staff_id',$admin_session['staff_id']);
			}

			$this->db->select('staff_id');
			$this->db->select('sum(service_total_price) as top');
			$this->db->group_by('staff_id');
			$this->db->order_by('top','desc');
			$this->db->limit(5);
			$result =  $this->db->get('invoice_services')->result_array();
			//gs($this->db->last_query());
			return $result;
		}else{
			return false;
		}
	}



    public function forgot_password(){
		
		if($this->input->post('email')!="")
		{
			$email = trim($this->input->post('email'));
			$validate_email = $this->db->select('*')->from('admin_users')->where(['email'=>$email])->get()->row_array();
			if($validate_email)
			{
				$password = rand(000000,999999);
				$md5_password = md5($password);
				$update_data['password'] = $md5_password;
				$data['name'] = $validate_email['admin_name'];
				$data['password'] = $password;

				$this->others->update_common_value("admin_users",$update_data,"id='".$validate_email['id']."' ");

				$mail = Array(
					'protocol' 	=> 'smtp',
			        'smtp_host' => 'mail.bookingintime.com',
			        'smtp_port' => 2525,
			        'smtp_user' => 'developer@bookingintime.com',
			        'smtp_pass' => 'ye_0~u+t1y,0',
			        'mailtype'  => 'html', 
			        'charset' 	=> 'utf-8',
			        'wordwrap' 	=> TRUE
			    );
				$this->load->library('email', $mail);
			    $this->email->set_newline("\r\n");
			    $email_body = $this->load->view('admin/templates/forgot-password',$data,true);
			    $this->email->from('developer@bookingintime.com', 'Bookingintime.com');
			    $list = array($email);
			    $this->email->to($list);
			    $this->email->subject('New Password for your account.');
			    $this->email->message($email_body);
			    if($this->email->send())
			    {
			    	///$this->session->set_flashdata('success_msg', "New password has been sended to your email");
					///redirect(base_url('/admin/login/forgot_password'));
					$result = array("type"=>"success","message"=>"New password has been sended to your email.","data"=>array());
 					echo json_encode($result);die;
			    }else{
			    	///$this->session->set_flashdata('error_msg', "Error while sending email");
					///redirect(base_url('/admin/login/forgot_password'));
					$result = array("type"=>"error","message"=>"Error while sending email.","data"=>array());
 					echo json_encode($result);die;
			    }
			}else{
				///$this->session->set_flashdata('error_msg', "Email does not exist in our system");
				///redirect(base_url('/admin/login/forgot_password'));
				$result = array("type"=>"error","message"=>"Email does not exist in our system.","data"=>array());
					echo json_encode($result);die;
			}
		}else{
			//redirect(base_url('/admin/login/forgot_password'));
			$result = array("type"=>"error","message"=>"Please enter email.","data"=>array());
			echo json_encode($result);die;
		}
		
	}



	public function inventoryReports($id=null){
		$data = array();
		if($this->input->post("report_name")){
			$this->form_validation->set_rules('report_name', 'Report Name', 'trim|required');
			$this->form_validation->set_rules('business_id', 'Business Id', 'trim|required|numeric');
			$this->form_validation->set_rules('location_id', 'Locaion Id', 'trim|required|numeric');
			$this->form_validation->set_rules('staff_id', 'Staff Id', 'trim|required|numeric');

			$this->form_validation->set_message('required', 'Field is required!!');
			$this->form_validation->set_message('numeric', 'Should be numeric!!');

			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
		 		$result = array("type"=>"error","message"=>"Please correct this errors!!","data"=>$errors);
	 			echo json_encode($result);die;
		 	}else{

		 		$insertData = array(
			 			"report_name"	=> $this->input->post("report_name"),
			 			"business_id"	=> $this->input->post("business_id"),
			 			"location_id"	=> $this->input->post("location_id"),
			 			"staff_id"		=> $this->input->post("staff_id"),
			 			"date_created"	=> date("Y-m-d H:i:s")
		 			);

	 			$success = $this->db->insert("inventory_reports",$insertData);
	 			if($success == true){
		 			$result = array("type"=>"success","message"=>"Inventory report generated successfully.","data"=>array());
		 			echo json_encode($result);die;
	 			}else{
	 				$result = array("type"=>"error","message"=>"Something went wrong. Please try again!!","data"=>array());
		 			echo json_encode($result);die;
	 			}
		 	}
	 	}

	 	if(!empty($id)){
	 		$this->db->where("id",$id);
	 	}

	 	$data = $this->db->get("inventory_reports");
	 	if( $data->num_rows() > 0 ){
			$result = array("type"=>"success","message"=>"Some inventory reports are already generated.","data"=>$data->result());
			echo json_encode($result);die;
	 	}else{
	 		$result = array("type"=>"success","message"=>"There is no inventory reports are generated yet.","data"=>array());
			echo json_encode($result);die;
	 	}

	}


	public function productReports($inventory_report_id=null,$id=null){
				
		$data = array();
		if($this->input->post("product_id")){
			$this->form_validation->set_rules('product_id', 'Product Id', 'trim|required|numeric');
			$this->form_validation->set_rules('location_id', 'Location Id', 'trim|required|numeric');
			$this->form_validation->set_rules('stock_qty', 'Stock Quantity', 'trim|required|numeric');
			$this->form_validation->set_message('required', 'Field is required!!');
			$this->form_validation->set_message('numeric', 'Should be numeric!!');

			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
		 		$result = array("type"=>"error","message"=>"Please correct this errors!!","data"=>$errors);
	 			echo json_encode($result);die;
		 	}else{

		 		$sys_stock_qty 	= null;
		 		$location_id 	= $this->input->post("location_id");
		 		$product_id 	= $this->input->post("product_id");

		 		if( !empty($product_id) ){
		 			$sys_stock_qty = getProductStockQtyForLocation($location_id,$product_id);
		 		}

		 		$insertData = array(
			 			"inventory_report_id"	=> $inventory_report_id,
			 			"product_id"			=> $product_id,
			 			"stock_qty"				=> $this->input->post("stock_qty"),
			 			"sys_stock_qty"			=> $sys_stock_qty,
		 			);

		 		if(!empty($inventory_report_id) && !empty($id)){
		 			
		 			$insertData["date_updated"] = date("Y-m-d H:i:s");
		 			$this->db->where("id",$id);
		 			$success = $this->db->update("product_reports",$insertData);
		 			if($success == true){
			 			$result = array("type"=>"success","message"=>"Product updated successfully.","data"=>array());
			 			echo json_encode($result);die;
		 			}else{
		 				$result = array("type"=>"error","message"=>"Something went wrong. Please try again!!","data"=>array());
			 			echo json_encode($result);die;
		 			}

		 		}else{

		 			$insertData["date_created"] = date("Y-m-d H:i:s");
		 			$success = $this->db->insert("product_reports",$insertData);
		 			if($success == true){
			 			$result = array("type"=>"success","message"=>"Product added successfully.","data"=>array());
			 			echo json_encode($result);die;
		 			}else{
		 				$result = array("type"=>"error","message"=>"Something went wrong. Please try again!!","data"=>array());
			 			echo json_encode($result);die;
		 			}

		 		}
		 	}
		}

		if(!empty($inventory_report_id) && empty($id)){
	 		$this->db->where("pr.inventory_report_id",$inventory_report_id);
	 	}else if(!empty($inventory_report_id) && !empty($id)){
	 		$this->db->where( "pr.id",$id );
	 		$this->db->where( "pr.inventory_report_id",$inventory_report_id );
	 	}
	 	$this->db->from("product_reports pr");
	 	$this->db->join("inventory_reports ir","pr.inventory_report_id = ir.id","left");
	 	$data = $this->db->get("");

	 	if( $data->num_rows() > 0 ){
			$result = array("type"=>"success","message"=>"Some product are already added.","data"=>$data->result());
			echo json_encode($result);die;
	 	}else{
	 		$result = array("type"=>"success","message"=>"There is no product added yet.","data"=>array());
			echo json_encode($result);die;
	 	}
	}

	public function getProductDetails(){

		$data = array();
		$bar_code = $this->input->post("bar_code");
		if($bar_code){
			$this->form_validation->set_rules('bar_code', 'Product Id', 'trim|required');
			$this->form_validation->set_message('required', 'Field is required!!');
			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
		 		$result = array("type"=>"error","message"=>"Please correct this errors!!","data"=>$errors);
	 			echo json_encode($result);die;
		 	}else{

		 		$this->db->select("id,product_name,bar_code");
		 		$this->db->where("bar_code",$bar_code);
		 		$success = $this->db->get("product");
		 		
	 			if($success == true){
		 			$result = array("type"=>"success","message"=>"Product added successfully.","data"=>$success->result());
		 			echo json_encode($result);die;
	 			}else{
	 				$result = array("type"=>"error","message"=>"Something went wrong. Please try again!!","data"=>array());
		 			echo json_encode($result);die;
	 			}
		 	}
		}else{
	 		$result = array("type"=>"error","message"=>"Please enter bar code!!","data"=>array());
			echo json_encode($result);die;
	 	}


	}

	public function productGenerateReports($inventory_report_id=null){

		$data = array();

		if(!empty($inventory_report_id)){
			$updateData = array(
					"status"		=> 1,
					"date_updated" 	=> date("Y-m-d H:i:s"),
				);
			$this->db->where("id",$inventory_report_id);
			$success = $this->db->update("inventory_reports",$updateData);
			if($success == true){
	 			$result = array("type"=>"success","message"=>"Inventory Report generated successfully.","data"=>array());
	 			echo json_encode($result);die;
 			}else{
 				$result = array("type"=>"error","message"=>"Something went wrong. Please try again!!","data"=>array());
	 			echo json_encode($result);die;
 			}
		}
		$result = array("type"=>"error","message"=>"There is no inventory report available for this id.","data"=>array());
		echo json_encode($result);die;
	}




}
