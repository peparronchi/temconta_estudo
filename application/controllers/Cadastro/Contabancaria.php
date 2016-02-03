<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contabancaria extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("cadastro/Contabancaria_model","contabancaria");
        $this->load->model("cadastro/Banco_model","banco");
        $this->load->model("cadastro/Tipoconta_model","tipoconta");
    }

    public function index(){


        $contabancaria = $this->contabancaria->listAll();
        $bancos = $this->banco->listAll();
        $tipoconta = $this->tipoconta->listAll();

        $data = array(

            "contabancaria" => $contabancaria,
            "bancos"        => $bancos,
            "tipoconta"     => $tipoconta

        );
        $this->load->template("cadastro/contabancaria",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            if($this->input->post("agencia") !== "" && $this->input->post("agencia") !== null){

                if($this->input->post("numero") !== "" && $this->input->post("numero") !== null){

                    if($this->input->post("banco") !== "" && $this->input->post("banco") !== null){

                        if($this->input->post("descricao") !== "" && $this->input->post("descricao") !== null) {

                            if ($this->input->post("tipoconta") !== "" && $this->input->post("tipoconta") !== null) {

                                if ($this->input->post("saldoinicial") !== "" && $this->input->post("saldoinicial") !== null) {


                                    $saldoinicial = str_replace(array("."), array(""), $this->input->post("saldoinicial"));

                                    $data = array(

                                        "contabancaria_agencia" => $this->input->post("agencia"),
                                        "contabancaria_numero" => $this->input->post("numero"),
                                        "contabancaria_banco_id" => $this->input->post("banco"),
                                        "contabancaria_descricao" => $this->input->post("descricao"),
                                        "contabancaria_tipoconta_id" => $this->input->post("tipoconta"),
                                        "contabancaria_saldo" => $saldoinicial

                                    );

                                    $retorno = $this->contabancaria->save($data);

                                    if ($retorno) {
                                        returnErroJson(1, "Conta bancária cadastrada com sucesso!",$retorno);
                                    } else
                                        returnErroJson(2, "Erro ao cadastrar conta bancária");

                                } else
                                    returnErroJson(2, "Preencha o campo 'Saldo Inicial'");
                            } else
                                returnErroJson(2, "Preencha o campo 'Tipo de Conta'");
                        }else
                            returnErroJson(2, "Preencha o campo 'Descrição'");
                    }
                    else
                        returnErroJson(2,"Preencha o campo 'Banco'");

                }
                else
                    returnErroJson(2,"Preencha o campo 'Número'");
            }
            else
                returnErroJson(2,"Preencha o campo 'Agência'");

        }
        else
            echo "Erro";

    }

    public function edit(){

        if($this->input->is_ajax_request()){

            if($this->input->post("cript") !== "" && $this->input->post("cript") !== null ) {

                if ($this->input->post("agencia") !== "" && $this->input->post("agencia") !== null) {

                    if ($this->input->post("numero") !== "" && $this->input->post("numero") !== null) {

                        if ($this->input->post("banco") !== "" && $this->input->post("banco") !== null) {

                            if($this->input->post("descricao") !== "" && $this->input->post("descricao") !== null) {

                                if ($this->input->post("tipoconta") !== "" && $this->input->post("tipoconta") !== null) {


                                    $data = array(

                                        "contabancaria_id" => $this->encrypt->decode($this->input->post("cript")),
                                        "contabancaria_agencia" => $this->input->post("agencia"),
                                        "contabancaria_numero" => $this->input->post("numero"),
                                        "contabancaria_banco_id" => $this->input->post("banco"),
                                        "contabancaria_descricao" => $this->input->post("descricao"),
                                        "contabancaria_tipoconta_id" => $this->input->post("tipoconta"),

                                    );

                                    $retorno = $this->contabancaria->edit($data);

                                    if ($retorno) {
                                        returnErroJson(1, "Conta bancária editada com sucesso!");
                                    } else
                                        returnErroJson(2, "Erro ao cadastrar conta bancária");
                                } else
                                    returnErroJson(2, "Preencha o campo 'Tipo de Conta'");
                            }else
                                returnErroJson(2, "Preencha o campo 'Descrição'");
                        } else
                            returnErroJson(2, "Preencha o campo 'Banco'");

                    } else
                        returnErroJson(2, "Preencha o campo 'Número'");
                } else
                    returnErroJson(2, "Preencha o campo 'Agência'");
            }else
                returnErroJson(2,"Selecione uma conta bancária");

        }
        else
            echo "Erro";

    }

    public function exclude(){

        if($this->input->is_ajax_request()){

            $cript = $this->input->post("cript");

            if($cript !== "" && $cript !== null){

                $retorno = $this->contabancaria->exclude($this->encrypt->decode($cript));

                if($retorno)
                    returnErroJson(1,"Excluído com sucesso");
                else
                    returnErroJson(2,"Erro ao excluir");

            }
            else
                returnErroJson(2,"Selecione uma conta bancária");

        }

    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){
            if($key){
                $contabancaria = $this->contabancaria->listUnique($this->encrypt->decode($key));

                if($contabancaria){
                    $contabancaria["cod"] = $key;
                    echo json_encode(array(

                        "contabancaria" => $contabancaria

                    ));
                }
            }
            else{
                returnErroJson(2,"Erro ao listar Conta Bancária");
            }
        }
        else
            echo "Erro";

    }

}