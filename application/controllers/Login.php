<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("login_model");
    }


    public function index()
    {

        if($this->session->userdata("usuario_logado")){
            redirect("/dashboard");
        }
        else {
            $this->load->view("index");
        }

    }

    public function autenticar(){

        $login = $this->input->post("usuario");
        $senha = $this->input->post("password");

        if($login != "" && $login != null && $senha != "" && $senha != null) {

            $usuario = $this->login_model->realizaLogin($login,$senha);
            if ($usuario) {
                $this->session->set_userdata("usuario_logado", $usuario);
                $this->session->unset_userdata("tentativa_login");
                redirect('/dashboard');

            }
            else{
                $this->session->set_flashdata("danger", "Usuário ou senha inválido(s)");
                redirect('/');

            }
        }
        else{
            $this->session->set_flashdata("danger", "Preencha o campo usuário e senha");
            redirect('/');
        }
    }

    public function desconectar(){

        $this->session->unset_userdata("usuario_logado");
        redirect("Login");
    }

}