<?php
    require_once("../conexao.php");
    @session_start();

    $email = $_POST['email_login'];
    $senha = md5($_POST['senha_login']);

    $res = $pdo->query("SELECT * FROM usuarios where (email = '$email' or cpf = '$email') and senha_crip = '$senha' "); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    
    if(@count($dados) > 0){
    	$_SESSION['id_usuario'] = $dados[0]['id'];
    	$_SESSION['nome_usuario'] = $dados[0]['nome'];
    	$_SESSION['email_usuario'] = $dados[0]['email'];
    	$_SESSION['cpf_usuario'] = $dados[0]['cpf'];
    	$_SESSION['nivel_usuario'] = $dados[0]['nivel'];
    	if($_SESSION['nivel_usuario'] == 'Admin'){
			header("location: painel-admin/index.php");
    	}

    	if($_SESSION['nivel_usuario'] == 'Cliente'){
    		header("location: painel-cliente/index.php");
		}
		
    } else {
		$_SESSION['dados_incorretos'] = true;
		header('Location: index.php');
		exit();
    }
?>