<?php
require_once("../../../conexao.php"); 

$id = $_POST['txtid2'];
$status = $_POST['status'];
$rastreio = $_POST['rastreio'];
$texto = 'Mudança de status no pedido, pedido '.$status;

if($status == 'Enviado'){
	$texto = 'Seu pedido foi Enviado, o código de rastreio é '. $rastreio;
	if($rastreio == ""){
		echo 'Preencha o código de Rastreio!';
		exit();
	}
}

$pdo->query("UPDATE vendas SET status = '$status', rastreio = '$rastreio' WHERE id = '$id'");
$pdo->query("INSERT mensagem SET id_venda = '$id', texto = '$texto', usuario = 'Admin', data = curDate(), hora = curTime()");

$res2 = $pdo->query("SELECT * FROM vendas where id = '$id'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$id_usuario = $dados2[0]['id_usuario'];	

$res2 = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$email_usuario = $dados2[0]['email'];		

//ENVIAR EMAIL PARA O CLIENTE INFORMANDO DA COMPRA
$destinatario = $email_usuario;
$assunto = $nome_loja . utf8_decode(' - Atualização no Status da Sua Compra');
$mensagem = utf8_decode('Seu pedido teve uma nova atualização, pedido '.$status);
$cabecalhos = "From: ".$email;
@mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Editado com Sucesso!!';
?>