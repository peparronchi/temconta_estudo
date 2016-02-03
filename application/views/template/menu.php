<div class="nav-side-menu">
    <div class="brand">Tem Conta!</div>
    <i class="fa fa-bars fa-3x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">



        <ul id="menu-content" class="menu-content collapse out">
            <li class="dashboard">
                <a href="<?= base_url("/Dashboard") ?>">
                    <i class="fa fa-dashboard fa-lg"></i> Dashboard
                </a>
            </li>

            <li data-toggle="collapse" data-target="#financeiro" class="collapsed financeiro">
                <a href="#"><i class="fa fa-money fa-lg"></i> Financeiro <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse out" id="financeiro">
                <li data-toggle="collapse" data-target="#contas" class="collapsed">
                    <a href="#">Contas<span class="arrow"></span></a>
                </li>
                <ul class="sub-sub-menu collapse out" id="contas">
                    <li><a href="<?= base_url("Financeiro/ContasPagar") ?>">Contas à Pagar</a></li>
                    <li><a href="<?= base_url("/Financeiro/ContasReceber") ?>">Contas à Receber</a></li>
                </ul>
            </ul>


            <li data-toggle="collapse" data-target="#cadastro" class="collapsed cadastro">
                <a href="#"><i class="fa fa-globe fa-lg"></i> Cadastros <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse out" id="cadastro">
                <li><a href="<?= base_url("Cadastro/Contabancaria") ?>">Conta Bancária</a></li>
                <li><a href="<?= base_url("Cadastro/Produto") ?>">Produto</a></li>
                <li><a href="<?= base_url("Cadastro/Tiporecebimento") ?>">Tipo Recebimento</a></li>
                <li><a href="<?= base_url("Cadastro/Usuario") ?>">Usuário</a></li>
            </ul>


            <li data-toggle="collapse" data-target="#relatorio" class="collapsed relatorio">
                <a href="#"><i class="fa fa-paperclip fa-lg"></i> Relatórios <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse out" id="relatorio">
                <li>Recebimetos por Período</li>
                <li><a href="<?= base_url("Relatorio/Pagamentos") ?>">Pagamentos por Período</a></li>
                <li>Despesas x Receitas</li>
            </ul>


            <li>
                <a href="#">
                    <i class="fa fa-user fa-lg"></i> Profile
                </a>
            </li>

            <li data-toggle="collapse" data-target="#config" class="collapsed">
                <a href="#"><i class="fa fa-wrench fa-lg"></i> Configurações <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse out" id="config">
                <li>Alterar Senha</li>
            </ul>


            <li>
                <a href="<?=base_url("Login/Desconectar")?>">
                    <i class="fa fa-sign-out fa-lg"></i> Desconectar
                </a>
            </li>

        </ul>
    </div>
</div>