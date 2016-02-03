<div class="container">

    <div class="page-header">

        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
    </div>

    <div class="form-group">

        <div class="col-md-4">

            <div class="canvas-container">

                <div class="panel panel-info">

                    <div class="panel-heading">
                        Despesas X Receitas <?= $data?>
                    </div>

                    <div class="panel-body">

                        <canvas id="graficoDoughnut"></canvas>

                        <div class="chart-legenda">
                            <ul>
                                <li ><i class="fa fa-square" style="color: #bce8f1" ></i> Receitas</li>
                                <li ><i class="fa fa-square" style="color: #337ab7;"></i> Despesas</li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>

            <div class="pre-scrollable">

                <table class="table">

                    <thead>
                        <tr>

                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Valor</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>Receitas</td>
                            <td><?= $data; ?></td>
                            <td>R$ <?= number_format($totalmesCR["total"],2,",",".")?></td>

                        </tr>

                        <tr>

                            <td>Despesas</td>
                            <td><?= $data; ?></td>
                            <td>R$ <?= number_format($totalmesCP["total"],2,",",".")?></td>

                        </tr>


                    </tbody>

                </table>

            </div>

        </div>

        <div class="col-md-8" style="margin:0px; padding:0px;">


            <div class="panel panel-info">

                <div class="panel-heading">
                    Despesas e Receitas decorrentes de <?= date("Y") ?>
                </div>

                <div class="panel-body">

                    <div class="canvas-containerBar">

                        <canvas id="graficoLine"></canvas>

                    </div>

                    <div class="chart-legenda">
                        <ul>
                            <li ><i class="fa fa-square" style="color: rgba(151,187,205,0.5)" ></i> Receitas</li>
                            <li ><i class="fa fa-square" style="color: rgba(220,220,220,0.5);"></i> Despesas</li>
                        </ul>
                    </div>


                </div>

            </div>


        </div>

    </div>

<script type="text/javascript">

    var options = {
        responsive:true
    };

    var dataDoughnut = [
        {
            value: <?= $totalmesCP["total"]?>,
            color:"#337ab7",
            highlight: "#337ab7",
            label: "Despesas"
        },
        {
            value: <?= $totalmesCR["total"]?>,
            color: "#bce8f1",
            highlight: "#bce8f1",
            label: "Receitas"
        },
    ]

    var dataBar = {
        labels: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
        datasets: [
            {
                label: "Despesas",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: [
                    <?php
                        for($i=0; $i<12; $i++){
                            echo "'".$totalperMonthCR[$i+1]["total"]."',";
                        }
                    ?>
                ]
            },
            {
                label: "Receitas",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: [
                    <?php
                       for($i=0; $i<12; $i++){
                           echo "'".$totalperMonthCP[$i+1]["total"]."',";
                       }
                   ?>

                ]
            }
        ]
    };


    window.onload = function(){
        var ctx = document.getElementById("graficoDoughnut").getContext("2d");
        var ctx2 = document.getElementById("graficoLine").getContext("2d");

        var Line = new Chart(ctx2).Bar(dataBar,options);
        var Doughnut = new Chart(ctx).Doughnut(dataDoughnut, options);
    }


</script>