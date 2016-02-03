<?php

defined('BASEPATH') OR exit('No direct script access allowed');
function returnErroJson($status,$msg,$cod=""){

    $ci = get_instance();
    if($status == 1){

        echo json_encode(array(

            "erro" => "Sucesso",
            "msg"  => $msg,
            "cript" => $ci->encrypt->encode($cod)

        ));
    }
    else{

        echo json_encode(array(

            "erro" => "Erro",
            "msg"  => $msg

        ));

    }

}
