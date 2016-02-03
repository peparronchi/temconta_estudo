<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContasReceber extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("cadastro/Tiporecebimento_model","recebimento");
        $this->load->model("cadastro/Contabancaria_model","contabancaria");
        $this->load->model("financeiro/Contasreceber_model","contasreceber");
    }

    public function index(){

        $contasreceber = $this->contasreceber->listAll();
        $contabancaria = $this->contabancaria->listAll();
        $recebimentos = $this->recebimento->listAll();
        $data = array(

            "recebimentos" => $recebimentos,
            "contabancaria" => $contabancaria,
            "contasreceber" => $contasreceber

        );

        $this->load->template("financeiro/contasreceber",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            $recebimento    = $this->input->post("recebimento");
            $valor          = $this->input->post("valor");
            $descricao      = $this->input->post("descricao");
            $frequencia     = $this->input->post("frequencia");
            $date           = $this->input->post("data");
            $contabancaria  = $this->input->post("contabancaria");
            $qtdemeses      = $this->input->post("qtdemeses");

            if($recebimento !== null && $recebimento !== ""){

                if($valor !== null && $valor !== ""){

                    if($frequencia !== null && $frequencia !== ""){

                        if($date !== null && $date !== ""){

                            if($contabancaria !== null && $contabancaria!== "") {

                                if (($frequencia !== 'U' && $qtdemeses !== "" && $qtdemeses !== null) || $frequencia == 'U') {

                                    $date = dateToSql($date);
                                    if($frequencia === 'U')
                                        $qtdemeses = 1;

                                    $usuario = $this->session->userdata("usuario_logado");
                                    $data = array(

                                        "contasreceber_total" => $valor,
                                        "contasreceber_descricao" => $descricao,
                                        "contasreceber_frequencia" => $frequencia,
                                        "contasreceber_qtdemeses" => $qtdemeses,
                                        "contasreceber_datacadastro" => date("Y-m-d"),
                                        "contasreceber_tiporecebimento_id" => $recebimento,
                                        "contasreceber_usuario_id" => $usuario["usuario_id"],
                                        "contasreceber_contabancaria_id" => $contabancaria

                                    );

                                    $this->contasreceber->startTransaction();
                                    $retorno = $this->contasreceber->save($data);

                                    if ($retorno) {

                                        for($i=0; $i < $qtdemeses; $i++){


                                            $dataitens = array(

                                                "itens_contasreceber_id" => $retorno,
                                                "itens_tiporecebimento_id" => $recebimento,
                                                "itens_valor" => $valor,
                                                "itens_numrecebimento" => $i+1,
                                                "iten_totalrecebimento" => $qtdemeses,
                                                "itens_datarecebimento" => $date,

                                            );

                                            $retorno2 = $this->contasreceber->saveItensCR($dataitens);
                                            if(!$retorno2)
                                                $erros[] = $retorno2;

                                            if($frequencia === 'M') {
                                                $date = addMonth($date);
                                            }
                                            else
                                                if($frequencia === 'T'){
                                                    $date = addXMonth($date,3);
                                                }
                                                else
                                                    if($frequencia === 'S'){
                                                        $date = addXMonth($date,6);
                                                    }
                                                    else
                                                        if($frequencia === 'A'){
                                                            $date = addXMonth($date,12);
                                                        }

                                        }

                                        if($this->contasreceber->statusTransaction() ===  FALSE){
                                            $this->contasreceber->rollbackTransaction();
                                            returnErroJson(2,"Erro ao inserir");
                                        }
                                        else{
                                            $this->contasreceber->commitTransaction();
                                            returnErroJson(1,"Inserido com sucesso!");
                                        }

                                    } else
                                        returnErroJson(2, "Erro ao cadastrar");
                                }
                            } else
                                returnErroJson(2,"Preencha o campo 'Qtde Meses'");

                        }
                        else
                            returnErroJson(2,"Preencha o campo 'Data'");

                    }
                    else
                        returnErroJson(2,"Preencha o campo 'Frequência'");

                }
                else
                    returnErroJson(2,"Preencha o campo 'valor'");

            }
            else
                returnErroJson(2,"Preencha o campo 'Recebimento'");

        }
        else
            echo "Erro";

    }

    public function edit(){

        if($this->input->is_ajax_request()){

            $cript          = $this->input->post("cript");
            $recebimento    = $this->input->post("recebimento");
            $valor          = $this->input->post("valor");
            $descricao      = $this->input->post("descricao");
            $frequencia     = $this->input->post("frequencia");
            $date           = $this->input->post("data");
            $contabancaria  = $this->input->post("contabancaria");
            $qtdemeses      = $this->input->post("qtdemeses");

            if($cript !== "" && $cript !== null) {

                if ($recebimento !== null && $recebimento !== "") {

                    if ($valor !== null && $valor !== "") {

                        if ($frequencia !== null && $frequencia !== "") {

                            if ($date !== null && $date !== "") {

                                if ($contabancaria !== null && $contabancaria !== "") {

                                    if ($frequencia !== 'U' && $qtdemeses !== "" && $qtdemeses !== null) {


                                        $usuario = $this->session->userdata("usuario_logado");
                                        $data = array(

                                            "contasreceber_id" => $this->encrypt->decode($cript),
                                            "contasreceber_total" => $valor,
                                            "contasreceber_descricao" => $descricao,
                                            "contasreceber_frequencia" => $frequencia,
                                            "contasreceber_qtdemeses" => $qtdemeses,
                                            "contasreceber_data" => dateToSql($date),
                                            "contasreceber_tiporecebimento_id" => $recebimento,
                                            "contasreceber_usuario_id" => $usuario["usuario_id"],
                                            "contasreceber_contabancaria_id" => $contabancaria,


                                        );

                                        $retorno = $this->contasreceber->save($data);

                                        if ($retorno) {
                                            returnErroJson(1, "Conta à Receber cadastrada com sucesso", $retorno);
                                        } else
                                            returnErroJson(2, "Eerro ao cadastrar");
                                    }
                                }
                                else
                                    returnErroJson(2,"Preencha o campo 'Qtde Meses'");;

                            } else
                                returnErroJson(2, "Preencha o campo 'Data'");

                        } else
                            returnErroJson(2, "Preencha o campo 'Frequência'");

                    } else
                        returnErroJson(2, "Preencha o campo 'valor'");

                } else
                    returnErroJson(2, "Preencha o campo 'Recebimento'");
            } else
                returnErroJson(2,"Selecione uma conta à receber");

        }
        else
            echo "Erro";

    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){

            $codigo = $this->encrypt->decode($key);

            if($codigo!== null && $codigo !== ""){

                $contasreceber = $this->contasreceber->listUnique($codigo);
                if($contasreceber){

                    $contasreceber["cod"] = $key;
                    $contasreceber["data"] = dateToBR($contasreceber["data"]);
                    echo json_encode(array(

                        "contasreceber" => $contasreceber

                    ));

                }
                else
                    returnErroJson(2,"Erro ao listar!");
            }
            else
                returnErroJson(2,"Selecione uma conta à receber");

        }

    }

    public function returnValue($key){

        if($this->input->is_ajax_request()){

            if($key!== "" && $key !== ""){

                $recebimento = $this->recebimento->returnValue($key);

                if($recebimento){

                    $valor = $recebimento["tiporecebimento_valor"];
                    echo $valor;

                }
                else
                    returnErroJson(2,"Erro ao retornar valor do tipo do recebimento");

            }
            else
                returnErroJson(2,"Selecione um tipo de recebimento");

        }
        else
            echo "Erro";

    }

}