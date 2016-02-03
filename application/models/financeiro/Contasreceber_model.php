<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contasreceber_model extends CI_Model{

    public function save($contasreceber){

        $retorno = $this->db->insert('contasreceber', $contasreceber);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;

    }

    public function saveItensCR($data){
        $retorno = $this->db->insert('contasreceber_itens', $data);
        if($retorno)
            return $this->db->insert_id();
        else
            return $retorno;
    }


    public function exclude($key){

        return $this->db->delete("contasreceber",array(

            "contasreceber_id" => $key

        ));

    }

    public function listAll(){

        $this->db->select("contasreceber_id,contasreceber_tiporecebimento_id, tiporecebimento_descricao, contasreceber_total,contasreceber_frequencia, contasreceber_datacadastro");
        $this->db->from("contasreceber");
        $this->db->join("tiporecebimento","contasreceber_tiporecebimento_id = tiporecebimento_id","left");
        $this->db->order_by("contasreceber_datacadastro","desc");
        return $this->db->get()->result_array();

    }

    public function listUnique($key){

        $this->db->select("
            contasreceber_id as cod,
            contasreceber_total as total,
            contasreceber_descricao as descricao,
            contasreceber_contabancaria_id as contabancaria,
            contasreceber_frequencia as frequencia,
            contasreceber_datacadastro as data,
            contasreceber_tiporecebimento_id as recebimento"
        );
        $this->db->from("contasreceber");
        $this->db->where("contasreceber_id",$key);
        return $this->db->get()->row_array();

    }

    public function returnValue($key){

        return $this->db->get_where("produto",array(

            "produto_id" => $key

        ))->row_array();

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


    public function totalProximoMes(){
        $datainicial = addMonth(date("Y-m")."-01");
        $datafinal = addMonth(date("Y-m")."-31");

        $this->db->select("sum(itens_valor) as total");
        $this->db->where("itens_datarecebimento BETWEEN '".$datainicial."' AND '".$datafinal."'");
        return $this->db->get("contasreceber_itens")->row_array();

    }

    public function totalMesAtual(){

        $this->db->select("sum(itens_valor) as total");
        $this->db->where("itens_datarecebimento BETWEEN '".date("Y-m")."-01' AND '".date("Y-m")."-31'");
        return $this->db->get("contasreceber_itens")->row_array();

    }


    public function totalPerMonth(){

        $this->db->select("
        sum(itens_valor) as total,
        month(itens_datarecebimento) as mes");
        $this->db->from("contasreceber_itens");
        $this->db->where("itens_datarecebimento BETWEEN '".date("Y")."-01-01' AND '".date("Y")."-12-31'");
        $this->db->group_by("month(itens_datarecebimento)");
        $this->db->order_by("month(itens_datarecebimento)");
        return $this->db->get()->result_array();

    }

}

?>