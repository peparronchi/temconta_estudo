<div id="modalLocalizar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Localizar Conta Bancária</h4>
            </div>
            <div class="modal-body">

                <div class="input-group"> <span class="input-group-addon">Filtrar</span>

                    <input id="filter" type="text" class="form-control" placeholder="Digite aqui...">
                </div>
                <div class="pre-scrollable">
                    <table class="table table-responsive table-bordered ">

                        <thead>

                        <tr>
                            <th>Banco</th>
                            <th>Descrição</th>
                            <th>Tipo Conta</th>
                            <th>Saldo Inicial</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="tbodyContabancaria" class="searchable">
                        <?php
                        if($contabancaria){

                            foreach($contabancaria as $conta):
                                ?>
                                <tr id="<?= $conta["contabancaria_id"] ?>">
                                    <td><?= $conta["banco_descricao"] ?></td>
                                    <td><?= $conta["contabancaria_descricao"] ?></td>
                                    <td><?= $conta["tipoconta_descricao"] ?></td>
                                    <td>R$ <?= number_format($conta["contabancaria_saldo"],2,",",".") ?></td>
                                    <td class="col-md-2 btn-primary" style="text-align: center"><button type="button" class="btn btn-primary" onclick="listUnique('<?=$this->encrypt->encode($conta["contabancaria_id"]) ?>')"><i class="glyphicon glyphicon-wrench"></i> Editar</button> </td>
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
            <h3>Cadastro de Conta Bancária</h3>
        </div>
    </div>


    <form action="" method="post" enctype="multipart/form-data" id="formContabancaria" role="form">


        <div class="form-group">

            <div class="row">

                <div class="col-md-2">

                    <label class="control-label">Agência *</label>
                    <input type="text" class="form-control" name="agencia" id="agencia">
                </div>

                <div class="col-md-2">

                    <label class="control-label">Número *</label>
                    <input type="text" class="form-control" name="numero" id="numero">

                </div>

                <div class="col-md-5">

                    <label class="control-label">Banco *</label>
                    <select class="form-control selectpicker" name="banco" id="banco" data-live-search="true" >
                        <option value="">Escolha o banco</option>
                        <?php

                            if($bancos){
                                foreach($bancos as $banco){

                                    echo "<option id=\"banco".$banco['banco_id']."\"  value=\"".$banco['banco_id']."\">".$banco["banco_codigo"]." - ".$banco['banco_descricao']."</option>";

                                }
                            }
                            else
                                echo "<option value=''>Erro ao listar bancos</option>";

                        ?>

                    </select>
                </div>

                <div class="col-md-3">

                    <label class="control-label">Tipo Conta *</label>
                    <select class="form-control selectpicker" name="tipoconta" id="tipoconta" data-live-search="true" >
                        <option value="">Escolha o tipo da conta</option>
                        <?php

                        if($tipoconta){
                            foreach($tipoconta as $conta){

                                echo "<option id=\"tipoconta".$conta['tipoconta_id']."\" value=\"".$conta['tipoconta_id']."\">".$conta["tipoconta_descricao"]."</option>";

                            }
                        }
                        else
                            echo "<option value=''>Erro ao listar bancos</option>";

                        ?>

                    </select>

                </div>

            </div>

        </div>

        <div class="form-group">

            <div class="row">

                <div class="col-md-2">

                    <label class="control-label">Saldo Inicial</label>
                    <input type="text" class="form-control" id="saldoinicial" name="saldoinicial"  onkeypress="mascara(this,mreais)" placeholder="R$ 00,00">

                </div>

                <div class="col-md-4">

                    <label class="control-label">Descrição *</label>
                    <input type="text" class="form-control" name="descricao" id="descricao">

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


<script src="<?= base_url("js/projeto/cadastro/contabancaria.js") ?>"></script>