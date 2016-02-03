<!doctype html>

<html>

<head>
	
	<meta charset="UTF-8" />
	
	<title>Chat entre Amigos utilizando WebSocket</title>
	
	<style>
		
		* {
			margin: 0 auto;
			padding: 0px;
		}

		body {
			background: #ffffff;
			font-family: tahoma;
			padding: 10px;
			text-align: center;
		}
		
		body > header {
			font-weight: bold;
			margin-bottom: 15px;
			color: #043f77;
		}
		
		body > section {
			background: #c9eee0;
			border-radius: 10px;
			padding: 40px;
			color: #043f77;
		}
		
		body > section > article {
			text-align: left;
		}
		
		input[type=text] {
			border-radius: 25px 0px 0px 25px;
			padding: 10px;
			border: 0px;
			min-width: 70%;
		}
		
		hr {
			color: #043f77;
			border: 1px #043f77 solid;
		}
		
		input[type=submit] {
			background: #043f77;
			border-radius: 0px 25px 25px 0px;
			padding: 10px;
			border: 0px;
			color: #ffffff;
			font-weight: bold;
		}

	</style>
	
</head>

<body onLoad="perguntarNome();">

	<header>
	
		<h1>Chat entre Amigos utilizando WebSocket</h1>
	
	</header>
	
	<section>
		
		<article>
			
			<strong>Histórico da Conversa:</strong><br />
			
			<pre id="registros"></pre>
			
			<br/><hr/><br />
		
			<div style="text-align: center;">
			
				<label>Digite sua mensagem: </label>&nbsp; 
				<input type="text" id="mensagem" name="mensagem" autofocus /><input type="submit" id="enviar" name="enviar" value="Enviar Mensagem" />
				
			</div>
			
		</article>
	
	</section>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	
	<script src="websocket.js"></script>
	
	<script>

		var nomePessoa = '';
	
		//////////////////////////////////////
		// função para capturar nome da pessoa
		function perguntarNome(){
			/*
			// não consegui colocar nome das pessoas no chat
			nomePessoa = prompt('Qual é seu nome?', '');

			if(nomePessoa == null || nomePessoa == ''){
				nomePessoa = 'Desconhecido';
			}
			*/
		}
		// função para capturar nome da pessoa
		//////////////////////////////////////
		
		////////////////////////////////////////////
		// funções para recuperar o dia e hora atual
		function retornaData(){
			var data = new Date();
			
			return data.getDate() + '.' + data.getMonth() + '.' + data.getFullYear();
		}

		function retornaHora(){
			var hora = new Date();
			
			return hora.getHours() + ':' + hora.getMinutes();
		}
		// funções para recuperar o dia e hora atual
		////////////////////////////////////////////

		// varíavel global
		var Servidor;
		
		///////////////////////////
		// registrar textos na tela
		function registrar(texto){
			$registro = $('#registros');

			$registro.append(($registro.html()? '\n' : '') + '[' + retornaData() + ' ' + retornaHora() + '] ' + texto);
		}
		// registrar textos na tela
		///////////////////////////

		//////////////////////////////
		// enviar mensagem ao servidor
		function enviar(texto){
			Servidor.enviar('message', texto);
		}
		// enviar mensagem ao servidor
		//////////////////////////////

		//////////////////////////////
		// Registrar inicio da conexão
		registrar('<b>Servidor:</b> <i>Conectando...</i>');
		Servidor = new NossoWebSocket('ws://31.170.164.119:8083/chat/servidor.php',nomePessoa.value);
		// Registrar inicio da conexão
		//////////////////////////////

		/////////////////////////////////////////////
		// Detectar quando o cliente envia a mensagem
		// seja por ENTER ou clicando no campo ENVIAR 
		$('#mensagem').keypress(function(e) {
			if(e.keyCode == 13 && $('#mensagem').val() != ''){
				
				registrar('<b>Eu:</b> <i>'+$('#mensagem').val()+'</i>');
				enviar($('#mensagem').val());

				$('#mensagem').val('');
			}
		});

		$('#enviar').click(function(){
			registrar('<b>Eu:</b> <i>'+$('#mensagem').val()+'</i>');
			enviar($('#mensagem').val());

			$('#mensagem').val('');
		});
		// Detectar quando o cliente envia a mensagem
		// seja por ENTER ou clicando no campo ENVIAR
		/////////////////////////////////////////////

		//////////////////////////////////////////
		// Se o servidor retornar algo, registrar!
		// Servidor conectou?
		Servidor.bind('open', function() {
			registrar("<b>Servidor:</b> <i>Seja bem-vindo ao chat!</i>");
		});

		// Servidor desconectou?
		Servidor.bind('close', function(data) {
			registrar('<b>Servidor:</b> <i>Você saiu do chat!</i>');
		});

		// Servidor enviou mensagem?
		Servidor.bind('message', function(resposta) {
			registrar(resposta);
		});
		// Se o servidor retornar algo, registrar!
		//////////////////////////////////////////

		// Iniciar conexão
		Servidor.conectar();
		
	</script>
	
</body>

</html>