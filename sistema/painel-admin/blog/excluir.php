<?php

require_once("../../../conexao.php"); 

$id = $_POST['id'];

$pdo->query("DELETE from blog WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>