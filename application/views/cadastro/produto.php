<div id="modalLocalizar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Localizar Produtos</h4>
            </div>
            <div class="modal-body">
                <div class="input-group"> <span class="input-group-addon">Filtrar</span>

                    <input id="filter" type="text" class="form-control" placeholder="Digite aqui...">
                </div>
                <div class="pre-scrollable">
                    <table class="table table-responsive table-bordered ">

                        <thead>

                        <tr>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="tbodyProdutos" class="searchable">
                        <?php
                        if($produto){

                            foreach($produto as $prod):
                                ?>
                                <tr id="<?= $prod["produto_descricao"] ?>">
                                    <td><?= $prod["produto_descricao"] ?></td>
                                    <td>R$ <?= number_format($prod["produto_valor"],2,",",".") ?></td>
                                    <td class="col-md-2 btn-primary" style="text-align: center"><button type="button" class="btn btn-primary" onclick="listUnique('<?=$this->encrypt->encode($prod["produto_id"]) ?>')"><i class="glyphicon glyphicon-wrench"></i> Editar</button> </td>
                                </tr>
                                <?php
                            endforeach;

                        }
                        ?>

                        </tbody>

                    </table>

                </div>


            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
            <h3>Cadastro de Produtos</h3>
        </div>
    </div>


    <form action="" method="post" enctype="multipart/form-data" id="formProduto" role="form">


        <div class="form-group">

            <div class="row">

                <div class="col-md-4">

                    <label class="control-label">Descrição *</label>
                    <input type="text" class="form-control" name="descricao" id="descricao">
                </div>

                <div class="col-md-2">

                    <label class="control-label">Valor</label>
                    <input type="text" class="form-control"  name="valor" id="valor" onkeypress="mascara(this,mreais)" placeholder="R$ 00,00">

                </div>

            </div>

        </div>
        <input type="hidden" id="cript" name="cript">

        <div class="well text-center">

            <button type="button" onclick="novo();" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Novo</button>
            <button type="button" onclick="save();" id="btnSave" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Salvar</button>
            <button type="button" onclick="localizar();" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Localizar</button>
            <button type="button" onclick="exclude();" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Excluir</button>

        </div>

    </form>

</div>

<script src="<?= base_url("js/projeto/cadastro/produto.js") ?>"></script>