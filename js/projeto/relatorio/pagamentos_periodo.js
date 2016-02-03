$(function(){

    $("#datainicial").mask("99/99/9999");
    $("#datafinal").mask("99/99/9999");

});


function listPagamentos(){
    $("#tbodyPagamentos").html("");
    var total =0;
    Loading();
    $.ajax({
        type: 'POST',
        url: base_url+"Relatorio/Pagamentos/ListPagamentos/",
        async: true,
        data: $("#formRelatorioPagamentos").serialize(),
        dataType: "json",
        success: function (response) {
            if (response.erro != "Erro") {
                for (var i =0; i < response.length; i++) {

                    $("#tbodyPagamentos").append("<tr>" +
                        "<td>"+response[i]["produto_descricao"]+"</td>" +
                        "<td>"+response[i]["contaspagar_descricao"]+"</td>" +
                        "<td>"+dataPtBr(response[i]["itens_datavencimento"])+"</td>" +
                        "<td>"+response[i]["itens_numparcela"]+"/"+response[i]["iten_totalparcela"]+"</td>" +
                        "<td>R$ "+response[i]["itens_valorunitario"]+"</td>" +
                        "</tr>");

                    total += parseFloat(response[i]["itens_valorunitario"]);
                }
                $("#tbodyPagamentos").append("<tr>" +
                    "<td colspan='2'></td>" +
                    "<td colspan='1'>Total</td>" +
                    "<td colspan='1'>"+total.toFixed(2)+"</td>" +
                    "</tr>");
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
                mensagem("Erro","Erro ao listar pagamentos!");
            }
        }
    });


}