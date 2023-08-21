<?php

class User extends CI_Controller {
  
  public function get_cows() {
    $cows = $this->db->query("SELECT * FROM `cows` ORDER BY `name`")->result_array();
    echo json_encode($cows);
  }
  
  public function get_details() {
    $cowID = intval($this->input->post('id'));
      $details = $this->db->query("SELECT * FROM `details` WHERE `cow_id`=".$cowID)->result_array();
      echo json_encode($details);
    }
}