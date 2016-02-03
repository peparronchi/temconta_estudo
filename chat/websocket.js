var NossoWebSocket = function(url, nome)
{
	var retorno = {};
	var url_cliente = url;
	var nome_pessoa = nome;
	var conexao;

	// passando pro servidor a mensagem
	this.enviar = function(nome_evento, event_data){
		this.conexao.send(event_data);
		
		return this;
	};

	// estabeler conexao
	this.conectar = function(){
		// ta abrindo a cada cliente novo, irritando
		//window.open('servidor.php');
		
		// iniciando comunicacao via websocket no nvegador
		if(typeof(MozWebSocket) == 'function'){
			this.conexao = new MozWebSocket(url_cliente);
		}
		else{
			this.conexao = new WebSocket(url_cliente);
		}
		
		// quando receber mensagem do servidor
		this.conexao.onmessage = function(evento){
			disparar('message', evento.data);
		};

		// quando desconectar
		this.conexao.onclose = function(){
			disparar('close',null)
		}
	 
		// quando conectar
		this.conexao.onopen = function(){
			disparar('open',null)
		}
	};

	this.desconectar = function() {
		this.conexao.close();
	};
	
	this.bind = function(nome_evento, chamada_retorno){
		retorno[nome_evento] = retorno[nome_evento] || [];
		retorno[nome_evento].push(chamada_retorno);
		
		return this;
	};

	var disparar = function(nome_evento, mensagem){
		var variavel = retorno[nome_evento];
		
		if(typeof variavel == 'undefined'){
			return;
		}
		
		for(var i = 0; i < variavel.length; i++){
			variavel[i](mensagem)
		}
	}
};