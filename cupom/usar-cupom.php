<?php 
require_once("../conexao.php");

$codigo = $_POST['cupom'];

if($codigo == ""){
	echo 'Insira um valor para o Cupom';
	exit();
}

$res = $pdo->query("SELECT * from cupons where codigo = '$codigo' and data >= curDate()");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);
if($linhas > 0){
	$valor_cupom = $dados[0]['desconto'];
	echo $valor_cupom;

	//EXCLUIR CUPOM APÓS O USO
	$pdo->query("DELETE from cupons where codigo = '$codigo' ");
}else{
	echo 'Esse código de cupom é inexistente!';
}

?>