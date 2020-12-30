<?php
require_once("../../../conexao.php"); 

$id = $_POST['id_carac'];
$pdo->query("DELETE from carac_prod WHERE id = '$id'");

echo 'Excluído com Sucesso!!';
?>