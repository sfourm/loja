<?php

require_once("../../../conexao.php"); 

$titulo = $_POST['titulo'];
$codigo = $_POST['codigo'];
$desconto = $_POST['desconto'];
$data = $_POST['data'];

$desconto = str_replace(',', '.', $desconto);

$antigo = $_POST['antigo'];
$id = $_POST['txtid2'];

if($titulo == ""){
	echo 'Preencha o Campo Titulo!';
	exit();
}


if($codigo == ""){
	echo 'Preencha o Campo Código!';
	exit();
}


if($desconto == ""){
	echo 'Preencha o Campo Desconto!';
	exit();
}


if($codigo != $antigo){
	$res = $pdo->query("SELECT * FROM cupons where codigo = '$codigo'"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
			echo 'Cupom já Cadastrado no Banco!';
			exit();
		}
}



if($id == ""){
	$res = $pdo->prepare("INSERT INTO cupons (titulo, desconto, codigo, data) VALUES (:titulo, :desconto, :codigo, :data)");
	
}else{

	$res = $pdo->prepare("UPDATE cupons SET titulo = :titulo, desconto = :desconto, codigo = :codigo, data = :data WHERE id = :id");
	

	$res->bindValue(":id", $id);
}

	$res->bindValue(":titulo", $titulo);
	$res->bindValue(":desconto", $desconto);
	$res->bindValue(":codigo", $codigo);
	$res->bindValue(":data", $data);
	
	$res->execute();


echo 'Salvo com Sucesso!!';

?>