$(function(){

    $("#data").mask("99/99/9999");
    alertTelas(1);
    searchtable();

});


function returnValue(key){

    Loading();
    $.ajax({
        type: 'GET',
        url: base_url+"Financeiro/ContasReceber/ReturnValue/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {

                $("#valor").val(response.toFixed(2).replace(".",","));
                $("#descricao").focus();
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
                mensagem("Erro","Erro ao listar tipo do recebimento!");
            }
        }
    });

}

function save(){

    if(validacao()){

        Loading();
        $.ajax({

            type:"POST",
            url: base_url+"Financeiro/ContasReceber/Save",
            async:true,
            data: $("#formCR").serialize(),
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
                    //location.reload();
                console.log("deu erro");
                else{
                    tirarLoading();
                    mensagem("Erro","Erro ao salvar !");
                }
            }

        });

    }

}

function listUnique(key){
    novo();
    Loading();
    $.ajax({
        type: 'GET',
        url: base_url+"Financeiro/ContasReceber/ListUnique/"+key,
        async: true,
        data: 1,
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {
                $("#recebimento").selectpicker("val",response.contasreceber["recebimento"]);
                $("#valor").val(response.contasreceber["total"]);
                $("#descricao").val(response.contasreceber["descricao"]);
                $("#frequencia").selectpicker("val",response.contasreceber["frequencia"]);
                $("#data").val(response.contasreceber["data"]);
                $("#contabancaria").selectpicker("val",response.contasreceber["contabancaria"]);
                $("#cript").val(response.contasreceber["cod"]);

                $("#modalLocalizar").modal("hide");
                $("#btnSave").attr("onClick","edit();");
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

function localizar(){

    $("#modalLocalizar  #search").val("").keyup();
    $("#modalLocalizar").modal("show");
    $('#modalLocalizar').on('shown.bs.modal', function () {

        $("#filter").focus()

    });

}

function novo(){

    $('#formCR').each (function(){
        this.reset();
        $('.selectpicker').selectpicker('val', '');
    });
    alertTelas(1);
    $("#btnSave").removeAttr("disabled");
    $("#btnSave").attr("onClick","save()");
    $("#recebimento").focus();

}

function changeFrequencia(value){

    if(value != 'U'){
        $("#divMonth").show()
        $("#qtdemeses").focus();
    }
    else{
        $("#qtdemeses").val("");
        $("#divMonth").hide();
    }

}

function validacao(){

    var validado = false;

    if($("#recebimento").val() == "" || $("#recebimento").val() == null || $("#recebimento").val() == undefined){

        mensagem("Erro", "Campo 'Recebimento' é obrigatorio!");

    }
    else
    if($("#valor").val() == "" || $("#valor").val() == null || $("#valor").val() == undefined){

        mensagem("Erro", "Campo 'Valor' é obrigatorio!");

    }
    else
    if($("#frequencia").val() == "" || $("#frequencia").val() == null || $("#frequencia").val() == undefined){

        mensagem("Erro", "Campo 'Frequência' é obrigatorio!");

    }
    else
    if($("#data").val() == "" || $("#data").val() == null || $("#data").val() == undefined){

        mensagem("Erro", "Campo 'Frequência' é obrigatorio!");

    }
    else
    if($("#contabancaria").val() == "" || $("#contabancaria").val() == null || $("#contabancaria").val() == undefined){

        mensagem("Erro", "Campo 'Conta Bancária' é obrigatorio!");

    }
    else
    if($("#frequencia").val() != 'U'){
        if($("#qtdemeses").val() == "" || $("#qtdemeses").val() == null || $("#qtdemeses").val()== undefined){
            mensagem("Erro","Campo 'Qtde Meses' é obrigatorio!")
        }
        else
            validado = true;
    }
    else
        validado = true;

    return validado;
}
