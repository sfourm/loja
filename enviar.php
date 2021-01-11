<?php
require_once 'mailer/class.phpmailer.php';
require_once 'mailer/class.smtp.php';
require_once 'conexao.php';

//Variáveis Globais

$emaildestinatario = 'contato@webpassos.com.br';
$comcopiaoculta = 'samuelsergio@webpassos.com.br';
$assunto = 'Loja WebPassos - Email de Contato';
$emailsender ='nao-responder@webpassos.com.br';
$nome = $_POST['nome'] or $_POST['nome2'];
$sobrenome = $_POST['sobrenome'] or $_POST['sobrenome2'];
$emailC = $_POST['email'] or $_POST['email2'];
$telefone = $_POST['telefone'] or $_POST['telefone2'];
$mensagem = $_POST['mensagem'] or $_POST['mensagem2'];
$data = date("j, m, Y, H:i:s");
$quebra_linha = "\n"; //Se "não for Windows"
$nomeremetente = $nome;
$emailremetente = $emailC;

// EMAIL - PHPMAILER

$mail = new PHPMailer;
$mail->setLanguage('br');                                 // Habilita as saídas de erro em Português
$mail->CharSet='UTF-8';                                   // Habilita o envio do email como 'UTF-8'

//$mail->SMTPDebug = 3;                                   // Habilita a saída do tipo "verbose"

$mail->isSMTP();                                          // Configura o disparo como SMTP
$mail->Host = 'email-ssl.com.br';                         // Especifica o enderço do servidor SMTP da Locaweb
$mail->SMTPAuth = true;                                   // Habilita a autenticação SMTP
$mail->Username = 'nao-responder@webpassos.com.br';       // Usuário do SMTP
$mail->Password = 'Samuel1324@';                          // Senha do SMTP
$mail->SMTPSecure = 'ssl';                                // Habilita criptografia TLS | 'ssl' também é possível
$mail->Port = 465;                                        // Porta TCP para a conexão

$mail->From = $emailsender;                               // Endereço previamente verificado no painel do SMTP
$mail->FromName = 'Contato - WebPassos';               // Nome no remetente
$mail->addAddress('samuelnunessergio@gmail.com');         // Acrescente um destinatário
$mail->addAddress($emaildestinatario);                    // O nome é opcional
$mail->addReplyTo($emailC, 'Informação');
$mail->addCC('cc@exemplo.com');
$mail->addBCC('bcc@exemplo.com');
$mail->isHTML(true);                                      // Configura o formato do email como HTML
$mail->Subject = 'WebPassos - Email de Contato';
$mail->Body    =  '<p>Nome: '.$nome.' '.$sobrenome.'</p><p>Email: '.$emailC.'</p><p>Telefone: '.$telefone.'</p><p>Mensagem: '.$mensagem.'</p> <p>Data: '.$data.'</p>';
$mail->AltBody = '<p>Nome: '.$nome.' '.$sobrenome.'</p><p>Email: '.$emailC.'</p><p>Telefone: '.$telefone.'</p><p>Mensagem: '.$mensagem.'</p> <p>Data: '.$data.'</p>';

if(!$mail->send()) {
    echo 'Email não pode ser enviado';
    echo 'Mensagem de erro: ' . $mail->ErrorInfo;
} else {
    echo 'Email enviado com Sucesso!';
}

//ENVIAR PARA O BANCO DE DADOS O EMAIL E NOME DOS CAMPOS
$res = $pdo->query("SELECT * FROM emails where email = '$_POST[email]'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) == 0){
	$res = $pdo->prepare("INSERT into emails (nome, sobrenome, email, ativo) values (:nome, :sobrenome, :email, :ativo)");
	$res->bindValue(":nome", $_POST['nome']);
	$res->bindValue(":sobrenome", $_POST['sobrenomem']);
	$res->bindValue(":email", $_POST['email']);
	$res->bindValue(":ativo", "Sim");
	$res->execute();
}

 ?>