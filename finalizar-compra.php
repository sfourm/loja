<?php 

require_once("conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$total = $_POST['total_compra'];
$total = str_replace(',', '.', $total);
$valor_frete =  $_POST['vlr_frete'];
$tem_frete = $_POST['existe_frete'];
$antigo = $_POST['antigo'];
@$sub_total = @$total - @$valor_frete;

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$complemento = $_POST['complemento'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$comentario = $_POST['comentario'];
$local = @$_POST['local'];

if($local != ""){
	$status_venda = 'Retirada';
}else{
	$status_venda = 'Não Enviado';
}

if($tem_frete == 'Sim' && $local == ""){
	if($valor_frete == '0' || $valor_frete == ""){
		echo ' Selecione um CEP válido para o Frete!';
		exit();
	}
}

if($nome == ""){
	echo 'Preencha o Campo Nome!';
	exit();
}

if($rua == ""){
	echo 'Preencha o Campo Rua!';
	exit();
}

if($numero == ""){
	echo 'Preencha o Campo Número!';
	exit();
}

if($bairro == ""){
	echo 'Preencha o Campo Bairro!';
	exit();
}

$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email where id = '$id_usuario'");
$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":cpf", $cpf);

$res->execute();

$res = $pdo->prepare("UPDATE clientes SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep where cpf = '$antigo' ");
$res->bindValue(":nome", $nome);
$res->bindValue(":email", $email);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":rua", $rua);
$res->bindValue(":numero", $numero);
$res->bindValue(":complemento", $complemento);
$res->bindValue(":bairro", $bairro);
$res->bindValue(":cidade", $cidade);
$res->bindValue(":estado", $estado);
$res->bindValue(":cep", $cep);

$res->execute();

$res = $pdo->prepare("INSERT vendas SET total = :total, frete = :frete, sub_total = :sub_total, id_usuario = :id_usuario, pago = :pago, data = curDate(), status = :status ");
$res->bindValue(":total", $total);
$res->bindValue(":frete", $valor_frete);
$res->bindValue(":sub_total", $sub_total);
$res->bindValue(":id_usuario", $id_usuario);
$res->bindValue(":pago", 'Não');
$res->bindValue(":status", $status_venda);
	
$res->execute();

$id_venda = $pdo->lastInsertId();

//MUDAR ID DA VENDA NOS ITENS DO CARRINHO
$pdo->query("UPDATE carrinho SET id_venda = '$id_venda' where id_usuario = '$id_usuario' and id_venda = 0");

if($comentario != ""){
	$res = $pdo->prepare("INSERT mensagem SET id_venda = :id_venda, texto = :texto, usuario = :usuario, data = curDate(), hora = curTime()");
	$res->bindValue(":id_venda", $id_venda);
	$res->bindValue(":texto", $comentario);
	$res->bindValue(":usuario", 'Cliente');
	$res->execute();
}

echo $id_venda;
?>