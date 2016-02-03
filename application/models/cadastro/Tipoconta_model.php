<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoconta_model extends CI_Model{


    public function listAll(){

        return $this->db->get("tipoconta")->result_array();

    }

}