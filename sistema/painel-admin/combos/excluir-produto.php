<?php

require_once("../../../conexao.php"); 

$id = $_POST['id_produto'];

$pdo->query("DELETE from prod_combos WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>