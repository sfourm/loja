<?php 
$id_usuario = $_SESSION['id_usuario'];
$cpf_usuario = $_SESSION['cpf_usuario'];

//Trazer total de pedidos
$res_todos = $pdo->query("SELECT * FROM vendas where id_usuario = '$id_usuario'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$totalPedidos = count($dados_total);


//Trazer total de pedidos finalizados
$res_todos = $pdo->query("SELECT * FROM vendas where id_usuario = '$id_usuario' and status = 'Entregue'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$pedidosFinalizados = count($dados_total);

//Trazer total de pedidos pendentes
$res_todos = $pdo->query("SELECT * FROM vendas where id_usuario = '$id_usuario' and (status = 'Enviado' or status = 'Não Enviado')");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$pedidosPendentes = count($dados_total);


//Trazer total de pedidos aguardando entrega
$res_todos = $pdo->query("SELECT * FROM vendas where id_usuario = '$id_usuario' and status = 'Enviado'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$aguardando = count($dados_total);
?>
<div class="container align-items-center">
    <div class="row pt-5 ">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-uppercase mb-1"><a href="index.php?pag=<?php echo $menu1 ?>">Total de Pedidos</a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalPedidos ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-primary"></i>
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
                            <div class="font-weight-bold text-uppercase mb-1"><a href="index.php?pag=<?php echo $menu1 ?>">Pedidos Finalizados</a></div>
                            <div class="h5 mb-0 font-weight-bold text-success-800"><?php echo @$pedidosFinalizados ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-success"></i>
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
                            <div class="font-weight-bold text-uppercase mb-1"><a href="index.php?pag=<?php echo $menu1 ?>">Pedidos Pendentes</a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$pedidosPendentes ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-danger"></i>
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
                            <div class="font-weight-bold text-uppercase mb-1"><a href="index.php?pag=<?php echo $menu1 ?>">Aguardando Entrega</a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$aguardando ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php 
    $res_todos = $pdo->query("SELECT * FROM clientes where cpf = '$cpf_usuario'");
    $dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
    $cartoes_cliente = $dados_total[0]['cartoes'];
    ?>

    <h5 class="mt-3 text-center">Cartões Fidelidade</h5>
    <p class="text-center">
        <small>Ao completar <?php echo $total_cartoes_troca ?> cartões você ganhará um cupom de desconto de R$ <?php echo $valor_cupom_cartao ?>,00 reais! 
            <?php if($cartoes_cliente == 0){
                echo 'Você não efetuou nenhuma compra ainda, faça a sua primeira compra e ganhe seu primeiro cartão!';
            }else{
                echo 'Você possui '.$cartoes_cliente.' Cartões!';
            } ?>
        </small>
    </p>

    <div class="row pb-5 align-items-center justify-content-center">
        <?php 
        for ($i=1; $i <= $total_cartoes_troca; $i++) { 
            if($i <= $cartoes_cliente){
                $img = 'logo-maior.png';
            }else{
                $img = 'logo-inativa.png';
            }
        ?>

        <div class="col-md-2 ml-2 mr-2 align-items-center">
            <img src="../../img/<?php echo $img ?>" width="180">
        </div>
        <?php } ?>
    </div>
</div>