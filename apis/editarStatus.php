<?php 

include_once('conexao.php');

$postjson = json_decode(file_get_contents("php://input"), true);
$status = $postjson['selected'];
$texto = 'Mudança de status no pedido, pedido '.$status;
$id = $postjson['id'];

$query = $pdo->query("UPDATE vendas SET status = '$postjson[selected]', rastreio = '$postjson[rastreio]' where id = '$postjson[id]'");


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


 

        if($query){
                $result = json_encode(array('success'=>true));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;

 ?>