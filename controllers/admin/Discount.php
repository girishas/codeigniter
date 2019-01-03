<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('others', '', TRUE);
        $this->load->model('discount_model', '', TRUE);
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
				$this->others->delete_record("discounts","id='".$item."' ".$condition);
				$count_records ++;
			}
			if($count_records>0){
				$this->session->set_flashdata('success_msg', "Discounts has been deleted successfully!");
			}else{
				$this->session->set_flashdata('error_msg', "No discounts are selected to delete!");
			}	
			redirect(base_url('admin/discount'));			
		}
		
        $get_string = implode('&', $arr_get);
        $config['base_url'] = base_url('admin/discount') .'?'.$get_string;
		
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
		
		if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){
			$arr_search['business_id'] = $admin_session['business_id'];
		}elseif($admin_session['role']=="location_owner" || $admin_session['role']=="staff"){
			//$arr_search['location_id'] = $admin_session['location_id'];
			$arr_search['business_id'] = $admin_session['business_id'];

		}
		 		
		$all_records = $this->discount_model->get_discount(false,$arr_search,$per_page, $config['offset'],"created_date","DESC");
		if($all_records){
			$data['all_records']= $all_records;
			$count_all_records = $this->discount_model->get_discount(true,$arr_search);
            $config['total_rows'] = $count_all_records;
			$data['total_records'] = $count_all_records;
		}
		$this->pagination->initialize($config);
		
		$data['setup_active_open']=true;
		$this->load->view('admin/discount/all_discount', $data);
	}
	
	public function add_discount($id='')
	{
		$admin_session = $this->session->userdata('admin_logged_in');
		
		
		if($this->input->post('action'))
		{
			
			$this->load->library('form_validation');
			
			if($admin_session['role'] == 'owner') { 
			$this->form_validation->set_rules('business_id', 'business_id', 'trim|required|xss_clean');
			}

			//$this->form_validation->set_rules('staff_id', 'staff_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('discount_name', 'discount_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('discount_type','discount_type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('discount_price', 'discount_price', 'trim|required|xss_clean');
			

			if($admin_session['role'] == 'owner') { 
				$data['business_id'] = $business_id = $this->input->post('business_id');
			}else{
				$data['business_id'] = $business_id = $admin_session['business_id'];
			}

			$data['staff_id'] 			= $staff_id = $this->input->post('staff_id');
			$data['discount_name'] 		= $discount_name = $this->input->post('discount_name');
			$data['discount_type'] 		= $discount_type = $this->input->post('discount_type');
			$data['discount_price'] 	= $discount_price = $this->input->post('discount_price');

			if ($this->form_validation->run() == TRUE) 
			{
				
				$inserData 	= array(

					'business_id' 	=> $business_id,
					//'staff_id'		=> $staff_id,
					'discount_name' => $discount_name, 
					'discount_type' => $discount_type,
					'discount_price'=> $discount_price,
					'created_date' 	=> date('Y-m-d H:i:s'),

					);

				if(!empty($id)){
					//echo "edit";die;
					//$inserData['date_updated'] 	= date('Y-m-d H:i:s');
					$where = array('id' => $id);
					$return = $this->others->update_common_value("discounts",$inserData,$where);

					if($return == true){
						$this->session->set_flashdata('success_msg', "Discounts updated successfully!");
						redirect(base_url('admin/discount'));
					}
				}else{
					//echo "insert";die;
					//$inserData['date_created'] 	= date('Y-m-d H:i:s');
					$return = $this->others->insert_data("discounts",$inserData);

					if($return == true){

						$this->session->set_flashdata('success_msg', "Discounts added successfully!");
						redirect(base_url('admin/discount'));
					}
				}
				
				
			}
		}
		
		// get all business for add service	
		$all_business = $this->others->get_all_table_value("business","id,name","","name","ASC");
		if($all_business) {
			$data['all_business'] = $all_business;
		}
		//print_r($all_business);die();
		
		if(!empty($id))
		{
			$where = array('id'=>$id);
			$details = $this->others->get_all_table_value("discounts","",$where,"","");
			if($details) {
				$data['details'] = $details;
			}
		}
		
		$data['setup_active_open']=true;
		$this->load->view('admin/discount/add_discount', $data);
	}
	

}
