<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class currency extends CI_Controller {

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
		$data['currency_active_open']=true;
		$this->load->view('admin/currency/all_currencies', $data);
	}
	
	public function add_currency()
	{
		$data['currency_active_open']=true;
		$this->load->view('admin/currency/add_currency', $data);
	}
}
