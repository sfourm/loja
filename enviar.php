<?php 

require_once("conexao.php");

if($_POST['nome'] == ""){
	echo 'Preecha o Campo Nome';
	exit();
}

if($_POST['email'] == ""){
	echo 'Preecha o Campo Email';
	exit();
}

if($_POST['mensagem'] == ""){
	echo 'Preecha o Campo Mensagem';
	exit();
}

$destinatario = $email;
$assunto = $nome_loja . ' - Email da Loja';

$mensagem = utf8_decode('Nome: '.$_POST['nome']. "\r\n"."\r\n" . 'Telefone: '.$_POST['telefone']. "\r\n"."\r\n" . 'Mensagem: ' . "\r\n"."\r\n" .$_POST['mensagem']);


$cabecalhos = "From: ".$_POST['email'];

mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Enviado com Sucesso!';


//ENVIAR PARA O BANCO DE DADOS O EMAIL E NOME DOS CAMPOS
$res = $pdo->query("SELECT * FROM emails where email = '$_POST[email]'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) == 0){
	$res = $pdo->prepare("INSERT into emails (nome, email, ativo) values (:nome, :email, :ativo)");
	$res->bindValue(":nome", $_POST['nome']);
	$res->bindValue(":email", $_POST['email']);
	$res->bindValue(":ativo", "Sim");
	$res->execute();
}




 ?>