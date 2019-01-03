<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
 
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('dashboard_model', '', TRUE);
		    $admin_session = $this->session->userdata('admin_logged_in');
        if($admin_session['admin_email'] =='') {
			 redirect(base_url('admin'));
	    }
    }

	public function index()
	{	

		$admin_session = $this->session->userdata('admin_logged_in');
    $business_details = $this->db->select("*")->from("admin_users")->where(["business_id"=>$admin_session['business_id'],"role"=>"business_owner"])->get()->row_array();
    if ($business_details['trial_expire_date'] < date('Y-m-d') && $admin_session['role'] != 'owner' ) {
     $this->session->set_flashdata('error_msg', "Your subscription has been ended, Please choose a plan to continue.");
      redirect(base_url('admin/logout'));
    }

    if(($admin_session['role']=='business_owner' or $admin_session['role']=='location_owner' or $admin_session['role']=='staff' or $admin_session['role']=='owner') && $admin_session['business_id']!=''){      
     
        //print_r($admin_session); exit;
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

        /* $output = array();
        $month = date("m");
        $day = date("d");
        $year = date("Y");
        for($i = 0; $i < 30; $i++)
        $output[] = date('Y-m-d',mktime(0,0,0,$month,($day-$i),$year));
        $dates_array = array_reverse($output);
        $ap_Array = array();
        $business_id = $admin_session['business_id'];
        foreach ($dates_array as $key => $value) {
          $received = $this->db->query("SELECT SUM(paid_amount) AS total FROM invoice_payments WHERE business_id=$business_id and pay_process_type=0 and paid_date='$value' GROUP BY paid_date")->row_array();
          $paid = $this->db->query("SELECT SUM(paid_amount) AS total FROM invoice_payments WHERE business_id=$business_id and pay_process_type=4 and paid_date='$value' GROUP BY paid_date")->row_array();
          $amount = $received['total']-$paid['total'];
          $inv_Data[$value] = number_format($amount,2);
        } 
        $data['salesamount'] = implode(", ",$inv_Data);
        $data['salesdates'] = implode(", ",array_keys($inv_Data));*/
        //gs($data['sales']);


        /* $old_date=Date('Y-m-d', strtotime("-30 days"));
        $current_date=Date('Y-m-d');
        $total_days=array();
        for ($i=$old_date; $i<$current_date; $i++) { 
        $total_days[ =$i;
        }
        print_r($total_days); exit;*/
        //echo $current_date; exit;

        
        // CURRENT MONTH ACTIVITY
        $current_month_activity =  $this->dashboard_model->getMothActivity();
        if($current_month_activity){
          $data['current_month_activity'] = $current_month_activity;
        }

        // TODAY'S NEXT APPOINTMENTS
        $next_appointments =  $this->dashboard_model->getTodaysNextAppointments();
        if($next_appointments){
          $data['next_appointments'] = $next_appointments;
        }

        // TOP SERVICES 
        $top_service =  $this->dashboard_model->getTopService();
        if($top_service){
          $data['top_service'] = $top_service;
        }
        

        // TOP STAFFS
        $top_staff =  $this->dashboard_model->getTopStaff();
       // gs($top_staff );
        if($top_staff){
          $data['top_staff'] = $top_staff;
      }

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

        if($admin_session['role']=="location_owner")
        {
            $this->db->where('location_id',$admin_session['location_id']);
            
        }
      $get_next_appointments=$this->db->get()->result_array();
    //  print_r($this->db->last_query()); exit;
      $currentday_new_booking=0;
      $firstday_new_booking=0;
      $second_new_booking=0;
      $thirday_new_booking=0;
      $fourday_new_booking=0;
      $fiveday_new_booking=0;
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
      $data['currentday_new_booking']=$currentday_new_booking;
      $data['firstday_new_booking']=$firstday_new_booking;
      $data['second_new_booking']=$second_new_booking;
      $data['thirday_new_booking']=$thirday_new_booking;
      $data['fourday_new_booking']=$fourday_new_booking;
      $data['fiveday_new_booking']=$fiveday_new_booking;

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
        if($admin_session['role']=="location_owner")
        {
            $this->db->where('location_id',$admin_session['location_id']);
            
        }
      $getConfirmedAppointments=$this->db->get()->result_array();
    //  print_r($this->db->last_query()); exit;
      $currentday_confirmed_booking=0;
      $firstday_confirmed_booking=0;
      $second_confirmed_booking=0;
      $thirday_confirmed_booking=0;
      $fourday_confirmed_booking=0;
      $fiveday_confirmed_booking=0;
      foreach ($getConfirmedAppointments as $key => $value) {
        if (date('Y-m-d')== $value['start_date']) {
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
      $data['currentday_confirmed_booking']=$currentday_confirmed_booking;
      $data['firstday_confirmed_booking']=$firstday_confirmed_booking;
      $data['second_confirmed_booking']=$second_confirmed_booking;
      $data['thirday_confirmed_booking']=$thirday_confirmed_booking;
      $data['fourday_confirmed_booking']=$fourday_confirmed_booking;
      $data['fiveday_confirmed_booking']=$fiveday_confirmed_booking;

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
        if($admin_session['role']=="location_owner")
        {
            $this->db->where('location_id',$admin_session['location_id']);
            
        }
      $getCancelledAppointments=$this->db->get()->result_array();
    //  print_r($this->db->last_query()); exit;
      $currentday_cancelled_booking=0;
      $firstday_cancelled_booking=0;
      $second_cancelled_booking=0;
      $thirday_cancelled_booking=0;
      $fourday_cancelled_booking=0;
      $fiveday_cancelled_booking=0;
      foreach ($getCancelledAppointments as $key => $value) {
        if (date('Y-m-d')== $value['start_date']) {
           $currentday_cancelled_booking=+$value['total_booking'];
        }
         if (date('Y-m-d', strtotime('+1 day', strtotime($fromdate)))== $value['start_date']) {
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
      $data['currentday_cancelled_booking']=$currentday_cancelled_booking;
      $data['firstday_cancelled_booking']=$firstday_cancelled_booking;
      $data['second_cancelled_booking']=$second_cancelled_booking;
      $data['thirday_cancelled_booking']=$thirday_cancelled_booking;
      $data['fourday_cancelled_booking']=$fourday_cancelled_booking;
      $data['fiveday_cancelled_booking']=$fiveday_cancelled_booking;

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
        if($admin_session['role']=="location_owner")
        {
            $this->db->where('location_id',$admin_session['location_id']);
            
        }
         $this->db->where('pay_service_type',1);        
          $getservice=$this->db->get()->result_array();

      $currentday_services_booking=0;
      $firstday_services_booking=0;
      $second_services_booking=0;
      $thirday_services_booking=0;
      $fourday_services_booking=0;
      $fiveday_services_booking=0;
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
      $data['currentday_services_booking']=$currentday_services_booking;
      $data['firstday_services_booking']=$firstday_services_booking;
      $data['second_services_booking']=$second_services_booking;
      $data['thirday_services_booking']=$thirday_services_booking;
      $data['fourday_services_booking']=$fourday_services_booking;
      $data['fiveday_services_booking']=$fiveday_services_booking;



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
        if($admin_session['role']=="location_owner")
        {
            $this->db->where('location_id',$admin_session['location_id']);
            
        }
         $this->db->where('pay_service_type',4);        
          $getProduct=$this->db->get()->result_array();

      $currentday_product_booking=0;
      $firstday_product_booking=0;
      $second_product_booking=0;
      $thirday_product_booking=0;
      $fourday_product_booking=0;
      $fiveday_product_booking=0;
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
      $data['currentday_product_booking']=$currentday_product_booking;
      $data['firstday_product_booking']=$firstday_product_booking;
      $data['second_product_booking']=$second_product_booking;
      $data['thirday_product_booking']=$thirday_product_booking;
      $data['fourday_product_booking']=$fourday_product_booking;
      $data['fiveday_product_booking']=$fiveday_product_booking;



       
    		$data['dashboard_active_open']=true;
        //echo "<pre>"; print_r($data['top_staff']); exit;
    		$this->load->view('admin/dashboard',$data);
    		//$this->load->view('admin/service/appointment_calendar');

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
      $this->load->view('admin/dashboard_owner',$data);
    }    

	}

	public function set_business(){
    	$business_id = $this->input->post('bid');
    	$_SESSION['admin_logged_in']['business_id'] = $business_id;
    	$previous_page = $this->session->userdata('previous_page');
			redirect($_SERVER['HTTP_REFERER']);
    }


}
