<?php
require_once("../../../conexao.php"); 
@session_start();

$id_usuario = $_SESSION['id_usuario'];
$id_produto = $_POST['id-produto'];
$nota = $_POST['nota'];
$comentario = $_POST['comentario'];

if($comentario == ""){
	$comentario = "Excelente Produto, totalmente Satisfeito!";
}

$query = $pdo->query("SELECT * FROM avaliacoes where id_usuario = '$id_usuario' and id_produto = '$id_produto' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res)>0){
	echo 'Você já avaliou este produto!';
	exit();
}

$res = $pdo->prepare("INSERT INTO avaliacoes (id_produto, id_usuario, texto, nota, data) values (:id_produto, :id_usuario, :texto, :nota, curDate())");

$res->bindValue(":id_usuario", $id_usuario);
$res->bindValue(":id_produto", $id_produto);
$res->bindValue(":nota", $nota);
$res->bindValue(":texto", $comentario);	
$res->execute();

echo 'Cadastrado com Sucesso!';


$destinatario = $email;
$assunto = $nome_loja . ' - Nova Avaliação de Produto';
$mensagem = utf8_decode($comentario);
$cabecalhos = "From: ".$email;
@mail($destinatario, $assunto, $mensagem, $cabecalhos);

?>