$(function(){

    $("#telefone").mask("(999)9999-9999");
    alertTelas(1);
    searchtable();

});

function save() {

    if (validacao()) {
        var dados = $('#formCadastroUsuario').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Usuario/Save",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                if (response.erro != "Erro") {
                    $("#tbodyUsuarios").append("<tr id="+$("#email").val()+">" +
                        "<td>"+$("#nome").val()+"</td>" +
                        "<td>"+$("#email").val()+"</td>" +
                        "<td class=\"col-md-2 btn-primary\" style=\"text-align: center\"><button type=\"button\" class=\"btn btn-primary\" onclick=\"listUnique( '"+response.cript+"')\"><i class=\"glyphicon glyphicon-wrench\"></i> Editar</button> </td>" +
                        "</tr>");
                    $('#formCadastroUsuario').each(function () {
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
                    mensagem("Erro","Erro ao salvar usuário!");
                }
            }
        });

    }

}

function edit(){

    if (validacao()) {
        var dados = $('#formCadastroUsuario').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Cadastro/Usuario/Edit",
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
                    mensagem("Erro","Erro ao editar o Usuário!");
                }
            }
        });

    }

}

function exclude(){

    var dados = $('#formCadastroUsuario').serialize();
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Cadastro/Usuario/Exclude",
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
                mensagem("Erro","Erro ao excluir o Usuário!");
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
        url: base_url+"Cadastro/Usuario/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#nome").val(response.usuario["nome"]);
                $("#email").val(response.usuario["email"]);
                $("#senha").val("****").attr("readonly","senha");
                $("#telefone").val(response.usuario["telefone"]);
                $("#cript").val(response.usuario["cod"]);
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

    $('#formCadastroUsuario').each (function(){
        this.reset();
        $("#senha").removeAttr("readonly");
    });
    alertTelas(1);
    $("#btnSave").attr("onClick","save()");
    $("#nome").focus();

}

function validacao(){

    var validado = false;

    if($("#nome").val() == "" || $("#nome").val() == null || $("#nome").val() == undefined){

        mensagem("Erro", "Campo 'Nome' é obrigatorio!");

    }
    else
    if ($("#email").val() == "" || $("#nome").val() == null || $("#nome").val() == undefined || !validarEmail($("#email").val())) {

        validar = false;
        if($("#email").val() == "" || $("#nome").val() == null || $("#nome").val() == undefined)
            mensagem("Erro", "Campo 'E-mail' é obrigatorio!");
        else
            mensagem("Erro", "Insira um E-mail valido!");

    }
    else
        validado = true;

    return validado;

}