<?php 

require_once("../conexao.php");
@session_start();

$id = $_POST['id'];


$res = $pdo->query("SELECT * from carrinho where id = '$id'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$combo = $dados[0]['combo'];
$id_produto = $dados[0]['id_produto'];

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

echo "Excluido com Sucesso!!";




?>