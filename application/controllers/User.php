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
}