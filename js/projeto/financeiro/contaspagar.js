$(function(){

    $("#datainicial").mask("99/99/9999");
    searchtable();
    alertTelas(1);

});

function calcularTotalMensal(){

    var parcelas = $("#qtdeparcela").val();
    var total = $("#valor").val().replace(".","");
    total = total.replace(",",".");
    var resultado = (total/parcelas);

    $("#totalmensal").val(resultado.toFixed(2)).keypress();

}

function addProduto(){


    var produto = $("#produto").val();
    var valor = $("#valor").val();
    var totalmensal = $("#totalmensal").val();
    var qtdeparcela = $("#qtdeparcela").val();
    var datainicial = $("#datainicial").val();
    var proximadata = $("#datainicial").val();

    if(validarAddProdutos(produto,valor,totalmensal,qtdeparcela,datainicial)) {


        $("#tableProduct tr#tr" + produto).remove();
        for (var i = 0; i < qtdeparcela; i++) {

            $("#tbodyaddProdutos").append("<tr id=\"tr"+produto+"\">" +
                "<td>"+$("#produto"+produto).html()+"</td>" +
                "<td>R$ " + totalmensal + "</td>" +
                "<td>" + parseInt(i+1) + "/"+ qtdeparcela+"</td>" +
                "<td>" + proximadata + "</td>" +
                "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"removeProduct("+produto+")\"><i class=\"fa fa-remove\"></i></button></td>" +
                "<input type=\"hidden\" name=\"valortotal["+produto+"]\" value=\""+valor+"\">" +
                "<input type=\"hidden\" name=\"totalparcela["+produto+"]\" value=\""+qtdeparcela+"\">" +
                "<input type=\"hidden\" name=\"mesinicial["+produto+"]\" value=\""+datainicial+"\">" +
                "</tr>");

            proximadata = addMonth(proximadata)

        }
    }

}



function removeProduct(key){

    var confirmacao = confirm("Deseja excluir todas parcelas desse produto?")
    if(confirmacao) {
        $("#tableProduct tr#tr" + key).remove();
    }
}

function save() {

    if (validacao()) {
        var dados = $('#formCP').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Financeiro/ContasPagar/Save",
            async: true,
            data: dados,
            dataType: "json",
            success: function (response) {
                if (response.erro != "Erro") {
                    novo();
                }
                tirarLoading();
                mensagem(response.erro, response.msg);
            },
            error : function(httpObj, txtStatus) {
                if(httpObj.status == 200 && httpObj.readyState == 4)
                    location.reload();
                else{
                    tirarLoading();
                    mensagem("Erro","Erro ao salvar !");
                }
            }
        });

    }

}

function edit(){

    if (validacao()) {
        var dados = $('#formCP').serialize();
        Loading();
        $.ajax({
            type: 'POST',
            url: base_url+"Financeiro/ContasPagar/Edit",
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
                    mensagem("Erro","Erro ao editar!");
                }
            }
        });

    }

}

