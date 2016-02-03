$(function(){
    alertTelas(1);
    searchtable();
});

function save() {

    if (validacao()) {
        var dados = $('#formTipoRecebimento').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Tiporecebimento/Save",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                if (response.erro != "Erro") {
                    var nivel = $("#nivel").val();
                    $("#tbodyTiporecebimento").append("<tr id="+$("#descricao").val()+">" +
                        "<td>"+$("#descricao").val()+"</td>" +
                        "<td>"+$("#valor").val()+"</td>" +
                        "<td class=\"col-md-2 btn-primary\" style=\"text-align: center\"><button type=\"button\" class=\"btn btn-primary\" onclick=\"listUnique( '"+response.cript+"')\"><i class=\"glyphicon glyphicon-wrench\"></i> Editar</button> </td>" +
                        "</tr>");
                    $('#formTipoRecebimento').each(function () {
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
                    mensagem("Erro","Erro ao salvar tipo recebimento!");
                }
            }
        });

    }

}

function edit(){

    if (validacao()) {
        var dados = $('#formTipoRecebimento').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Tiporecebimento/Edit",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                tirarLoading();
                mensagem(response.erro, response.msg);
            },
            error : function(httpObj, txtStatus) {
                if(httpObj.status == 200 && httpObj.readyState == 4)
                    location.reload();
                else{
                    tirarLoading();
                    mensagem("Erro","Erro ao editar tipo de recebimento!");
                }
            }
        });

    }

}

function exclude(){

    var dados = $('#formTipoRecebimento').serialize();
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Cadastro/Tiporecebimento/Exclude",
        async: true,
        data: dados,
        dataType: "json",
        success: function (response) {
            $("tr#"+$("#descricao").val());
            novo();
            tirarLoading();
            mensagem(response.erro, response.msg);
        },
        error : function(httpObj, txtStatus) {
            if(httpObj.status == 200 && httpObj.readyState == 4)
                location.reload();
            else{
                tirarLoading();
                mensagem("Erro","Erro ao excluir tipo de recebimento!");
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
        url: base_url+"Cadastro/TipoRecebimento/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#descricao").val(response.tiporecebimento["descricao"]);
                $("#valor").val(response.tiporecebimento["valor"]);
                $("#cript").val(response.tiporecebimento["cod"]);
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

    $('#formTipoRecebimento').each (function(){
        this.reset();
    });
    alertTelas(1);
    $("#btnSave").attr("onClick","save()");
    $("#descricao").focus();

}

function validacao(){

    var validado = false;

    if($("#descricao").val() == "" || $("#descricao").val() == null || $("#descricao").val() == undefined){

        mensagem("Erro", "Campo 'Descrição' é obrigatorio!");

    }
    else
    if ($("#valor").val() == "" || $("#valor").val() == null || $("#valor").val() == undefined ) {

        mensagem("Erro", "Campo 'Valor' é obrigatorio!");

    }
    else
        validado = true;

    return validado;

}