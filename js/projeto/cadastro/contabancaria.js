$(function(){
    alertTelas(1);
    searchtable();
});

function save() {

    if (validacao()) {
        var dados = $('#formContabancaria').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Contabancaria/Save",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                if (response.erro != "Erro") {
                    var banco = $("#banco").val();
                    var tipoconta = $("#tipoconta").val();
                    $("#tbodyContabancaria").append("<tr id="+$("#descricao").val()+">" +
                        "<td>"+$("#banco"+banco).html()+"</td>" +
                        "<td>"+$("#descricao").val()+"</td>" +
                        "<td>"+$("#tipoconta"+tipoconta).html()+"</td>" +
                        "<td>"+$("#saldoinicial ").val()+"</td>" +
                        "<td class=\"col-md-2 btn-primary\" style=\"text-align: center\"><button type=\"button\" class=\"btn btn-primary\" onclick=\"listUnique( '"+response.cript+"')\"><i class=\"glyphicon glyphicon-wrench\"></i> Editar</button> </td>" +
                        "</tr>");
                    $('#formContabancaria').each(function () {
                        this.reset();
                    });
                }
                tirarLoading();
                mensagem(response.erro, response.msg);
            },
            error : function(httpObj, txtStatus) {
                if(httpObj.status == 200 && httpObj.readyState == 4)
                    location.reload();
                else{
                    tirarLoading();
                    mensagem("Erro","Erro ao salvar a Conta Bancária!");
                }
            }
        });

    }

}

function edit(){

    if (validacao()) {
        var dados = $('#formContabancaria').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Contabancaria/Edit",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                tirarLoading();
                mensagem(response.erro, response.msg);
            },
            error : function(httpObj, txtStatus) {
                if(httpObj.status == 200 && httpObj.readyState == 4)
                //location.reload();
                    console.log(httpObj);
                else{
                    tirarLoading();
                    mensagem("Erro","Erro ao editar a Conta Bancária!");
                }
            }
        });

    }

}

function exclude(){

    var dados = $('#formContabancaria').serialize();
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Cadastro/Contabancaria/Exclude",
        async: true,
        data: dados,
        dataType: "json",
        success: function (response) {
            novo();
            tirarLoading();
            mensagem(response.erro, response.msg);
        },
        error : function(httpObj, txtStatus) {
            if(httpObj.status == 200 && httpObj.readyState == 4)
                location.reload();
            else{
                tirarLoading();
                mensagem("Erro","Erro ao excluir a Conta Bancária!");
            }
        }
    });


}

function localizar(){

    $("#modalLocalizar  #search").val("").keyup();
    $("#modalLocalizar").modal("show");
    $('#modalLocalizar').on('shown.bs.modal', function () {

        $("#filter").focus()

    });

}

function listUnique(key){

    Loading();
    $.ajax({
        type: 'GET',
        url: base_url+"Cadastro/Contabancaria/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#agencia").val(response.contabancaria["agencia"]);
                $("#numero").val(response.contabancaria["numero"]);
                $("#banco").selectpicker("val",response.contabancaria["banco"]);
                $("#descricao").val(response.contabancaria["descricao"]);
                $("#tipoconta").selectpicker("val",response.contabancaria["tipoconta"]);
                $("#saldoinicial").val(response.contabancaria["saldo"]).attr("readonly","true");
                $("#cript").val(response.contabancaria["cod"]);
                $("#modalLocalizar").modal("hide");
                $("#btnSave").attr("onClick","edit()");
                alertTelas(2);
            }
            else{
                mensagem(response.erro,response.msg);
            }
            tirarLoading();
        },
        error : function(httpObj, txtStatus) {
            if(httpObj.status == 200 && httpObj.readyState == 4)
                location.reload();
            else{
                tirarLoading();
                mensagem("Erro","Erro ao listar usuário!");
            }
        }
    });

}

function novo(){

    $('#formContabancaria').each (function(){
        this.reset();
        $('.selectpicker').selectpicker('val', '');
    });
    alertTelas(1);
    $("#btnSave").attr("onClick","save()");
    $("#agencia").focus();

}


function validacao(){

    var validado = false;

    if($("#agencia").val() == "" || $("#agencia").val() == null || $("#agencia").val() == undefined){

        mensagem("Erro", "Campo 'Agência' é obrigatorio!");

    }
    else
    if($("#numero").val() == "" || $("#numero").val() == null || $("#numero").val() == undefined){

        mensagem("Erro", "Campo 'Número' é obrigatorio!");

    }
    else
    if($("#banco").val() == "" || $("#banco").val() == null || $("#banco").val() == undefined){

        mensagem("Erro", "Campo 'Banco' é obrigatorio!");

    }
    else
    if($("#descricao").val() == "" || $("#descricao").val() == null || $("#descricao").val() == undefined){

        mensagem("Erro", "Campo 'Descrição' é obrigatorio!");

    }
    else
    if($("#tipoconta").val() == "" || $("#tipoconta").val() == null || $("#banco").val() == undefined){

        mensagem("Erro", "Campo 'Tipo Conta' é obrigatorio!");

    }
    else
    if($("#saldoinicial").val() == "" || $("#saldoinicial").val() == null || $("#saldoinicial").val() == undefined){

        mensagem("Erro", "Campo 'Saldo Inicial' é obrigatorio!");

    }
    else
        validado = true;

    return validado;

}