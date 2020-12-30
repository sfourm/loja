<?php

require_once("../../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM alertas where ativo = 'Sim' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) >= 1){
	echo 'Você não pode Ter mais de um alerta Ativo!!';
	exit();
}

$pdo->query("UPDATE alertas SET ativo = 'Sim' WHERE id = '$id'");

echo 'Ativado com Sucesso!!';

?>