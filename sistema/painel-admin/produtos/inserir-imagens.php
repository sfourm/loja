<?php

require_once("../../../conexao.php"); 

$id_produto = $_POST['id'];



//SCRIPT PARA SUBIR FOTO NO BANCO
$caminho = '../../../img/produtos/detalhes/' .@$_FILES['imgproduto']['name'];
if (@$_FILES['imgproduto']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
  $imagem = @$_FILES['imgproduto']['name']; 
}

$imagem_temp = @$_FILES['imgproduto']['tmp_name']; 

$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



	$pdo->query("INSERT INTO imagens (id_produto,  imagem) VALUES ( '$id_produto', '$imagem')");

	echo 'Salvo com Sucesso!!';

?>