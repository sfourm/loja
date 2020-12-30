<?php
require_once("../../../conexao.php"); 

$id = $_POST['id'];
$pdo->query("DELETE from vendas WHERE id = '$id'");

//EXCLUIR PRODUTOS DA VENDA
$query = $pdo->query("SELECT * FROM carrinho where id_venda = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
    foreach ($res[$i] as $key => $value) {
}

    $pdo->query("DELETE from carrinho WHERE id_venda = '$id'");
}

echo 'Excluído com Sucesso!!';
?>