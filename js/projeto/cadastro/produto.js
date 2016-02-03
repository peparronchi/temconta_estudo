$(function(){
    alertTelas(1);
    searchtable();
});

function save() {

    if (validacao()) {
        var dados = $('#formProduto').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Produto/Save",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                if (response.erro != "Erro") {
                    var nivel = $("#nivel").val();
                    $("#tbodyProdutos").append("<tr id="+$("#descricao").val()+">" +
                        "<td>"+$("#descricao").val()+"</td>" +
                        "<td>"+$("#valor").val()+"</td>" +
                        "<td class=\"col-md-2 btn-primary\" style=\"text-align: center\"><button type=\"button\" class=\"btn btn-primary\" onclick=\"listUnique( '"+response.cript+"')\"><i class=\"glyphicon glyphicon-wrench\"></i> Editar</button> </td>" +
                        "</tr>");
                    $('#formProduto').each(function () {
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
                    mensagem("Erro","Erro ao salvar Produto!");
                }
            }
        });

    }

}

function edit(){

    if (validacao()) {
        var dados = $('#formProduto').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Produto/Edit",
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
                    mensagem("Erro","Erro ao editar Produto!");
                }
            }
        });

    }

}

function exclude(){

    var dados = $('#formProduto').serialize();
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Cadastro/Produto/Exclude",
        async: true,
        data: dados,
        dataType: "json",
        success: function (response) {
            $("tr#"+$("#descricao").val());
            tirarLoading();
            mensagem(response.erro, response.msg);
        },
        error : function(httpObj, txtStatus) {
            if(httpObj.status == 200 && httpObj.readyState == 4)
                location.reload();
            else{
                tirarLoading();
                mensagem("Erro","Erro ao excluir Produto!");
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
        url: base_url+"Cadastro/Produto/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#descricao").val(response.produto["descricao"]);
                $("#valor").val(response.produto["valor"]);
                $("#cript").val(response.produto["cod"]);
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

    $('#formProduto').each (function(){
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
        validado = true;

    return validado;

}