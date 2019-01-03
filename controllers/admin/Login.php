<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->__clear_cache();
		$admin_session = $this->session->userdata('admin_logged_in');
        if ($admin_session['admin_email'] != '') {
            redirect(base_url('admin/dashboard'));
        }
        $this->load->helper('url');
        $currentURL = uri_string();
        if ($currentURL == 'admin') {
            redirect(base_url('admin/login'));
        }

    }

    private function __clear_cache() {
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	} 
	
	public function index()
	{		
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
		$data = "";
		if($this->input->post('email')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$data=[];
			if ($this->form_validation->run() == TRUE) {
				$check_login = $this->check_admin_available($email,$password);
				 $verify = $this->others->admin_verify_available($email, $password);
				 //echo "here"; print_r($verify);die;
		 	if (!$verify) { 
				if($check_login){  
					$admin_session = $this->session->userdata('admin_logged_in');
					//gs($admin_session);
					// check whether trial or paid
					if($admin_session['role'] != 'owner' ){
						$cookie_name = "verified_system_".$admin_session['admin_id'];
						//echo "hi"; exit;			
						
						//echo $_COOKIE[$cookie_name]; exit;
						$business_details = $this->db->select("*")->from("admin_users")->where(["business_id"=>$admin_session['business_id'],"role"=>"business_owner"])->get()->row_array();

						if(!isset($_COOKIE[$cookie_name]) && $business_details['trial_expire_date'] >= date('Y-m-d') ){
							$this->session->unset_userdata('admin_logged_in');
							$this->session->set_userdata("admin_info",$admin_session); 
							$this->session->set_flashdata('error_msg', "Please verify this system");
							return redirect(base_url('admin/login/verify_system'));
							//exit;
						}

						//echo $business_details['trial_expire_date']; die;

						if(!empty($business_details['trial_expire_date']) || !empty($admin_session['payment_status']) || $business_details['trial_expire_date'] < date('Y-m-d') )
						{

							//echo $business_details['trial_expire_date']; die;

							if($admin_session['payment_status'] == 1 && $business_details['trial_expire_date'] > date('Y-m-d') )
							{
								$user_data = $this->db->select('*')->from('admin_users')->where('id',$admin_session['admin_id'])->get()->row_array();
								$stripe_keys = array(
								"secret_key"      => $this->config->item('secret_key'),
								"publishable_key" => $this->config->item('publishable_key')
								);
								if($user_data['role']=="location_owner" or $user_data['role']=="staff"){
									//echo "hi"; exit;

									$location_id = $user_data['location_id'];
									$business_id = $user_data['business_id'];
									$ip_address = $this->db->select("*")->from("security")->where(["business_id"=>$business_id,"location_id"=>$location_id])->get()->row_array();
									//print_r($ip_address); exit;
									if($ip_address && $ip_address['ip_address']!=""){
										if($ip!=$ip_address['ip_address']){
											//echo $ip.'  '.$ip_address['ip_address']. "hi"; exit;
											$this->session->unset_userdata('admin_logged_in');
											//$this->session->set_flashdata('error_msg', "You are not authorized to acces this area.");
       										//return redirect(base_url('admin'));

       										$this->session->set_flashdata('error_msg',"You are not authorized to acces this area.");
										return redirect('admin');
										}
									}
								}
								require_once(APPPATH.'stripe-php/init.php');
								\Stripe\Stripe::setApiKey($stripe_keys['secret_key']);
								if(!empty($user_data['stripe_id'])){
									try{
										$sub = \Stripe\Subscription::retrieve($user_data['stripe_id']);
										$res = json_encode($sub);
										$response_data = json_decode($res,true);
										if($response_data['status']!="active"){
											$update_data = array(
									    	'payment_status'=>0
									    );
									    $this->others->update_common_value("admin_users",$update_data,"id='".$admin_session['admin_id']."' ");
									    $this->session->set_flashdata('error_msg', "Your subscription has been ended, Please choose a plan to continue.");
									    redirect(base_url('admin/service/membership_payment'));
										}
										// Add Data in business_membership
									    $insert_data = array(
											'business_id' => $admin_session['business_id'],
											'stripe_var_dump' => $res,
											'created_at' => date("Y-m-d H:i:s"),
											'stripe_id' => $response_data['id'],
											'payment_status' => $response_data['status'],
											'stripe_user_id' => $response_data['customer'],
											'stripe_plan_id' =>$response_data['plan']['id'],
											'stripe_start_date' =>date("Y-m-d H:i:s"),
											'stripe_end_date' =>date("Y-m-d H:i:s"),
											'type' =>1,
											);
										//$this->others->insert_data("business_membership",$insert_data);
									}
									catch(Exception $e){
										$this->session->set_flashdata('error_msg', $e->getMessage());
										return redirect('admin/login');
									}

								}
								

								redirect(base_url('admin/dashboard'));
							}elseif($business_details['trial_expire_date'] >= date('Y-m-d') ){
								
								redirect(base_url('admin/dashboard'));
							}


							elseif($business_details['trial_expire_date'] < date('Y-m-d') ){
								$this->session->set_flashdata('error_msg', "Your plan has been ended, please purchase a plan to continue.");
								redirect(base_url('admin/service/membership_payment'));
							}else
							{
								$this->session->set_flashdata('error_msg', "Your subscription has been ended, Please choose a plan to continue.");
								redirect(base_url('admin/service/membership_payment'));
							}
						}
						else{
							redirect(base_url('admin/service/membership_payment'));
						}
					}
					else{

						redirect(base_url('admin/dashboard'));
					}

				}else{
					$data['data_error']="Invalid email or password";
				}

				}else{
					$data['data_error']="Your account has been Inactived please contact manager !!";
				}



			}
		}
		$this->load->view('admin/login', $data);
	}

	public function verify_system(){
		$this->load->library('session');
		$admin_session=$info = $this->session->userdata("admin_info");	

		//print_r($info); exit;
		$cookie_name = "verified_system_".$admin_session['admin_id'];
		
		//$cookie_name = "verified_system_".$info['business_id'];
		if(isset($_COOKIE[$cookie_name])){
			return redirect(base_url("/admin/login"));
		}
		if(!$this->session->userdata("admin_info")){
			return redirect(base_url("/admin/login"));
		}
		//gs($info);
		$attempty_by = $this->db->select("*")->from("admin_users")->where("id",$info['admin_id'])->get()->row_array();
		$staff_name = $attempty_by['admin_name'];
		if ($admin_session['role']=='business_owner') {
			$business_info = $this->db->select("*")->from("admin_users")->where(["business_id"=>$info['business_id'],"role"=>"business_owner"])->get()->row_array();
		}

		if ($admin_session['role']=='staff' || $admin_session['role']=='location_owner') {
			$business_info = $this->db->select("*")->from("admin_users")->where(["staff_id"=>$info['staff_id'],])->get()->row_array();
		}

		$business_mail_info = $this->db->select("*")->from("admin_users")->where(["business_id"=>$info['business_id'],"role"=>"business_owner"])->get()->row_array();

		

		//$email = "dev.girishas@gmail.com";
		$email = $business_mail_info['email'];
		$business_name = $business_mail_info['admin_name'];
		if($business_mail_info['id']==$attempty_by['id']){
			$staff_name = "You";
		}
		else{
			$staff_name = $business_info['admin_name'];
		}
		$welcome_email = $this->db->select('*')->from('templates')->where('slug','security-alert')->get()->row_array();
		$verification_code = mt_rand(100000, 999999);
		$insert_data = array(
			"business_id"=>$info['business_id'],
			"attempt_user_id"=>$info['admin_id'],
			"verification_code"=>$verification_code
		);
		$insert_id =$this->others->insert_data('system_security',$insert_data);
	//	$insert_id = $this->db->insert_id();
		$mail_data = str_replace(["{BUSINESS_NAME}","{VERIFICATION_CODE}","{STAFF_NAME}"],[$business_name,$verification_code,$staff_name], $welcome_email['email_html']);
		$data['subject'] =$welcome_email['subject'];
	    $data['mail_data'] = $mail_data;
	   	$subject = $welcome_email['subject'];
	   	$mail = $this->config->item('mail_data');
		$mail_content = $this->load->view('admin/templates/appointment',$data,true);
	    $this->load->library('email', $mail);
	    $this->email->set_newline("\r\n");
	    $this->email->from($this->config->item('default_mail'),$business_name);
	    $list = array($email);
	    $this->email->to($list);
	    $this->email->subject($subject);
	    $this->email->message($mail_content);
	    $this->email->send();
		$data['business_info'] = $business_mail_info;
		$data['system_security_id'] = $insert_id;
		$this->load->view("admin/verify_system",$data);
	}

	public function verify_code(){
		$verification_code = trim($this->input->post('verification_code'));
		$system_security_id = $this->input->post('system_security_id');
		$security_data = $this->db->select("*")->from("system_security")->where("id",$system_security_id)->get()->row_array();
		if($verification_code !=""){
			if($security_data){
				if($verification_code==$security_data['verification_code']){
					$data = array("type"=>"success","message"=>"Verification successful");
					$cookie_name = "verified_system_".$security_data['attempt_user_id'];
					$cookie_value = $security_data['attempt_user_id'];
					setcookie($cookie_name, $cookie_value, time() + ( 365 * 24 * 60 * 60));
					$ad_session = $this->session->userdata("admin_info");
					$this->session->set_userdata('admin_logged_in', $ad_session);
				}else{
					$data = array("type"=>"error","message"=>"wrong verification code");
				}
			}else{
				$data = array("type"=>"error","message"=>"Please try again after roloading page");
			}
		}else{
			$data = array("type"=>"error","message"=>"verification code could not be empty");
		}
		echo json_encode($data);
	}

	public function forgot_password(){
		if($this->input->post('action')){
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
						'protocol' => 'smtp',
				        'smtp_host' => 'mail.bookingintime.com',
				        'smtp_port' => 2525,
				        'smtp_user' => 'developer@bookingintime.com',
				        'smtp_pass' => 'ye_0~u+t1y,0',
				        'mailtype'  => 'html', 
				        'charset' => 'utf-8',
				        'wordwrap' => TRUE
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
				    	$this->session->set_flashdata('success_msg', "New password has been sended to your email");
						redirect(base_url('/admin/login/forgot_password'));
				    }else{
				    	$this->session->set_flashdata('error_msg', "Error while sending email");
						redirect(base_url('/admin/login/forgot_password'));
				    }
				}else{
					$this->session->set_flashdata('error_msg', "Email does not exist in our system");
					redirect(base_url('/admin/login/forgot_password'));
				}
			}else{
				redirect(base_url('/admin/login/forgot_password'));
			}
		}
		$this->load->view('admin/forgot_password');
	}
		
	public function check_admin_available($email,$password) {

        $result = $this->others->admin_available($email, $password);
		if ($result) {
            $sess_array = array(
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
			//echo "<pre>";print_r($sess_array); echo "</pre>"; die;
            $this->session->set_userdata('admin_logged_in', $sess_array);
            return TRUE;
        } else {
            $this->form_validation->set_message('check_admin_avail', 'Invalid email or password');
            return FALSE;
        }
    }
	
}
