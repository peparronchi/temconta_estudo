<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contaspagar_model extends CI_Model{

    public function saveCP($contaspagar){

        $retorno = $this->db->insert('contaspagar', $contaspagar);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function saveItensCP($itens){

        return $this->db->insert('contaspagar_itens', $itens);

    }

    public function exclude($key){

        return $this->db->delete("contaspagar",array(

            "contaspagar_id" => $key

        ));

    }

    public function listAll(){

        $this->db->select("contaspagar_id,itens_produto_id, produto_descricao,itens_numparcela, contaspagar_totalparcelas,itens_datavencimento,itens_datapagamento, itens_valorunitario, itens_id");
        $this->db->from("contaspagar");
        $this->db->join("contaspagar_itens","contaspagar_id = itens_contaspagar_id","left");
        $this->db->join("produto ","itens_produto_id  = produto_id","left");
        $this->db->where("itens_datavencimento > '".date("Y-m")."-01'");
        return $this->db->get()->result_array();

    }

    public function listUnique($key){

        $this->db->select("contaspagar_id as cod,
            contaspagar_total as total,
            contaspagar_totalparcelas as totalparcelas,
            contaspagar_contabancaria_id as contabancaria,
            itens_produto_id as codproduto,
            produto_descricao as produto,
            itens_numparcela as numparcela,
            itens_valorunitario as valorunitario,
            itens_datavencimento as datavencimento"
        );
        $this->db->from("contaspagar");
        $this->db->join("contaspagar_itens","contaspagar_id = itens_contaspagar_id","left");
        $this->db->join("produto ","itens_produto_id  = produto_id","left");
        $this->db->where("contaspagar_id",$key);
        return $this->db->get()->result_array();

    }

    public function returnValue($key){

        return $this->db->get_where("produto",array(

            "produto_id" => $key

        ))->row_array();

    }

    public function totalProximoMes(){

        $datainicial = addMonth(date("Y-m")."-01");
        $datafinal = addMonth(date("Y-m")."-31");

        $this->db->select("sum(itens_valorunitario) as total");
        $this->db->where("itens_datavencimento BETWEEN '".$datainicial."' AND '".$datafinal."'");
        return  $this->db->get("contaspagar_itens")->row_array();


    }

    public function totalMesAtual(){

        $this->db->select("sum(itens_valorunitario) as total");
        $this->db->where("itens_datavencimento BETWEEN '".date("Y-m")."-01' AND '".date("Y-m")."-31'");
        return $this->db->get("contaspagar_itens")->row_array();

    }

    public function totalPerMonth(){

        $this->db->select("
        sum(itens_valorunitario) as total,
        month(itens_datavencimento) as mes");
        $this->db->from("contaspagar_itens");
        $this->db->where("itens_datavencimento BETWEEN '".date("Y")."-01-01' AND '".date("Y")."-12-31'");
        $this->db->group_by("month(itens_datavencimento)");
        $this->db->order_by("month(itens_datavencimento)");
        return $this->db->get()->result_array();
    }

    public function pagamentosperiodo($data){



        $this->db->select(
            "produto_descricao,
            itens_valorunitario,
            itens_numparcela,
            iten_totalparcela,
            itens_datavencimento,
			contaspagar_descricao"
        );
        $this->db->from("contaspagar");
        $this->db->join("contaspagar_itens","contaspagar_id  = itens_contaspagar_id","left");
        $this->db->join("produto","itens_produto_id  = produto_id","left");
        $this->db->where("itens_datavencimento BETWEEN '".$data["datainicial"]."' AND '".$data["datafinal"]."' ");
        if($data["itens_produto_id"] !== "" && $data["itens_produto_id"] !== null){
            $this->db->where("itens_produto_id",$data["itens_produto_id"]);

        }
		$this->db->order_by("itens_valorunitario desc");
        return $this->db->get()->result_array();


    }
	
	public function listarPagamentosMesatual(){
		
		$this->db->select("contaspagar_id,itens_produto_id, produto_descricao,itens_numparcela, contaspagar_totalparcelas,itens_datavencimento,itens_datapagamento, itens_valorunitario, itens_id");
        $this->db->from("contaspagar");
        $this->db->join("contaspagar_itens","contaspagar_id = itens_contaspagar_id","left");
        $this->db->join("produto ","itens_produto_id  = produto_id","left");
        $this->db->where("itens_datavencimento BETWEEN '".date("Y-m")."-01' AND '".date("Y-m")."-31'");
        return $this->db->get()->result_array();

		
	}

    public function baixarPagamento($key, $data){


        return $this->db->update("contaspagar_itens",$data,"itens_id = $key");



    }

    public function startTransaction(){

        $this->db->trans_begin();
    }

    public function rollbackTransaction(){

        $this->db->trans_rollback();;

    }
    public function commitTransaction(){

        $this->db->trans_commit();

    }

    public function statusTransaction(){

       return $this->db->trans_status();
    }


}

?>