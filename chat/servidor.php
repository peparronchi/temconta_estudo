<?php
set_time_limit(0);

require 'class.PHPWebSocket.php';

function EnviarMensagem($integranteID, $mensagem, $tamanho_mensagem){
	global $Servidor;
	
	$ip = long2ip($Servidor->wsClients[$integranteID][6]);
	$nome_pessoa = $Servidor->wsClients[$integranteID][12];

	if($tamanho_mensagem == 0){
		$Servidor->wsClose($integranteID);
		
		return;
	}

	if(sizeof($Servidor->wsClients) == 1){
		$Servidor->wsSend($integranteID, '<b>Servidor:</b> <i>No momento você é o único no chat. <a href="cliente.php" target="_blank">Clique aqui</a> e inclua um novo integrante.</i>');
	}
	else{
		foreach($Servidor->wsClients as $id => $integrante){
			if($id != $integranteID){
				//$Servidor->wsSend($id, '<b>'.$nome_pessoa.':</b> <i>'.$mensagem.'</i>');
				$Servidor->wsSend($id, '<b>Integrante '.$integranteID.':</b> <i>'.$mensagem.'</i>');
			}
		}
	}
}

function EntrarNoChat($integranteID){
	global $Servidor;
	
	$ip = long2ip($Servidor->wsClients[$integranteID][6]);
	$nome_pessoa = $Servidor->wsClients[$integranteID][12];

	foreach($Servidor->wsClients as $id => $integrante){
		if($id != $integranteID){
			$Servidor->wsSend($id, '<b>Servidor:</b> <i>O integrante '.$integranteID.' ('.$ip.') entrou no chat</i>');
		}
	}
}

function SairDoChat($integranteID, $status){
	global $Servidor;
	
	$ip = long2ip($Servidor->wsClients[$integranteID][6]);
	$nome_pessoa = $Servidor->wsClients[$integranteID][12];

	foreach($Servidor->wsClients as $id => $integrante){
		$Servidor->wsSend($id, '<b>Servidor:</b> <i>O integrante '.$integranteID.' ('.$ip.') saiu do chat</i>.');
	}
}

$Servidor = new PHPWebSocket();

$Servidor->bind('message', 'EnviarMensagem');
$Servidor->bind('open', 'EntrarNoChat');
$Servidor->bind('close', 'SairDoChat');

$Servidor->wsStartServer('31.170.164.119', 9300);
?>