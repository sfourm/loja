<?php
include_once('conexao.php');

echo "<meta HTTP-EQUIV='refresh' CONTENT='1200;URL=script-enviar.php'>"; 
$agora = date('Y-m-d H:i:s');
$email_adm = $email;

//PEGAR TOTAL DE EMAILS DO BANCO
$query = $pdo->query("SELECT * FROM emails where ativo = 'Sim' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_emails = @count($res);


$query = $pdo->query("SELECT * FROM envios_email where id = '1' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$data = $res[0]["data"];
$final = $res[0]["final"];
$mensagem = $res[0]["mensagem"];
$assunto = $res[0]["assunto"];
$link = $res[0]["link"];

if ($final == 0){
	echo 'Não tem mais emails pendentes, todos já foram enviados!';
} else {

	if ($agora >= $data){
		//VER SE JÁ PASSOU TODA A LISTA DE EMAILS
		if ($final >= $total_emails){
			$query = $pdo->query("UPDATE envios_email SET data = '$agora', final = '0', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");
			exit();
		}
		
		$inicio = $final;
		$final_novo = $enviar_total_emails + $final;
		//APÓS ENVIAR O EMAIL É PRECISO SALVAR A HORA NA TABELA DE ENVIOS
		$nova_hora = date('Y-m-d H:i:s', strtotime('+'.$intervalo_envio_email.'minute', strtotime($agora)));
		$query = $pdo->query("UPDATE envios_email SET data = '$nova_hora', final = '$final_novo', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");

		$url_s = $url_loja;
		$url_nova = $url_loja . $link;
		$url_descadastrar = $url_loja . 'descadastrar.php';

		//DISPARAR EMAIL PARA OS CLIENTES DE HORA EM HORA
		$query_emails = $pdo->query("SELECT * from emails where ativo = 'Sim' and (id > '$inicio' and id <= '$final_novo')");
		$res_emails = $query_emails->fetchAll(PDO::FETCH_ASSOC);

		for ($i=0; $i < count($res_emails); $i++) { 
		foreach ($res_emails[$i] as $key => $value) {

		}
		
		$nome_cliente_email = $res_emails[$i]['nome'];
		$cliente_email = $res_emails[$i]['email'];
		$id_email = $res_emails[$i]['id'];
			
		$to = $cliente_email;
		$subject = "$assunto";
		$message = "
			Olá $nome_cliente_email, <br><br>
			$mensagem !

			<br><br> <i> <a title='$url_nova' href='$url_nova' target='_blank'>Clique aqui </a> para ver em nosso site !!</i> <br><br>

			<a title='$url_nova' href='$url_nova' target='_blank'>$url_nova</a>
			
			<br><br><br>
			WhatsApp -> <a href='https://api.whatsapp.com/send?1=pt_BR&phone=$whatsapp_link' alt='$whatsapp' target='_blank'><i class='fab fa-whatsapp'></i>$whatsapp</a>

			<br><br><br>
			<i> Caso não queira mais receber nossos emails <a href='$url_descadastrar' target='_blank'> clique aqui </a> para se descadastrar!</i> <br><br>";

			$dest = $email_adm;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

			if ($to != $dest){
				$headers .= "From: " .$dest;
			}

			mail($to, $subject, $message, $headers);
		}
		//ENVIAR EMAIL PARA O ADMIM INFORMANDO SOBRE O ULTIMO ENVIO DE EMAIL
		$destinatario = $email_adm;
		$assunto = "Disparo Email Inicio $inicio e Final $final_novo ";
		$mensagem = utf8_decode($mensagem);
		$cabecalhos = "From: ".$email_adm;
		@mail($destinatario, $assunto, $mensagem, $cabecalhos);	
	}
} 
?>
