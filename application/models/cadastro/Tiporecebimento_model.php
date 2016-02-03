<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiporecebimento_model extends CI_Model{

    public function save($tiporecebimento){

        $retorno = $this->db->insert('tiporecebimento', $tiporecebimento);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function edit($tiporecebimento){

        return $this->db->update('tiporecebimento', $tiporecebimento,array(

            "tiporecebimento_id" => $tiporecebimento["tiporecebimento_id"]

        ));

    }

    public function exclude($key){

        return $this->db->delete("tiporecebimento",array(

            "tiporecebimento_id" => $key

        ));

    }

    public function listAll(){

        return $this->db->get("tiporecebimento")->result_array();

    }

    public function listUnique($key){

        $this->db->select("tiporecebimento_id as cod, tiporecebimento_descricao as descricao, tiporecebimento_valor as valor");
        $this->db->where(array(

            "tiporecebimento_id" => $key

        ));
        return $this->db->get("tiporecebimento")->row_array();

    }

    public function returnValue($key){

        return $this->db->get_where("tiporecebimento",array(

            "tiporecebimento_id" => $key

        ))->row_array();

    }


}

?>