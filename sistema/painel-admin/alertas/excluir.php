<?php
require_once("../../../conexao.php"); 

$id = $_POST['id'];
$pdo->query("DELETE from alertas WHERE id = '$id'");

echo 'Excluído com Sucesso!!';
?>