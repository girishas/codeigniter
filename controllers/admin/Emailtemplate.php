<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplate extends CI_Controller {
	 
	 public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
		$this->load->model('emailtemplate_model', '', TRUE);

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
				$this->others->delete_record("templates","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Templates has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No templates are selected to delete!");
			}	
			redirect(base_url('admin/emailtemplate'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/emailtemplate') .'?'.$get_string;
		
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
         
		if($this->input->get('customer_search')){
			$customer_name = $this->input->get('customer_search');
			$customer_name = explode(" ",$customer_name);
			$search_first_name = trim($customer_name[0]);
			$search_last_name = trim($customer_name[1]);
			if(!empty($search_first_name))
				$arr_search['first_name'] = $search_first_name;
			if(!empty($search_last_name))
				$arr_search['last_name'] = $search_last_name;
		}		 
		
		if($admin_session['role']=="business_owner"){
			$arr_search['business_id'] = $admin_session['business_id'];
		}
		if($admin_session['role']=="location_owner"){
			$arr_search['location_id'] = $admin_session['location_id'];
		}
		 		
		$all_templates = $this->emailtemplate_model->get_templates(false,$arr_search,$per_page, $config['offset'],"created_at","DESC");
		if($all_templates){
			$data['all_templates']= $all_templates;
			$count_all_records = $this->emailtemplate_model->get_templates(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/emailtemplate/all_emailtemplate', $data);
	}

	public function add_emailtemplate()
	{
		$admin_session = $this->session->userdata('admin_logged_in');

		if($this->input->post('action'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('slug', 'slug', 'trim|required|xss_clean');
			$this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean');
			$this->form_validation->set_rules('shortcodes','shortcodes', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email_html','email_html', 'trim|required|xss_clean');
			
			$data['title'] = $title = $this->input->post('title');
			$data['slug'] = $slug = $this->input->post('slug');
			$data['subject'] = $subject = $this->input->post('subject');
			$data['shortcodes'] = $shortcodes = $this->input->post('shortcodes');
			$data['email_html'] = $email_html = $this->input->post('email_html');

			if ($this->form_validation->run() == TRUE) 
			{
				$return = $this->emailtemplate_model->checkSlugDuplicate($slug,$id='');
				if($return == false){
					$this->session->set_flashdata('error_msg', "Slug name must be unique!");
					//redirect('admin/emailtemplate/add_emailtemplate');
				}
				else{
					$inserData 	= array(
						'title'			=> $title,
						'slug'			=> $slug,
						'subject'		=> $subject,
						'shortcodes'	=> $shortcodes,
						'email_html'	=> $email_html,
						);

					$return = $this->others->insert_data("templates",$inserData);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Email template inserted successfully!");
						redirect(base_url('admin/emailtemplate'));
					}
				}
				

			}
		}

		$data['setup_active_open']=true;
		$this->load->view('admin/emailtemplate/add_emailtemplate', $data);
	}

	public function edit_emailtemplate($id='')
	{

		$admin_session = $this->session->userdata('admin_logged_in');

		if($this->input->post('action'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('slug', 'slug', 'trim|required|xss_clean');
			$this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean');
			$this->form_validation->set_rules('shortcodes','shortcodes', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email_html','email_html', 'trim|required|xss_clean');
			
			$data['title'] = $title = $this->input->post('title');
			$data['slug'] = $slug = $this->input->post('slug');
			$data['subject'] = $subject = $this->input->post('subject');
			$data['shortcodes'] = $shortcodes = $this->input->post('shortcodes');
			$data['email_html'] = $email_html = $this->input->post('email_html');

			if ($this->form_validation->run() == TRUE) 
			{
				$return = $this->emailtemplate_model->checkSlugDuplicate($slug,$id);
				if($return == false){
					$this->session->set_flashdata('error_msg', "Slug name must be unique!");
					//redirect('admin/emailtemplate/add_emailtemplate');
				}
				else{
					$updateData 	= array(
						'title'			=> $title,
						'slug'			=> $slug,
						'subject'		=> $subject,
						'shortcodes'	=> $shortcodes,
						'email_html'	=> $email_html,
						);

					$where = array('id' => $id);
					$return = $this->others->update_common_value("templates",$updateData,$where);
					if($return == true){
						$this->session->set_flashdata('success_msg', "Email template updated successfully!");
						redirect(base_url('admin/emailtemplate'));
					}
				}
				

			}
		}

		// get template details
		if(!empty($id)){
			$template_details = $this->others->get_all_table_value("templates","*","id='".$id."'");
			$data['template_details'] = $template_details;
		}


		$data['setup_active_open']=true;
		$this->load->view('admin/emailtemplate/edit_emailtemplate', $data);
	}
	

	
}
