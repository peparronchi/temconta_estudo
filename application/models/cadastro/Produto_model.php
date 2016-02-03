<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model{

    public function save($produto){

        $retorno = $this->db->insert('produto', $produto);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function edit($produto){

        return $this->db->update('produto', $produto,array(

            "produto_id" => $produto["produto_id"]

        ));

    }

    public function exclude($key){

        return $this->db->delete("produto",array(

            "produto_id" => $key

        ));

    }

    public function listAll(){

        return $this->db->get("produto")->result_array();

    }

    public function listUnique($key){

        $this->db->select("produto_id as cod, produto_descricao as descricao, produto_valor as valor");
        $this->db->where(array(

            "produto_id" => $key

        ));
        return $this->db->get("produto")->row_array();

    }

    public function returnValue($key){

        return $this->db->get_where("produto",array(

            "produto_id" => $key

        ))->row_array();

    }


}

?>