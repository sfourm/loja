<?php

require_once("../../../conexao.php"); 

$id_prod = $_POST['txtidProduto'];

$id_combo = $_POST['txtid'];




	$res = $pdo->query("SELECT * FROM prod_combos where id_produto = '$id_prod' and id_combo = '$id_combo' "); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
			echo 'Produto já adicionado!';
			exit();
		}





$pdo->query("INSERT INTO prod_combos (id_produto, id_combo) VALUES ('$id_prod', '$id_combo')");


echo 'Salvo com Sucesso!!';

?>