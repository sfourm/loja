<?php

require_once("../../../conexao.php"); 

$carac = $_POST['caract'];

$id = $_POST['txtid'];

if($carac == ""){
	echo 'Escolha uma Caracteristica!';
	exit();
}



	$res = $pdo->query("SELECT * FROM carac_prod where id_carac = '$carac' and id_prod = '$id' "); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
			echo 'Característica já cadastrada!';
			exit();
		}





$pdo->query("INSERT INTO carac_prod (id_carac, id_prod) VALUES ('$carac', '$id')");


echo 'Salvo com Sucesso!!';

?>