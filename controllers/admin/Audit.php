<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Audit extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('session');
			$this->load->model('others', '', TRUE);
			$this->load->model('audit_history', '', TRUE);
			
			$admin_session = $this->session->userdata('admin_logged_in');
			if($admin_session['admin_email'] =='') {
				redirect(base_url('admin'));
			}
		}
		
		private function __clear_cache() {
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		} 
		
		
		public function history(){
			$admin_session = $this->session->userdata('admin_logged_in');
			$this->session->unset_userdata('audit_search');
			$business_user_id = $admin_session['business_id'];
			$data['business_staff'] = $this->audit_history->get_business_staff($business_user_id);
			$data['audit_history_active_open'] = true;
			$this->load->view('admin/audit/history',$data);
		}
		
		public function view($id=null){
			$this->load->library('pagination');
			
			if(!empty($this->session->userdata('audit_search'))){
				//$_POST['audit_search'] = $this->session->userdata('audit_search');
			}
			
			$arr_search = '';
			if(!empty($this->input->post('audit_search'))){
				$arr_search = $this->input->post('audit_search');
				$this->session->set_userdata(array(
					'audit_search'  => $arr_search
				));
				$data['audit_search'] = $arr_search;
			}else{
				$data['audit_search'] = $this->session->userdata('audit_search');
				$arr_search = $this->session->userdata('audit_search');
				//$this->session->unset_userdata('audit_search');
			}
			
			$config = array();
			
			$offset = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$count=$this->audit_history->get_view_data(true,$arr_search,null,null,$id); 	
			$data['count'] = $count;
			
			
			
			$config["base_url"] = base_url() . "admin/audit/view/$id";
			$config['total_rows'] =  $count;
			$config['per_page'] = '10';
			$config['uri_segment'] =5;
			$config['full_tag_open'] = '<ul class="pagination" style="float:right;">';
			$config['full_tag_close'] = '</ul>'; 
			$config['prev_link'] = '&lt; Prev';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = 'Next &gt;';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active page-item"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['num_links']=3;
			$this->pagination->initialize($config);
			
			$data["user_id"] = $id;	
			$data["offset"] = $offset;	
			$data["per_page"] = $config['per_page'];	
			$data["links"] = $this->pagination->create_links();	
			$data['viewData'] = $this->audit_history->get_view_data(false,$arr_search,$config['per_page'],$offset,$id); 
			$data['audit_history_active_open'] = true;
			$this->load->view('admin/audit/view',$data);
		}
		
		
		
		
	}
