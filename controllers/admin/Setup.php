<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
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
		$data['admin_session'] = $admin_session;
		$data['setup_active_open']=true;		
		$this->load->view('admin/setup/index',$data);
	}

	public function security(){
		$admin_session = $this->session->userdata('admin_logged_in');
		if(!$admin_session['role']=="business_owner"){
			return redirect(base_url('/admin/dashboard'));
		}
		$locations = $this->db->select("*")->from("location")->where("business_id",$admin_session['business_id'])->get()->result_array();
		$data['locations'] = $locations;
		$data['admin_session'] = $admin_session;
		$old_array = array();
		$old_records = $this->db->select("*")->from("security")->where("business_id",$admin_session['business_id'])->get()->result_array();
		if($old_records){
			foreach ($old_records as $key => $value) {
				$old_array[$value['location_id']]=$value;
			}
		}
		$data['old_array'] = $old_array;
		if($this->input->post('action')){
			$location_ids = $this->input->post('location_id');
			$ip_addresses = $this->input->post('ip_address');
			$this->db->from("security")->where("business_id",$admin_session['business_id'])->delete();
			foreach ($location_ids as $key => $value) {
				$insert_array = array(
					"business_id"=>$admin_session['business_id'],
					"location_id"=>$value,
					"ip_address"=>trim($ip_addresses[$key]),
				);
				$this->others->insert_data("security",$insert_array);
			}
			$this->session->set_flashdata('success_msg', "Information Saved successfully");
			redirect(base_url('admin/setup/security/'.$business_id));
		}
		$this->load->view("admin/setup/security",$data);
	}
}
