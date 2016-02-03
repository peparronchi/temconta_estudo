<div id="modalLocalizar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Localizar Contas à Receber</h4>
            </div>
            <div class="modal-body">

                <div class="input-group"> <span class="input-group-addon">Filtrar</span>

                    <input id="filter" type="text" class="form-control" placeholder="Digite aqui...">
                </div>
                <div class="pre-scrollable">
                    <table class="table table-responsive table-bordered ">

                        <thead>

                        <tr>
                            <th>Recebimento</th>
                            <th>Valor</th>
                            <th>Frequência</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyUsuarios" class="searchable">
                        <?php
                        if($contasreceber){

                            foreach($contasreceber as $receber):

                                if($receber["contasreceber_frequencia"]== "U")
                                    $frequencia = "Unica Vez";
                                else
                                if($receber["contasreceber_frequencia"]== "M")
                                    $frequencia = "Mensal";
                                else
                                if($receber["contasreceber_frequencia"]== "T")
                                    $frequencia = "Trimestral";
                                else
                                if($receber["contasreceber_frequencia"]== "S")
                                    $frequencia = "Semestral";
                                else
                                if($receber["contasreceber_frequencia"]== "A")
                                    $frequencia = "Anual";

                                ?>
                                <tr id="<?= $receber["contasreceber_id"] ?>">
                                    <td><?= $receber["tiporecebimento_descricao"] ?></td>
                                    <td>R$ <?= number_format($receber["contasreceber_total"],2,",",".") ?></td>
                                    <td><?= $frequencia ?></td>
                                    <td><?= dateToBR($receber["contasreceber_datacadastro"]) ?></td>
                                    <td class="col-md-2 btn-primary" style="text-align: center"><button type="button" class="btn btn-primary" onclick="listUnique('<?=$this->encrypt->encode($receber["contasreceber_id"]) ?>')"><i class="glyphicon glyphicon-wrench"></i> Editar</button> </td>
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
            <h3>Contas à Receber</h3>
        </div>
    </div>


    <form action="" method="post" enctype="multipart/form-data" id="formCR" role="form">


        <div class="form-group">

            <div class="row">

                <div class="col-md-3">

                    <label class="control-label">Recebimento <i class="blue fa fa-asterisk "></i></label>
                    <select name="recebimento" id="recebimento" class="form-control selectpicker" onchange="returnValue(this.value)" data-live-search="true" title="Escolha o recebimento...">

                        <?php

                        if($recebimentos){

                            foreach($recebimentos as $recebimento){

                                echo "<option value=\"".$recebimento["tiporecebimento_id"]."\">".$recebimento["tiporecebimento_descricao"]."</option>";

                            }
                        }

                        ?>

                    </select>
                </div>

                <div class="col-md-3">

                    <label class="control-label">Valor <i class="blue fa fa-asterisk "></i></label>
                    <input type="text" class="form-control"  name="valor" id="valor" onkeypress="mascara(this,mreais)" placeholder="R$ 00,00">

                </div>

                <div class="col-md-6">

                    <label class="control-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Digite a descrição do recebimento...">

                </div>

            </div>

        </div>

        <div class="form-group">

            <div class="row">

                <div class="col-md-3">

                    <label class="control-label">Frequência <i class="blue fa fa-asterisk"></i></label>
                    <select class="form-control selectpicker" onchange="changeFrequencia(this.value)"  name="frequencia" id="frequencia" data-live-search="true" title="Frequência de recebimento...">

                        <option value="U">Unica Vez</option>
                        <option value="M">Mensal</option>
                        <option value="T">Trimestral</option>
                        <option value="S">Semestral</option>
                        <option value="A">Anual</option>

                    </select>

                </div>

                <div class="col-md-2">

                    <label class="control-label">Data <i class="blue fa fa-asterisk"></i></label>
                    <input name="data" id="data" class="form-control" type="text" placeholder="__/__/____" value="10/<?= date("m/Y") ?>">

                </div>

                <div id="divMonth" class="col-md-2" style="display:none">

                    <label class="control-label">Qtde Meses <i class="blue fa fa-asterisk"></i></label>
                        <input name="qtdemeses" id="qtdemeses" class="form-control" type="number">

                </div>

                <div class="col-md-4">

                    <label class="control-label">Conta Bancária <i class="blue fa fa-asterisk"></i></label>
                    <select class="form-control selectpicker" name="contabancaria" id="contabancaria" data-live-search="true" title="Selecione uma conta">

                        <?php

                        if($contabancaria){

                            foreach($contabancaria as $conta){

                                echo "<option value=\"".$conta["contabancaria_id"]."\">".$conta["contabancaria_descricao"]."</option>";

                            }

                        }
                        else
                            echo "<option>Não há contas existentes</option>"

                        ?>

                    </select>

                </div>

            </div>

        </div>

        <div class="well text-center">

            <button type="button" onclick="novo();" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Novo</button>
            <button type="button" onclick="save();" id="btnSave" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Salvar</button>
            <button type="button" onclick="localizar();" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Localizar</button>
            <button type="button" onclick="exclude();" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Excluir</button>

        </div>

    </form>

</div>

<script src="<?= base_url("js/projeto/financeiro/contasreceber.js") ?>"></script>