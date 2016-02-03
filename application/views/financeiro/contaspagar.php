<div id="modalLocalizar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Localizar Contas à Pagar</h4>
            </div>
            <div class="modal-body">

                <div class="input-group"> <span class="input-group-addon">Filtrar</span>

                    <input id="filter" type="text" class="form-control" placeholder="Digite aqui...">
                </div>
                <div class="pre-scrollable">
                    <table class="table table-responsive table-bordered ">

                        <thead>

                        <tr>
                            <th>Produto</th>
                            <th>Parcela</th>
                            <th>R$ Parcela</th>
                            <th>Mês Venc</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="tbodyContasPagar" class="searchable">
                        <?php
                        if($contaspagar){

                            foreach($contaspagar as $pagar):
                                ?>
                                <tr id="<?= $pagar["contaspagar_id"] ?>">
                                    <td><?= strtoupper($pagar["produto_descricao"]) ?></td>
                                    <td><?= $pagar["itens_numparcela"]."/".$pagar["contaspagar_totalparcelas"]  ?></td>
                                    <td>R$ <?= number_format($pagar["itens_valorunitario"],2,",",".") ?></td>
                                    <td><?= dateToBR($pagar["itens_datavencimento"]) ?></td>
                                    <td class="col-md-2 btn-primary" style="text-align: center"><button type="button" class="btn btn-primary" onclick="listUnique('<?=$this->encrypt->encode($pagar["contaspagar_id"]) ?>')"><i class="glyphicon glyphicon-wrench"></i> Editar</button> </td>
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
            <h3>Contas à Pagar</h3>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#menudashboard"><i class="fa fa-tachometer"></i> Dashboard</a></li>
        <li class="active"><a data-toggle="tab" href="#menubaixar"><i class="fa fa-download"></i> Baixar</a></li>
        <li><a data-toggle="tab" href="#menucadastrar"><i class="fa fa-list"></i> Cadastrar</a></li>
    </ul>

    <div class="tab-content">

        <div id="menubaixar" class="tab-pane fade in active">


            <table class="table datatable" >

                <thead>

                    <th>Produto</th>
                    <th>Parcela</th>
                    <th>R$ Parcela</th>
                    <th>Data Venc</th>
                    <th>Pago</th>
                    <th></th>

                </thead>

                <tbody>

                <?php
                if($contaspagar) {
					$saldopago 		= 0;
					$saldoapagar 	= 0;
                    foreach ($contaspagar as $pagar):
                        if($pagar["itens_datapagamento"] !== NULL && $pagar["itens_datapagamento"] !== ""){
                            //$cor = "background-color: RGBA(118,234,122,0.61)";
                            $corpago = "btn-success";
                            $classpago = "fa fa-check-square-o";
                            $keypago = "pago";
							$saldopago += $pagar["itens_valorunitario"];
                        }
                        else {
                            //$cor = "background-color: RGBA(236,131,131,0.3)";
                            $corpago = "btn-danger";
                            $classpago = "fa fa-square-o";
                            $keypago = "naopago";
							$saldoapagar += $pagar["itens_valorunitario"];
                        }

                        ?>
                        <tr id="<?= $pagar["contaspagar_id"] ?>">
                            <td><?= ucfirst($pagar["produto_descricao"]) ?></td>
                            <td><?= $pagar["itens_numparcela"]."/".$pagar["contaspagar_totalparcelas"]  ?></td>
                            <td>R$ <?= number_format($pagar["itens_valorunitario"],2,",",".") ?></td>
                            <td><?= dateToBR($pagar["itens_datavencimento"]) ?></td>
                            <td><button value="<?= $pagar["itens_id"] ?>" class="btn <?=$corpago?> " type="button" onclick="baixarPagamento(this)"><i class="<?= $classpago; ?>"></i></td>
                            <td><button style="margin-right: 3px;" type="button" class="btn" title="editar" onclick="listUnique('<?=$this->encrypt->encode($pagar["contaspagar_id"]) ?>')"><i class="fa fa-wrench"></i></button> </td>
                        </tr>
                        <?php
                    endforeach;

                }
                else
                    echo "<tr><td colspan=\"4\">Não há resultados</td></tr>";
                ?>
				<tr>
				
					<td colspan="2"></td>
					<td colspan="1">À Pagar</td>
					<td colspan="1" class="text-danger">R$ <?= number_format($saldoapagar,2,",",".") ?></td>
					<td colspan="1">Pago</td>
					<td colspan="1" class="text-success">R$ <?= number_format($saldopago,2,",",".") ?></td>
				
				</tr>
                </tbody>

            </table>


        </div>

        <div id="menucadastrar" class="tab-pane fade">

            <form action="" method="post" enctype="multipart/form-data" id="formCP" role="form">


                <div class="form-group">

                    <div class="row">

                        <div class="col-md-3">

                            <label class="control-label">Produto *</label>
                            <select name="produto" id="produto" class="form-control selectpicker" onchange="returnValue(this.value)" data-live-search="true" title="Escolha o produto...">

                                <?php

                                if($produtos){
                                    foreach($produtos as $produto){

                                        echo "<option id=\"produto".$produto['produto_id']."\"  value=\"".$produto['produto_id']."\">".$produto["produto_descricao"]."</option>";

                                    }
                                }
                                else
                                    echo "<option value=''>Erro ao listar produtos</option>";

                                ?>

                            </select>
                        </div>

                        <div class="col-md-2">

                            <label class="control-label">Valor *</label>
                            <input type="text" class="form-control"  name="valor" id="valor" onblur="calcularTotalMensal()" onkeypress="mascara(this,mreais)" placeholder="R$ 00,00">

                        </div>


                        <div class="col-md-2">

                            <label class="control-label">Parcelas *</label>
                            <select class="form-control selectpicker"  name="qtdeparcela" id="qtdeparcela" data-live-search="true" title="Quantidade..." onchange="calcularTotalMensal()">

                                <?php

                                for($i=1; $i <= 12; $i++) {

                                    if($i == 1)
                                        echo "<option value=" . $i . ">" . $i . " parcela </option>";
                                    else
                                        echo "<option value=" . $i . ">" . $i . " parcelas </option>";
                                }

                                ?>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="control-label">Total Mensal</label>
                            <input type="text" id="totalmensal" name="totalmensal" class="form-control" onkeypress="mascara(this,mreais)"  placeholder="R$ 00,00" readonly>

                        </div>

                        <div class="col-md-2">

                            <label class="control-label">Data Inicial</label>
                            <input type="text" id="datainicial" name="datainicial" class="form-control" placeholder="__/__/____" value="<?= date("d/m/Y") ?>">

                        </div>

                        <div class="col-md-1" >
                            <button type="button" onclick="addProduto();" class="botaoAlinhado btn btn-primary"><i class="fa fa-plus-circle"></i></button>

                        </div>


                    </div>

                </div>

                <div class="form-group">

                    <div class="row">

						<div class="col-md-4">

                            <label class="control-label">Descrição</label>
                            <input type="text" id="descricao" name="descricao" class="form-control"  >

                        </div>
						
                        <div class="col-md-4">

                            <label class="control-label">Conta Bancária</label>
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

                <div class="form-group">

                    <div class="pre-scrollable">
                        <table class="table table-responsive table-bordered " id="tableProduct">

                            <thead>

                            <tr>
                                <th>Produto</th>
                                <th>Valor Mensal</th>
                                <th>Parcela</th>
                                <th>Mês Venc</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tbodyaddProdutos" class="searchable">

                            </tbody>

                        </table>

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
    </div>

</div>

<script src="<?= base_url("js/projeto/financeiro/contaspagar.js") ?>"></script>