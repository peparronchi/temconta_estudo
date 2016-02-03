<?php

defined('BASEPATH') OR exit('No direct script access allowed');
function mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
        if($mask[$i] == '#')
        {
            if(isset($val[$k]))
                $maskared .= $val[$k++];
        }
        else
        {
            if(isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function dateToSql($dateptBR){

    $newDate =  explode("/",$dateptBR);
    return "$newDate[2]-$newDate[1]-$newDate[0]";

}

function dateToBR($dateMysql){

    $newDate =  explode("-",$dateMysql);
    return "$newDate[2]/$newDate[1]/$newDate[0]";

}

function addMonth($date){

    $newDate = explode("-",$date);
    $day = $newDate[2];
    $month = $newDate[1];
    $year = $newDate[0];

    if($month == 12){
        $month = "01";
        $year = $year+1;
    }
    else{
        if($month < 9){
            $month = $month+1;
            $month = "0".$month;
        }
        else{
            $month = $month+1;
        }
    }

    return "$year-$month-$day";

}

function addXMonth($date,$x){

    $newDate = explode("-",$date);
    $day = $newDate[2];
    $month = $newDate[1];
    $year = $newDate[0];

    if($month == 12){
        $month = "0".$x;
        $year = $year+1;
    }
    else{
        if(($month+$x) < 9){
            $month = $month+$x;
            $month = "0".$month;
        }
        else{
            $month = $month+$x;
        }
    }

    return "$year-$month-$day";

}

function convertMonth($month){

    switch($month){

        case 1:
            return "Janeiro";
            break;

        case 2:
            return "Fevereiro";
            break;

        case 3:
            return "Março";
            break;

        case 4:
            return "Abril";
            break;

        case 5:
            return "Maio";
            break;

        case 6:
            return "Junho";
            break;

        case 7:
            return "Julho";
            break;

        case 8:
            return "Agosto";
            break;

        case 9:
            return "Setembro";
            break;

        case 10:
            return "Outubro";
            break;

        case 11:
            return "Novembro";
            break;

        case 12:
            return "Dezembro";
            break;

    }


}
