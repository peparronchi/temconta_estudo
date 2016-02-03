<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("financeiro/Contasreceber_model","contasreceber");
        $this->load->model("financeiro/Contaspagar_model","contaspagar");

    }

    public function index(){

        if(intval(date("d")) < 13){
            $totalmesCP  = $this->contaspagar->totalMesAtual();
            $totalmesCR = $this->contasreceber->totalMesAtual();
            $data = date("m/Y");
        }
        else{
            $totalmesCP  = $this->contaspagar->totalProximoMes();
            $totalmesCR  = $this->contasreceber->totalProximoMes();
            $data =  date("m/Y",strtotime(date("Y-m", strtotime(date("Y-m"))) . " +1 month"));
        }

        $totalperMonthCP = $this->contaspagar->totalPerMonth();
        $totalperMonthCR = $this->contasreceber->totalPerMonth();


        if($totalperMonthCR) {
            foreach ($totalperMonthCR as $month) {
                $newArray[$month["mes"]] = array(

                    "total" => $month["total"],
                    "mes" => $month["mes"]

                );

            }
        }

        if($totalperMonthCP) {
            foreach ($totalperMonthCP as $month) {
                $newArrayCP[$month["mes"]] = array(

                    "total" => $month["total"],
                    "mes" => $month["mes"]

                );

            }
        }
        if($totalperMonthCP && $totalperMonthCR) {
            for ($i = 1; $i <= 12; $i++) {

                if (!array_key_exists($i, $newArray)) {
                    $newArray[$i] = array(

                        "total" => 0,
                        "mes" => $i

                    );
                }
                if (!array_key_exists($i, $newArrayCP)) {
                    $newArrayCP[$i] = array(

                        "total" => 0,
                        "mes" => $i

                    );
                }

            }
        }
        else {
            $newArray = $totalperMonthCR;
            $newArrayCP = $totalperMonthCP;
        }

        ksort($newArray);
        ksort($newArrayCP);

        $data = array(

            "totalmesCP" => $totalmesCP,
            "totalperMonthCP" => $newArrayCP,
            "totalmesCR" => $totalmesCR,
            "totalperMonthCR" => $newArray,
            "data" => $data

        );
        $this->load->template("dashboard",$data);

    }

    public function atualizarDashboard(){

        if($this->input->is_ajax_request()){

            $cr = $this->contasreceber->totalPerMonth();
            $cp = $this->contaspagar->totalPerMonth();

            $data = array(

                "cr" => $cr,
                "cp" => $cp

            );

            echo json_encode($data);


        }
        else
            redirect("dashboard");

    }


}