<?php
require_once("../../conexao.php"); 

$nome_E = $_POST['nome-usuario'];
$sobrenome_E = $_POST['sobrenome-usuario'];
$email_E = $_POST['email-usuario'];
$telefone_E = $_POST['telefone-usuario'];
$cpf_E = $_POST['cpf-usuario'];
$antigo_E = $_POST['antigo'];
$id_usuario_E = $_POST['txtid'];


if($nome_E == ""){
	echo 'Preencha o Campo Nome!';
	exit();
}

if($sobrenome_E == ""){
	echo 'Preencha o Campo Sobrenome!';
	exit();
}

if($cpf_E == ""){
	echo 'Preencha o Campo CPF!';
	exit();
}

if($email_E == ""){
	echo 'Preencha o Campo Email!';
	exit();
}

if($telefone_E == ""){
	echo 'Preencha o Campo Telefone!';
	exit();
}
if($cpf_E != $antigo_E){
	$res = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf'"); 
	$dados_E = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados_E) > 0){
		echo 'CPF já Cadastrado no Banco!';
		exit();
	}
}

$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, cpf = :cpf, email = :email, telefone = :telefone WHERE id = :id");
$res->bindValue(":nome", $nome_E);
$res->bindValue(":sobrenome", $sobrenome_E);
$res->bindValue(":email", $email_E);
$res->bindValue(":telefone", $telefone_E);
$res->bindValue(":cpf", $cpf_E);
$res->bindValue(":id", $id_usuario_E);

$res->execute();

$res = $pdo->prepare("UPDATE clientes SET nome = :nome, sobrenome = :sobrenome, cpf = :cpf, email = :email, telefone = :telefone,  WHERE cpf = :cpf_antigo");
$res->bindValue(":nome", $nome_E);
$res->bindValue(":sobrenome", $sobrenome_E);
$res->bindValue(":email", $email_E);
$res->bindValue(":telefone", $telefone_E);
$res->bindValue(":cpf", $cpf_E);
$res->bindValue(":cpf_antigo", $antigo_E);

$res->execute();

echo 'Salvo com Sucesso!';
?>