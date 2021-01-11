<?php
require_once("../../conexao.php");


$nome =  $_POST['nome-e'];
$sobrenome =  $_POST['sobrenome-e'];
$cpf =  $_POST['cpf-e'];
$email =  $_POST['email-e'];
$telefone =  $_POST['telefone-e'];

$antigo_E = $_POST['antigo'];
$rua_E = $_POST['rua'];
$numero_E = $_POST['numero'];
$bairro_E = $_POST['bairro'];
$complemento_E = $_POST['complemento'];
$cep_E = $_POST['cep'];
$cidade_E = $_POST['cidade'];
$estado_E = $_POST['estado'];

$res = $pdo->prepare("UPDATE clientes SET nome = :nome, sobrenome = :sobrenome, cpf = :cpf, email = :email, telefone = :telefone, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep where cpf = '$antigo_E' ");
$res->bindValue(":nome", $nome);
$res->bindValue(":sobrenome", $sobrenome);
$res->bindValue(":email", $email);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":rua", $rua_E);
$res->bindValue(":numero", $numero_E);
$res->bindValue(":complemento", $complemento_E);
$res->bindValue(":bairro", $bairro_E);
$res->bindValue(":cidade", $cidade_E);
$res->bindValue(":estado", $estado_E);
$res->bindValue(":cep", $cep_E);

$res->execute();

echo 'Salvo com Sucesso!';
?>
