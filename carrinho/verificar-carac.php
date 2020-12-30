<?php 

require_once("../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$res = $pdo->query("SELECT * from carrinho where id_usuario = '$id_usuario' and id_venda = 0 order by id asc");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($dados);

for ($i=0; $i < count($dados); $i++) { 
 foreach ($dados[$i] as $key => $value) {
 }

 $id_produto = $dados[$i]['id_produto'];	
 $id_carrinho = $dados[$i]['id'];
 $combo = $dados[$i]['combo'];

if($combo != 'Sim'){
	$query_c = $pdo->query("SELECT * from carac_prod where id_prod = '$id_produto'");
	$res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);
	$total_prod_carac = @count($res_c);

		if($total_prod_carac > 0){

		   $query4 = $pdo->query("SELECT * from carac_itens_car where id_carrinho = '$id_carrinho'");
		  $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
		  $total_carac = @count($res4);

		  if($total_carac == 0){
		  	echo 'Selecione as Características dos Produtos!';
		  	exit();
		  }

		}
	}
}

 ?>