<?php
require_once("../../../conexao.php"); 

$quantidade = $_POST['quantidade'];
$id = $_POST['txtid2'];
if($quantidade == ""){
	echo 'Preencha o Campo Quantidade!';
	exit();
}

$res2 = $pdo->query("SELECT * FROM produtos where id = '$id'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$estoque = $dados2[0]['estoque'];
$total_estoque = $estoque + $quantidade;
$pdo->query("UPDATE produtos SET  estoque = '$total_estoque' where id = '$id'");

echo 'Salvo com Sucesso!!';
?>