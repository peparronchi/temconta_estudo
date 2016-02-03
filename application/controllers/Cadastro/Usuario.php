<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("cadastro/Usuario_model","usuario");
    }

    public function index(){


        $usuarios = $this->usuario->listAll();
        $data = array(

            "usuarios" => $usuarios

        );

        $this->load->template("cadastro/usuario",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            $nome = $this->input->post("nome");
            $email = $this->input->post("email");
            $telefone = str_replace(array("(",")","-"),array("","",""),$this->input->post("telefone"));
            $senha = $this->input->post("senha");

            if($nome !== "" && $nome !== null){

                if($email !== "" && $email !== null){

                    if($senha !== "" && $senha !== null){

                        $data = array(

                            "usuario_nome" => $nome,
                            "usuario_email" => $email,
                            "usuario_senha" => md5($senha),
                            "usuario_telefone" => $telefone

                        );

                        $retorno = $this->usuario->save($data);

                        if($retorno){
                            returnErroJson(1,"Usuário cadastrado com sucesso!",$retorno);
                        }
                        else
                            returnErroJson(2,"Erro ao cadastrar usuário");

                    }
                    else
                        returnErroJson(2,"Campo 'Senha' é obrigatório!");
                }
                else
                    returnErroJson(2,"Campo 'E-mail' é obrigatório!");
            }
            else
                returnErroJson(2,"Campo 'Nome' é obrigatório!");


        }
        else
            echo "Erro";

    }

    public function edit(){

        if($this->input->is_ajax_request()){

            $nome     = $this->input->post("nome");
            $email    = $this->input->post("email");
            $telefone = str_replace(array("(",")","-"),array("","",""),$this->input->post("telefone"));
            $cript    = $this->input->post("cript");

            if($cript !== "" && $cript !== null) {

                if ($nome !== "" && $nome !== null) {

                    if ($email !== "" && $email !== null) {

                        $data = array(

                            "usuario_id" => $this->encrypt->decode($cript),
                            "usuario_nome" => $nome,
                            "usuario_email" => $email,
                            "usuario_telefone" => $telefone

                        );

                        $retorno = $this->usuario->edit($data);

                        if ($retorno) {
                            returnErroJson(1, "Usuário editado com sucesso!");
                        } else
                            returnErroJson(2, "Erro ao cadastrar usuário");

                    } else
                        returnErroJson(2, "Campo 'E-mail' é obrigatório!");
                } else
                    returnErroJson(2, "Campo 'Nome' é obrigatório!");
            }else
            returnErroJson(2,"Selecione um usuário");


        }
        else
            echo "Erro";

    }

    public function exclude(){

        if($this->input->is_ajax_request()){

            $cript = $this->input->post("cript");

            if($cript !== "" && $cript !== null){

                $retorno = $this->usuario->exclude($this->encrypt->decode($cript));

                if($retorno)
                    returnErroJson(1,"Excluído com sucesso");
                else
                    returnErroJson(2,"Erro ao excluir");

            }
            else
                returnErroJson(2,"Selecione um usuário");

        }

    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){
            if($key){
                $usuario = $this->usuario->listUnique($this->encrypt->decode($key));

                if($usuario){
                    $usuario["cod"] = $key;
                    $usuario["telefone"] = mask($usuario["telefone"],"(###)####-####");
                    echo json_encode(array(

                        "usuario" => $usuario

                    ));
                }
                else
                    returnErroJson(2,"Erro ao listar usuário");
            }
            else{
                returnErroJson(2,"Erro ao listar usuário");
            }
        }
        else
            echo "Erro";

    }

}