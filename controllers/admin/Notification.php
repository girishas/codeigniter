<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('notifications_model', '', TRUE);
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
				$this->others->delete_record("general_comments","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Notification are deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No records are selected to delete!");
			}	
			redirect(base_url('admin/notification'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/notification') .'?'.$get_string;
		
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
         
		 
		
	 
		 		
		$all_records = $this->notifications_model->get_notifications(false,$arr_search,$per_page, $config['offset'],"date_created","DESC");
		//gs($all_records); die;
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->notifications_model->get_notifications(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/notification/all_notifications', $data);
	}
	

	public function edit_notifications($id='')
	{
		//gs($this->input->post('is_all'));

		$admin_session = $this->session->userdata('admin_logged_in');
		$business_id = $admin_session['business_id'];
		
		
		if($this->input->post('action'))
		{
			$this->load->library('form_validation');
			
			if($admin_session['role'] == 'owner') { 
			$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
			}

			$this->form_validation->set_rules('is_all', 'Notification', 'trim|xss_clean|required');
			if($this->input->post('is_all') == 1){
				$this->form_validation->set_rules('staff_id', 'Staff', 'trim|xss_clean|required');
			}
			$this->form_validation->set_rules('comments', 'Comments', 'trim|xss_clean|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|xss_clean');
			
			$data['is_all'] = $is_all = $this->input->post('is_all');
			$data['staff_id'] = $staff_id = $this->input->post('staff_id');
			$data['comments'] = $comments = $this->input->post('comments');
			$data['status'] = $status = $this->input->post('status');


			if ($this->form_validation->run() == TRUE) 
			{
			//echo "dfsadad".$this->input->post('is_all');die;

				$inserData 	= array(
					'business_id'			=> $business_id,
					'is_all' 				=> $is_all,
					'staff_id' 				=> $staff_id,
					'comments'				=> $comments,
					'status'				=> $status,
					'date_created'  		=> date('Y-m-d H:i:s'),
					);
				
				if($id){
					
					$where = array("id"=>$id);
					$return = $this->others->update_common_value("general_comments",$inserData,$where);
					$this->session->set_flashdata('success_msg', "Notification updated successfully!");
					redirect(base_url('admin/notification/'));
				}else{

					$return = $this->others->insert_data("general_comments",$inserData);
				    $this->session->set_flashdata('success_msg', "Notification added successfully!");
					redirect(base_url('admin/notification/'));
					
				}

				// if($is_all == 0){
				// 	$where = array("business_id"=>$business_id);
				// 	$result = $this->db->where($where)->get('general_comments')->row();
					
				// 	if(count((array)$result) > 0){
				// 		$where = array("business_id"=>$business_id,"is_all"=>0);
				// 		$return = $this->others->update_common_value("general_comments",$inserData,$where);
				// 		$this->session->set_flashdata('success_msg', "Notification updated successfully!");
				// 		redirect(base_url('admin/notification/'));
				// 	}else{
				// 		$inserData['date_created'] 	= date('Y-m-d H:i:s');
				// 		$return = $this->others->insert_data("general_comments",$inserData);
				// 		$this->session->set_flashdata('success_msg', "Notification added successfully!");
				// 		redirect(base_url('admin/notification/'));
				// 	}
				// }else{
				// 	$where = array("business_id"=>$business_id,"staff_id"=>$staff_id,"is_all"=>1);
				// 	$result = $this->db->where($where)->get('general_comments')->row();
				// 	if(count((array)$result) > 0){
				// 		$where = array("business_id"=>$business_id,"is_all"=>1,"staff_id"=>$staff_id,);
				// 		$return = $this->others->update_common_value("general_comments",$inserData,$where);
				// 		$this->session->set_flashdata('success_msg', "Notification updated successfully!");
				// 		redirect(base_url('admin/notification/'));
				// 	}else{
				// 		$inserData['date_created'] 	= date('Y-m-d H:i:s');
				// 		$return = $this->others->insert_data("general_comments",$inserData);
				// 		$this->session->set_flashdata('success_msg', "Notification added successfully!");
				// 		redirect(base_url('admin/notification/'));
				// 	}
				// }
				
				
			}
		}
		
		// get all staff
		$all_staff = $this->others->get_all_table_value("staff","id,first_name,last_name","business_id=".$business_id."","first_name","ASC");
			if($all_staff) {
			$data['all_staff'] = $all_staff;
		}

		if($id){
			$all_notifications = $this->others->get_all_table_value("general_comments","*","id=".$id."","","");
			$data['all_notifications'] = $all_notifications;
			//print_r($all_notifications);die;
		}

		$data['setup_active_open']=true;
		$this->load->view('admin/notification/edit_notifications', $data);
	}
	

}
