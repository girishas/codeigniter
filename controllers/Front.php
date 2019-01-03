<?php
date_default_timezone_set('Australia/Melbourne');
	defined('BASEPATH') OR exit('No direct script access allowed');
	use Twilio\Rest\Client;
	class Front extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('business_model', '', TRUE);
			$this->load->model('user_model', '', TRUE); 
			$this->load->library('form_validation');
			//$this->timezone();
			
		}

		private function __clear_cache() {
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		}
		
		public function index()
		{
			//redirect(base_url('admin/dashboard'));
			$this->load->view('home');
		}
		public function widget_bookings($id=null)
		{ 

			$encode = $id;
			$decode = base64_decode($id);
			$decode = explode("_",$decode);
			$id = $decode[0];
			$_SESSION['booking']['business_id']= $id;
			//gs($_SESSION);		
			$business_name = $this->db->select('name')->from('business')->where(array('business.id' =>$id))->get()->row_array();
			$_SESSION['busines']['name']=$business_name['name'];
			$this->load->helper(array('form', 'url'));
			$data = array();
			
			if($this->input->post('submit')){
				$data['step'] = $this->input->post('step');	
				}else{
				$data['step'] = 0;
			}	 
			$service_id=array();
			$service_listing = array();
			$new_service_listing = array(); 
			//print_r($this->input->post());	

			if ($this->input->post('step') == '2' and (!isset($_POST['9'])) ) {
				$date = $this->input->post('date');
				$time = $this->input->post('time');
				$_SESSION['booking']['date'] = $date;
				$_SESSION['booking']['time'] = $time.':00';
				$_SESSION['booking']['service_end_time']=sum_the_time($_SESSION['booking']['time'] , $_SESSION['booking']['service_total_duration']);
				
			}
			if($this->input->post('step') == '2' and (!isset($_POST['9'])) ){
				//	$date = $this->input->post('date');
				//$time = $this->input->post('time');
				//$_SESSION['booking']['date'] = $date;
				//$_SESSION['booking']['time'] = $time.':00';
				
				
				
				//echo $_SESSION['booking']['time'] .''.$_SESSION['booking']['service_total_duration'].''.$_SESSION['booking']['service_end_time']; exit;
				//gs($_SESSION['booking']['service_total_all_seconds']);
				//gs($_SESSION['booking']['time']);
				//print_r($_SESSION['booking']['service_total_all_seconds']); exit;
				
				/*$_SESSION['booking']['service_end_time'] = date("h:i:s a", $_SESSION['booking']['time'] + $_SESSION['booking']['service_total_all_seconds']);*/
				
				
				//echo $total_end_time.'</br>';
				
				//echo $_SESSION['booking']['service_total_duration'].'</br>';
				
				
				//$singletime = date("h:i:s a", $_SESSION['booking']['time']);
				//echo $singletime.'</br>';
				//echo $_SESSION['booking']['time'].'</br>';
				
				//echo $_SESSION['booking']['service_end_time'].'</br>';
				
				//exit; 
				
				//gs();
				
			}
			
			if($this->input->post('step') == '1' and (!isset($_POST['10'])) ){
				
				$location_id = $this->input->post('location_id');
				$_SESSION['booking']['location_id'] = $location_id;
				
				
				
			}
			
			if($this->input->post('step') == '9' and (!isset($_POST['step0'])) ){
				//gs($this->input->post()); exit;
				$service_id=$this->input->post('id');
				$group_service_id = $this->input->post('group_service_id');
				
				//print_r($service_id);
				$_SESSION['booking']['group_service_id'] = $group_service_id;
				$group_check_service_id=[];
				foreach ($service_id as $key => $value) {
					$group_check_service_id=isset($group_service_id[$value])?$group_service_id[$value]:0;
				}
				
				//print_r($group_check_service_id);
				
				
				$group_packages_listing = $this->db->select('*')->from('packages')->where_in('id',$group_check_service_id)->get()->result_array();
				
				
				
				$_SESSION['booking']['group_packages_listing'] = $group_packages_listing;
				//print_r($_SESSION['booking']['group_packages_listing']);// exit;
				
				$group_listing = $this->db->select('*')->from('packages')->join('package_services','package_services.package_id=packages.id','inner')->where_in('packages.id',$group_check_service_id)->get()->result_array();
				//print_r($this->db->last_query());
				
				$group_timing_listing=array();
				foreach ($group_listing as $key => $value) {
					
					$group_timing_listing[]=$value['service_timing_id'];
				}
				
				//print_r($group_timing_listing);
				
				foreach($service_id as $value1){
					
					$this->db->select('*');
					$this->db->from('service_timing');
					$this->db->where('id',$value1);
					if (count((array)(array)$group_timing_listing)>0) {
						$this->db->where_not_in('id',$group_timing_listing);
					}
					
					$service_timing_listing[] =$this->db->get()->result_array();
					
					
					//print_r($this->db->last_query());
				}
				
				//print_r($service_timing_listing);
				if (count((array)(array)$service_timing_listing)>0) {
					foreach($service_timing_listing as $service_listing_value){
						if (isset($service_listing_value[0])) {
							$new_group_service_listing[] = $service_listing_value[0];
						}
						else{
							$new_group_service_listing[] = '';
						}
						
						
					}
				}
				else{
					$new_group_service_listing[] = '';
				}
				
				
				
				$_SESSION['booking']['service_timing_listing'] = $new_group_service_listing;
				
				
				foreach($service_id as $value1){
					
					$service_listing[] = $this->db->select('*')->from('service_timing')->where('id',$value1)->get()->result_array();
					//print_r($this->db->last_query());
				}	
				
				//print_r($service_listing);
				//exit;		
				foreach($service_listing as $service_listing_value){
					
					$new_service_listing[] = $service_listing_value[0];
				}
				
				
				$_SESSION['booking']['service_listing'] = $new_service_listing;
				foreach ($new_service_listing as $key => $value) {
					$tr[] = $value['id'];
					$duration[] = $value['duration'];
				}
				$_SESSION['booking']['service_listing_arr'] = $tr;
				$_SESSION['booking']['service_listing_duration'] = $duration;
				$all_seconds=0;
				foreach ($_SESSION['booking']['service_listing_duration'] as $time) {
					list($hour, $minute, $second) = explode(':', $time);
					$all_seconds += $hour * 3600;
					$all_seconds += $minute * 60;
					$all_seconds += $second;
				}
				
				$total_minutes = floor($all_seconds/60);
				$seconds = $all_seconds % 60;
				$hours = floor($total_minutes / 60); 
				$minutes = $total_minutes % 60;
				
				$total_duration =sprintf('%02d:%02d:%02d', $hours, $minutes,$seconds);
				$_SESSION['booking']['service_total_duration']=$total_duration;
				$_SESSION['booking']['service_total_all_seconds']=$all_seconds;
				
				
				//gs($_SESSION['booking']['service_total_duration']);
			}
			
			
			if($this->input->post('step') == '3' and (!isset($_POST['step1']))){
				
				
				
				if($this->input->post('staff_id') != 0){
					$staff_id = $this->input->post('staff_id');
					
					$staff_list_id = $this->db->select('first_name,last_name,id')->from('staff')->where(array('staff.id' =>$staff_id))->get()->result_array();
					$_SESSION['booking']['staff_list_id'] = $staff_list_id;
					}else{
					$_SESSION['booking']['staff_list_id'] = array();
					
				}
				
			}
			
			if(isset($_POST['step1'])){
				
				$data['step'] = '1';
			}
			if(isset($_POST['step10'])){
				unset($_SESSION['booking']);
				$data['step'] = '10';			
			}
			if(isset($_POST['step9'])){
				
				$data['step'] = '9';			
			}
			if(isset($_POST['step2'])){
				$data['step'] = '2';			
			}
			
			if(isset($_POST['step0'])){
				unset($_SESSION['booking']['service_listing']);
				unset($_SESSION['booking']['service_listing_arr']);
				unset($_SESSION['booking']['time']);
				unset($_SESSION['booking']['date']);
				$data['step'] = '0';
			}
			
			
			if(isset($_POST['step1'])){
				$data['step'] = '1';
				unset($_SESSION['booking']['staff_list_id']);
			}
			if($this->input->post('step') == '4' and (!isset($_POST['step2']))){
				$customer_number=$this->input->post('customer_number');
				//echo "<pre>"; print_r($_POST);
				$customer_number = preg_replace('/\s+/', '', $customer_number);
				$customer_number = str_replace("+610","+61",$customer_number);
				
				$data['customer_number']= $customer_number;
				$old_format_date = $_SESSION['booking']['date'];
				$a = explode('-',$old_format_date);
				$old_format_date = $a[2].'-'.$a[1].'-'.$a[0];
				$data['date']= $date=$old_format_date;			
				$data['time']= $time = $this->input->post('time');
				$data['time']= $time = $_SESSION['booking']['time'];			
				$data['first_name']= $first_name = $this->input->post('first_name');
				$data['last_name']= $last_name = $this->input->post('last_name');
				$data['email']= $email = $this->input->post('email');
				//$data['group_service_id']=	$group_service_id = $this->input->post('group_service_id');
				//print_r($_SESSION['booking']['group_service_id']); exit;
				$data['appointment_total_amount']= $appointment_total_amount = $this->input->post('appointment_total_amount');
				$staff_notes = $this->input->post('staff_notes');
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('customer_number', 'First Name', 'trim|required|xss_clean|regex_match[/^\+?(\d[\d-. ]+)?(\([\d-. ]+\))?[\d-. ]+\d$/]');
				$this->form_validation->set_rules('email', 'Last Name', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_message('valid_email', 'Please Provide valid email');
				$this->form_validation->set_message('regex_match', 'Please Provide 10 digit mobile');
				if ($this->form_validation->run() == TRUE) {
					if(isset($_SESSION['booking']['staff_list_id']) && count((array)$_SESSION['booking']['staff_list_id']) != 0){
						$staffId =  $_SESSION['booking']['staff_list_id'][0]['id'];
						//$location_id =getLocationIdbyStaffId($staffId);
						
						$location_id=$_SESSION['booking']['location_id'];
						$location_name = getLocationNameById($location_id);

						$booking_number = generateBookingNo($staffId,$location_id);
						}else{
						$staffId =  0;
						$location_id =0;
						$booking_number = rand(10000000,99999999);
					};		
					$customer = $this->db->from('customer')->where(array('mobile_number' =>$customer_number))->get()->row_array(); 

					$booking_widget_status= $this->db->select('*')->from('calendar_settings')->where(['business_id'=>$id])->get()->row()->booking_widget_status;
					if ($booking_widget_status==1) {
						$booking_status=0;
					}
					else{
						$booking_status=1;

					}

					//print_r($customer);
					//exit;
					//echo $staffId; exit;
					
					if($customer){
						
						$customer_id=$customer['id'];
						/*
							$updateData = array(
							'business_id'=>$id,
							'location_id'=>$location_id,
							'first_name'=>$this->input->post('first_name'),
							'last_name'=>$this->input->post('last_name'),
							'email'=>$this->input->post('email'),
							'mobile_number'=>$customer_number,
							'date_created'=>date('Y-m-d H:i:s'),
							); 
						$old_customer = $this->db->where('id', $customer['id'])->update('customer', $updateData);*/
						
						$bookingData =  array(
						'booking_number' =>$booking_number,
						'customer_id' => $customer['id'],
						'business_id' => $id,
						'location_id' => $location_id,
						'staff_id' => $staffId,
						'staff_notes' => $this->input->post('staff_notes'),
						'start_date'=>$date, 
						'start_time'=>$time,
						'booking_status'=>$booking_status,
						'booking_type'=>1,
						'date_created'=>date('Y-m-d H:i:s')
						); 
						
						$new_booking =  $this->db->insert('bookings',$bookingData);
						$last_booking_id = $this->db->insert_id();
						$last_booking = $this->db->from('bookings')->where(array('id' =>$last_booking_id))->get()->row_array();
						
						}else{
						
						$insertData = array(
				        //'customer_number'=>generateCustID($id),
				        'business_id'=>$id,
				        'location_id'=>$location_id,
				        'first_name'=>$this->input->post('first_name'),
				        'last_name'=>$this->input->post('last_name'),
				        'email'=>$this->input->post('email'),
				        'mobile_number'=>$customer_number,
				        'customer_type'=>'widget',
				        'status'=>1,
				        'notification'=>'email',
				        'reminders'=>'both',
				        'date_created'=>date('Y-m-d H:i:s'),
						); 
						
						$new_customer =  $this->db->insert('customer',$insertData);
						
						$customer_id = $this->db->insert_id();
						$u_data = array(
						'customer_number'=>$id.'0'.$customer_id
						);
						$this->others->update_common_value("customer",$u_data,"id='".$customer_id."' ");
						$bookingData =  array(
						'booking_number' =>$booking_number,
						'customer_id' => $customer_id,
						'business_id' => $id,
						'location_id' => $location_id,
						'staff_id' => $staffId,
						'staff_notes' => $this->input->post('staff_notes'),
						'start_date'=>$date, 
						'start_time'=>$time,
						'booking_status'=>$booking_status,
						'booking_type'=>1,
						'date_created'=>date('Y-m-d H:i:s')
						);
						
						$new_booking =  $this->db->insert('bookings',$bookingData);
						$last_booking_id = $this->db->insert_id();
						$last_booking = $this->db->from('bookings')->where(array('id' =>$last_booking_id))->get()->row_array();
						
						//$this->load->view('thankyou',$data);
						
					}
					
					$i=0;			
					foreach($_SESSION['booking']['service_listing'] as $key=>$item){
						$i++;
						//echo $i;
						if (count((array)$_SESSION['booking']['service_listing'])>1 && $i>1) {
							
							$last_start_time = $this->db->from('booking_services')->where(array('id' =>$last_booking_time))->get()->row_array();
							
							//print_r($last_start_time['book_duration']);
							
							$str_time =$last_start_time['book_start_time'];
							
							$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
							
							sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
							
							$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
							
							$str_time =$last_start_time['book_duration'];
							
							$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
							
							sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
							
							$hrs_toadd_seconds = $hours * 3600 + $minutes * 60 + $seconds;
							
							$last_booking_time = $hrs_old_seconds + $hrs_toadd_seconds;
							
							$last_booking['start_time']=gmdate("H:i:s", $last_booking_time);
						}
						
						
						$BookingService = array(
						'booking_id' =>$last_booking_id,
						'group_service_id'=>isset($_SESSION['booking']['group_service_id'][$item['id']])?$_SESSION['booking']['group_service_id'][$item['id']]:0,
						'service_id' => getmainServiceId($item['id']),
						'service_timing_id' => $item['id'],
						'staff_id' => $staffId,
						'book_start_time' => $last_booking['start_time'],
						'book_duration' => $item['duration'],
						'book_end_time'=>sum_the_time($last_booking['start_time'],$item['duration']),
						'date' => $last_booking['start_date'],
				        );		
						
						//echo $last_booking['start_time'].'</br>'; 
						$new_booking_service =  $this->db->insert('booking_services',$BookingService);
						$last_booking_time = $this->db->insert_id();
						
						//print_r($this->db->last_query()); exit;
						//print_r($customer_id); exit;
						if($customer_id !=null){
							
							$customer_data = $this->db->select('*')->from('customer')->where('id',$customer_id)->get()->row_array();
							//online booking time sms send
							
							/*if($customer_data['mobile_number'] !="" && strlen($customer_data['mobile_number'])>2 ){
								require_once(APPPATH.'twilio-php-master/Twilio/autoload.php');
								$smsaccount=getTwilioSmsAccounts($customer_data['business_id']);
								$twalio_keys = array(
								// "sid"      => $this->config->item('sid'),
								// "token" => $this->config->item('token'),
								"sid"      => $smsaccount['account_sid'],						
								"token" => $smsaccount['auth_token'],
								"twalio_phone_number" => $smsaccount['mobile_number'],
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
								'body' => "Your online bookings appointment has been booked successfully."
							    )
								);
								}catch(Exception $e){
								//echo "<pre>",print_r($e->getMessage());die;
								}
								}
							*/
							
							
							//	echo 
							
						}	
						//End
						
						
						
						
						//online booking time mail send
						
					}
					
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
					$appointment_booking_number=$booking_number;
					$customer_id=isset($customer_id)?$customer_id:$customer['id'];
					$business_name = getBusinessNameById($id);
					$customer_name = getCustomerNameById($customer_id);

					$booking_widget_status= $this->db->select('*')->from('calendar_settings')->where(['business_id'=>$id])->get()->row()->booking_widget_status;
					if ($booking_widget_status==1) {
					$appointment_email= getEmailTemplate($id,'onlinepencilledbookings');
					}else{
						$appointment_email= getEmailTemplate($id,'onlinebookings');
					}
					
					
					
					/* $this->db->select('*');
						$this->db->from('business_templates');
						$this->db->where('slug','onlinebookings');
						$this->db->where('business_id',$id);
						$appointment_email = $this->db->get()->row_array();
						
						
						if (!$appointment_email || $appointment_email==''|| empty($appointment_email)) {
						$this->db->select('*');
						$this->db->from('business_templates');
						$this->db->where('slug','onlinebookings');
						$this->db->where('business_id',0);
						$appointment_email = $this->db->get()->row_array();
					}*/		
					
					$location_deatils=getLocationData($_SESSION['booking']['location_id']); 
					$service_list='';
					$i=1;
					foreach ($_SESSION['booking']['service_listing_arr'] as $key => $value) {
						//$service_name=getCaptionName($value);
						$caption_name=getCaptionName($value);
						$service_main_id=getmainServiceId($value);			 	
						$service_main_name=getServiceName($service_main_id);
						
						$service_list.='<br>'.$i.'.  '.$service_main_name.' '.$caption_name;
						//  	$service_list.='<br>'.$i.'.  '.$service_name;
						$i++;
					}  
					
					
					
					$subject = str_replace("{BUSINESS_NAME}",$business_name,$appointment_email['subject']);
					$mail_data = str_replace(["{BUSINESS_NAME}","{CUSTOMER_NAME}","{APPOINTMENT_NUMBER}","{TOTAL_AMOUNT}","{location}","{date}","{time}","{service}","{LOCATION_PHONE}"],[$business_name,$customer_name,$appointment_booking_number,$appointment_total_amount,$location_deatils['location_name'],$_SESSION['booking']['date'],$_SESSION['booking']['time'],$service_list,$location_deatils['phone_number']], $appointment_email['email_html']);
					$appointment['subject'] = $subject;
					$appointment['mail_data'] = $mail_data;
					
					$customer_email = $this->db->select('*')->from('customer')->where('id',$customer_id)->get()->row_array();
					$old_format_date = $_SESSION['booking']['date'];
					$a = explode('-',$old_format_date);
					$date = $a[2].'-'.$a[1].'-'.$a[0];
					//print_r($_SESSION['booking']['service_listing_duration']); exit;
					
					//$mail_content = $this->load->view('admin/templates/onlinebooking',$appointment,true);
					
					$mail_content = $this->load->view('booking-confirmation',$appointment,true);
					
					
					$data['business_id'] = $id;
					$data['customer_id'] = $customer_id;
					$data['appointment_booking_number'] = $appointment_booking_number;
					$data['date'] = $date;
					$data['service'] = $_SESSION['booking']['service_listing_arr'];
					$data['staff'] = $_SESSION['booking']['staff_list_id'][0]['id'];
					$data['duration'] = $_SESSION['booking']['service_listing_duration'];
					$data['start_time'] = $_SESSION['booking']['time'];
					$data['appointment_total_amount'] = $appointment_total_amount;
					if (isset($_SESSION['booking'])) {		    	
						
						$this->load->helper('dompdf');
						$this->load->library('dompdf_gen');
						$this->load->view("admin/calendar/onlinebooking_pdf",$data);
						$html = $this->output->get_output();
						$this->dompdf->load_html($html);
						$this->dompdf->render();			
						file_put_contents('uploads/onlinebooking/'.$appointment_booking_number.".pdf", 
						$this->dompdf->output());
					}
					//echo $email =$data['email'];	exit;
					
					$this->db->select('*');
					$this->db->from('location');
					$this->db->where('id',$_SESSION['booking']['location_id']);
					$getlocation=$this->db->get()->row_array();
					$locationmail=$getlocation['email'];
					$mail = $this->config->item('mail_data');
					
					//print_r($mail); exit;
					
					$this->load->library('email', $mail);
					$this->email->set_newline("\r\n");
					// $this->email->from('developer@bookingintime.com',$business_name);
					$this->email->from($this->config->item('default_mail'),$business_name.'/'.$location_name);
					$list = array($email);
					$this->email->to($list);
					$this->email->subject($subject);
					$this->email->message($mail_content);
					$file_name = $appointment_booking_number.".pdf";
					// $this->email->attach(base_url('uploads/onlinebooking/'.$file_name));
					$this->email->send();
					if (isset($locationmail) && $locationmail!='') {
						$welcome_email = getEmailTemplate($id,'email-for-location');
						$mail_data = str_replace(["{CUSTOMER_NAME}","{APPOINTMENT_NUMBER}","{BUSINESS_NAME}","{date}","{time}","{service}","{LOCATION_NAME}","{LOCATION_PHONE}"],[$customer_name,$appointment_booking_number,$business_name,$_SESSION['booking']['date'],$_SESSION['booking']['time'],$service_list,$getlocation['location_name'],$getlocation['phone_number']], $welcome_email['email_html']);
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
					/*  if (!$this->email->send()) {               
						show_error($this->email->print_debugger()); exit;
						}
						else {
						
						echo 'Success to send email'; exit;
					}*/
					
					
					//exit;
					unset($_SESSION['booking']);
					$data['step'] = 0;
					redirect(base_url('online-bookings/'.$encode));
					
					
					}else{
					$data['step'] = 3;
					//echo "adsas a asasds";die;
				}
				
			}
			
			
			/*$service_list = $this->db->select('*')->from('services')->where(array('services.business_id' => $id))->get()->result_array();
				foreach ($service_list as $key => $value) {
				$captions = $this->db->select('*')->from('service_timing')->where(array('service_timing.service_id' =>$value['id']))->get()->result_array();
				$service_list[$key]['captions'] = $captions;
				}
				
			$data['service_list'] = $service_list;*/
			$service_categories = $this->db->select('*')->from('service_category')->where(['business_id'=>$id,'cat_type'=>1])->order_by('short_number', 'ASC')->get()->result_array();
			if($service_categories){
				foreach ($service_categories as $key => $value) {
					$service_categories[$key]['services'] = $this->db->select('*')->from('services')->where(array('business_id' => $id,'is_service_group' => 0,'service_category_id'=>$value['id'],'is_online'=>1))->get()->result_array();
					if($service_categories[$key]['services']){
						foreach ($service_categories[$key]['services'] as $kkey => $vvalue) {
							$service_categories[$key]['services'][$kkey]['service_timing'] = $this->db->select('*')->from('service_timing')->where(['service_id'=>$vvalue['id'],'status'=>1])->get()->result_array();
						}
					}
				}
			}
			//gs($service_categories);
			$data['service_list'] = $service_categories;
			
			$arr_search['business_id'] = $id;
			$all_service_group = get_service_group_helper(false,$arr_search,"", "","sequenceo_order","ASC");
			//print_r($all_service_group); exit;
			
			$data['options_gs']=$all_service_group;
			
			//echo "<pre>"; print_r($data['options_gs']); die;
			$location_id = (isset($_SESSION['booking']['location_id']))?$_SESSION['booking']['location_id']:"";
			
			
			$total_service_id=(isset($_SESSION['booking']['service_listing_arr']))?$_SESSION['booking']['service_listing_arr']:"";
			$total_service_end_time=(isset($_SESSION['booking']['service_end_time']))?$_SESSION['booking']['service_end_time']:"";
			
			if (isset($_SESSION['booking']['service_listing_arr'])) {
				$total_service_main_id=[];
				foreach ($_SESSION['booking']['service_listing_arr'] as $key => $value) {
					$total_service_main_id[]=getmainServiceId($value);
				}
			}
			
			//print_r($service_main_id);
			
			
			//print_r($total_service_id); exit;	
			
			//echo $total_service_end_time; exit;
			
			$total_service_start_time=(isset($_SESSION['booking']['time']))?$_SESSION['booking']['time']:"";
			
			
			$service_start_date=(isset($_SESSION['booking']['date']))?$_SESSION['booking']['date']:"";	
			$a = explode('-',$service_start_date);
			if (isset($_SESSION['booking']['date'])) {
				$service_start_date = trim($a[2]).'-'.trim($a[1]).'-'.trim($a[0]);
			}
			
			//print_r($_SESSION['booking']['time']); exit;
			
			$week_day = getWeekDay($service_start_date);
			//echo $week_day; exit;
			//echo $total_service_date; exit;		

			$booking_widget_status= $this->db->select('*')->from('calendar_settings')->where(['business_id'=>$id])->get()->row()->booking_widget_status;
			if ($booking_widget_status==1) {
				$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner');			
			$this->db->where('roster.week_day',$week_day);
			$this->db->where('roster.week_day_date <= ',$service_start_date);
			$this->db->where('roster.is_repeat',1);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);	
			$data1=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;

			$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner');			
			$this->db->where('roster.week_day_date',$service_start_date);
			$this->db->where('roster.is_repeat',0);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);			
			$data2=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;

			$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner'); 			
			$this->db->where('roster.week_day',$week_day);
			$this->db->where('roster.week_day_date <= ',$service_start_date);
			$this->db->where('roster.end_repeat_date >= ',$service_start_date);
			$this->db->where('roster.is_repeat',2);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);		
			$data3=$this->db->get()->result_array();
			$result_data=array_merge($data1,$data2,$data3);		

			//print_r($result_data); exit;	
			$serialized_array = array_map("serialize", $result_data);
			$result=[];
			foreach ($serialized_array as $key => $val) {				
				$result[$val] = true;				
			}			
			$staff_list= array_map("unserialize", (array_keys($result)));
			//print_r($staff_list); exit;
			$data['staff_list'] = $staff_list;
		}
			else{
				
				/*$query = $this->db->query("SELECT * FROM booking_services WHERE date='$service_start_date'  and book_start_time<='$total_service_end_time' and book_end_time >= '$total_service_start_time' GROUP BY staff_id ");
 			$total_booking = $query->result_array();
*/	
 			//echo $total_service_start_time; exit;
 				$query = $this->db->query("SELECT * FROM booking_services WHERE date='$service_start_date'  AND book_end_time>'$total_service_start_time' AND book_start_time<'$total_service_end_time'GROUP BY staff_id");
 			$total_booking = $query->result_array();

 			//print_r($this->db->last_query()); exit;
 			
			
			
 			$total_booking_staff_id=[];
 			foreach ($total_booking as $key => $value) {
 				$total_booking_staff_id[]=$value['staff_id'];
			}
 			//$total_booking_staff_id=implode(',', $total_booking_staff_id);
 			//print_r($total_booking_staff_id); exit;
			$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner');
			$this->db->join('staff_services','roster.staff_id=staff_services.staff_id','inner');
			$this->db->where('roster.week_day',$week_day);
			$this->db->where('roster.week_day_date <= ',$service_start_date);
			$this->db->where('roster.is_repeat',1);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);
			//$this->db->where('staff.staff_type',0);
			if (!empty($total_booking_staff_id)) {
				$this->db->where_not_in('roster.staff_id', ($total_booking_staff_id));
			}
			
			if (!empty($total_service_main_id)) {
				$this->db->where_in('staff_services.service_id', ($total_service_main_id));
			}
 			
			$data1=$this->db->get()->result_array();
			
 			//print_r($this->db->last_query()); exit;
 			
			
			$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner');
			$this->db->join('staff_services','roster.staff_id=staff_services.staff_id','inner');
			$this->db->where('roster.week_day_date',$service_start_date);
			$this->db->where('roster.is_repeat',0);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);
 			// $this->db->where('staff.staff_type',0);
			if (!empty($total_booking_staff_id)) {
				$this->db->where_not_in('roster.staff_id', ($total_booking_staff_id));
			}
			if (!empty($total_service_main_id)) {
				$this->db->where_in('staff_services.service_id', ($total_service_main_id));
			}
			$data2=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
			
			$this->db->select('staff.first_name,staff.last_name,staff.id');
			$this->db->from('roster');
			$this->db->join('staff','roster.staff_id=staff.id','inner'); 
			$this->db->join('staff_services','roster.staff_id=staff_services.staff_id','inner'); 
			$this->db->where('roster.week_day',$week_day);
			$this->db->where('roster.week_day_date <= ',$service_start_date);
			$this->db->where('roster.end_repeat_date >= ',$service_start_date);
			$this->db->where('roster.is_repeat',2);
			$this->db->where('roster.location_id',$location_id);
			$this->db->where('roster.is_break',0);
			$this->db->where('roster.start_hours <= ',$total_service_start_time);
			$this->db->where('roster.end_hours >= ',$total_service_end_time);
			$this->db->where('staff.business_id',$id);
 			// $this->db->where('staff.staff_type',0);
			if (!empty($total_booking_staff_id)) {
				$this->db->where_not_in('roster.staff_id', ($total_booking_staff_id));
			}
			if (!empty($total_service_main_id)) {
				$this->db->where_in('staff_services.service_id', ($total_service_main_id));
			}
			$data3=$this->db->get()->result_array();
			//print_r($this->db->last_query()); exit;
			
			$result_data=array_merge($data1,$data2,$data3);
 			// print_r( $result_data); exit;
			
			///function get_unique_associate_array($array) {
			
			$serialized_array = array_map("serialize", $result_data);
			$result=[];
			foreach ($serialized_array as $key => $val) {
				
				$result[$val] = true;
				
			}
			
			$staff_list= array_map("unserialize", (array_keys($result)));
			
			// gs($staff_list);
			if(count((array)$staff_list)>0){
				foreach ($staff_list as $key => $value) {
					$staff_id = $value['id'];
					$query = $this->db->query("SELECT * FROM blocked_time WHERE date='$service_start_date' and staff_id=$staff_id and start_time<='$total_service_end_time' and end_time >= '$total_service_start_time'");
					$ddata = $query->result_array();
					if($ddata){
						unset($staff_list[$key]);
					}
				}
			}
			//gs($staff_list);
			$data['staff_list'] = $staff_list;

			}


			
			$locations = $this->db->select('*')->from('location')->where(['business_id'=>$id,'status'=>1])->get()->result_array();


			$data['locations'] = $locations;	
			$this->load->view('widget_view',$data);
		}
		
		
		public function sign_up()
		{
			//print_r("hi"); exit;
			$this->load->helper(array('form', 'url'));
			$data = array();
			if($this->input->post('action')){
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admin_users.email]');
				$this->form_validation->set_rules('passwd', 'Password', 'trim|required|xss_clean');
				$this->form_validation->set_rules('owner_first_name', 'Owner first name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
				$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean'); 
				
				$this->form_validation->set_message("required","field is required.");
				$this->form_validation->set_message("valid_email","Email is not valid.");
				$this->form_validation->set_message("is_unique","Must be unique"); 
				
				
				$data['name'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				$data['address1'] = $this->input->post('address1');
				$data['city'] = $this->input->post('city');
				$data['state'] = $this->input->post('state');
				$data['website'] = $this->input->post('website');
				$data['phone_number'] = $this->input->post('phone_number');
				$data['owner_first_name'] = $this->input->post('owner_first_name');
				$data['owner_last_name'] = $this->input->post('owner_last_name');
				
				
				//$data['business_category_id'] = $this->input->post('business_category_id');
				//$data['country_id'] = $this->input->post('country_id');
				$data['post_code'] = $this->input->post('post_code');
				//$data['currency_id'] = $this->input->post('currency_id');
				//$data['time_zone_id'] = $this->input->post('time_zone_id');
				//$data['time_format'] = $this->input->post('time_format');
				$data['description'] = $this->input->post('description');
				//$data['logo'] = $this->input->post('logo');
				//$data['facebook_url'] = $this->input->post('facebook_url');
				//$data['twitter_url'] = $this->input->post('twitter_url');
				// print_r($data); die;
				if ($this->form_validation->run() == TRUE) {
					
					$picture = ""; 
					
					
					$insert_data = array('name'=>$this->input->post('name'),
					'email'=>$this->input->post('email'),
					'password'=>$this->input->post('passwd'),
					'address1'=>$this->input->post('address1'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'website'=>$this->input->post('website'),
					'phone_number'=>$this->input->post('phone_number'),
					'owner_first_name'=>$this->input->post('owner_first_name'),
					'owner_last_name'=>$this->input->post('owner_last_name'),
					//'business_category_id'=>$this->input->post('business_category_id'),
					//'country_id'=>$this->input->post('country_id'),
					'post_code'=>$this->input->post('post_code'),
					//'currency_id'=>$this->input->post('currency_id'),
					//'time_zone_id'=>$this->input->post('time_zone_id'),
					//'time_format'=>$this->input->post('time_format'),
					'description'=>$this->input->post('description'),
					//'logo'=>$picture,
					//'facebook_url'=>$this->input->post('facebook_url'),
					//'twitter_url'=>$this->input->post('twitter_url'),
					'date_created' => date('Y-m-d H:i:s'));
					
					$success = $this->others->insert_data("business",$insert_data);
					if ($success) {
						$admin_name = $this->input->post('owner_first_name');
						if(!empty($this->input->post('owner_last_name'))){
							$admin_name .=' '.$this->input->post('owner_last_name');
						}
						$insert_id = $success;
						//Create a business owner account
						$email = $this->input->post('email');
						$vhash = md5($this->input->post('email')).time();
						$insert_admin = array('email'=>$this->input->post('email'),
						'password'=>md5($this->input->post('passwd')),
						'admin_name'=>$admin_name,
						'role'=>'business_owner',
						'business_id'=>$insert_id,
						'trial_expire_date'=>"".date('Y-m-d',strtotime("+15 day"))."",
						'payment_status'=>0,
						'status'=>0,
						'verify_hash'=>$vhash,
						'date_created' => date('Y-m-d H:i:s'));
						//gs($insert_admin);die;
						$this->others->insert_data("admin_users",$insert_admin);
						$welcome_email = $this->db->select('*')->from('templates')->where('slug','account-confirmation')->get()->row_array();
						$link = "Please click here to verify your email <a href='".base_url('verify/'.$vhash)."'>Verify Now</a>";
						$mail_data = str_replace(["{LINK}"],[$link], $welcome_email['email_html']);
						//echo $mail_data;die;
						$data['subject'] =$welcome_email['subject'];
						$data['mail_data'] = $mail_data;
						$subject = $welcome_email['subject'];
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
						$mail = $this->config->item('mail_data');
						$mail_content = $this->load->view('thankyou_email',$data,true);
						//echo $mail_content;die;
						$this->load->library('email', $mail);
						$this->email->set_newline("\r\n");
						
						$this->email->from($this->config->item('default_mail'),$admin_name);
						// $this->email->from('developer@bookingintime.com',$admin_name);
						$list = array($email);
						$this->email->to($list);
						$this->email->subject($subject);
						$this->email->message($mail_content);
						$this->email->send();
						
						//supper admin mail 
						
						$welcome_email = $this->db->select('*')->from('templates')->where('slug','new_business _register')->get()->row_array();
						$email= $data['email'];
						$phone_number= $data['phone_number'];
						$mail_data = str_replace(["{BUSINESS_NAME}","{Email}","{PHONE_NUMBER}","{ADMIN_NAME}"],[$admin_name,$email,$phone_number], $welcome_email['email_html']);
						$data['subject'] =$welcome_email['subject'];
						$data['mail_data'] = $mail_data;
						$subject = $welcome_email['subject'];
						$mail = $this->config->item('mail_data');
						//$mail_content = $this->load->view('thankyou_email',$data,true);
						$mail_content = $this->load->view('booking-confirmation',$data,true);
						
						$adminDetails = $this->db->select('*')->from('admin_users')->where('role','owner')->get()->row_array();
						$admin_email=$adminDetails['email'];
						$admin_name=$adminDetails['admin_name'];
						
						$this->load->library('email', $mail);
						$this->email->set_newline("\r\n");
						$this->email->from($this->config->item('default_mail'),$admin_name);
						$list = array($admin_email);
						$this->email->to($list);
						$this->email->subject($subject);
						$this->email->message($mail_content);
						$this->email->send();
						
						
						$this->session->set_flashdata('new_data', $insert_admin);
						redirect(base_url('thank-you'));
						} else {
						$this->session->set_flashdata('error_msg', "Adding business is failed!");
						redirect(base_url('sign_up'));
					}
					} else {
					// gs($_POST);die;
					$this->session->set_flashdata('error_msg', "Please fill mandatory fields of business form!");
					//redirect(base_url('sign_up'));
				}
				
			}
			//
			$this->load->view('sign_up', $data); 
		}
		
		public function thankyou(){
			//gs($this->session->flashdata('new_data'));die;
			$data['data'] = $this->session->flashdata('new_data');
			if(!$this->session->flashdata('new_data')){
				redirect(base_url('admin/login'));
			}
			$this->load->view('thankyou',$data);
		}
		
		public function verify(){
			$hash = $this->uri->segment(2);
			$validate_email = $this->db->select('*')->from('admin_users')->where(['verify_hash'=>$hash])->get()->row_array();
			if($validate_email)
			{
				/*$update_data['status']=1;
				$this->others->update_common_value("admin_users",$update_data,"id='".$validate_email['id']."' ");*/
				$this->session->set_flashdata('success_msg', "Your account has been verified successfully.");
				redirect(base_url('admin/login'));
				}else{
				$this->session->set_flashdata('error_msg', "Record Could not found.");
				redirect(base_url('admin/login'));
			}
		}
		
		public function sms_confirmation_cron(){
			
			/*$admin_session = $this->session->userdata('admin_logged_in');
				print_r($admin_session); exit;
				$time_slot = $this->db->select('*')->from('email_confirmation_time')->where('business_id',$admin_session['business_id'])->get()->row_array();
				if(count((array)$time_slot)>0){
				$before_time  = $time_slot['time'];
				}else{
				
			}*/
			$time_array = $this->db->select('*')->from('email_confirmation_time')->get()->result_array();
			//print_r($this->db->last_query()); exit;
			
			foreach($time_array as $time_slot){
				if(!empty($time_slot)){
					$before_time  = $time_slot['time'];
					$business_id = $time_slot['business_id'];
					}else{
					$before_time = 24;
					$business_id ='';
					
				}
				//echo $before_time; exit;
				$status = implode(",",array(0,1,6));
				$now  = date("Y-m-d H:i:s"); 
				$date = date("Y-m-d H:i:s", strtotime('+'.$before_time.' hours',time()));
				
				$bookings = $this->db->query("SELECT * FROM bookings where (cast(concat(start_date, ' ', start_time) as datetime) >='$now') and (cast(concat(start_date, ' ', start_time) as datetime) <='$date') and business_id = $business_id and booking_status in ($status) and is_confirmation_sent in(0,2) and customer_id!=''")->result_array();
				
				//$bookings = $this->db->query("SELECT * FROM bookings where id=864")->result_array();	
				print_r($this->db->last_query());
				echo "<br/>";
				if(count((array)$bookings)>0){	
					foreach ($bookings as $key => $value) {
						
						$welcome_email = getEmailTemplate($value['business_id'],'appointment-reminder');	
						$customer_data = $this->db->select('*')->from('customer')->where('id',$value['customer_id'])->get()->row_array();	
						//print_r($customer_data); exit;
						
						//$customer_name = $customer_data['first_name'].' '.$customer_data['last_name'];		
						$customer_name = $customer_data['first_name'];		
						$customer_number = $customer_data['mobile_number'];		
						$booking_referance = $value['booking_number'];		
						$business_name = getBusinessNameById($value['business_id']);		
						$booking_id = base64_encode($value['id']);
						$booking_date_time = date("d M,Y",strtotime($value['start_date']));	
						$booking_start_time = date("h:i a",strtotime($value['start_time']));	
						$location_data = getLocationData($value['location_id']);
						$location_name = $location_data['location_name'];
						$location_phone = $location_data['phone_number'];
						$location_email = $location_data['email'];
						//echo $location_email;die;
						$this->db->select('*');
						$this->db->from('booking_services');
						$this->db->where('booking_id',$value['id']);
						$booking_service=$this->db->get()->result_array();
						//$booking_start_time = date("h:i a",strtotime($booking_service[0]['book_start_time']));
						
						$service_list='';
						$i=1;
						foreach ($booking_service as $key => $service) {
							//$service_name=getCaptionName($service['service_id']);
							$caption_name=getCaptionName($service['service_timing_id']);
							$service_main_name=getServiceName($service['service_id']);
							
							$service_list.='<br>'.$i.'.  '.$service_main_name.' '.$caption_name;
							$i++;
						}  
						$email = $customer_data['email'];
						
						if($email !='' && ($customer_data['notification']=='both' or $customer_data['notification']=='email')){
							$link = base_url('verify-appointment/'.$booking_id);
							$mail_data = str_replace(["{CLIENT_FIRST_NAME}","{BOOKING_REFERENCE}","{BUSINESS_NAME}","{BOOKING_DATE_TIME}","{LOCATION_NAME}","{LOCATION_PHONE}","{LOCATION_EMAIL}","{LINK}","{service}"],[$customer_name,$booking_referance,$business_name,$booking_date_time,$location_name,$location_phone,$location_email,$link,$service_list], $welcome_email['email_html']);
							//echo $mail_data;die;
							$data['subject'] =$welcome_email['subject'];
							$data['mail_data'] = $mail_data;
							$subject = $welcome_email['subject'];
							$mail_content = $this->load->view('booking-confirmation',$data,true);
							// echo $mail_content;die;
							$mail = $this->config->item('mail_data');
							$this->load->library('email', $mail);
							$this->email->set_newline("\r\n");
							$this->email->from($this->config->item('default_mail'),$location_name);
							$list = array($email);
							$this->email->to($list);
							$this->email->subject($subject);
							$this->email->message($mail_content);
							// $this->email->send(); 
						}
						//print_r($customer_data); exit;
						//  Confirmation Message
						//$customer_number='+919079832203';
						//if (1==1) {
						//echo $customer_number; exit;
						if($customer_number !="" && strlen($customer_number)>2 && ($customer_data['reminders']=='both' or $customer_data['reminders']=='sms')){
							require_once(APPPATH.'twilio-php-master/Twilio/autoload.php');
							$smsaccount=getTwilioSmsAccounts($customer_data['business_id']);
							$twalio_keys = array(
							//"sid"      => $this->config->item('sid'),
							"sid"      => $smsaccount['account_sid'],						
							"token" => $smsaccount['auth_token'],
							"twalio_phone_number" => $smsaccount['mobile_number'],					  
							// "token" => $this->config->item('token'),
							// "twalio_phone_number" => $this->config->item('twalio_phone_number'),
							"twalio_messaging_service_id" => $this->config->item('twalio_messaging_service_id'),
							);
							$mobile_number = str_replace(" ","",$customer_number);
							//$mobile_number = "+919672141097";
							//gs($mobile_number);
							$client = new Client($twalio_keys['sid'], $twalio_keys['token']);
							//$mobile_number = "+919079832203"
							try{
								$client->messages->create(
								// the number you'd like to send the message to
								$mobile_number,
								//'+61450372103',
								array(
								// A Twilio phone number you purchased at twilio.com/console
								'from' => $twalio_keys['twalio_phone_number'],
								// the body of the text message you'd like to send
								/*'body' => "Hi $customer_name,\n This is a friendly reminder about your appointment with $location_name on $booking_date_time \n Please reply with Ok-$booking_referance to confirm."*/
								'body' => "Hi $customer_name,\nReminder for your booking at $location_name on $booking_date_time/$booking_start_time.\nReply Yes or Call us to discuss\n$business_name\n$location_phone"
								)
								);
								echo "<br/> Message Sent";
								}catch(Exception $e){
								echo "<br/><pre>",print_r($e->getMessage());//die;
							}
							$update_booking = array(
							'is_confirmation_sent'=>1,
							'date_updated'=>date("Y-m-d H:i:s")
							);
							$this->others->update_common_value("bookings",$update_booking,"id='".$value['id']."' ");
							insertBookingLog($value['id'],'SMS',null,null);

							
						}
						
					}
				}
			}		
		}
		
		
		function verify_appointment(){
			$id = $hash = $this->uri->segment(2);
			if($id==""){
				return redirect(base_url('/'));
			}
			$appointment_id = base64_decode($id);
			$update_booking = array(
	    	'booking_status'=>8,
			'date_updated'=>date("Y-m-d H:i:s")
			);
			$this->others->update_common_value("bookings",$update_booking,"id='".$appointment_id."' ");
			insertBookingLog($appointment_id,'SMS',null,null);

			// Send Message from twalio Api
			$booking_data = $this->db->select('*')->from('bookings')->where('id',$appointment_id)->get()->row_array();
			$customer_id = $booking_data['customer_id'];
			if($customer_id !=null){
				$customer_data = $this->db->select('*')->from('customer')->where('id',$customer_id)->get()->row_array();
				if($customer_data['mobile_number'] !="" && strlen($customer_data['mobile_number'])>2 && ($customer_data['notification']=='both' or $customer_data['notification']=='sms') && $booking_data['is_confirmation_sent']!=2){
					$smsaccount=getTwilioSmsAccounts($customer_data['business_id']);
					require_once(APPPATH.'twilio-php-master/Twilio/autoload.php');
					$twalio_keys = array(
					"sid"      => $smsaccount['account_sid'],						
					"token" => $smsaccount['auth_token'],
					"twalio_phone_number" => $smsaccount['mobile_number'],
					//"sid"      => $this->config->item('sid'),
					// "token" => $this->config->item('token'),
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
						'body' => "Your appointment has been re-confirmed successfully."
					    )
						);
						}catch(Exception $e){
						//echo "<pre>",print_r($e->getMessage());die;
					}
				}
			}
			return redirect(base_url('appointment-confirmed'));
		}
		
		function appointment_confirmed(){
			$this->load->view('appointment_confirmed');
		}
		
		function confirm_mobile(){
			$from = $_POST['From'];
			$body = $_POST['Body'];
			$customer_data = $this->db->select('*')->from('customer')->where('mobile_number',$from)->get()->row_array();
			$sms = $body;
			$customer_id = $customer_data['id'];
			$before_time = 24;
			$status = implode(",",array(0,1,6));
			$now  = date("Y-m-d");
			$date = date("Y-m-d", strtotime('+'.$before_time.' hours',time()));
			if($customer_id!="" && ($body=="yes" or $body=="YES" or $body=="Yes")){
				$bookings = $this->db->query("SELECT * FROM bookings where ((start_date >='$now') and (start_date <='$date')) and booking_status in ($status) and customer_id=$customer_id")->result_array();
				if($bookings){
					$update_booking = array(
			    	'booking_status'=>8,
					'date_updated'=>date("Y-m-d H:i:s")
					);
					foreach ($bookings as $key => $value) {
						$this->others->update_common_value("bookings",$update_booking,"id='".$value['id']."' ");
					}
					/*$smsaccount=getTwilioSmsAccounts($customer_data['business_id']);
						require_once(APPPATH.'twilio-php-master/Twilio/autoload.php');
						$twalio_keys = array(
						"sid"      => $smsaccount['account_sid'],						
						"token" => $smsaccount['auth_token'],
						"twalio_phone_number" => $smsaccount['mobile_number'],
						"twalio_messaging_service_id" => $this->config->item('twalio_messaging_service_id'),
						);
						$mobile_number = $from;
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
						'body' => "Your appointment has been re-confirmed successfully."
					    )
						);
						}catch(Exception $e){
						//echo "<pre>",print_r($e->getMessage());die;
					}*/
				}
			}
		}
		
		
		function verify_bookingtime(){		
			$date_staff=$this->input->post('date_staff');		
			$weekday=date('w', strtotime($date_staff));
			$location_id=$_SESSION['booking']['location_id'];
			
			$this->db->select('*');
			$this->db->from('location_weekdays');
			$this->db->where('business_id',$_SESSION['booking']['business_id']);
			$this->db->where('location_id',$location_id);
			$this->db->where('weekday',$weekday);
			$getlocation_weekday=$this->db->get()->row_array();
			//print_r($this->db->last_query()); exit;
			$start_time=$getlocation_weekday['start_time'];
			$end_time=$getlocation_weekday['end_time'];
			if (empty($start_time) || $start_time=='') {
				$start_time= $this->config->item('location_start_time'); 
			}
			if (empty($end_time) || $end_time=='') {
				$end_time= $this->config->item('location_end_time'); 
			}
			$inc   = 15 * 60;
			$start_time=date("h:i A",strtotime($start_time));
			$end_time=date("h:i A",strtotime($end_time));
			
			if (date('d-m-Y')==$date_staff) {
				
				$melbourne = time();
				 $start_time= date("h:i A",$melbourne);
				 //$start_time=date("h:i A",strtotime($melbourne));				 
			}

			
			//echo $start_time.'  '. $end_time; exit;
			$start_time = (strtotime($start_time)); // 6  AM
			$end_time   = (strtotime($end_time)); // 10 PM			
			
			
			$staff_html = "<select>";
			for( $i = $start_time; $i <= $end_time; $i += $inc )
			{
				// to the standart format
				$range = date( 'g:i A', $i );
				$rangevalue = date( 'H:i', $i ); 
				$staff_html .= "<option value=".$rangevalue.">$range</option>";
			}
			$staff_html .= "</select>";
			$status = 'success';
			$jsonEncode = json_encode(array('status' => $status,'staff_html' => $staff_html));
			echo $jsonEncode;	
			
		}
		
		
		
		
		public function email_confirmation_cron(){			
			$time_array = $this->db->select('*')->from('email_confirmation_time')->get()->result_array();			
			foreach($time_array as $time_slot){
				
				/*$this->load->helper('file');		
		if ( ! write_file(FCPATH .'/uploads/uploads/log_'.date("Y-m-d").'.txt',$time_slot  )){
		echo 'Unable to write the file';
		}
		else{ 
		echo 'File written!';
		}
		print_r($time_slot); exit;*/

			

				if(count((array)$time_slot)>0){
					$before_time  = $time_slot['email_time'];
					$business_id = $time_slot['business_id'];
					}else{
					$before_time = 24;
					$business_id = '';
				}
				//echo $before_time; exit;
				$status = implode(",",array(0,1,6));
				$now  = date("Y-m-d H:i:s"); 
				$date = date("Y-m-d H:i:s", strtotime('+'.$before_time.' hours',time()));
				
				$bookings = $this->db->query("SELECT * FROM bookings where (cast(concat(start_date, ' ', start_time) as datetime) >='$now') and (cast(concat(start_date, ' ', start_time) as datetime) <='$date') and business_id = $business_id and booking_status in ($status) and is_confirmation_sent=0 and customer_id!=''")->result_array();	
				//print_r($this->db->last_query()); exit;	
				if(count((array)$bookings)>0){	
					foreach ($bookings as $key => $value) {
						
						$welcome_email = getEmailTemplate($value['business_id'],'appointment-reminder');	
						$customer_data = $this->db->select('*')->from('customer')->where('id',$value['customer_id'])->get()->row_array();	
						//print_r($this->db->last_query()); exit;
						//print_r($customer_data); exit;
						
						//$customer_name = $customer_data['first_name'].' '.$customer_data['last_name'];		
						$customer_name = $customer_data['first_name'];		
						$customer_number = $customer_data['mobile_number'];		
						$booking_referance = $value['booking_number'];		
						$business_name = getBusinessNameById($value['business_id']);		
						$booking_id = base64_encode($value['id']);
						$booking_date_time = date("d M,Y",strtotime($value['start_date']));	
						$booking_start_time = date("h:i a",strtotime($value['start_time']));

						$location_data = getLocationData($value['location_id']);
						$location_name = $location_data['location_name'];
						$location_phone = $location_data['phone_number'];
						$location_email = $location_data['email'];
						//echo $location_email;die;
						$this->db->select('*');
						$this->db->from('booking_services');
						$this->db->where('booking_id',$value['id']);
						$booking_service=$this->db->get()->result_array();
						//$booking_start_time = date("h:i a",strtotime($booking_service[0]['book_start_time']));
						
						$service_list='';
						$i=1;
						foreach ($booking_service as $key => $service) {
							//$service_name=getCaptionName($service['service_id']);
							$caption_name=getCaptionName($service['service_timing_id']);
							$service_main_name=getServiceName($service['service_id']);
							
							$service_list.='<br>'.$i.'.  '.$service_main_name.' '.$caption_name;
							$i++;
						}  
						$email = $customer_data['email'];
						
						if($email !='' && ($customer_data['notification']=='both' or $customer_data['notification']=='email')){
							$link = base_url('verify-appointment/'.$booking_id);
							$mail_data = str_replace(["{CLIENT_FIRST_NAME}","{BOOKING_REFERENCE}","{BUSINESS_NAME}","{BOOKING_DATE_TIME}","{LOCATION_NAME}","{LOCATION_PHONE}","{LOCATION_EMAIL}","{LINK}","{service}"],[$customer_name,$booking_referance,$business_name,$booking_date_time,$location_name,$location_phone,$location_email,$link,$service_list], $welcome_email['email_html']);
							//echo $mail_data;die;
							$data['subject'] =$welcome_email['subject'];
							$data['mail_data'] = $mail_data;
							$subject = $welcome_email['subject'];
							$mail_content = $this->load->view('booking-confirmation',$data,true);
							// echo $mail_content;die;
							$mail = $this->config->item('mail_data');
							$this->load->library('email', $mail);
							$this->email->set_newline("\r\n");
							$this->email->from($this->config->item('default_mail'),$business_name.'/'.$location_name);
							$list = array($email);
							$this->email->to($list);
							$this->email->subject($subject);
							$this->email->message($mail_content);
							//$this->email->send();
							if($this->email->send())
							{
								echo "Your email has been send successfully. ".$customer_data['email'];
								$update_booking = array(
								'is_confirmation_sent'=>2,
								'date_updated'=>date("Y-m-d H:i:s")
								);
								$this->others->update_common_value("bookings",$update_booking,"id='".$value['id']."' ");

								insertBookingLog($value['id'],'Email',null,null);
							} 
						}			
					}
				} 
				
			}
			
		}
		
		
		
		public function timezone(){
			//$admin_session = $this->session->userdata('admin_logged_in');
			$timezone = "";
			/*if($admin_session['role']=="location_owner" or $admin_session['role']=="staff"){
				$timezone_id = $this->db->select('timezone_id')->from('location')->where('id',$admin_session['location_id'])->get()->row_array();
				$timezone = $timezone_id['timezone_id'];
				}*/

				//elseif($admin_session['role']=="business_owner"){
				$timezone_id = $this->db->select('time_zone_id')->from('business')->where('id',$_SESSION['booking']['business_id'])->get()->row_array();
				//print_r($this->db->last_query());
				$timezone = $timezone_id['time_zone_id'];
			//}
			if($timezone !=""){
				$tzone= $this->db->select('*')->from('time_zones')->where('id',$timezone)->get()->row_array();
				$t_zone = $tzone['name'];
				//echo $t_zone;
				}else{
				$t_zone = "Australia/Melbourne";
			}	 	
			date_default_timezone_set($t_zone);
			//echo $t_zone;
		} 
		
		
		
	}
