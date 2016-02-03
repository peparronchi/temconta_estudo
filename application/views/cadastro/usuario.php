<div id="modalLocalizar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Localizar Usuário</h4>
            </div>
            <div class="modal-body">

                <div class="input-group"> <span class="input-group-addon">Filtrar</span>

                    <input id="filter" type="text" class="form-control" placeholder="Digite aqui...">
                </div>
                <div class="pre-scrollable">
                    <table class="table table-responsive table-bordered ">

                        <thead>

                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyUsuarios" class="searchable">
                        <?php
                        if($usuarios){

                            foreach($usuarios as $usuario):
                                ?>
                                <tr id="<?= $usuario["usuario_id"] ?>">
                                    <td><?= $usuario["usuario_nome"] ?></td>
                                    <td><?= $usuario["usuario_email"] ?></td>
                                    <td class="col-md-2 btn-primary" style="text-align: center"><button type="button" class="btn btn-primary" onclick="listUnique('<?=$this->encrypt->encode($usuario["usuario_id"]) ?>')"><i class="glyphicon glyphicon-wrench"></i> Editar</button> </td>
                                </tr>
                                <?php
                            endforeach;

                        }
                        ?>

                        </tbody>

                    </table>

                </div>


            </div>
        </div>

    </div>
</div>

<div class="container">

    <div class="alertalert-dismissible fade in alert-tela alert" id="alertTelas" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong class="strongAlert"></strong>
    </div>

    <div class="page-header">

        <div class="page-title">
            <h3>Cadastrar Usuário</h3>
        </div>
    </div>


    <form action="" method="post" enctype="multipart/form-data" id="formCadastroUsuario" role="form">


        <div class="form-group">

            <div class="row">

                <div class="col-md-4">

                    <label class="control-label">Nome *</label>
                    <input type="text" class="form-control" name="nome" id="nome" autofocus=""  placeholder="Digite o nome do usuário...">

                </div>

                <div class="col-md-5">

                    <label class="control-label">E-mail *</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="exemplo@exemplo.com...">

                </div>

                <div class="col-md-3">

                    <label class="control-label">Senha *</label>
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite a senha do usuário..">

                </div>

            </div>

        </div>

        <div class="form-group">

            <div class="row">

                <div class="col-md-3">

                    <label class="control-label">Telefone *</label>
                    <input type="text" class="form-control" name="telefone" id="telefone"  placeholder="(ddd)xxxx-xxxx">

                </div>




            </div>
            <input type="hidden" id="cript" name="cript">

        </div>

        <div class="well text-center">

            <button type="button" onclick="novo();" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Novo</button>
            <button type="button" onclick="save();" id="btnSave" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Salvar</button>
            <button type="button" onclick="localizar();" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Localizar</button>
            <button type="button" onclick="exclude();" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Excluir</button>

        </div>

    </form>

</div>

<script src="<?= base_url("js/projeto/cadastro/usuario.js") ?>">
</script>