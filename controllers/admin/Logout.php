<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class logout extends CI_Controller {

    function __construct()
	 {
	   parent::__construct();
       $this->load->library('session');
     }
    public function index()
	{
	   $this->session->sess_destroy();
       redirect(base_url('admin/login'));
	}
}
?>