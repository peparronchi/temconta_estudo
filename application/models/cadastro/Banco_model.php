<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banco_model extends CI_Model{


    public function listAll(){

        return $this->db->get("banco")->result_array();

    }

}