<?php
require_once("../../../conexao.php"); 

$titulo = $_POST['titulo'];
$descricao_1 = $_POST['descricao-1'];
$descricao_2 = $_POST['descricao-2'];
$palavras = $_POST['palavras'];
$antigo = $_POST['antigo'];

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($titulo)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ?"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);

$id = $_POST['txtid2'];

if($titulo == ""){
	echo 'Preencha o Campo Título!';
	exit();
}

if($titulo != $antigo){
	$res = $pdo->query("SELECT * FROM blog where titulo = '$titulo'"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
	if(@count($dados) > 0){
		echo 'Postagem já Cadastrada no Banco!';
		exit();
	}
}

//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../../img/blog/' .$nome_img;
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
	$res = $pdo->prepare("INSERT INTO blog (titulo, descricao_1, descricao_2, imagem, data, palavras, nome_url) VALUES (:titulo, :descricao_1, :descricao_2, :imagem, curDate(), :palavras, :nome_url)");
	$res->bindValue(":imagem", $imagem);
}else{

	if($imagem == "sem-foto.jpg"){
		$res = $pdo->prepare("UPDATE blog SET titulo = :titulo, descricao_1 = :descricao_1, descricao_2 = :descricao_2, palavras = :palavras, nome_url = :nome_url WHERE id = :id");
	}else{
		$res = $pdo->prepare("UPDATE blog SET titulo = :titulo, descricao_1 = :descricao_1, descricao_2 = :descricao_2, imagem = :imagem, palavras = :palavras, nome_url = :nome_url WHERE id = :id");
		$res->bindValue(":imagem", $imagem);
	}

	$res->bindValue(":id", $id);
}

$res->bindValue(":titulo", $titulo);
$res->bindValue(":descricao_1", $descricao_1);
$res->bindValue(":descricao_2", $descricao_2);
$res->bindValue(":palavras", $palavras);
$res->bindValue(":nome_url", $nome_url);

$res->execute();

echo 'Salvo com Sucesso!!';
?>