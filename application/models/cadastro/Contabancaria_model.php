<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contabancaria_model extends CI_Model{

    public function save($contabancaria){

        $retorno = $this->db->insert('contabancaria', $contabancaria);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function edit($contabancaria){

        return $this->db->update('contabancaria', $contabancaria,array(

            "contabancaria_id" => $contabancaria["contabancaria_id"]

        ));

    }

    public function exclude($key){

        return $this->db->delete("contabancaria",array(

            "contabancaria_id" => $key

        ));

    }

    public function listAll(){

        $this->db->select("contabancaria_id,
        contabancaria_agencia,
        contabancaria_numero,
        contabancaria_banco_id,
        banco_descricao,
        contabancaria_tipoconta_id,
        contabancaria_descricao,
        tipoconta_descricao,
        contabancaria_saldo,
        contabancaria_status");
        $this->db->from("contabancaria");
        $this->db->join("banco","contabancaria_banco_id = banco_id","left");
        $this->db->join("tipoconta","contabancaria_tipoconta_id = tipoconta_id","left");
        return $this->db->get()->result_array();

    }

    public function listUnique($key){

        $this->db->select("contabancaria_id as cod,
        contabancaria_agencia as agencia,
        contabancaria_numero as numero,
        contabancaria_banco_id as banco,
        contabancaria_descricao as descricao,
        contabancaria_tipoconta_id as tipoconta,
        contabancaria_saldo as saldo");
        $this->db->where(array(

            "contabancaria_id" => $key

        ));
        return $this->db->get("contabancaria")->row_array();

    }

}