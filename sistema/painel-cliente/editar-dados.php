<?php
require_once("../../conexao.php"); 

$nome = $_POST['nome-usuario'];
$sobrenome = $_POST['sobrenome-usuario'];
$email = $_POST['email-usuario'];
$telefone = $_POST['telefone-usuario'];
$cpf = $_POST['cpf-usuario'];
$antigo = $_POST['antigo'];
$id_usuario = $_POST['txtid'];

if($nome == ""){
	echo 'Preencha o Campo Nome!';
	exit();
}

if($sobrenome == ""){
	echo 'Preencha o Campo Sobrenome!';
	exit();
}

if($cpf == ""){
	echo 'Preencha o Campo CPF!';
	exit();
}

if($email == ""){
	echo 'Preencha o Campo Email!';
	exit();
}

if($cpf != $antigo){
	$res = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf'"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
		echo 'CPF já Cadastrado no Banco!';
		exit();
	}
}

$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, cpf = :cpf, email = :email, telefone = :telefone WHERE id = :id");
$res->bindValue(":nome", $nome);
$res->bindValue(":sobrenome", $sobrenome);
$res->bindValue(":email", $email);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":id", $id_usuario);

$res->execute();

$res = $pdo->prepare("UPDATE clientes SET nome = :nome, sobrenome = :sobrenome, cpf = :cpf, email = :email, telefone = :telefone,  WHERE cpf = :cpf_antigo");
$res->bindValue(":nome", $nome);
$res->bindValue(":sobrenome", $sobrenome);
$res->bindValue(":email", $email);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":cpf_antigo", $antigo);

$res->execute();

echo 'Salvo com Sucesso!';
?>