<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("cadastro/produto_model","produto");
    }

    public function index(){

        $produto = $this->produto->listAll();
        $data = array(

            "produto" => $produto

        );

        $this->load->template("cadastro/produto",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            if($this->input->post("descricao")){

                    $valor = str_replace(array("."),array(""),$this->input->post("valor"));
                    $valor = str_replace(array(","),array("."),$valor);
                    $data = array(

                        "produto_descricao" => $this->input->post("descricao"),
                        "produto_valor" => $valor

                    );


                    $retorno = $this->produto->save($data);

                    if($retorno){

                        returnErroJson(1,"Produto cadastrado com sucesso!",$retorno);
                    }
                    else{
                        returnErroJson(2,"Erro ao cadastrar Produto");
                    }


            }
            else{
                returnErroJson(2,"Preencha o campo 'Descrição'");
            }

        }
        else
            echo "Erro";

    }

    public function edit(){

        if($this->input->is_ajax_request()){

            if($this->input->post("descricao")) {
                if ($this->input->post("cript")) {

                    $valor = str_replace(array("."),array(""),$this->input->post("valor"));
                    $valor = str_replace(array(","),array("."),$valor);

                    $data = array(
                        "produto_id" => $this->encrypt->decode($this->input->post("cript")),
                        "produto_descricao" => $this->input->post("descricao"),
                        "produto_valor" => $valor

                    );


                    $retorno = $this->produto->edit($data);

                    if ($retorno) {

                        returnErroJson(1, "Produto editado com sucesso!");
                    } else {
                        returnErroJson(2, "Erro ao editar Produto");
                    }
                } else {

                    returnErroJson(2, "Por favor, recarrega a página'");
                }
            }
            else{
                returnErroJson(2,"Preencha o campo 'Descrição'");
            }

        }
        else
            echo "Erro";

    }

    public function exclude(){

        if($this->input->is_ajax_request()){

            $key = $this->input->post("cript");

            if($key) {

                $retorno = $this->produto->exclude($this->encrypt->decode($key));
                if($retorno){

                    returnErroJson(1,"Produto excluído com sucesso");

                }
                else{
                    returnErroJson(2,"Erro ao excluir o Produto");
                }
            }
            else
                returnErroJson(2,"Selecione um Produto");

        }
        else
            echo "Erro";


    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){
            if($key){
                $produto = $this->produto->listUnique($this->encrypt->decode($key));

                if($produto){
                    $produto["cod"] = $key;
                    echo json_encode(array(

                        "produto" => $produto

                    ));
                }
            }
            else{
                returnErroJson(2,"Erro ao listar Produto");
            }
        }
        else
            echo "Erro";

    }

}