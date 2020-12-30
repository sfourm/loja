<?php 

//VERIFICAR SE TEM REGISTROS NO CARRINHO COM MAIS DE XX DIAS
$data_carrinho = date('Y-m-d', strtotime("-".$dias_limpar_carrinho." days"));
$res = $pdo->query("SELECT * from carrinho where data <= '$data_carrinho' and id_venda = 0");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < count($dados); $i++) { 
    foreach ($dados[$i] as $key => $value){}

    $id_produto = $dados[$i]['id_produto'];	
    $combo = $dados[$i]['combo'];
    $id = $dados[$i]['id'];
    if($combo != 'Sim'){
        $query_c = $pdo->query("SELECT * from carac_prod where id_prod = '$id_produto'");
        $res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);
        $total_prod_carac = @count($res_c);

        if($total_prod_carac > 0){

            $query4 = $pdo->query("SELECT * from carac_itens_car where id_carrinho = '$id'");
            $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
        
            for ($i2=0; $i2 < count($res4); $i2++) { 
                foreach ($res4[$i2] as $key => $value) {
            }
            $pdo->query("DELETE FROM carac_itens_car where id_carrinho = '$id'");
            }
        }
    }
$pdo->query("DELETE FROM carrinho where id = '$id'");
}

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate()");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$totalPedidos = count($dados_total);

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$pedidosFinalizados = count($dados_total);

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Não'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$pedidosPendentes = count($dados_total);

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$total_vendas_dia;
for ($i2=0; $i2 < count($dados_total); $i2++) { 
    foreach ($dados_total[$i2] as $key => $value) {
    }
   @$total_vendas_dia = @$total_vendas_dia + $dados_total[$i2]['total'];
} 

$total_dia = @$total_vendas_dia;
$total_dia = number_format($total_dia, 2, ',', '.');

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Sim' and (status = 'Enviado' or status = 'Entregue' or status = 'Disponivel') ");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$totalPedidosEnviados = count($dados_total);

$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Sim' and status != 'Enviado' and status != 'Entregue' and status != 'Disponivel' ");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$totalPedidosPendentes = count($dados_total);

$mes_atual = Date("m");
$ano_atual = Date("Y");
$data_inicial = $ano_atual."-".$mes_atual."-01";

$res_todos = $pdo->query("SELECT * FROM vendas where data >= '$data_inicial' and data <= curDate() and pago = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$total_vendas_mes;
for ($i2=0; $i2 < count($dados_total); $i2++) { 
    foreach ($dados_total[$i2] as $key => $value) {
    }
   @$total_vendas_mes = @$total_vendas_mes + $dados_total[$i2]['total'];
}    
$total_mes = @$total_vendas_mes;
$total_mes = number_format($total_mes, 2, ',', '.');

$res_todos = $pdo->query("SELECT * FROM vendas where data >= '$data_inicial' and data <= curDate() and pago = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_vendas = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM clientes");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_clientes = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM produtos");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_produtos = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM combos");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_combos = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM produtos where promocao = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_promocoes = @count($dados_total);
?>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vendas Hoje</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalPedidos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vendas Aprovadas</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$pedidosFinalizados ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vendas Pendentes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$pedidosPendentes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Vendido Dia</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$total_dia ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pedidos Enviados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalPedidosEnviados ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pedidos Pendentes</div>
                        <div class="h5 mb-0 font-weight-bold text-danger-800"><?php echo @$totalPedidosPendentes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vendas Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$quantidade_vendas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total R$ Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$total_mes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Clientes Cadastrados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$quantidade_clientes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Produtos Cadastrados</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$quantidade_produtos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Combos Cadastrados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$quantidade_combos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Produtos em Promoções</div>
                        <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$quantidade_promocoes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
