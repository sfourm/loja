<?php

require_once("../../conexao.php"); 

$assunto = $_POST['assunto-email'];
$link = $_POST['link-email'];
$mensagem = $_POST['mensagem-email'];
$inicio = 0;
$final = $enviar_total_emails;

if($assunto == ""){
	echo 'Preencha o Campo Assunto!';
	exit();
}

if($mensagem == ""){
	echo 'Preencha o Campo Mensagem!';
	exit();
}


//SALVAR NA TABELA ENVIO EMAILS
$agora = date('Y-m-d H:i:s');

$nova_hora = date('Y-m-d H:i:s', strtotime('+'.$intervalo_envio_email.' minute', strtotime($agora)));
$query = $pdo->query("UPDATE envios_email SET data = '$nova_hora', final = '$final', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");


$query = $pdo->query("SELECT * FROM emails where ativo = 'Sim' order by id limit $final");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$url_s = $url_loja;
$url_nova = $url_loja . $link;


for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {

	}

		$to = $res[$i]['email'];
		$nome_cliente = $res[$i]['nome'];
		$subject = "$assunto";
		$url_descadastrar = $url_loja . 'descadastrar.php';
		$message = "


				Olá $nome_cliente, <br>
				$mensagem !


				<br><br> <i> <a title='$url_nova' href='$url_nova' target='_blank'>Clique aqui </a> para ver em nosso site !!</i> <br><br>

				<a title='$url_nova' href='$url_nova' target='_blank'>$url_nova</a>
				

				<br><br><br>
				WhatsApp -> <a href='http://api.whatsapp.com/send?1=pt_BR&phone=$whatsapp_link' alt='$whatsapp' target='_blank'><i class='fab fa-whatsapp'></i>$whatsapp</a>

				<br><br><br>
       <i> Caso não queira mais receber nossos emails <a href='$url_descadastrar' target='_blank'> clique aqui </a> para se descadastrar!</i> <br><br>


				";


				$remetente = $email;
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

				if($to != $remetente){
					$headers .= "From: " .$remetente;
				}

				mail($to, $subject, $message, $headers);



	}




	//ENVIAR EMAIL PARA O ADMIM INFORMANDO SOBRE O ULTIMO ENVIO DE EMAIL
	$destinatario = $email;
	$assunto = $nome_loja . ' - Campanha Email';
    $mensagem = utf8_decode('Email enviado até o email de número '.$final);
    $cabecalhos = "From: ".$email;
    @mail($destinatario, $assunto, $mensagem, $cabecalhos);


	echo 'Enviado com Sucesso!';




	?>