<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagamentos extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("financeiro/Contaspagar_model","contaspagar");
        $this->load->model("cadastro/Produto_model","produto");

    }

    public function index(){

        $produtos = $this->produto->listAll();
        $data = array(

            "produtos" => $produtos

        );
        $this->load->template("relatorio/pagamentos_periodo",$data);

    }

    public function listPagamentos(){

        if($this->input->is_ajax_request()){

            $datainicial = $this->input->post("datainicial");
            $datafinal = $this->input->post("datafinal");
            $produto = $this->input->post("produto");

            if($datafinal !== "" && $datainicial !== null){

                if($datafinal !== "" && $datafinal !== null){


                    $data = array(

                        "itens_produto_id" => $produto,
                        "datainicial" => dateToSql($datainicial),
                        "datafinal" => dateToSql($datafinal)


                    );

                    $retorno = $this->contaspagar->pagamentosperiodo($data);

                    if($retorno){

                        echo json_encode($retorno);
                    }
                    else
                        returnErroJson(2,"Nenhum resultado encontrado");


                }
                else
                    returnErroJson(2,"Preencha o campo 'Data Final'");

            }
            else
                returnErroJson(2,"Preencha o campo 'Data Inicial'");

        }
        else
            redirect("dashboard");

    }



}