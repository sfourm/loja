<?php
require_once("../../conexao.php"); 

$nome = $_POST['nome-usuario'];
$email = $_POST['email-usuario'];
$cpf = $_POST['cpf-usuario'];
$senha = $_POST['senha'];
$senha_crip = md5($_POST['senha']);
$antigo = $_POST['antigo'];
$id_usuario = $_POST['txtid'];

if($nome == ""){
	echo 'Preencha o Campo Nome!';
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

if($senha != $_POST['conf-senha']){
	echo 'As senhas não coincidem!';
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

//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{ 
  $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}

if($imagem == "sem-foto.jpg"){
		$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, senha_crip = :senha_crip WHERE id = :id");
	}else{
		$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, senha_crip = :senha_crip, imagem = :imagem WHERE id = :id");
		$res->bindValue(":imagem", $imagem);
	}

$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":senha", $senha);
$res->bindValue(":senha_crip", $senha_crip);
$res->bindValue(":id", $id_usuario);

$res->execute();

echo 'Salvo com Sucesso!';
?>