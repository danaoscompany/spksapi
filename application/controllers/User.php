<?php

class User extends CI_Controller {
  
  public function get_cows() {
    $cows = $this->db->query("SELECT * FROM `cows` ORDER BY `name`")->result_array();
    echo json_encode($cows);
  }
  
  public function get_details() {
    $cowID = intval($this->input->post('id'));
      $details = $this->db->query("SELECT * FROM `details` WHERE `cow_id`=".$cowID)->result_array();
      $details['cow'] = $this->db->query("SELECT * FROM `cows` WHERE `id`=".$cowID)->row_array();
      echo json_encode($details);
    }
    
  public function get_all_details() {
        $details = $this->db->query("SELECT * FROM `details`")->result_array();
        for ($i=0; $i<sizeof($details); $i++) {
          $details[$i]['cow'] = $this->db->query("SELECT * FROM `cows` WHERE `id`=".$details[$i]['cow_id'])->row_array();
        }
        echo json_encode($details);
      }
      
  public function add_detail() {
    $name = $this->input->post('name');
    $details = json_decode($this->input->post('details'), true);
    $config['upload_path'] = './userdata/';
    $config['allowed_types'] = '*';
    $config['max_size'] = 102400
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $this->db->insert("cows", array(
        "name" => $name,
        "img" => $this->upload->data()['file_name']
      ));
      $cowID = $this->db->insert_id();
      for ($i=0; $i<sizeof($details); $i++) {
        $detail = $details[$i];
        $this->db->insert('details', array(
          'cow_id' => $cowID,
          'detail' => $detail
        ));
      }
    }
  }
}