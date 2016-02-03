<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiporecebimento extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("cadastro/tiporecebimento_model","tiporecebimento");
    }

    public function index(){

        $tiporecebimento = $this->tiporecebimento->listAll();
        $data = array(

            "tiporecebimento" => $tiporecebimento

        );

        $this->load->template("cadastro/tiporecebimento",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            if($this->input->post("descricao")){
                if($this->input->post("valor")){

                    $data = array(

                        "tiporecebimento_descricao" => $this->input->post("descricao"),
                        "tiporecebimento_valor" => str_replace(array("."),array(""),$this->input->post("valor"))

                    );


                   $retorno = $this->tiporecebimento->save($data);

                    if($retorno){

                        returnErroJson(1,"Tipo Recebimento cadastrado com sucesso!",$retorno);
                    }
                    else{
                        returnErroJson(2,"Erro ao cadastrar tipo recebimento");
                    }


                }
                else{
                    returnErroJson(2,"Preencha o campo 'Valor'");
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

            if($this->input->post("descricao")){
                if($this->input->post("valor")){
                    if($this->input->post("cript")) {

                        $data = array(
                            "tiporecebimento_id" => $this->encrypt->decode($this->input->post("cript")),
                            "tiporecebimento_descricao" => $this->input->post("descricao"),
                            "tiporecebimento_valor" => str_replace(array("."), array(""), $this->input->post("valor"))

                        );


                        $retorno = $this->tiporecebimento->edit($data);

                        if ($retorno) {

                            returnErroJson(1, "Tipo de Recebimento editado com sucesso!");
                        } else {
                            returnErroJson(2, "Erro ao editar tipo recebimento");
                        }
                    }
                    else{

                        returnErroJson(2,"Por favor, recarrega a página'");
                    }

                }
                else{
                    returnErroJson(2,"Preencha o campo 'Valor'");
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

                $retorno = $this->tiporecebimento->exclude($this->encrypt->decode($key));
                if($retorno){

                    returnErroJson(1,"Tipo de Recebimento excluído com sucesso");

                }
                else{
                    returnErroJson(2,"Erro ao excluir o Tipo de Recebimento");
                }
            }
            else
                returnErroJson(2,"Selecione um Tipo de Recebimento");

        }
        else
            echo "Erro";


    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){
            if($key){
                $tiporecebimento = $this->tiporecebimento->listUnique($this->encrypt->decode($key));

                if($tiporecebimento){
                    $tiporecebimento["cod"] = $key;
                    echo json_encode(array(

                        "tiporecebimento" => $tiporecebimento

                    ));
                }
            }
            else{
                returnErroJson(1,"Erro ao listar Tipo de Recebimento");
            }
        }
        else
            echo "Erro";

    }

}