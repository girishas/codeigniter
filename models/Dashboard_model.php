<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Dashboard_model extends CI_Model {

  public function __construct() {
    parent::__construct(); 
    $this->admin_session = $this->session->userdata('admin_logged_in');
  }


  // CURRENT MONTH ACTIVITY

  public function getMothActivity() {

    //print_r($this->admin_session);die;
    
    $select = array('id','customer_id','staff_id','service_id','customer_id','business_id','date_created');
    $this->db->select($select);    
    if($this->admin_session['role'] == 'owner'){
      if($this->admin_session['business_id']){
        $this->db->where('business_id',$this->admin_session['business_id']);
      }
    }else if($this->admin_session['role'] == 'business_owner'){
      $this->db->where('business_id',$this->admin_session['business_id']);
    }else if($this->admin_session['role'] == 'location_owner'){
      $this->db->where('location_id',$this->admin_session['location_id']);
    }else{
      $this->db->where('staff_id',$this->admin_session['staff_id']);
    }

    $data = date('m');
    $this->db->where('month(date_created)',$data);
    $this->db->where('service_id !=',NULL);
    $this->db->order_by('date_created ','desc');
    $this->db->limit(5);
    $result =  $this->db->get('invoice_services')->result_array();
    //print_r($this->db->last_query());die;
    return $result;
  }


  // TODAY'S NEXT APPOINTMENTS
  public function getTodaysNextAppointments() {

    /*$data = date('Y-m-d');
    $this->db->where('date',$data);
    $this->db->limit(5);
    $result =  $this->db->get('booking_services')->result_array();*/

    if($this->admin_session['role'] == 'owner'){
      if($this->admin_session['business_id']){
        $this->db->where('t2.business_id',$this->admin_session['business_id']);
      }
    }else if($this->admin_session['role'] == 'business_owner'){
      $this->db->where('t2.business_id',$this->admin_session['business_id']);
    }else if($this->admin_session['role'] == 'location_owner'){
      $this->db->where('t2.location_id',$this->admin_session['location_id']);
    }else{
      $this->db->where('t2.staff_id',$this->admin_session['staff_id']);
    }

    $select = array(
      't1.id as id',
      't1.book_start_time as book_start_time',
      't1.booking_id as booking_id',
      't1.service_id as service_id',
      't1.staff_id as staff_id',
    );

     $data = date('Y-m-d');

     $whree_in = array( 't2.booking_status'=>0, 't2.booking_status'=>1,'t2.booking_status'=>6);

     $result = $this->db->select($select)
     ->from('booking_services as t1')
     ->where('date',$data)
     ->where_in('t2.booking_status',array(0,1,6))
     ->join('bookings as t2', 't1.booking_id = t2.id', 'INNER')
     ->limit(5)->get()->result_array();

     //print_r($this->db->last_query());die;


    /*$this->db->select($select);
    $data = date('Y-m-d');
    $this->db->from('booking_services');
    $this->db->where('date',$data);
    $this->db->where('bookings.booking_status',0);
    $this->db->or_where('bookings.booking_status',1);
    $this->db->join('bookings', 'booking_services.booking_id = bookings.id', 'left');
    $this->db->limit(5);
    $result =  $this->db->get()->result_array();*/
    //print_r($this->db->last_query());die;
    return $result;
  }


  // TOP SERVICES 
  public function getTopService() {

    if($this->admin_session['role'] == 'owner'){
      if($this->admin_session['business_id']){
        $this->db->where('business_id',$this->admin_session['business_id']);
      }
    }else if($this->admin_session['role'] == 'business_owner'){
      $this->db->where('business_id',$this->admin_session['business_id']);
    }else if($this->admin_session['role'] == 'location_owner'){
      $this->db->where('location_id',$this->admin_session['location_id']);
    }else{
      $this->db->where('staff_id',$this->admin_session['staff_id']);
    }

    $this->db->select('service_id');
    $this->db->select('sum(service_total_price) as top');
    $this->db->where('service_id !=',NULL);
    $this->db->group_by('service_id');
    $this->db->order_by('top','desc');
    $this->db->limit(5);
    $result =  $this->db->get('invoice_services')->result_array();
    //print_r($this->db->last_query());die;
    return $result;
  }


  // TOP STAFFS
  public function getTopStaff() {

    if($this->admin_session['role'] == 'owner'){
      if($this->admin_session['business_id']){
      $this->db->where('business_id',$this->admin_session['business_id']);
      }
    }else if($this->admin_session['role'] == 'business_owner'){
      $this->db->where('business_id',$this->admin_session['business_id']);
    }else if($this->admin_session['role'] == 'location_owner'){
      $this->db->where('location_id',$this->admin_session['location_id']);
    }else{
      $this->db->where('staff_id',$this->admin_session['staff_id']);
    }
    
    $this->db->select('staff_id');
    $this->db->select('sum(service_total_price) as top');
    $this->db->group_by('staff_id');
    $this->db->order_by('top','desc');
    $this->db->limit(5);
    $result =  $this->db->get('invoice_services')->result_array();

   //gs($this->db->last_query());
    
    return $result;
  }
  

}