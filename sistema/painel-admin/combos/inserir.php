<?php

require_once("../../../conexao.php"); 

$nome = $_POST['nome-cat'];
$descricao = $_POST['descricao'];
$descricao_longa = $_POST['descricao_longa'];
$valor = $_POST['valor'];
$tipo_envio = $_POST['tipo_envio'];
$ativo = $_POST['ativo'];
$palavras = $_POST['palavras'];
$peso = $_POST['peso'];
$largura = $_POST['largura'];
$altura = $_POST['altura'];
$comprimento = $_POST['comprimento'];
$valor_frete = $_POST['valor-frete'];
$link = $_POST['link'];

$valor = str_replace(',', '.', $valor);
$valor_frete = str_replace(',', '.', $valor_frete);
$peso = str_replace(',', '.', $peso);
$largura = str_replace(',', '.', $largura);
$altura = str_replace(',', '.', $altura);
$comprimento = str_replace(',', '.', $comprimento);

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);

$antigo = $_POST['antigo'];
$id = $_POST['txtid2'];

if($nome == ""){
	echo 'Preencha o Campo Nome!';
	exit();
}

if($valor == ""){
	echo 'Preencha o Campo Valor!';
	exit();
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../../img/combos/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
  
  $imagem = $nome_img;

  
}
$imagem_temp = @$_FILES['imagem']['tmp_name']; 

$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO combos (nome, nome_url, descricao, descricao_longa, valor, imagem, tipo_envio, palavras, ativo, peso, largura, altura, comprimento, valor_frete, link) VALUES (:nome, :nome_url, :descricao, :descricao_longa, :valor, :imagem,  :tipo_envio, :palavras, :ativo, :peso, :largura, :altura, :comprimento,  :valor_frete, :link)");
	$res->bindValue(":imagem", $imagem);
}else{

	if($imagem == "sem-foto.jpg"){
		$res = $pdo->prepare("UPDATE combos SET nome = :nome, nome_url = :nome_url, descricao = :descricao, descricao_longa = :descricao_longa, valor = :valor,  tipo_envio = :tipo_envio, palavras = :palavras, ativo = :ativo, peso = :peso, largura = :largura, altura = :altura, comprimento = :comprimento, valor_frete = :valor_frete, link = :link WHERE id = :id");
	}else{
		$res = $pdo->prepare("UPDATE combos SET nome = :nome, nome_url = :nome_url,descricao = :descricao,descricao_longa = :descricao_longa,valor = :valor, tipo_envio = :tipo_envio,palavras = :palavras,ativo = :ativo,peso = :peso, largura = :largura, altura = :altura, comprimento = :comprimento, valor_frete = :valor_frete, imagem = :imagem, link = :link WHERE id = :id");
		$res->bindValue(":imagem", $imagem);
	}

	$res->bindValue(":id", $id);
}

	$res->bindValue(":nome", $nome);
	$res->bindValue(":nome_url", $nome_url);
	
	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":descricao_longa", $descricao_longa);
	$res->bindValue(":valor", $valor);
	
	$res->bindValue(":tipo_envio", $tipo_envio);
	$res->bindValue(":palavras", $palavras);
	$res->bindValue(":ativo", $ativo);
	$res->bindValue(":peso", $peso);
	$res->bindValue(":largura", $largura);
	$res->bindValue(":altura", $altura);
	$res->bindValue(":comprimento", $comprimento);
	
	$res->bindValue(":valor_frete", $valor_frete);
	$res->bindValue(":link", $link);
	
	
	

	$res->execute();


echo 'Salvo com Sucesso!!';

?>