function exclude(){

    var dados = $('#formCP').serialize();
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Financeiro/ContasPagar/Exclude",
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
                mensagem("Erro","Erro ao excluir!");
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
    novo();
    Loading();
    $.ajax({
        type: 'GET',
        url: base_url+"Financeiro/ContasPagar/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {
                $("#produto").selectpicker("val",response.contaspagar[0]["codproduto"]);
                $("#valor").val(response.contaspagar[0]["total"]);
                $("#qtdeparcela").selectpicker("val",response.contaspagar[0]["totalparcelas"]);
                $("#totalmensal").val(response.contaspagar[0]["valorunitario"]);
                $("#datainicial").val(response.contaspagar[0]["datavencimento"]);
                $("#contabancaria").selectpicker("val",response.contaspagar[0]["contabancaria"]);
                $("#cript").val(response.contaspagar[0]["cod"]);
                console.log(response.contaspagar.length);
                for (var i = 0; i < response.contaspagar.length; i++) {
                    $("#tbodyaddProdutos").append("<tr id=\"tr"+response.contaspagar[i]["codproduto"]+"\">" +
                        "<td>"+response.contaspagar[i]["produto"]+"</td>" +
                        "<td>R$ " + response.contaspagar[i]["total"] + "</td>" +
                        "<td>" + response.contaspagar[i]["numparcela"] + "/"+ response.contaspagar[i]["totalparcelas"] +"</td>" +
                        "<td>" + response.contaspagar[i]["datavencimento"] + "</td>" +
                        "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"removeProduct("+response.contaspagar[i]["codproduto"]+")\"><i class=\"fa fa-remove\"></i></button></td>" +
                        "<input type=\"hidden\" name=\"valortotal["+response.contaspagar[i]["codproduto"]+"]\" value=\""+response.contaspagar[i]["total"]+"\">" +
                        "<input type=\"hidden\" name=\"totalparcela["+response.contaspagar[i]["codproduto"]+"]\" value=\""+response.contaspagar[i]["totalparcelas"]+"\">" +
                        "<input type=\"hidden\" name=\"mesinicial["+response.contaspagar[i]["codproduto"]+"]\" value=\""+response.contaspagar[i]["datavencimento"]+"\">" +
                        "</tr>");


                }
                $('.nav-tabs a:last').tab('show')
                $("#modalLocalizar").modal("hide");
                $("#btnSave").attr("onClick","");
                $("#btnSave").attr("disabled","true");
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
                mensagem("Erro","Erro ao listar conta à pagar!");
            }
        }
    });

}

function novo(){

    $('#formCP').each (function(){
        this.reset();
        $('.selectpicker').selectpicker('val', '');
        $("#tbodyaddProdutos").html("");
    });
    alertTelas(1);
    $("#btnSave").removeAttr("disabled");
    $("#btnSave").attr("onClick","save()");
    $("#produto").focus();

}

function returnValue(key){

    Loading();
    $.ajax({
        type: 'GET',
        url: base_url+"Financeiro/ContasPagar/ReturnValue/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#valor").val(response.toFixed(2).replace(".",","));
                calcularTotalMensal();

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
                mensagem("Erro","Erro ao listar conta à pagar!");
            }
        }
    });

}


function baixarPagamento(key){
    Loading();
    $.ajax({
        type: 'GET',
        url: base_url + "Financeiro/ContasPagar/BaixarPagamento/" + key.value,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                mensagem(response.erro, response.msg);
                location.reload();

            }
            else {
                mensagem(response.erro, response.msg);
                tirarLoading();
            }
        },
        error: function (httpObj, txtStatus) {
            if (httpObj.status == 200 && httpObj.readyState == 4)
                location.reload();
            else {
                tirarLoading();
                mensagem("Erro", "Erro ao realizar baixa!");
            }
        }
    });
};


function validarAddProdutos(produto, valor, totalmensal, qtdeparcela, datainicial){

    var validado = false;

     if(produto == null || produto == "" || produto == undefined){

         mensagem("Erro","Selecione um Produto!");

     }
     else
    if(valor == null || valor == "" || valor == undefined){

        mensagem("Erro","Preencha o campo 'Valor'!");

    }
    else
    if(qtdeparcela == null || qtdeparcela == "" || qtdeparcela == undefined){

        mensagem("Erro","Selecione o campo 'Parcelas'!");

    }
    else
    if(totalmensal == null || totalmensal == "" || totalmensal == undefined){

        mensagem("Erro","Tente novamente'!");

    }
    else
    if(datainicial == null || datainicial == "" || datainicial == undefined){

        mensagem("Erro","Preencha o campo 'Data Inicial'!");

    }
    else{

        validado = true;

    }

    return validado;

}

function validacao(){

    var validado = false;

    if($("#contabancaria").val() == null || $("#contabancaria").val() == "" || $("#contabancaria").val() == undefined){

        mensagem("Erro","Selecione uma 'Conta Bancária'!");

    }
    else
    if($("#tbodyaddProdutos tr").length < 1){

        mensagem("Erro","Insirá ao menos um conta à pagar na tabela!");

    }
    else
        validado = true;

    return validado;

}
