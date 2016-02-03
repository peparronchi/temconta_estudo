<div class="container">

    <div class="page-header">

        <div class="page-title">
            <h3>Chat</h3>
        </div>
    </div>

    <div class="form-group">

        <div class="row">

            <div class="col-md-6">

                <div class="panel panel-info" style="height: 300px; overflow: auto;">

                    <div class="list-group">


                    </div>

                </div>


            </div>

            <div class="col-md-4">

                <label class="control-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" readonly value="<?= $this->session->userdata("usuario_logado")["usuario_id"]." - ". $this->session->userdata("usuario_logado")["usuario_nome"] ?>">

                <label class="control-label">Mensagem</label>
                <textarea type="text" id="msg" name="msg" rows="10" class="form-control" placeholder="enter to send message"></textarea>
            </div>

        </div>

    </div>

    <div class="form-group">

        <div class="row">



        </div>

    </div>

</div>

<script>

    $( "#msg" ).keypress(function(e) {
        var height = $('.list-group').height();
        var tecla;

        if (e.keyCode) // testa se é IE
            tecla = e.keyCode;
        else
        if (e.which) // testa se é FF
            tecla = e.which;

        if(tecla != 13)
            return;

        $(".list-group").append("<a href=\"#\" class=\"list-group-item\">"+$("#nome").val()+": "+this.value+"</a>");
        $(this).val('');
        console.log(height);
        $('.list-group').scrollTop(height);
    });

</script>