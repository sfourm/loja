<?php

require_once("../../../conexao.php"); 

$id = $_POST['id'];

$pdo->query("UPDATE promocao_banner SET ativo = 'Não' WHERE id = '$id'");

echo 'Desativado com Sucesso!!';

?>