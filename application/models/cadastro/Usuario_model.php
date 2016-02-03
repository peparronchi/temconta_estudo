<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{

    public function save($usuario){

        $retorno = $this->db->insert('usuario', $usuario);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function edit($usuario){

        return $this->db->update('usuario', $usuario,array(

            "usuario_id" => $usuario["usuario_id"]

        ));

    }

    public function exclude($key){

        return $this->db->delete("usuario",array(

            "usuario_id" => $key

        ));

    }

    public function listAll(){

        return $this->db->get("usuario")->result_array();

    }

    public function listUnique($key){

        $this->db->select("usuario_id as cod, usuario_nome as nome, usuario_email as email, usuario_telefone as telefone");
        $this->db->where(array(

            "usuario_id" => $key

        ));
        return $this->db->get("usuario")->row_array();

    }


}

?>