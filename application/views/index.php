<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url("img/favicon.ico")?>">
    <link rel="stylesheet" href="<?= base_url("css/login.css")?>">
    <link rel="stylesheet" href="<?= base_url("css/login.css")?>">
    <link rel="stylesheet" href="<?= base_url("css/bootstrap.css")?>">
    <link rel="stylesheet" href="<?= base_url("css/jquery.jgrowl.min.css")?>">
    <link rel="stylesheet" href="<?= base_url("css/jgrowl.personalizado.css")?>">
    <link rel="stylesheet" href="<?= base_url("css/bootstrap-select.min.css")?>">

    <title>Tem Conta</title>

</head>
<body>
<div class="container">
    <div id="loginbox" style="margin-top: 150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Realize seu Login</div>
                <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Esqueceu sua senha?</a></div>
            </div>

            <div style="padding-top:30px" class="panel-body" >

                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                <form action="<?= base_url("Login/autenticar")?>" id="loginform" class="form-horizontal" role="form" method="post">

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="usuario" type="text" class="form-control" name="usuario" value="" pattern=".{4,}" title="Mínimo 4 caracteres"  placeholder="Usuário" autofocus required>
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Senha" required>
                    </div>



                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input id="lembrar" type="checkbox" name="lembrar" value="1"> Lembrar
                            </label>
                        </div>
                    </div>


                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-md-12 ">
                            <button id="btnlogin" class="btn btn-success btn-block" data-loading-text="Carregando..." autocomplete="off">Login</button>

                        </div>
                    </div>





            </div>
        </div>
    </div>
</div>

<script src="<?= base_url("js/jquery-1.11.3.min.js")?>"></script>
<script src="<?= base_url("js/jquery-2.1.4.min.js")?>"></script>
<script src="<?= base_url("js/bootstrap.min.js")?>"></script>
<script src="<?= base_url("js/jquery.jgrowl.min.js")?>"></script>

<?php if($this->session->flashdata("danger") ): ?>
    <script>

        $.jGrowl("<?= $this->session->flashdata("danger"); ?>", {theme: 'growl-error', header: 'Erro!', life:'3000', position: 'top-right' });

    </script>
<?php endif ?>

<script>

    $( "#btnlogin" ).click(function() {
        if ($("#usuario").val() != "" && $("#usuario").val() != null &&  $("#usuario").val() != undefined && $("#usuario").val().length > 3 && $("#password").val() != "" && $("#password").val() &&  $("#password").val() != undefined && $("#password").val().length > 3) {

            $(this).button('loading');
        }
    });

</script>

</body>
</html>