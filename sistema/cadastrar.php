<?php 

require_once("../conexao.php");

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefoneC = $_POST['telefone'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);

if($nome == ""){
	echo 'Preencha o Campo nome!';
	exit();
}

if($email == ""){
	echo 'Preencha o Campo Email!';
	exit();
}

if($cpf == ""){
	echo 'Preencha o Campo CPF!';
	exit();
}
if($telefoneC == ""){
	echo 'Preencha o Campo Telefone!';
	exit();
}

if($senha == ""){
	echo 'Preencha o Campo senha!';
	exit();
}

if($senha != $_POST['confirmar-senha']){
	echo 'As senhas não coincidem!';
	exit();
}



$cpfbd = $pdo->query("SELECT * FROM usuarios where cpf = '$_POST[cpf]'");
$emailbd = $pdo->query("SELECT * FROM usuarios where email = '$_POST[email]'"); 
$telefonebd = $pdo->query("SELECT * FROM usuarios where telefone = '$_POST[telefone]'"); 

$dados = $cpfbd->fetchAll(PDO::FETCH_ASSOC);
$dadosemail = $emailbd->fetchAll(PDO::FETCH_ASSOC);
$dadostelefone = $telefonebd->fetchAll(PDO::FETCH_ASSOC);
if(@count($dadoscpf) == 1){
	
	echo 'CPF já Cadastrado!';

} else if (@count($dadosemail) == 1) {

	echo 'Email já Cadastrado!';

} else if (@count($dadostelefone) == 1) {

	echo 'Telefone já Cadastrado!';

} else {
	
	$res = $pdo->prepare("INSERT into usuarios (nome, cpf, email, telefone, senha, senha_crip, nivel) values (:nome, :cpf, :email, :telefone, :senha, :senha_crip, :nivel)");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":email", $email);
	$res->bindValue(":telefone", $telefoneC);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":senha", $senha);
	$res->bindValue(":senha_crip", $senha_crip);
	$res->bindValue(":nivel", 'Cliente');

	$res->execute();


	$res = $pdo->prepare("INSERT into clientes (nome, cpf, email, telefone) values (:nome, :cpf, :email, :telefone)");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":email", $email);
	$res->bindValue(":telefone", $telefoneC);
	$res->bindValue(":cpf", $cpf);
	
	$res->execute();


	$res = $pdo->query("SELECT * FROM emails where email = '$email'"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) == 0){
	$res = $pdo->prepare("INSERT into emails (nome, email, ativo) values (:nome, :email, :ativo)");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":email", $email);
	$res->bindValue(":ativo", "Sim");
	$res->execute();
}

	echo 'Cadastrado com Sucesso!';
}


?>