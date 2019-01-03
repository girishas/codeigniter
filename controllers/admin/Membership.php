<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class membership extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('membership_model', '', TRUE);

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
		
		$arr_search = array();
		$filter = array();
		$per_page = '';
		$config['per_page'] = $per_page;
		$config['offset'] = '';
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['role'] != 'owner'){
			$this->session->set_flashdata('error_msg', "Access Denied");
	        redirect(base_url('admin/setup'));
		}
		
		$all_records = $this->membership_model->get_membership(false,$arr_search,$per_page, $config['offset'],"name","ASC");
		//print_r($all_records);die;
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->membership_model->get_membership(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		

		$data['setup_active_open']=true;
		$this->load->view('admin/membership/all_memberships', $data);
	}
	
	public function edit_membership($id='')
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		if($admin_session['role'] != 'owner'){
			$this->session->set_flashdata('error_msg', "Access Denied");
	        redirect(base_url('admin/setup'));
		}

		if(is_numeric($id) && !empty($id)){

			// start update membership data
			$post = $this->input->post('action');
			if(!empty($post) && $post=='save'){
				//echo "updata";die;
				$this->load->library('form_validation');
				$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('stripe_plan_id', 'Stripe plan Id', 'trim|required|xss_clean');
			
				if ($this->form_validation->run() == TRUE) {

					$update_data['name'] = $this->input->post('name');
					$update_data['plan_price'] = $this->input->post('plan_price');
					$update_data['staff_allowed'] = $this->input->post('staff_allowed');
					$update_data['stripe_plan_id'] = $this->input->post('stripe_plan_id');

					$success = $this->others->update_common_value("membership",$update_data,"id='".$id."' ");

					if($success == true){
						$this->session->set_flashdata('success_msg', "Membership is updated successfully!");
						redirect(base_url('admin/membership'));
					}
				}
			}
			// end update membership data


			$all_memberships = $this->others->get_all_table_value("membership","*","id='".$id."'");
			//print_r($all_memberships);die;
			if($all_memberships){
				$data['all_memberships'] = $all_memberships;
			}
		}
		$data['setup_active_open']=true;
		$this->load->view('admin/membership/edit_membership', $data);
	}
	
}
