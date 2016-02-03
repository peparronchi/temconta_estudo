<div class="container">

    <div class="page-header">

        <div class="page-title">
            <h3>Relatório Pagamentos por Período</h3>
        </div>
    </div>

    <form action="" method="post" enctype="multipart/form-data" id="formRelatorioPagamentos" role="form">
        <div class="form-group">

            <div clas="row">

                <div class="col-md-3">

                    <label class="control-label">Produto</label>
                    <select name="produto" id="produto" class="form-control selectpicker"  data-live-search="true" >

                        <option value="">Todos</option>
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

                <div class="col-md-3">

                    <label class="c-label">Data Inicial *</label>
                    <input type="text" class="form-control" name="datainicial" id="datainicial" placeholder="__/__/____" value="01/<?=date("m/Y") ?>">

                </div>

                <div class="col-md-3">

                    <label class="c-label">Data Final *</label>
                    <input type="text" class="form-control" name="datafinal" id="datafinal" placeholder="__/__/____"  value="31/<?=date("m/Y") ?>">

                </div>

                <div class="col-md-3">

                    <button type="button" class="btn btn-primary btn-block botaoAlinhado" onclick="listPagamentos()"><i class="fa fa-search"></i> Listar</button>

                </div>

            </div>

        </div>

        <div class="form-group" >

            <div class="row">

                <div class="col-md-12" style="margin-top: 45px;">

                    <div class="pre-scrollable">
<pre>
                        <table class="table">

                            <thead>

                            <tr>

                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Data Pgto</th>
                                <th>Parcela/Total</th>
                                <th>Preço</th>

                            </tr>

                            </thead>

                            <tbody id="tbodyPagamentos">

                        </table>
</pre>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<script src="<?=base_url("js/projeto/relatorio/pagamentos_periodo.js")?>"></script>