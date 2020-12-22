<?php 

include_once('conexao.php');

$postjson = json_decode(file_get_contents("php://input"), true);
$qtd = $postjson['qtd'];
$id = $postjson['id'];

$res2 = $pdo->query("SELECT * FROM produtos where id = '$id'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$estoque = $dados2[0]['estoque'];
$total_estoque = $estoque + $qtd;
$pdo->query("UPDATE produtos SET  estoque = '$total_estoque' where id = '$id'");



     
            $result = json_encode(array('success'=>true));

            echo $result;

 ?>