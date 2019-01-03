<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Expense extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('expense_model', '', TRUE);
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
			
			
			if($this->input->post('action')){
				
				$data['business_id'] = $this->input->post('business_id');
				$data['location_id'] = $this->input->post('location_id');
				
				
				
				
				$b_id = ($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff")?$admin_session['business_id']:$this->input->post('business_id') ; 
				$loc_id = ($admin_session['role']=="location_owner" || $admin_session['role']=="staff")?$admin_session['location_id']:$this->input->post('location_id') ;
				
				$this->load->library('form_validation');
				if($admin_session['role']=="owner"){
					$this->form_validation->set_rules('business_id', 'Business name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
				}
				if($admin_session['role']=="business_owner"){
					$this->form_validation->set_rules('location_id', 'Location Name', 'trim|required|xss_clean');
				}
				
				$this->form_validation->set_rules('open_cash', 'Amount', 'is_numeric|trim|required|xss_clean');	
				$this->form_validation->set_message('is_numeric', 'Amount should be numeric');
				
				if ($this->form_validation->run() == TRUE) {
					
					$data['open_cash'] = $open_cash= $this->input->post('open_cash');
					
					$insert_data = array(
					'business_id'=>$b_id,
					'location_id'=>$loc_id,
					'open_date'=>date('Y-m-d'),
					'open_cash'=>$this->input->post('open_cash'),
					);
					
					//print_r($insert_data); exit;
					$success = $this->others->insert_data("pos_daily",$insert_data);
					if ($success) {
						
						$this->session->set_flashdata('success_msg', "Register is open successfully!");
						redirect(base_url('admin/expense'));
						} else {
						$this->session->set_flashdata('error_msg', "Adding expense is failed!");
						redirect(base_url('admin/expense'));
					}
					
				}
				
				
			}
			
			//gs('dfdsf');
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"|| $admin_session['role']=="staff"){
				$location_condition = "";
				$location_condition = " business_id='".$admin_session['business_id']."' ";
				$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			$open_date = date('Y-m-d');
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$open_date = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id']])->get()->result_array();
				}else if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$open_date = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->row_array();
			}
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
			$data['all_business'] = $all_business;	
			
			if($open_date){
				$data['open_date']=$open_date;
			}
			
			//gs($data);
			$data['page']='expense';
			
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/open_register', $data);
			
		}
		
		public function today_sale($loc_id=null)
		{
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('action')){
				
				$data['start_date'] = $start_date = $this->input->post('start_date');
				$data['end_date'] = $end_date = $this->input->post('end_date');
				$data['location_id'] = $location_id = $this->input->post('location_id');
				$admin_session = $this->session->userdata('admin_logged_in');
				
				$this->form_validation->set_rules('start_date', 'start_date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('end_date', 'end_date', 'trim|required|xss_clean');
				
				$this->form_validation->set_message('required', 'Date format is wrong');
				
				if ($this->form_validation->run() == TRUE) {
					
					$condition = "";
					if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
						$condition .= "business_id='".$admin_session['business_id']."' ";
						if($location_id){
							$condition .= " and location_id='".$location_id."' ";
						}
					}
					
					
					if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
						$condition .= "location_id='".$admin_session['location_id']."' ";
					}
					
					$sale = $this->db->from('pos_daily')->where($condition)->where('open_date BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"')->get()->result_array();
					
					//gs($this->db->last_query());
					
					$filename = "sale_".time().".csv";
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename='.$filename);
					$fp = fopen('php://output', 'w');
					//gs($fp);
					
					$row = array("Open Date","Open Cash","Cash Payment","Cheque Payment","Credit Card Payment","Gift Payment","Wallet Payment","Total Sale","Cash Expense","Other Expense","Cash Refund","Other Refund","Total Discount","Location");
					fputcsv($fp, $row);
					
					
					if($sale){		
						$i=1;
						foreach($sale as $row){
							$location_name = getLocationNameById($row['location_id']);
							$date1=date_create($row['open_date']);
							$date =  date_format($date1,"d/m/Y ");
							$arr = array($date,$row['open_cash'],$row['cash_payment'],$row['cheque_payment'],$row['cc_payment'],$row['gif_payment'],$row['wallet_payment'],$row['total_sale'],$row['cash_total_expence'],$row['other_total_expence'],$row['other_total_refund'],$row['cash_total_refund'],$row['total_discount'],$location_name);
							fputcsv($fp, $arr);
							$i++;
							
						}				
					}
					exit;
					
				}
			}
			$all_invoice = array();
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$this->db->from('invoice_payments');
				$this->db->where('paid_date',date('Y-m-d'));
				$this->db->where('business_id',$admin_session['business_id']);
				if (!is_null($loc_id)) {
					$this->db->where('location_id',$loc_id);
				}
				
				$this->db->select('sum(paid_amount) AS total ,payment_type_id');
				$this->db->group_by('payment_type_id');
				$all_invoice = $this->db->get()->result_Array();
				//print_r($this->db->last_query()); exit;
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$all_invoice = $this->db->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->select(['sum(paid_amount) as total','payment_type_id'])->group_by('payment_type_id')->get()->result_Array();	
			}
			
			$this->db->select('sum(invoice_services.service_total_price) AS total');
			$this->db->from('invoice_payments');
			$this->db->join('invoice_services','invoice_services.invoice_id=invoice_payments.invoice_id');
			$this->db->where('invoice_payments.paid_date',date('Y-m-d'));
			$this->db->where('invoice_payments.business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('invoice_payments.location_id',$loc_id);
			}

			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('invoice_payments.location_id',$admin_session['location_id']);
			}

			$this->db->where('invoice_services.pay_service_type',5);
			
			$this->db->group_by('invoice_payments.payment_type_id');
			$data['total_voucher'] = $this->db->get()->row_Array();

			$this->db->select('sum(invoice_services.service_total_price) AS total');
			$this->db->from('invoice_payments');
			$this->db->join('invoice_services','invoice_services.invoice_id=invoice_payments.invoice_id');
			$this->db->where('invoice_payments.paid_date',date('Y-m-d'));
			$this->db->where('invoice_payments.business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('invoice_payments.location_id',$loc_id);
			}

			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('invoice_payments.location_id',$admin_session['location_id']);
			}
			$this->db->where_in('invoice_services.pay_service_type',array('7','8'));
			
			$this->db->group_by('invoice_payments.payment_type_id');
			$total_discount = $this->db->get()->row_Array();
			$data['total_discount']=$total_discount['total'];
			
			//print_r($this->db->last_query()); exit;
			
			
			$this->db->select('sum(outstanding_invoice_amount) AS total_outstanding_invoice_amount')->from('invoices');
			$this->db->where('business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('location_id',$loc_id);
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('location_id',$admin_session['location_id']);
			}
			
			$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d") ="'.date('Y-m-d'). '" ');
			
			$data['total_outstanding'] = $this->db->get()->row_array();
			//print_r($this->db->last_query()); exit;
			
			
			$total_sales = 0;
			$cash_payment=0;
			$gift_card_payment=0;
			$credit_card_payment=0;
			$cheque_payment=0;
			$wallet_payment=0;
			
			
			if($all_invoice){
				
				foreach($all_invoice as $value){
					if($value['payment_type_id'] == '5'){
						$cash_payment +=$value['total'];
						} elseif($value['payment_type_id'] == '6'){
						$credit_card_payment +=$value['total'];
						} elseif($value['payment_type_id'] == '7'){
						$gift_card_payment+=$value['total'];
						
						} elseif($value['payment_type_id'] == '8'){
						$cheque_payment +=$value['total'];
					}	
					
					elseif($value['payment_type_id'] == '9'){
						$wallet_payment +=$value['total'];
					}	
					$total_sales+= $value['total'];
				}

				$data['wallet_payment']=$wallet_payment;				
				$data['cheque_payment']=$cheque_payment;
				$data['credit_card_payment']=$credit_card_payment;
				
				$data['gift_card_payment']=$gift_card_payment;
				
				if($total_sales){
					$data['total_sales']=$total_sales;
				}
				
				
			}
			
			//print_r($total_sales); exit;
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$location_condition = "";
				$location_condition = " business_id='".$admin_session['business_id']."' ";
				$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			
			$today_total_expenses=array();
			$refund_invoice_data=array();
			$today_pos=array();
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->row_array();
				
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->select('*')->get()->result_array();
				//print_r($this->db->last_query()); exit;
				
				$refund_invoice_data = $this->db->select('*')->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'pay_process_type'=>4,'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->result_Array();
				
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->row_array();
				
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->select('*')->get()->result_array();
				
				$refund_invoice_data = $this->db->select('*')->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'pay_process_type'=>4,'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->result_Array();
			}
			//print_r($admin_session); exit;
			
			$this->db->select('SUM(product.retail_price) AS total_amount');
			$this->db->from('product_used');
			$this->db->join('product','product_used.product_id=product.id','inner');
			$this->db->where('product_used.flag_bit',1);
			if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
				$this->db->where('product_used.business_id',$admin_session['business_id']);
			}
			
			if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
				$this->db->where('product_used.business_id',$admin_session['business_id']);
				$this->db->where('product_used.location_id',$admin_session['location_id']);
			}
			
			if (isset($loc_id)) {
				$this->db->where('product_used.location_id',$loc_id);
			}
			
			
			$this->db->like('product_used.date_created',date('Y-m-d'));		
			$total_amount_product=$this->db->get()->row_array();
			$data['product_used_amount']= $total_amount_product['total_amount'];
			$cash_today_total_expenses=0;
			$other_today_total_expenses=0;
			
			if($today_total_expenses){
				
				foreach ($today_total_expenses as $key => $value) {
					if ($value['medium']==5) {
						$cash_today_total_expenses+=$value['amount'];
					}
					else{
						$other_today_total_expenses+=$value['amount'];
						
					}
					
				}
				
			}
			
			$data['cash_today_total_expenses']=$cash_today_total_expenses;
			$data['other_today_total_expenses']=$other_today_total_expenses;
			
			
			if($today_pos){
				$data['today_pos']=$today_pos;
			}
			$today_total_refund = 0;
			$today_total_Cash_refund=0;
			$today_total_othere_refund=0;
			
			
			if($refund_invoice_data){			
				foreach($refund_invoice_data as $value){
					$today_total_refund+= $value['paid_amount'];
					if ($value['payment_type_id']==5) {
						$today_total_Cash_refund+= $value['paid_amount'];
					}
					if ($value['payment_type_id']!=5) {
						$today_total_othere_refund+= $value['paid_amount'];
					}
				}
				
				if($today_total_refund){
					$data['today_total_refund']=$today_total_refund;
				}
				
				if($today_total_Cash_refund){
					$data['today_total_Cash_refund']=$today_total_Cash_refund;
				}
				
				if($today_total_othere_refund){
					$data['today_total_othere_refund']=$today_total_othere_refund;
				}
				
				
			}
			$data['total_cash_payment']=$total_cash_payment=$cash_payment-$today_total_Cash_refund;
			$data['total_card_payment']=$total_card_payment=$credit_card_payment-$today_total_othere_refund;
			
			//echo $total_sales; exit;
			
			if($total_sales){
				$total_sales=$total_sales-((isset($data['today_total_refund']))?$data['today_total_refund']:0);
			}
			
			$data['total_sales']=$total_sales;
			
			
			
			/*$total_cash = ((isset($data['total_sales']))?$data['total_sales']:0)+((isset($today_pos['open_cash']))?$today_pos['open_cash']:0)-((isset($today_total_expenses))?$today_total_expenses[0]['total']:0);*/
			/*
				$total_cash = ((isset($today_pos['open_cash']))?$today_pos['open_cash']:0)-((isset($today_total_expenses))?$today_total_expenses[0]['total']:0)-((isset($data['today_total_refund']))?$data['today_total_refund']:0);
			*/		
			
			$total_cash = ((isset($today_pos['open_cash']))?$today_pos['open_cash']:0)+(isset($total_cash_payment)?$total_cash_payment:0)-(isset($today_total_Cash_refund)?$today_total_Cash_refund:0)-(isset($cash_today_total_expenses)?$cash_today_total_expenses:0);
			
			
			if($total_cash){
				$data['total_cash']=$total_cash;
			}
			
			
			$data['page']='today_sale';
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/today_sale', $data);
			
		}
		
		public function close_register($loc_id=null)
		{
			$admin_session = $this->session->userdata('admin_logged_in');
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$all_invoice = $this->db->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id,'pay_process_type !='=>4])->select(['sum(paid_amount) as total','payment_type_id','count(payment_type_id) as total_slip'])->group_by('payment_type_id')->get()->result_array();
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$all_invoice = $this->db->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id'],'pay_process_type !='=>4])->select(['sum(paid_amount) as total','payment_type_id','count(payment_type_id) as total_slip'])->group_by('payment_type_id')->get()->result_array();	
			}
			
			$this->db->select('sum(invoice_services.service_total_price) AS total');
			$this->db->from('invoice_payments');
			$this->db->join('invoice_services','invoice_services.invoice_id=invoice_payments.invoice_id');
			$this->db->where('invoice_payments.paid_date',date('Y-m-d'));
			$this->db->where('invoice_payments.business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('invoice_payments.location_id',$loc_id);
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('invoice_payments.location_id',$admin_session['location_id']);
			}
			$this->db->where('invoice_services.pay_service_type',5);
			
			$this->db->group_by('invoice_payments.payment_type_id');
			$total_voucher = $this->db->get()->row_Array();
			$data['total_voucher']=$total_voucher['total'];
			
			$this->db->select('sum(outstanding_invoice_amount) AS total_outstanding_invoice_amount')->from('invoices');
			$this->db->where('business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('location_id',$loc_id);
			}
			if($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$this->db->where('location_id',$admin_session['location_id']);
			}
			$this->db->where('DATE_FORMAT(date_created, "%Y-%m-%d") ="'.date('Y-m-d'). '" ');
			$data['total_outstanding'] = $this->db->get()->row_array();
			
			/*$total_sales = 0;
				$cash_payment=0;
				//print_r($all_invoice); exit;
				if($all_invoice){
				//$total_sales = 0;
				foreach($all_invoice as $value){
				if($value['payment_type_id'] == '5'){
				$data['cash_payment'] +=$value['total'];
				$data['cash_payment_slip']=$value['total_slip'];
				} elseif($value['payment_type_id'] == '6'){
				$data['credit_card_payment'] +=$value['total'];
				$data['cc_slip']=$value['total_slip'];
				} elseif($value['payment_type_id'] == '7'){
				$data['gift_card_payment'] +=$value['total'];	
				} else{
				$data['cheque_payment']=$value['total'];
				$data['cheque_payment_slip'] +=$value['total_slip'];	
				}	
				$total_sales+= $value['total'];
				if($total_sales){
				$data['total_sales']=$total_sales;
				}
				
				}
			}*/
			
			//today close 
			
			$total_sales = 0;
			$cash_payment=0;
			$gift_card_payment=0;
			$credit_card_payment=0;
			$cheque_payment=0;
			$wallet_payment=0;
			
			if($all_invoice){
				
				foreach($all_invoice as $value){
					if($value['payment_type_id'] == '5'){
						$cash_payment +=$value['total'];
						$data['cash_payment_slip']=$value['total_slip'];
						} elseif($value['payment_type_id'] == '6'){
						$credit_card_payment +=$value['total'];
						$data['cc_slip']=$value['total_slip'];
						} elseif($value['payment_type_id'] == '7'){
						$gift_card_payment+=$value['total'];
						} elseif($value['payment_type_id'] == '8'){
						$cheque_payment +=$value['total'];
						$data['cheque_payment_slip'] =$value['total_slip'];
						}
						elseif($value['payment_type_id'] == '9'){
							$wallet_payment +=$value['total'];
						}
					
					$total_sales+= $value['total'];
					
				}
				
				$data['wallet_payment']=$wallet_payment;
				$data['cheque_payment']=$cheque_payment;
				$data['credit_card_payment']=$credit_card_payment;
				
				$data['gift_card_payment']=$gift_card_payment;
				
				if($total_sales){
					$data['total_sales']=$total_sales;
				}
				
				
			}
			
			//print_r($total_sales); exit;
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$location_condition = "";
				$location_condition = " business_id='".$admin_session['business_id']."' ";
				$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			
			$today_total_expenses=array();
			$refund_invoice_data=array();
			$today_pos=array();
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->row_array();
				
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->select('*')->get()->result_array();
				//print_r($this->db->last_query()); exit;
				
				$refund_invoice_data = $this->db->select('*')->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'pay_process_type'=>4,'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->result_Array();
				
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->row_array();
				
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->select('*')->get()->result_array();
				
				$refund_invoice_data = $this->db->select('*')->from('invoice_payments')->where(['paid_date'=>date('Y-m-d'),'pay_process_type'=>4,'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->result_Array();
			}
			//print_r($admin_session); exit;
			
			$this->db->select('SUM(product.retail_price) AS total_amount');
			$this->db->from('product_used');
			$this->db->join('product','product_used.product_id=product.id','inner');
			$this->db->where('product_used.flag_bit',1);
			if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") {
				$this->db->where('product_used.business_id',$admin_session['business_id']);
			}
			
			if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
				$this->db->where('product_used.business_id',$admin_session['business_id']);
				$this->db->where('product_used.location_id',$admin_session['location_id']);
			}
			
			if (isset($loc_id)) {
				$this->db->where('product_used.location_id',$loc_id);
			}
			
			
			$this->db->like('product_used.date_created',date('Y-m-d'));		
			$total_amount_product=$this->db->get()->row_array();
			$data['product_used_amount']= $total_amount_product['total_amount'];
			$cash_today_total_expenses=0;
			$other_today_total_expenses=0;
			
			if($today_total_expenses){
				
				foreach ($today_total_expenses as $key => $value) {
					if ($value['medium']==5) {
						$cash_today_total_expenses+=$value['amount'];
					}
					else{
						$other_today_total_expenses+=$value['amount'];
						
					}
					
				}
				
			}
			
			$data['cash_today_total_expenses']=$cash_today_total_expenses;
			$data['other_today_total_expenses']=$other_today_total_expenses;
			
			
			if($today_pos){
				$data['today_pos']=$today_pos;
			}
			$today_total_refund = 0;
			$today_total_Cash_refund=0;
			$today_total_othere_refund=0;
			
			//print_r($refund_invoice_data); exit;
			if($refund_invoice_data){			
				foreach($refund_invoice_data as $value){
					$today_total_refund+= $value['paid_amount'];
					if ($value['payment_type_id']==5) {
						$today_total_Cash_refund+= $value['paid_amount'];
					}
					if ($value['payment_type_id']!=5) {
						$today_total_othere_refund+= $value['paid_amount'];
					}
				}
				
				if($today_total_refund){
					$data['today_total_refund']=$today_total_refund;
				}
				
				if($today_total_Cash_refund){
					$data['today_total_Cash_refund']=$today_total_Cash_refund;
				}
				
				if($today_total_othere_refund){
					$data['today_total_othere_refund']=$today_total_othere_refund;
				}
				
				
			}
			
			//$data['total_cash_payment']=$total_cash_payment=$cash_payment-$today_total_Cash_refund;
			$data['total_cash_payment']=$total_cash_payment=$cash_payment;
			
			
			//echo $total_sales; exit;
			
			/*if($total_sales){
				$total_sales=$total_sales-((isset($data['today_total_refund']))?$data['today_total_refund']:0);
				}
			$data['total_sales']=$total_sales;*/
			
			$total_cash = ((isset($today_pos['open_cash']))?$today_pos['open_cash']:0)+(isset($total_cash_payment)?$total_cash_payment:0)-(isset($today_total_Cash_refund)?$today_total_Cash_refund:0)-(isset($cash_today_total_expenses)?$cash_today_total_expenses:0);
			$total_card = ((isset($data['credit_card_payment']))?$data['credit_card_payment']:0)-(isset($today_total_othere_refund)?$today_total_othere_refund:0)-(isset($other_today_total_expenses)?$other_today_total_expenses:0);
			$total_cheque = ((isset($data['cheque_payment']))?$data['cheque_payment']:0);
			
			
			if($total_cash){
				$data['total_cash']=$total_cash;
			}
			if($total_card){
				$data['total_card']=$total_card;
			}
			if($total_cheque){
				$data['total_cheque']=$total_cheque;
			}
			//End
			$today_pos=array();
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->get()->row_array();
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$today_pos = $this->db->from('pos_daily')->where(['open_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->get()->row_array();
			}

			$this->db->select('sum(invoice_services.service_total_price) AS total');
			$this->db->from('invoice_payments');
			$this->db->join('invoice_services','invoice_services.invoice_id=invoice_payments.invoice_id');
			$this->db->where('invoice_payments.paid_date',date('Y-m-d'));
			$this->db->where('invoice_payments.business_id',$admin_session['business_id']);
			if (!is_null($loc_id)) {
				$this->db->where('invoice_payments.location_id',$loc_id);
			}

			if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff") {
				$this->db->where('invoice_payments.location_id',$admin_session['location_id']);
			}
			$this->db->where_in('invoice_services.pay_service_type',array('7','8'));
			
			$this->db->group_by('invoice_payments.payment_type_id');
			$total_discount= $this->db->get()->row_Array();
			$data['total_discount']=$total_discount['total'];
			
			
			//$total_cash = (isset($data['total_sales']))?$data['total_sales']:0+(isset($today_pos['open_cash']))?$today_pos['open_cash']:0-(isset($data['total_sales']))?$data['total_sales']:0;
			
			if($this->input->post('action')){
				$updateData =  array(
				'cash_payment'=>(isset($data['total_cash_payment']))?$data['total_cash_payment']:0,
				'cheque_payment'=>(isset($data['cheque_payment']))?$data['cheque_payment']:0,
				'cc_payment'=>(isset($data['credit_card_payment']))?$data['credit_card_payment']:0,
				'gif_payment'=>(isset($data['gift_card_payment']))?$data['gift_card_payment']:0,
				'total_sale'=>$data['total_sales'],
				'other_total_expence'=>(isset($data['other_today_total_expenses']))?$data['other_today_total_expenses']:0,
				'other_total_refund'=>(isset($data['today_total_othere_refund']))?$data['today_total_othere_refund']:0,
				
				'cash_total_expence'=>(isset($data['cash_today_total_expenses']))?$data['cash_today_total_expenses']:0,
				'cash_total_refund'=>(isset($data['today_total_Cash_refund']))?$data['today_total_Cash_refund']:0,
				'total_voucher'=>(isset($data['total_voucher']))?$data['total_voucher']:0,
				'total_discount'=>(isset($data['total_discount']))?$data['total_discount']:0,
				'wallet_payment'=>(isset($data['wallet_payment']))?$data['wallet_payment']:0,
				'is_closed'=>1,
				'notes'=>$this->input->post('description'),
				);
				
				
				$where = array('id' => $today_pos['id']);
				
				$success = $this->others->update_common_value("pos_daily",$updateData,$where);
				
				if ($success) {
					$this->session->set_flashdata('success_msg', "Register closed successfully!");
					redirect(base_url('admin/expense/close_register'));
				} else {
					$this->session->set_flashdata('error_msg', "Register closing failed!");
					redirect(base_url('admin/expense/close_register'));
				}
				if($success){
					$data['success']=$success;
				}		
				
			}
			
			
			if($today_pos){
				$data['today_pos']=$today_pos;
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$loc_id])->select(['sum(amount) as total'])->get()->result_array();
				}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$today_total_expenses =  $this->db->from('pos_expences')->where(['paid_date'=>date('Y-m-d'),'business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id']])->select(['sum(amount) as total'])->get()->result_array();
			}
			
			//print_r($this->db->last_query()); exit;
			
			//gs($today_total_expenses);
			
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
				$location_condition = "";
				$location_condition = " business_id='".$admin_session['business_id']."' ";
				$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
				if($locations)
				$data['locations'] = $locations;	
			}
			
			
			
			/*$total_cash = ((isset($data['total_sales']))?$data['total_sales']:0)+((isset($today_pos['open_cash']))?$today_pos['open_cash']:0)-((isset($today_total_expenses))?$today_total_expenses[0]['total']:0);*/
			
			if($today_total_expenses){
				$data['today_total_expenses']=$today_total_expenses;
			}

			

			
			/*if($total_cash){
				$data['total_cash']=$total_cash;
			}*/
			
			$data['page']='close_register';
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/close_register', $data);
		}
		
		public function all_expenses()
		{
			$admin_session = $this->session->userdata('admin_logged_in'); 
			
			
			$arr_search=array();
			$per_page=array();
			$config['offset']=array();
			
			
			if ($this->input->post('record')) {
				
				$condition = "";
			if($admin_session['role']=="business_owner"){
			$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			//$condition .= " AND location_id='".$admin_session['location_id']."' ";
			$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
			$this->others->delete_record("pos_expences","id='".$item."' ".$condition);
			$count_records ++;
			}
			if($count_records>0){
			$this->session->set_flashdata('success_msg', "Pos Expense has been deleted successfully!");
			}else{
			$this->session->set_flashdata('error_msg', "No pos Expense are selected to delete!");
			}	
			redirect(base_url('admin/expense'));			
			}
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
			$data['all_business'] = $all_business;
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			if($admin_session['role']=="owner")
			{
			//$arr_search['business_id'] = $admin_session['business_id'];
			}else if($admin_session['role']=="business_owner"){
			$arr_search['business_id'] = $admin_session['business_id'];
			
			}else if( $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['business_id'] = $admin_session['business_id'];
			$arr_search['location_id'] = $admin_session['location_id'];
			
			} 
			
			$all_records = $this->expense_model->get_all_expenses(false,$arr_search,$per_page, $config['offset'],"id","DESC");
			if($all_records){
			$data['all_records']=$all_records;
			}
			
			
			$data['page']='all_expenses';	
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			//$data['all_pos_category']=$all_pos_category;
			
			$this->load->view('admin/expense/all_expenses', $data);
			
			}
			
			public function add_expense($id='')
			{
			$admin_session = $this->session->userdata('admin_logged_in');
			
			
			if($this->input->post('action')){
			
			$b_id = ($admin_session['role']=="business_owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff")?$admin_session['business_id']:$this->input->post('business_id') ; 
			$loc_id = ($admin_session['role']=="location_owner" || $admin_session['role']=="staff")?$admin_session['location_id']:$this->input->post('location_id') ; 
			
			$business_id = $this->input->post('business_id');
			$data['business_id'] = $this->input->post('business_id');
			$data['location_id'] = $this->input->post('location_id');
			$data['paid_date'] = $this->input->post('paid_date');
			$data['reference'] = $this->input->post('reference');
			$data['category_id'] = $this->input->post('category_id');
			$data['vendor_id'] = $this->input->post('vendor_id');
			$data['amount'] = $this->input->post('amount');
			$data['description'] = $this->input->post('description');
			$data['medium'] = $this->input->post('medium');
			
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
			$this->form_validation->set_rules('paid_date', 'Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'numeric|trim|required|xss_clean');
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required|xss_clean');
			$this->form_validation->set_rules('medium', 'Medium', 'trim|required|xss_clean');
			
			$this->form_validation->set_rules('vendor_id', 'Vendor', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
			
			
			$this->form_validation->set_message('numeric', 'Amount should be numeric');
			
			if ($this->form_validation->run() == TRUE) {
			
			$amount = $this->input->post('amount');
			$net = (90 / 100) * $amount;
			$gst = (10 / 100) * $amount;
			
			//$total_amount = $amount + $gst + $net;
			$medium = $this->input->post('medium');
			$paid_date = $this->input->post('paid_date');
			$date=date_create($paid_date);
			
			$paid_date =date_format($date, "Y-m-d");
			
			$insert_data = array(
			'business_id'=>$b_id,
			'location_id'=>$loc_id,
			'paid_date'=>$paid_date,
			'reference'=>$this->input->post('reference'),
			'pos_expcategory_id'=>$this->input->post('category_id'),
			'vendor_id'=>$this->input->post('vendor_id'),
			'amount'=>$amount,
			'description'=> $this->input->post('description'),
			'net'=>$net,
			'gst'=>$gst,
			//'total_amount'=>$total_amount,
			'medium'=>$medium
			);
			
			if(!empty($id)){
			$where = array('id' => $id);
			$return = $this->others->update_common_value("pos_expences",$insert_data,$where);
			
			if($return == true){
			
			$this->session->set_flashdata('success_msg', "Class category updated successfully!");
			redirect(base_url('admin/expense'));
			}
			
			}
			else{
			
			$success = $this->others->insert_data("pos_expences",$insert_data);
			if ($success) {
			$this->session->set_flashdata('success_msg', "Expense is added successfully!");
			redirect(base_url('admin/expense/all_expenses'));
			} else {
			$this->session->set_flashdata('error_msg', "Adding expense is failed!");
			redirect(base_url('admin/expense/add_expense'));
			}
			}
			}
			
			
			}
			
			if(!empty($id)){
			$pos_expense_details = $this->others->get_all_table_value("pos_expences","*","id=".$id."","","");
			if($pos_expense_details) {
			$data['pos_expense_details'] = $pos_expense_details;
			}
			
			}
			
			
			$all_pos_category = $this->db->from('pos_expcategory')->where(['business_id'=>$admin_session['business_id'], 'status'=>1])->get()->result_array();
			
			$all_vendor = $this->db->from('vendors')->where(['business_id'=>$admin_session['business_id'], 'status'=>1])->get()->result_array();
			
			if($all_vendor){
			$data['all_vendor']=$all_vendor;
			}
			
			$all_medium = $this->db->from('payment_type')->where(['status'=>'active'])->get()->result_array();
			
			if($all_medium){
			$data['all_medium']=$all_medium;
			}
			
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business)
			$data['all_business'] = $all_business;
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			
			$data['page']='all_expenses';
			$data['expense_active_open']=true;
			$data['all_pos_category']=$all_pos_category;
			$data['admin_session']=$admin_session;
			
			//gs($data);
			$this->load->view('admin/expense/add_expense', $data);
			}
			
			
			
			/*public function edit_expense(){
			
			}*/
			
			public function all_pos_category()
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
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			//$condition .= " AND location_id='".$admin_session['location_id']."' ";
			$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
			$this->others->delete_record("pos_expcategory","id='".$item."' ".$condition);
			$count_records ++;
			}
			if($count_records>0){
			$this->session->set_flashdata('success_msg', "Pos Service category has been deleted successfully!");
			}else{
			$this->session->set_flashdata('error_msg', "No pos service category are selected to delete!");
			}	
			redirect(base_url('admin/expense/all_pos_category'));			
			}
			
			
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/expense/all_pos_category') .'?'.$get_string;
			
			if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['business_id']= $business_id;
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
			
			
			
			/*if($this->input->get('customer_search')){
			$customer_name = $this->input->get('customer_search');
			$customer_name = explode(" ",$customer_name);
			$search_first_name = trim($customer_name[0]);
			$search_last_name = trim($customer_name[1]);
			if(!empty($search_first_name))
			$arr_search['first_name'] = $search_first_name;
			if(!empty($search_last_name))
			$arr_search['last_name'] = $search_last_name;
			}	*/	 
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			
			$arr_search['business_id'] = $admin_session['business_id'];
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			
			
			$all_service_category = $this->expense_model->get_pos_category(false,$arr_search,$per_page, $config['offset'],"id","DESC");
			
			
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			if($all_service_category){
			$data['all_service_category']= $all_service_category;
			$count_all_records = $this->expense_model->get_pos_category(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
			}
			$this->pagination->initialize($config);
			
			$data['page']='all_pos_category';	
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/all_pos_category', $data);
			}
			
			public function add_pos_category(){
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post())
			{
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			
			
			if($admin_session['role'] == 'owner') { 
			$data['business_id'] = $business_id = $this->input->post('business_id');
			}else{
			$data['business_id'] = $business_id = $admin_session['business_id'];
			}
			
			$data['name'] 	= $name = $this->input->post('name');
			$data['status'] 	= $status = $this->input->post('status');
			
			if ($this->form_validation->run() == TRUE) 
			{
			$inserData 	= array(
			'name' 	=> $name,
			'status'  => $status,
			'business_id'  => $business_id
			);
			
			$success = $this->others->insert_data("pos_expcategory",$inserData);
			if ($success) {
			$this->session->set_flashdata('success_msg', "Pos Category is added successfully!");
			redirect(base_url('admin/expense/all_pos_category'));
			} else {
			$this->session->set_flashdata('error_msg', "Adding expense is failed!");
			redirect(base_url('admin/expense/add_pos_category'));
			}
			
			}
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			$data['page']='all_pos_category';	
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/add_pos_category', $data);
			}
			
			public function edit_pos_category($id=''){
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('edit_pos_category'))
			{
			
			
			$this->load->library('form_validation');
			
			/*if($admin_session['role'] == 'owner') { 
			$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
			}
			*/
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			
			
			if($admin_session['role'] == 'owner') { 
			$data['business_id'] = $business_id = $this->input->post('business_id');
			}else{
			$data['business_id'] = $business_id = $admin_session['business_id'];
			}
			
			$data['name'] 	= $name = $this->input->post('name');
			$data['status'] 	= $status = $this->input->post('status');
			
			if ($this->form_validation->run() == TRUE) 
			{
			
			$updateData 	= array(
			'name' 	    => $name,
			'status'  => $status
			);
			$where = array('id' => $id);
			
			$return = $this->others->update_common_value("pos_expcategory",$updateData,$where);
			if($return == true){
			$this->session->set_flashdata('success_msg', "Service Category updated successfully!");
			redirect(base_url('admin/expense/all_pos_category'));
			}
			}
			}
			
			// get template details
			if(!empty($id)){
			$pos_category_details = $this->others->get_all_table_value("pos_expcategory","*","id='".$id."'");
			$data['pos_category_details'] = $pos_category_details;
			}
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
			$data['all_business'] = $all_business;
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			$data['page']='all_pos_category';	
			$data['expense_active_open']=true;
			$this->load->view('admin/expense/edit_pos_category', $data);
			}
			
			
			public function all_vendors()
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
			$this->others->delete_record("vendors","id='".$item."' ".$condition);
			$count_records ++;
			}
			if($count_records>0){
			$this->session->set_flashdata('success_msg', "Pos Service category has been deleted successfully!");
			}else{
			$this->session->set_flashdata('error_msg', "No pos service category are selected to delete!");
			}	
			redirect(base_url('admin/expense/all_vendors'));			
			}
			
			$get_string = implode('&', $arr_get);
			$config['base_url'] = base_url('admin/expense/all_vendors') .'?'.$get_string;
			
			if ($this->input->get('business_id')) {
            $business_id = $this->input->get('business_id');
			$arr_search['business_id']= $business_id;
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
			
			/*if($this->input->get('customer_search')){
			$customer_name = $this->input->get('customer_search');
			$customer_name = explode(" ",$customer_name);
			$search_first_name = trim($customer_name[0]);
			$search_last_name = trim($customer_name[1]);
			if(!empty($search_first_name))
			$arr_search['first_name'] = $search_first_name;
			if(!empty($search_last_name))
			$arr_search['last_name'] = $search_last_name;
			}	*/	 
			
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			
			$arr_search['business_id'] = $admin_session['business_id'];
			}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			$arr_search['business_id'] = $admin_session['business_id'];
			}
			
			$all_vendors = $this->expense_model->get_all_vendor(false,$arr_search,$per_page, $config['offset'],"id","DESC");
			
			if($all_vendors){
			$data['all_vendors']= $all_vendors;
			$count_all_records = $this->expense_model->get_all_vendor(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			$this->pagination->initialize($config);
			$data['page']='all_vendors';
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/all_vendors', $data);
			}
			
			
			public function add_vendor(){
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post())
			{
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('vendor_name', 'name', 'trim|required|xss_clean');
			
			
			if($admin_session['role'] == 'owner') { 
			$data['business_id'] = $business_id = $this->input->post('business_id');
			}else{
			$data['business_id'] = $business_id = $admin_session['business_id'];
			}
			
			$data['vendor_name'] 	= $name = $this->input->post('vendor_name');
			$data['status'] 	= $status = $this->input->post('status');
			
			if ($this->form_validation->run() == TRUE) 
			{
			$inserData 	= array(
			'vendro_name' 	=> $name,
			'status'  => $status,
			'business_id'  => $business_id,
			'date_created'  => date('Y-m-d H:i:s'),
			);
			
			$success = $this->others->insert_data("vendors",$inserData);
			if ($success) {
			$this->session->set_flashdata('success_msg', "Vendor is added successfully!");
			redirect(base_url('admin/expense/all_vendors'));
			} else {
			$this->session->set_flashdata('error_msg', "Adding Vendor is failed!");
			redirect(base_url('admin/expense/add_vendor'));
			}
			
			}
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			$data['page']='all_vendors';	
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			$this->load->view('admin/expense/add_vendor', $data);
			}
			
			
			public function edit_vendor($id=''){
			
			$admin_session = $this->session->userdata('admin_logged_in');
			
			if($this->input->post('edit_vendor'))
			{
			
			
			$this->load->library('form_validation');
			
			/*if($admin_session['role'] == 'owner') { 
			$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
			}
			*/
			$this->form_validation->set_rules('vendor_name', 'name', 'trim|required|xss_clean');
			
			
			if($admin_session['role'] == 'owner') { 
			$data['business_id'] = $business_id = $this->input->post('business_id');
			}else{
			$data['business_id'] = $business_id = $admin_session['business_id'];
			}
			
			$data['name'] 	= $name = $this->input->post('vendor_name');
			$data['status'] 	= $status = $this->input->post('status');
			
			if ($this->form_validation->run() == TRUE) 
			{
			
			$updateData 	= array(
			'vendro_name' 	    => $name,
			'status'  => $status
			);
			$where = array('id' => $id);
			
			$return = $this->others->update_common_value("vendors",$updateData,$where);
			if($return == true){
			$this->session->set_flashdata('success_msg', "Vendor updated successfully!");
			redirect(base_url('admin/expense/all_vendors'));
			}
			}
			}
			
			// get template details
			if(!empty($id)){
			$vendor_details = $this->others->get_all_table_value("vendors","*","id='".$id."'");
			$data['vendor_details'] = $vendor_details;
			}
			
			$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
			if($all_business) {
			$data['all_business'] = $all_business;
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			$data['page']='all_vendors';	
			
			$data['expense_active_open']=true;
			$this->load->view('admin/expense/edit_vendor', $data);
			}
			
			public function all_sale(){
			$admin_session = $this->session->userdata('admin_logged_in');
			
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
			$this->others->delete_record("pos_daily","id='".$item."' ".$condition);
			$count_records ++;
			}
			if($count_records>0){
			$this->session->set_flashdata('success_msg', "Sale has been deleted successfully!");
			}else{
			$this->session->set_flashdata('error_msg', "No pos Expense are selected to delete!");
			}	
			redirect(base_url('admin/expense/all_sale'));			
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" || $admin_session['role']=="location_owner"){
			$location_condition = "";
			$location_condition = " business_id='".$admin_session['business_id']."' ";
			$locations = $this->others->get_all_table_value("location","id,location_name",$location_condition,"location_name","ASC");
			if($locations)
			$data['locations'] = $locations;	
			}
			
			if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){	
			
			$all_sales =  $this->db->from('pos_daily')->where(['business_id'=>$admin_session['business_id'],'is_closed'=>1])->order_by("open_date", "desc")->get()->result_array();
			}else if( $admin_session['role']=="location_owner"){
			$all_sales =  $this->db->from('pos_daily')->where(['business_id'=>$admin_session['business_id'],'location_id'=>$admin_session['location_id'],'is_closed'=>1])->order_by("open_date", "desc")->get()->result_array();
			}
			//gs($all_sales);
			if($all_sales) {
			$data['all_sales'] = $all_sales;
			}
			
			$data['page']='today_sale';
			$data['expense_active_open']=true;
			$data['admin_session']=$admin_session;
			//	gs($data);
			$this->load->view('admin/expense/all_sales', $data);	
			
			}
			
			
			
			}
						