<?php
require_once("../../conexao.php"); 

$id_usuario = $_POST['txtid'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$complemento = $_POST['complemento'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$res = $pdo->prepare("UPDATE rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep WHERE id = :id");
$res->bindValue(":rua", $rua);
$res->bindValue(":numero", $numero);
$res->bindValue(":bairro", $bairro);
$res->bindValue(":cidado", $cidade);
$res->bindValue(":complemento", $complemento);
$res->bindValue(":estado", $estado);
$res->bindValue(":cep", $cep);
$res->bindValue(":id", $id_usuario);

$res->execute();

echo 'Salvo com Sucesso!';
?>