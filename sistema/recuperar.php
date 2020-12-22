<?php


require_once("../conexao.php");

$email = $_POST['email-recuperar'];

if($email == ""){
    echo 'Preencha o Campo Email!';
    exit();
}

$res = $pdo->query("SELECT * FROM usuarios where email = '$email' "); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
    $senha = $dados[0]['senha'];
   
   //ENVIAR O EMAIL COM A SENHA
    $destinatario = $email;
    $assunto = $nome_loja . ' - Recuperação de Senha';
    $mensagem = utf8_decode('Sua senha é ' .$senha);
    $cabecalhos = "From: ".$email;
    mail($destinatario, $assunto, $mensagem, $cabecalhos);

    echo 'Senha Enviada para o Email!';
}else{
   echo 'Este email não está cadastrado!';

}

?>