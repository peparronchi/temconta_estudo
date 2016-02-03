var base_url = "http://localhost/";
$(function () {
    var menuativo = retornaMenuAtivo();
    $( "ul#menu-content" ).find( "li."+menuativo ).addClass("active");

    $("body").fadeIn("slow");
    $( "#menu ul>li>a" ).click(function() {
     var url = this.href;
     if(url !== "" && url !== "#" && url !== window.location.href+"#"  && url !== window.location.href)
        Loading();
     });

    var toogleMenu = document.querySelectorAll('.toggle-menu'),
        wrapper    = document.querySelector('.wrapper');

// criando evento de click para abrir o menu
    for (var i = 0; i < toogleMenu.length; i++){
        toogleMenu[i].addEventListener('click', menuAction);
    }

// função auxiliar que abre e fecha o menu
    function menuAction() {
        if(wrapper.classList.contains('show-menu')){
            wrapper.classList.remove('show-menu');
        }
        else {
            wrapper.classList.add('show-menu');
        }
    }

    $(".datatable").bdt();

});

function tirarLoading(){

    $("#divloading").remove();

}

function Loading(){

    $('body').append('<div class="overlay" id="divloading"></div>');
    setTimeout(function(){ tirarLoading(); }, 15000);


}

function mensagem(erro,mensagem){
    var tema;
    if(erro == "Erro")
        tema = "growl-error"
    else
    if(erro == "Sucesso")
        tema = "growl-success"

    return $.jGrowl(mensagem, {theme: tema, header: erro, life:'3000', position: 'top-right' });

}

function alertTelas(classe){

    var classealert, mensagem;
    if(classe == 1){
        classealert = "alert-info"
        mensagem = "Novo";
    }
    else
    if(classe == 2){
        classealert = "alert-warning"
        mensagem = "Editando";
    }
    $(".strongAlert").html(mensagem);

    $("#alertTelas").removeClass("alert-warning");
    $("#alertTelas").removeClass("alert-info");
    $("#alertTelas").addClass(classealert);
    $("#alertTelas").show();

}

function validarEmail(email){

    var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if(!filtro.test(email)){
        return false;
    }
    else
        return true;

}

function retornaMenuAtivo(){

    var prefixo = window.location.href.split("/");
    return prefixo[3].toLowerCase().replace("#","");

}

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function mreais(v){
    v=v.replace(/\D/g,"")						//Remove tudo o que não é dígito
    v=v.replace(/(\d{2})$/,",$1") 			//Coloca a virgula
    v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1.$2") 	//Coloca o primeiro ponto
    return v
}

function searchtable(){

    $('#filter').keyup(function () {

        var rex = new RegExp($(this).val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    })
}

function dataMysql(date){

    return date.split("/")[2]+"-"+date.split("/")[1]+"-"+date.split("/")[0];

}

function dataPtBr(date){

    return date.split("-")[2]+"/"+date.split("-")[1]+"/"+date.split("-")[0];

}

function addMonth(date){

    var day     = date.split("/")[0];
    var month   = date.split("/")[1];
    var year    = date.split("/")[2];

    if(month == 12){
        month = "01";
        year = parseInt(year) + parseInt(1);
    }
    else{
        if(month < 9){
            month = parseInt(month)+parseInt(1);
            month = "0"+month;
        }
        else{
            month = parseInt(month)+parseInt(1);
        }
    }

    return day+"/"+month+"/"+year;


}

function convertMonth(month){


    switch(month) {

        case 1:
            return "Janeiro";
            break;

        case 2:
            return "Fevereiro";
            break;

        case 3:
            return "Março";
            break;

        case 4:
            return "Abril";
            break;

        case 5:
            return "Maio";
            break;

        case 6:
            return "Junho";
            break;

        case 7:
            return "Julho";
            break;

        case 8:
            return "Agosto";
            break;

        case 9:
            return "Setembro";
            break;

        case 10:
            return "Outubro";
            break;

        case 11:
            return "Novembro";
            break;

        case 12:
            return "Dezembro";
            break;
    }

}