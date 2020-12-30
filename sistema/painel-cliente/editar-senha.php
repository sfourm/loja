<?php
require_once("../../conexao.php"); 

$id_usuario = $_POST['txtid'];
$email = $_POST['email-usuario'];
$senha = $_POST['senha'];
$senha_crip = md5($_POST['senha']);

if($senha != $_POST['conf-senha']){
	echo 'As senhas não coincidem!';
	exit();
}

$res = $pdo->prepare("UPDATE usuarios SET email = :email, senha = :senha, senha_crip = :senha_crip WHERE id = :id");
$res->bindValue(":email", $email);
$res->bindValue(":senha", $senha);
$res->bindValue(":senha_crip", $senha_crip);
$res->bindValue(":id", $id_usuario);

$res->execute();

$res = $pdo->prepare("UPDATE clientes SET email = :email WHERE id = :id");
$res->bindValue(":email", $email);
$res->bindValue(":id", $id_usuario);

$res->execute();

echo 'Salvo com Sucesso!';
?>