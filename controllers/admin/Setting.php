<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('setting_model', '', TRUE);

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

		// update data in table settings
		$post = $this->input->post('action');

		if(!empty($post) && $post=='save') {

			$this->load->library('form_validation');
			$this->form_validation->set_rules('site_name', 'site_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('admin_email', 'admin_email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('stripe_secret_key', 'stripe_secret_key', 'trim|required|xss_clean');
			$this->form_validation->set_rules('stripe_publishable_key', 'stripe_publishable_key', 'trim|required|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				$update_data = array(
				   	array(
				      	'slug' => 'site_name' ,
				      	'value' => $this->input->post('site_name') 
				   	),
				   	array(
				      	'slug' => 'admin_email' ,
				      	'value' => $this->input->post('admin_email')
				   	),
				   	array(
				      	'slug' => 'stripe_secret_key' ,
				      	'value' => $this->input->post('stripe_secret_key') 
				   	),
				   	array(
			      		'slug' => 'stripe_publishable_key' ,
				      	'value' => $this->input->post('stripe_publishable_key')
				   	)
				);
				
				$this->db->update_batch('settings', $update_data, 'slug');

				if($_FILES['website_logo']['name'])
				{
					$config['upload_path']          = './assets/images/';
	                $config['allowed_types']        = 'gif|jpg|png|jpeg';
	                $config['file_name']			= 'website_logo.jpg';
	                $config['overwrite'] 			= TRUE;
	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('website_logo'))
	                {
	                        $error = array('error' => $this->upload->display_errors());
	                        $this->session->set_flashdata('error_msg', "Website logo should be gif | jpg | png | jpeg !");
	                        redirect(base_url('admin/setting'));
	                }
	                
				}

				$this->session->set_flashdata('success_msg', "Setting updated successfully!");
				redirect(base_url('admin/setting'));
			}
		}
		// update data in table settings
		
		$all_records = $this->setting_model->get_setting(false,$arr_search,$per_page, $config['offset']);
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->setting_model->get_setting(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		

		$data['setup_active_open']=true;
		$this->load->view('admin/setting/edit_setting', $data);
	}
	

}
