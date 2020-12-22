<?php 

include_once('conexao.php');

if(@$nivel_estoque == ""){
  $nivel_estoque = 5;
}
  
$res_todos = $pdo->query("SELECT * FROM vendas where data = curDate() and pago = 'Sim'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$vendasHoje = count($dados_total);


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
$quantidade_vendas_mes = @count($dados_total);




$res_todos = $pdo->query("SELECT * FROM clientes");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_clientes = @count($dados_total);

$res_todos = $pdo->query("SELECT * FROM produtos");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_produtos = @count($dados_total);


$res_todos = $pdo->query("SELECT * FROM produtos where estoque <= '$nivel_estoque' order by estoque asc");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$quantidade_estoque = @count($dados_total);

   

 		$dados = array(
 			'vendasHoje' => $vendasHoje,
 			'total_dia' => $total_dia,
			'totalPedidosPendentes' => $totalPedidosPendentes,
      'total_mes' => $total_mes,
      'quantidade_vendas_mes' => $quantidade_vendas_mes,
      'quantidade_clientes' => $quantidade_clientes,
      'quantidade_produtos' => $quantidade_produtos,
      'quantidade_estoque' => $quantidade_estoque,
                  
        
 		);

 		

        
 $result = json_encode(array('success'=>true, 'result'=>$dados));
 echo $result;

 ?>