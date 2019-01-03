<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Reports extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('reports_model', '', TRUE);
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
		
		public function index(){
			
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				//$data=$this->input->post();
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['sale_date'] = $sale_date = $this->input->post('sale_date');
			}
			$this->db->select('invoice_services.*, sum(invoice_services.service_qty) AS total_service_qty, sum(invoice_services.service_total_price) AS total_service_total_price');
			$this->db->from('invoice_services');
			$this->db->join('invoices','invoices.id=invoice_services.invoice_id','inner');
			$this->db->where('invoices.invoice_status <>',5);
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoice_services.business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner'|| $admin_session['role']=='staff') {
				$this->db->where('invoice_services.location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0) {
				$this->db->where('invoice_services.location_id',$location_id);
			}
			if (isset($sale_date) && $sale_date!='') {
				$sale_date=date("Y-m-d", strtotime($sale_date) );
				//$this->db->like('date_created',$sale_date);
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d") ="'.$sale_date. '" ');
			}
			
			if (!$this->input->post('search_filter') ) {
				$today=date("Y-m-d");
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d") ="'.$today. '" ');
			}	
			
			$this->db->group_by('invoice_services.pay_service_type');
			$invoice_services =$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
			//echo "<pre>"; print_r($invoice_services); exit;
			
			$data['invoice_services']=$invoice_services;
			$data['reports_active_open']=true;
			//print_r($data['select_location_id']); exit;
			$this->load->view('admin/reports/product_sales_reports', $data);
		}
		
		public function product_alert()
		{
			$arr_search = array();
			$filter = array();
			$per_page = '';
			$config['per_page'] = $per_page;
			$config['offset'] = '';
			$admin_session = $this->session->userdata('admin_logged_in');
			
			// check whethter filter is apply or not
			if($this->input->post('search_filter'))
			{
				if($admin_session['role']=="business_owner"){
					$data['business_id'] = $business_id = $admin_session['business_id'];
					}else{
					$data['business_id'] = $business_id = $this->input->post('business_id');
				}
				
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['sku'] = $sku = $this->input->post('sku');
				$data['product_name'] = $product_name = $this->input->post('sku');
				
				if(!empty($business_id)){
					$filter['pl.business_id'] =$business_id;
				}
				if(!empty($location_id)){
					$filter['pl.location_id'] =$location_id;
				}
				if(!empty($sku)){
					$filter['p.sku'] =$sku;
					$filter['p.product_name'] =$sku;
					
				}
				
			}
			
			$all_records = $this->reports_model->get_product_details(false,$arr_search,$per_page, $config['offset'],"p.date_created","DESC",$filter);
			if($all_records){
				$data['all_records']= $all_records;
				$count_all_records = $this->reports_model->get_product_details(true,$arr_search);
				$config['total_rows'] = $count_all_records;
				$data['total_records'] = $count_all_records;
			}
			// get all business
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business){
				$data['all_business'] = $all_business;
			}
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/product_alert_reports', $data);
		}
		
		
		public function reports_customer()
		{
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			
			$this->db->select('customer.*,location.location_name,location.id AS location_id ');
			$this->db->from('customer');
			$this->db->join('location','location.id=customer.location_id','inner');
			
			
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('customer.business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('customer.location_id',$admin_session['location_id']);
				
			}
			
			if ($this->input->post('search_filter')) {
				
				$data['location_id']=$location_id=$this->input->post('location_id');
				$this->db->where('location.id',$location_id);
			}			
			$data['customers'] = $this->db-> get()->result();
			
			$this->db->select('customer.*,location.location_name,location.id AS location_id ');
			$this->db->from('customer');
			$this->db->join('location','location.id=customer.location_id','inner');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('customer.business_id',$admin_session['business_id']);
			}	
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('customer.location_id',$admin_session['location_id']);
				
			}
			$this->db->group_by('location.id');
			
			$data['locations'] = $this->db-> get()->result();
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/reports_customer', $data);
		}
		
		
		public function reports_appointment()
		{
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			
			$this->db->select('staff.first_name AS staff_first_name,staff.last_name AS staff_last_name,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,booking_services.book_start_time,booking_services.book_duration,bookings.date_created,bookings.start_date,bookings.booking_number,bookings.id AS bookings_id ,customer.mobile_number AS customer_mobile_number,customer.email AS customer_email,location.location_name,service_timing.caption AS service_timing_caption,bookings.start_time,service_timing.retail_price,service_timing.special_price,bookings.booking_status,customer.id AS customer_id,location.id AS location_id');		
			$this->db->from('bookings');
			$this->db->join('booking_services','bookings.id=booking_services.booking_id','inner');
			$this->db->join('staff','staff.id=booking_services.staff_id','inner');
			$this->db->join('customer','customer.id=bookings.customer_id','Left');
			$this->db->join('location','location.id=bookings.location_id','inner');
			$this->db->join('service_timing','service_timing.id=booking_services.service_id','left');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('bookings.business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('bookings.location_id',$admin_session['location_id']);
				
			}
			
			
			if ($this->input->post('search_filter')) {
				
				$data['from_date']=$from_date=$this->input->post('from_date');
				$data['to_date']=$to_date=$this->input->post('to_date');
				$data['location_id']=$location_id=$this->input->post('location_id');
				$data['status']=$status=$this->input->post('status');
				$data['staff_id']=$staff_id=$this->input->post('staff_id');
				
				if (isset($from_date) && $from_date!='' ) {
					$from_date=date("Y-m-d", strtotime($from_date) );
					$this->db->where('DATE_FORMAT(bookings.start_date, "%Y-%m-%d")>="'.$from_date. '" ');
				}
				
				if ( isset($to_date)  && $to_date!='') {
					$to_date=date("Y-m-d", strtotime($to_date) );
					$this->db->where('DATE_FORMAT(bookings.start_date, "%Y-%m-%d")<="'.$to_date. '" ');
				}		
				/*if ($booking_date!='') {
					$booking_date=date('Y-m-d',strtotime($booking_date));
					$this->db->where('bookings.start_date',$booking_date);
				}*/
				
				if ($location_id!='') {
					$this->db->where('bookings.location_id',$location_id);
				}
				if ($status>=0) {
					$this->db->where('bookings.booking_status',$status);
				}
				
				if ($staff_id!='') {
					$this->db->where('bookings.staff_id',$staff_id);
				}
				
			}
			
			if (!$this->input->post('search_filter')) {
				
				$this->db->where('MONTH(bookings.start_date)',date('m'));
			}
			$this->db->group_by('bookings.booking_number');					
			$data['bookings'] = $this->db->get()->result();	
			//echo $this->db->last_query(); die;
			$this->db->select('location.location_name,location.id AS location_id');		
			$this->db->from('bookings');
			$this->db->join('booking_services','bookings.id=booking_services.booking_id','inner');
			$this->db->join('staff','staff.id=booking_services.staff_id','inner');
			$this->db->join('customer','customer.id=bookings.customer_id','Left');
			$this->db->join('location','location.id=bookings.location_id','inner');
			$this->db->join('service_timing','service_timing.id=booking_services.service_id','inner');
			
			
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('bookings.business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('bookings.location_id',$admin_session['location_id']);
				
			}
			$this->db->group_by('bookings.location_id');
			
			$data['locations'] = $this->db-> get()->result();
			
			/*$this->db->select('staff.first_name AS staff_first_name,staff.last_name AS staff_last_name,staff.id AS staff_id ');		
				$this->db->from('bookings');
				$this->db->join('staff','staff.id=bookings.staff_id','inner');
				if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('bookings.business_id',$admin_session['business_id']);
				}
				
				if($admin_session['role']=="location_owner")
				{
				$this->db->where('bookings.location_id',$admin_session['location_id']);
				
				}
				
				$this->db->group_by('staff.id');
			$data['staffs'] = $this->db-> get()->result();*/
			
			$this->db->select('first_name AS staff_first_name,last_name AS staff_last_name,id AS staff_id ');
			$this->db->from('staff');		
			$this->db->where('status',1);
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('location_id',$admin_session['location_id']);
				
			}
			
			
			$data['staffs'] = $this->db->get()->result();
			
			
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/reports_appointment', $data);
		}
		
		public function reports_voucher()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			$this->db->select('*');
			$this->db->from('vouchers');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			
			if ($this->input->post('search_filter')) {
				$data=$this->input->post();
				$from_date=$this->input->post('from_date');
				$to_date=$this->input->post('to_date');
				$allow_online=$this->input->post('allow_online');
				$status=$this->input->post('status');
				
				/*if ($expiry_date!='') {
					$expiry_date=date('Y-m-d',strtotime($expiry_date));
					$this->db->where('expiry_date',$expiry_date);
				}*/
				
				if (isset($from_date) && $from_date!='' ) {
					$from_date=date("Y-m-d", strtotime($from_date) );
					$this->db->where('DATE_FORMAT(expiry_date, "%Y-%m-%d")>="'.$from_date. '" ');
				}
				
				if ( isset($to_date)  && $to_date!='') {
					$to_date=date("Y-m-d", strtotime($to_date) );
					$this->db->where('DATE_FORMAT(expiry_date, "%Y-%m-%d")<="'.$to_date. '" ');
				}
				
				if ($allow_online!='') {
					$this->db->where('allow_online',$allow_online);
				}
				if ($status!='') {
					$this->db->where('status',$status);
				}
				
			}			
			$data['vouchers'] = $this->db-> get()->result();
			//echo $this->db->last_query(); exit;
			
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/reports_voucher', $data);
		}
		
		public function reports_invoice()
		{
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			
			$this->db->select('invoices.*,location.id AS location_id ,location.location_name,customer.first_name AS customer_first_name,customer.last_name AS customer_last_name,customer.id AS customer_id, invoices.id AS invoices_id  ');
			$this->db->from('invoices');
			$this->db->join('location','location.id=invoices.location_id','inner');
			$this->db->join('customer','customer.id=invoices.customer_id','inner');
			
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoices.business_id',$admin_session['business_id']);
			}
			
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('invoices.location_id',$admin_session['location_id']);
			}
			
			if ($this->input->post('search_filter')) {
				//print_r($_POST); exit;
				$data=$this->input->post();
				$from_date=$this->input->post('from_date');
				$to_date=$this->input->post('to_date');
				$location_id=$this->input->post('location_id');
				$status=$this->input->post('status');
				
				if (isset($from_date) && $from_date!='' ) {
					$from_date=date("Y-m-d", strtotime($from_date) );
					$this->db->where('DATE_FORMAT(invoices.date_created, "%Y-%m-%d")>="'.$from_date. '" ');
				}
				
				if ( isset($to_date)  && $to_date!='') {
					$to_date=date("Y-m-d", strtotime($to_date) );
					$this->db->where('DATE_FORMAT(invoices.date_created, "%Y-%m-%d")<="'.$to_date. '" ');
				}
				
				/*if ($invoice_date!='') {
					$invoice_date=date('Y-m-d',strtotime($invoice_date));
					//$this->db->where('invoices.date_created',$invoice_date);
					$this->db->like('invoices.date_created',$invoice_date);
				}*/
				
				if ($location_id>0) {
					$this->db->where('invoices.location_id',$location_id);
				}
				if ($status>=0) {
					$this->db->where('invoices.invoice_status',$status);
				}
				
			}
			$this->db->group_by('invoices.invoice_number');
			
			
			$data['invoices'] = $this->db-> get()->result();	
			$this->db->select('location.id AS location_id ,location.location_name');
			$this->db->from('invoices');
			$this->db->join('location','location.id=invoices.location_id','inner');
			$this->db->join('customer','customer.id=invoices.customer_id','inner');
			
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoices.business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('invoices.location_id',$admin_session['location_id']);
			}
			$this->db->group_by('invoices.location_id');
			$data['locations'] = $this->db-> get()->result();
			//echo $this->db->last_query(); exit;
			$data['admin_session']=$admin_session;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/reports_invoice', $data);
		}
		
		public function sale_by_staff()
		{		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');
			}
			$this->db->select('invoice_services.*,sum(invoice_services.service_qty) AS total_service_qty, sum(case when (pay_service_type = 7) THEN 0 ELSE invoice_services.service_total_price END) AS total_service_total_price, sum(case when (pay_service_type = 7) THEN invoice_services.service_total_price ELSE 0 END) AS total_service_discount_price,sum(case when (pay_service_type = 8) THEN invoice_services.service_total_price ELSE 0 END) AS total_voucher_applied,sum(invoice_services.service_total_price - invoice_services.service_unit_price) AS  total_tax_amount,DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d" ) AS created_at ');
			$this->db->from('invoice_services');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoice_services.business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('invoice_services.location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0) {
				$this->db->where('invoice_services.location_id',$location_id);
			}	
			
			if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d")>="'.$from_date. '" ');
			}
			
			if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d")<="'.$to_date. '" ');
			}
			$this->db->where('invoice_services.pay_service_type !=',9);

			$this->db->group_by('invoice_services.staff_id');
			$invoice_services =$this->db->get()->result_array();
				//print_r($this->db->last_query()); exit;
			$data['invoice_services']=$invoice_services;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/sale_by_staff', $data);
		}
		
		public function sale_by_day()
		{		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');
			}
			// $this->db->select('*,sum(service_qty) AS total_service_qty,sum(service_total_price) AS total_service_total_price,sum(service_discount_price) AS total_service_discount_price,sum(tax_amount) AS  total_tax_amount,DATE_FORMAT(date_created, "%Y-%m-%d" ) AS created_at ');
			
			$this->db->select('invoice_services.*,sum(invoice_services.service_qty) AS total_service_qty, sum(case when (pay_service_type = 7) THEN 0 ELSE invoice_services.service_total_price END) AS total_service_total_price, sum(case when (pay_service_type = 7) THEN invoice_services.service_total_price ELSE 0 END) AS total_service_discount_price,sum(case when (pay_service_type = 8) THEN invoice_services.service_total_price ELSE 0 END) AS total_voucher_applied,sum(invoice_services.tax_amount) AS  total_tax_amount,DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d" ) AS created_at ');
			$this->db->from('invoice_services');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0 ) {
				$this->db->where('location_id',$location_id);
			}
			if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d")>="'.$from_date. '" ');
			}
			
			if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d")<="'.$to_date. '" ');
			}
			if (!$this->input->post('search_filter')) {
				$this->db->where('MONTH(date_created)',date('m'));
			}
			
			$this->db->group_by('created_at');
			$this->db->order_by('created_at','DESC');
			$invoice_services =$this->db->get()->result_array();
			//echo $this->db->last_query(); die;
			$data['invoice_services']=$invoice_services;
			//echo "<pre>"; print_r($data['invoice_services']); exit;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/sale_by_day', $data);
		}
		
		
		public function sale_by_month()	{		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');
			}
			// $this->db->select('*,sum(service_qty) AS total_service_qty,sum(service_total_price) AS total_service_total_price,sum(service_discount_price) AS total_service_discount_price,sum(tax_amount) AS  total_tax_amount,DATE_FORMAT(date_created, "%Y-%m-%d" ) AS created_at ');
			$this->db->select('invoice_services.*,sum(invoice_services.service_qty) AS total_service_qty, sum(case when (pay_service_type = 7) THEN 0 ELSE invoice_services.service_total_price END) AS total_service_total_price, sum(case when (pay_service_type = 7) THEN invoice_services.service_total_price ELSE 0 END) AS total_service_discount_price,sum(case when (pay_service_type = 8) THEN invoice_services.service_total_price ELSE 0 END) AS total_voucher_applied,sum(invoice_services.tax_amount) AS  total_tax_amount,DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d" ) AS created_at ');
			
			$this->db->from('invoice_services');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0 ) {
				$this->db->where('location_id',$location_id);
			}
			/*if (isset($from_date) && isset($to_date) ) {
				//$this->db->where('date_created BETWEEN "'.$from_date. '" and "'.$to_date.'"');
				$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d") BETWEEN "'.$from_date. '" and "'.$to_date.'"');
			}*/
			if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d")>="'.$from_date. '" ');
			}
			
			if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d")<="'.$to_date. '" ');
			}
			
			if(!$this->input->post('search_filter'))
			{
				$this->db->where('YEAR(date_created)',date('Y'));
			}
			$this->db->group_by('MONTH(created_at)');
			$invoice_services =$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
			$data['invoice_services']=$invoice_services;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/sale_by_month', $data);
		}
		
		
		public function report_inventory()
		{		
			$arr_search = array();
			$filter = array();
			$per_page = '';
			$config['per_page'] = $per_page;
			$config['offset'] = '';
			$admin_session = $this->session->userdata('admin_logged_in');
			
			// check whethter filter is apply or not
			if($this->input->post('search_filter'))
			{
				//echo "<pre>"; print_r($this->input->post()); exit;
				if($admin_session['role']=="business_owner"){
					$data['business_id'] = $business_id = $admin_session['business_id'];
					}else{
					$data['business_id'] = $business_id = $this->input->post('business_id');
				}				
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['bar_code'] = $sku = $this->input->post('sku');
				$data['product_name'] = $product_name = $this->input->post('sku');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');

				$data['brand_id'] = $brand_id = $this->input->post('brand_id');
				$data['brand_sub_category_id'] = $brand_sub_category_id = $this->input->post('brand_sub_category_id');
				$data['product_category_id'] = $product_category_id = $this->input->post('product_category_id');

				$data['is_product_alert'] = $is_product_alert = $this->input->post('is_product_alert');

				

			}
			
			
			$this->db->select('p.id pid,p.product_name pname,p.sku psku,p.bar_code bar_code,p.alert_quantity p_alrtqty,p.purchase_price p_pprice,p.retail_price p_rprice,pl.location_id pl_locid,sum(pl.quantity) as totalstcokqty,p.category_id,p.brand_id,p.brand_category_id');    
			$this->db->from('product p');
			$this->db->join('product_locationwise pl', 'pl.product_id=p.id','inner');
			//$this->db->where('p.business_id');
			$this->db->group_by('pl.product_id');
			$this->db->group_by('pl.location_id');
			$admin_session = $this->session->userdata('admin_logged_in');
			if($admin_session['role']=="business_owner")
			{
				$this->db->where('p.business_id',$admin_session['business_id']);
				
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=='staff')
			{
				$this->db->where('pl.location_id',$admin_session['location_id']);
				
			}
			if(isset($location_id) && $location_id>0 ){
				$this->db->where('pl.location_id', $location_id);
			}
			if(!empty($sku)){
				$this->db->like('p.bar_code', $sku);
			}

			if(isset($brand_id) && $brand_id>0 ){
				$this->db->where('p.brand_category_id', $brand_id);
			}

			if(isset($brand_sub_category_id) && $brand_sub_category_id>0 ){
				$this->db->where('p.brand_id', $brand_sub_category_id);
			}

			if(isset($product_category_id) && $product_category_id>0 ){
				$this->db->where('p.category_id', $product_category_id);
			}


			
			/*if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(pl.date_created, "%Y-%m-%d")>="'.$from_date. '" ');
			}*/
			
			/*if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(pl.date_created, "%Y-%m-%d")<="'.$to_date. '" ');
			}*/
			//$this->db->where('MONTH(p.date_created)',date('m'));
			
			
			/*if (!$this->input->post('search_filter')) {
				
				$this->db->where('MONTH(p.date_created)',date('m'));
			}	*/
			
			
			$data['all_records']=$this->db->get()->result_array();


			$data['brand'] = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>1])->get()->result_array();

			$data['category'] = $this->db->select('*')->from('product_category')->where(['business_id'=>$admin_session['business_id']])->get()->result_array();

			$data['brand_sub_category'] = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>2])->get()->result_array();

			


			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business){
				$data['all_business'] = $all_business;
			}
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/report_inventory', $data);
		}
		
		
		public function daily_cash(){	
			
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');
			}
			
			$this->db->select('*');
			$this->db->from('pos_daily');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id) {
				$this->db->where('location_id',$location_id);
			}
			
			if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(open_date, "%Y-%m-%d")>="'.$from_date. '" ');
			}
			
			if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(open_date, "%Y-%m-%d")<="'.$to_date. '" ');
			}
			
			/*if (isset($from_date) && isset($to_date) ) {
				//$this->db->where('open_date BETWEEN "'.$from_date. '" and "'.$to_date.'"');
				$this->db->where('DATE_FORMAT(open_date, "%Y-%m-%d") BETWEEN "'.$from_date. '" and "'.$to_date.'"');
			}*/
			$this->db->where('MONTH(open_date)',date('m'));
			
			//DATE_FORMAT(date_created, "%Y-%m-%d")
			
			$todayopening =$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
			
			$data['todayopening']=$todayopening;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/daily_cash', $data);
		}
		
		
		public function staff_commission(){		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
			}
			$this->db->select('*');
			$this->db->from('staff');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0 ) {
				$this->db->where('location_id',$location_id);
			}
			
			$get_staff =$this->db->get()->result_array();
			$data['get_staff']=$get_staff;
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/staff_commission', $data);
		}
		
		public function getStaffbyLocationId()
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			$location_id = $this->input->post('location_id');
			
			$this->db->select('*');
			$this->db->from('staff');		
			$this->db->where('location_id',$location_id);
			$this->db->where('status',1);
			
			$record=$this->db->get()->result_array();
			
			if(count((array)$record) > 0){
				
				$staff_html = '<select class="form-control staff"  name="staff_id" id="staff_id">';
				$staff_html .= '<option value="">All Staff</option>';
				foreach($record as $cat){
					$staff_html .='<option value="'.$cat['id'].'">'.$cat['first_name']. ' ' .$cat['last_name'].'</option>';
				}
				$staff_html .='</select>';
				
				//echo json_encode($record);
				} else {
				$staff_html = '<select class="form-control" name="staff_id" id="staff_id">';
				$staff_html .= '<option value="0">Select Staff</option>';
				$staff_html .='</select>';
			}
	        $status = 'success';
			$jsonEncode = json_encode(array('status' => $status,'staff_html' => $staff_html));
			echo $jsonEncode;
			
		}
		
		//Pre Gst Manager
		
		public function pre_gst_manager()	{		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$this->db->select('SUM(case when (payment_type_id)=5 then paid_amount end) As Cash, 
				SUM(case when (payment_type_id)=6 then paid_amount end) As Card,
				SUM(case when (payment_type_id)=7 then paid_amount end) As Voucher,
				SUM(case when (payment_type_id)=8 then paid_amount end) As Other,
				MONTH(paid_date) AS MONTH,YEAR(paid_date) AS YEAR,location_id,business_id');
				$this->db->from('invoice_payments');
				if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
					$this->db->where('location_id',$admin_session['location_id']);
				}
				
				
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['year'] = $year = $this->input->post('year');
				$data['month'] = $month = $this->input->post('month');
					
					if ($this->input->post('location_id')) {
					$this->db->where('location_id',$location_id);
				}		
				
				$this->db->where('MONTH(paid_date)',$month);
				$this->db->where('YEAR(paid_date)',$year);
				$this->db->group_by('MONTH(paid_date)');
				$month_payments =$this->db->get()->row_array();
				//print_r($this->db->last_query()); exit;

				$data['month_payments']=$month_payments;
				
				$this->db->select('*');
				$this->db->from('pre_gst_settings');		
				$location_id = $this->input->post('location_id');
				$this->db->where('location_id',$location_id);
				$gst_settings =$this->db->get()->row_array();
				$data['gst_settings']=$gst_settings;
			}
			
			$this->db->select('*');
			$this->db->from('pre_gst_management');		
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			$gst_management =$this->db->get()->result_array();
			$data['gst_management']=$gst_management;
			
			
			$this->db->select('YEAR(paid_date) AS year');
			$this->db->from('invoice_payments');
			$this->db->group_by('YEAR(paid_date)');
			$gst_year =$this->db->get()->result_array();
			$data['gst_year']=$gst_year;
			
			
			$this->db->select('*')->from('business');
			if ($admin_session['business_id']!='') {
				$this->db->where('id',$admin_session['business_id']);
			}
			$data['tax_service_percent']=$this->db->get()->row_array();
			
			
			//echo "<pre>"; print_r($data); exit;
			
			$data['pre_gst_manager_active_open']=true;
			$this->load->view('admin/reports/pre_gst_manager', $data);
		}
		
		
		public function pre_gst_management()	{
			
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('action')){
				$data=$this->input->post();
				$business_id=$this->input->post('business_id');
				$location_id=$this->input->post('location_id');
				$year=$this->input->post('year');
				$month=$this->input->post('month');
				$cash=$this->input->post('cash');
				$card=$this->input->post('card');			
				$voucher=$this->input->post('voucher');
				$others=$this->input->post('others');
				$total=$this->input->post('total');
				//print_r($data); exit;
				$pdf_id=time();
				$this->load->helper('dompdf');
				$this->load->library('dompdf_gen');
				$this->load->view("admin/reports/pre_gst_pdf",$data);
				$html = $this->output->get_output();				
				$this->dompdf->load_html($html);
				$this->dompdf->render();
				file_put_contents('uploads/pregst/'.$pdf_id.".pdf", $this->dompdf->output());
				$invoice_id='uploads/pregst/'.$pdf_id.".pdf";
				$insert_array = [
				'business_id'=>$business_id,
				'location_id'=>$location_id,
				'year'=>$year,
				'month'=>$month,
				'cash'=>$cash,
				'card'=>$card,
				'gift_voucher'=>$voucher,
				'others'=>$others,
				'total'=>$total,
				'pdf_id'=>$invoice_id,												
				'created_date'=>date("Y-m-d H:i:s"),
				];
				$insert = $this->others->insert_data("pre_gst_management",$insert_array);
				$this->session->set_flashdata('success_msg', "Pre Gst  is added successfully!");
				redirect(base_url('admin/reports/pre_gst_manager/'));
			}
			
		}
		
		
		public function send_mail_management(){
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			$management_id = $this->input->post('management_id');
			if($this->input->post('email') && $management_id>0 ){
				
				$email = $this->input->post('email');
				$this->db->select('*');
				$this->db->from('pre_gst_management');
				$this->db->where('id',$management_id);	
				$management_details=$this->db->get()->row_array();
				$business_name = getBusinessNameById($management_details['business_id']);		
				$location_deatils=getLocationData($management_details['location_id']);			
				$invoice_email= getEmailTemplate($management_details['business_id'],'pre-gst');
				//print_r($invoice_email); exit;
				$month= date("F", mktime(0, 0, 0, $management_details['month'], 10));
				//$subject = str_replace($invoice_email['subject']);
				$this->db->select('*')->from('business');			
				$this->db->where('id',$management_details['business_id']);			
				$tax_service_percent=$this->db->get()->row_array();
				$totaltax=   $tax_service_percent['tax_service_percent']/100*$management_details['total'];
				$netamount=$management_details['total']- $totaltax;
				
				$subject = str_replace("{BUSINESS_NAME}",$business_name,$invoice_email['subject']);
				$mail_data = str_replace(["{BUSINESS_NAME}","{LOCATION_NAME}","{LOCATION_PHONE}","{MONTH}","{YEAR}","{TOTAL}"],[$business_name,$location_deatils['location_name'],$location_deatils['phone_number'],$month,$management_details['year'],$netamount],$invoice_email['email_html']);
				
				$invoice['subject'] = $subject;
				$invoice['mail_data'] = $mail_data;
				$mail_content = $this->load->view('booking-confirmation',$invoice,true);
				$mail = $this->config->item('mail_data');
				$this->load->library('email', $mail);
				$this->email->set_newline("\r\n");
				$this->email->from($this->config->item('default_mail'),$business_name);
				$list = array($email);
				$this->email->to($list);
				$this->email->subject($subject);
				$this->email->message($mail_content);
				$this->email->attach(base_url($management_details['pdf_id']));
				$this->email->send();
				$this->session->set_flashdata('success_msg', "Email sent successfully!");
				redirect(base_url('admin/reports/pre_gst_manager/'));
			}
			
			else{
				$this->session->set_flashdata('error_msg', "Email not sent!");
				redirect(base_url('admin/reports/pre_gst_manager/'));
			}
			
			
		}
		
		//End
		
		
		
		// Gst ATO Manager
		
		public function gst_ato_manager()	{		
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$this->db->select('SUM(case when (payment_type_id)=5 then paid_amount end) As Cash, 
				SUM(case when (payment_type_id)=6 then paid_amount end) As Card,
				SUM(case when (payment_type_id)=7 then paid_amount end) As Voucher,
				SUM(case when (payment_type_id)=8 then paid_amount end) As Other,
				MONTH(paid_date) AS MONTH,YEAR(paid_date) AS YEAR,location_id,business_id');
				$this->db->from('invoice_payments');
				if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
					$this->db->where('business_id',$admin_session['business_id']);
				}
				if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
					$this->db->where('location_id',$admin_session['location_id']);
				}
				
				
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['year'] = $year = $this->input->post('year');
				$data['month'] = $month = $this->input->post('month');	
				if ($this->input->post('location_id')) {
				$this->db->where('location_id',$location_id);
						}		
				
				$this->db->where('MONTH(paid_date)',$month);
				$this->db->where('YEAR(paid_date)',$year);
				$this->db->group_by('MONTH(paid_date)');
				$month_payments =$this->db->get()->row_array();
				$data['month_payments']=$month_payments;
				
				$this->db->select('*');
				$this->db->from('gst_ato_settings');		
				$location_id = $this->input->post('location_id');
				$this->db->where('location_id',$location_id);
				$gst_settings =$this->db->get()->row_array();
				$data['gst_settings']=$gst_settings;
			}
			
			$this->db->select('*');
			$this->db->from('gst_ato_management');		
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('location_id',$admin_session['location_id']);
			}
			$gst_management =$this->db->get()->result_array();
			$data['gst_management']=$gst_management;
			
			
			$this->db->select('YEAR(paid_date) AS year');
			$this->db->from('invoice_payments');
			$this->db->group_by('YEAR(paid_date)');
			$gst_year =$this->db->get()->result_array();
			$data['gst_year']=$gst_year;
			
			
			$data['gst_ato_manager_active_open']=true;
			$this->load->view('admin/reports/gst_ato_manager', $data);
		}
		
		
		public function gst_ato_management()	{
			
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('action')){
				$data=$this->input->post();
				$business_id=$this->input->post('business_id');
				$location_id=$this->input->post('location_id');
				$year=$this->input->post('year');
				$month=$this->input->post('month');
				$cash=$this->input->post('cash');
				$card=$this->input->post('card');			
				$voucher=$this->input->post('voucher');
				$others=$this->input->post('others');
				$total=$this->input->post('total');
				//print_r($data); exit;
				$pdf_id=time();
				$this->load->helper('dompdf');
				$this->load->library('dompdf_gen');
				$this->load->view("admin/reports/pre_gst_pdf",$data);
				$html = $this->output->get_output();				
				$this->dompdf->load_html($html);
				$this->dompdf->render();
				file_put_contents('uploads/gstato/'.$pdf_id.".pdf", $this->dompdf->output());
				$invoice_id='uploads/gstato/'.$pdf_id.".pdf";
				$insert_array = [
				'business_id'=>$business_id,
				'location_id'=>$location_id,
				'year'=>$year,
				'month'=>$month,
				'cash'=>$cash,
				'card'=>$card,
				'gift_voucher'=>$voucher,
				'others'=>$others,
				'total'=>$total,
				'pdf_id'=>$invoice_id,												
				'created_date'=>date("Y-m-d H:i:s"),
				];
				$insert = $this->others->insert_data("gst_ato_management",$insert_array);
				$this->session->set_flashdata('success_msg', "Gst ATO is added successfully!");
				redirect(base_url('admin/reports/gst_ato_manager/'));
			}
			
		}
		
		
		public function send_ato_mail_management(){
			$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			$management_id = $this->input->post('management_id');
			if($this->input->post('email') && $management_id>0 ){
				
				$email = $this->input->post('email');
				$this->db->select('*');
				$this->db->from('gst_ato_management');
				$this->db->where('id',$management_id);	
				$management_details=$this->db->get()->row_array();
				$business_name = getBusinessNameById($management_details['business_id']);		
				$location_deatils=getLocationData($management_details['location_id']);			
				$invoice_email= getEmailTemplate($management_details['business_id'],'gst_ato');
				//print_r($invoice_email); exit;
				$month= date("F", mktime(0, 0, 0, $management_details['month'], 10));
				//$subject = str_replace($invoice_email['subject']);
				$subject = str_replace("{BUSINESS_NAME}",$business_name,$invoice_email['subject']);
				$mail_data = str_replace(["{BUSINESS_NAME}","{LOCATION_NAME}","{LOCATION_PHONE}","{MONTH}","{YEAR}","{TOTAL}"],[$business_name,$location_deatils['location_name'],$location_deatils['phone_number'],$month,$management_details['year'],$management_details['total']],$invoice_email['email_html']);
				
				$invoice['subject'] = $subject;
				$invoice['mail_data'] = $mail_data;
				$mail_content = $this->load->view('booking-confirmation',$invoice,true);
				$mail = $this->config->item('mail_data');
				$this->load->library('email', $mail);
				$this->email->set_newline("\r\n");
				$this->email->from($this->config->item('default_mail'),$business_name);
				$list = array($email);
				$this->email->to($list);
				$this->email->subject($subject);
				$this->email->message($mail_content);
				$this->email->attach(base_url($management_details['pdf_id']));
				$this->email->send();
				$this->session->set_flashdata('success_msg', "Email sent successfully!");
				redirect(base_url('admin/reports/gst_ato_manager/'));
			}
			
			else{
				$this->session->set_flashdata('error_msg', "Email not sent!");
				redirect(base_url('admin/reports/gst_ato_manager/'));
			}
			
			
		}

		public function finances_summary()
		{
			$admin_session = $this->session->userdata('admin_logged_in');			
			$this->db->select('invoice_services.service_total_price AS total_amount,invoice_payments.payment_type_id,invoice_payments. pay_process_type, invoice_services.pay_service_type');
			$this->db->from('invoice_payments');
			$this->db->join('invoice_services','invoice_payments.invoice_id=invoice_services.invoice_id','inner');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoice_payments.business_id',$admin_session['business_id']);
			}

			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('invoice_payments.location_id',$admin_session['location_id']);
			}
			
			if ($this->input->post('search_filter')) {
				$data=$this->input->post();
				$from_date=$this->input->post('from_date');
				$to_date=$this->input->post('to_date');
				$location_id=$this->input->post('location_id');					
				if (isset($from_date) && $from_date!='' ) {
					$from_date=date("Y-m-d", strtotime($from_date) );

					$this->db->where('DATE_FORMAT(invoice_payments.paid_date, "%Y-%m-%d")>="'.$from_date. '" ');
				}				
				if ( isset($to_date)  && $to_date!='') {
					$to_date=date("Y-m-d", strtotime($to_date) );
					$this->db->where('DATE_FORMAT(invoice_payments.paid_date, "%Y-%m-%d")<="'.$to_date. '" ');
				}

				if ($location_id>0) {
				$this->db->where('invoice_payments.location_id',$location_id);
			}	
				
			}

			if (!$this->input->post('search_filter')) {
				$this->db->where('DATE_FORMAT(invoice_payments.paid_date, "%Y-%m-%d")="'.date('Y-m-d'). '" ');
			}
			$this->db->group_by('invoice_services.id');			
			$data['payments'] = $this->db-> get()->result_array();	
			//echo "<pre>"; print_r($data['payments']); exit;

			$data['reports_active_open']=true;
			$this->load->view('admin/reports/finances_summary', $data);
		}

		public function getBrandbyBrandCategary()
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		$brand_id = $this->input->post('brand_id');
			$record = $this->db->select('*')->from('product_brand')->where(['business_id'=>$admin_session['business_id'],'type'=>2,'category_id'=>$brand_id])->get()->result_array();

		if(count((array)$record) > 0){

				$staff_html = '<select class="form-control form-control-sm"  name="brand_sub_category_id" id="brand_sub_category_id">';
				$staff_html .= '<option value="">All Brand Sub Category</option>';
				foreach($record as $cat){
					$staff_html .='<option value="'.$cat['id'].'">'.$cat['brand_name']. ' </option>';
				}
				$staff_html .='</select>';;
			} else {
	           $staff_html = '<select class="form-control form-control-sm" name="brand_sub_category_id" id="brand_sub_category_id">';
				$staff_html .= '<option value="">All Brand Sub Category</option>';
				$staff_html .='</select>';
	        }
	        $status = 'success';
	         $jsonEncode = json_encode(array('status' => $status,'brand_sub_category' => $staff_html));
                echo $jsonEncode;

	}


	public function summary()
		{
		$data['admin_session']=$admin_session = $this->session->userdata('admin_logged_in');
			if($this->input->post('search_filter'))
			{
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$data['from_date'] = $from_date = $this->input->post('from_date');
				$data['to_date'] = $to_date = $this->input->post('to_date');
			}
			$this->db->select('invoice_services.*,sum(invoice_services.service_qty) AS total_service_qty, sum(case when (pay_service_type = 7) THEN 0 ELSE invoice_services.service_total_price END) AS total_service_total_price, sum(case when (pay_service_type = 7) THEN invoice_services.service_total_price ELSE 0 END) AS total_service_discount_price,sum(case when (pay_service_type = 8) THEN invoice_services.service_total_price ELSE 0 END) AS total_voucher_applied,sum(invoice_services.service_total_price - invoice_services.service_unit_price) AS  total_tax_amount,DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d" ) AS created_at ');
			$this->db->from('invoice_services');
			if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
				$this->db->where('invoice_services.business_id',$admin_session['business_id']);
			}
			if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {
				$this->db->where('invoice_services.location_id',$admin_session['location_id']);
			}
			if (isset($location_id) && $location_id>0) {
				$this->db->where('invoice_services.location_id',$location_id);
			}	
			
			if (isset($from_date) && $from_date!='' ) {
				$from_date=date("Y-m-d", strtotime($from_date) );
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d")>="'.$from_date. '" ');
			}
			
			if ( isset($to_date)  && $to_date!='') {
				$to_date=date("Y-m-d", strtotime($to_date) );
				$this->db->where('DATE_FORMAT(invoice_services.date_created, "%Y-%m-%d")<="'.$to_date. '" ');
			}
			$this->db->where('invoice_services.pay_service_type!=',9);
			$this->db->group_by('MONTH(date_created)');
			$this->db->group_by('YEAR(date_created)');
			$data['invoice_services'] =$this->db->get()->result_array();
			$data['reports_active_open']=true;
			$this->load->view('admin/reports/summary', $data);		
	}

}
