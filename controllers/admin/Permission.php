<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permission extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('permissions', '', TRUE);
		$this->load->model('user_permissions', '', TRUE);
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
		$data['admin_session']= $admin_session;
		
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
			}elseif($admin_session['role']=="location_owner"){
				//$condition .= " AND location_id='".$admin_session['location_id']."' ";
				$condition .= " AND business_id='".$admin_session['business_id']."' ";
			}
			$count_records = 0;
			foreach($this->input->post('record') as $item){
				$this->others->delete_record("staff","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Staff has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No staff are selected to delete!");
			}	
			redirect(base_url('admin/staff'));			
		}
        

        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/staff') .'?'.$get_string;

        if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner"))
        {
        	$arr_search['s.business_id']= $admin_session['business_id'];
        }
		
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

				$this->db->select('*');
				$this->db->from('staff');
			if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
				$this->db->where('business_id',$admin_session['business_id']);
			}elseif($admin_session['role']=="location_owner"){
				$this->db->where('location_id',$admin_session['location_id']);
			}
			$data['all_records']=$this->db->get()->result_array();
			
		
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business)
			$data['all_business'] = $all_business;
		
		
		$data['staff_active_open']=true;
		$this->load->view('admin/staff/all_staff', $data);
	}
	
	public function change_password($staff_id){
		if($this->input->post('action')){
			$password = $this->input->post('password');
			$update_data = array(
				"password"=>md5($password)
			);
			$success = $this->others->update_common_value("admin_users",$update_data,"staff_id='".$staff_id."' ");
			if($success){
				$this->session->set_flashdata('success_msg', "Password has been changed successfully!");
				redirect(base_url('admin/staff'));
			} else {
				$this->session->set_flashdata('error_msg', "Password could not be changed, Please try again.");
				redirect(base_url('admin/staff'));
			}
		}
		$this->load->view('admin/staff/change_password');
	}
	
		
}
 