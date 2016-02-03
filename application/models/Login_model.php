<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

    public function realizaLogin($usuario, $senha){

        $usuario = $this->db->get_where("usuario",array(

            "usuario_nome" => $usuario,
            "usuario_senha" => md5($senha)

        ))->row_array();

        return $usuario;

    }

    public function alterarSenha($usuario, $senhaatual, $senhanova){

        $this->db->where('usuario_id', $usuario);
        $this->db->where('usuario_senha', md5($senhaatual));
        $this->db->update('usuario', array(
            "usuario_senha" => md5($senhanova)

        ));
        return $this->db->affected_rows();

    }


}

?>