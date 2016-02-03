<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContasPagar extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("financeiro/Contaspagar_model","contaspagar");
        $this->load->model("cadastro/Produto_model","produto");
        $this->load->model("cadastro/Contabancaria_model","contabancaria");
    }

    public function index(){

        $contabancaria = $this->contabancaria->listAll();
        $produtos = $this->produto->listAll();
        $contaspagar = $this->contaspagar->listarPagamentosMesatual();
        $data = array(

            "produtos" => $produtos,
            "contabancaria" => $contabancaria,
            "contaspagar" => $contaspagar

        );
        $this->load->template("financeiro/contaspagar",$data);

    }

    public function save(){

        if($this->input->is_ajax_request()){

            $contabancaria = $this->input->post("contabancaria");
            $usuario = $this->session->userdata("usuario_logado");
			$descricao = $this->input->post("descricao");

            $this->contaspagar->startTransaction();

            if($contabancaria !== null && $contabancaria !== "") {

                foreach ($_POST["valortotal"] as $key => $value) {

                    $valortotal = str_replace(".","",$this->input->post("valortotal")[$key]);
                    $valortotal = str_replace(",",".",$valortotal);
                    $qtdeparcelas = $this->input->post("totalparcela")[$key];
                    $mesinicial = dateToSql($this->input->post("mesinicial")[$key]);

                    $proximomes = $mesinicial;
                    (intval($qtdeparcelas) > 0) ? $valorunitario = round(intval($valortotal)/intval($qtdeparcelas),2): $valorunitario = 0;



                    $data = array(

                        "contaspagar_total" => $value,
                        "contaspagar_totalparcelas" => $qtdeparcelas,
                        "contaspagar_datacadastro" => date("Y-m-d"),
                        "contaspagar_total" => $valortotal,
						"contaspagar_descricao" => $descricao,
                        "contaspagar_usuario_id" => $usuario["usuario_id"],
                        "contaspagar_contabancaria_id" => $contabancaria

                    );

                    $retorno = $this->contaspagar->saveCP($data);
                    if($retorno){


                        $valorunitario = str_replace(",",".",$valorunitario);
                        for($i=0; $i < $qtdeparcelas ; $i++) {


                            $dataitens = array(

                                "itens_contaspagar_id" => $retorno,
                                "itens_produto_id" => $key,
                                "itens_valorunitario" => $valorunitario,
                                "itens_valortotal" => $valortotal,
                                "itens_numparcela" => $i+1,
                                "iten_totalparcela" => $qtdeparcelas,
                                "itens_datavencimento" => $proximomes,

                            );

                            $retorno2 = $this->contaspagar->saveItensCP($dataitens);
                            if(!$retorno2){
                                $erros[] = $retorno2;
                            }

                            $proximomes = addMonth($proximomes);
                        }

                    }
                    else
                        $erros[] = $retorno;


                }

                if($this->contaspagar->statusTransaction() ===  FALSE){
                    $this->contaspagar->rollbackTransaction();
                    returnErroJson(2,"Erro ao inserir");
                }
                else{
                    $this->contaspagar->commitTransaction();
                    returnErroJson(1,"Inserido com sucesso!");
                }

            }
            else
                returnErroJson(2,"Selecione uma conta bancária");

        }
        else
            echo "Erro";

    }

    public function listUnique($key){

        if($this->input->is_ajax_request()){

            $codigo = $this->encrypt->decode($key);

            if($codigo!== null && $codigo !== ""){

                $contaspagar = $this->contaspagar->listUnique($codigo);
                if($contaspagar){

                    for($i=0; $i < count($contaspagar); $i++){
                        $contaspagar[$i]["cod"] = $key;
                        $contaspagar[$i]["datavencimento"] = dateToBR($contaspagar[$i]["datavencimento"]);
                    }

                    echo json_encode(array(

                        "contaspagar" => $contaspagar

                    ));

                }
                else
                    returnErroJson(2,"Erro ao listar!");
            }
            else
                returnErroJson(2,"Selecione uma conta à pagar");

        }

    }

    public function returnValue($key){

        if($this->input->is_ajax_request()){

            if($key!== "" && $key !== ""){

                $produto = $this->produto->returnValue($key);

                if($produto){

                    $valor = $produto["produto_valor"];
                    echo $valor;

                }
                else
                    returnErroJson(2,"Erro ao retornar valor do produto");

            }
            else
                returnErroJson(2,"Selecione um produto");

        }
        else
            echo "Erro";

    }

    public function baixarPagamento($key){

        if($this->input->is_ajax_request()){

            if($key !== null && $key !== ""){


                $data = array(

                    "itens_datapagamento" => date("Y-m-d")

                );

                $retorno = $this->contaspagar->baixarPagamento($key, $data);

                if($retorno){

                    returnErroJson(1,"Baixa realizada com sucesso!");

                }

            }
            else
                returnErroJson(2,"Erro ao baixar pagamento");

        }
        else
            redirect(base_url());

    }

}