<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Main_model extends CI_Model {

  public function __construct() {
    parent::__construct(); 

  }

  // Fetch records
  public function getData($rowno,$rowperpage,$search="",$iso="") {
 
    $this->db->select('*');
    $this->db->from('country');

    if($search != ''){
      $this->db->like('name', $search);
    }

    if($iso != ''){
      $this->db->like('iso_code', $iso);
    }

    $this->db->limit($rowperpage, $rowno); 
    $query = $this->db->get();
 
    return $query->result_array();
  }

  // Select total records
  public function getrecordCount($search = '' ,$iso = "") {

    $this->db->select('count(*) as allcount');
    $this->db->from('country');
 
    if($search != ''){
      $this->db->like('name', $search);
    }

    if($iso != ''){
      $this->db->like('iso_code', $iso);
    }

    $query = $this->db->get();
    $result = $query->result_array();
 
    return $result[0]['allcount'];
  }

}