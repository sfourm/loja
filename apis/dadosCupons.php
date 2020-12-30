<?php 

include_once('conexao.php');

$id = $_GET['busca'];


$res2 = $pdo->query("SELECT * FROM cupons where id = '$id'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$titulo = $dados2[0]['titulo'];
$codigo = $dados2[0]['codigo'];
$desconto = $dados2[0]['desconto'];
$data = $dados2[0]['data'];
 

$dados = array(
  'titulo' => $titulo,
  'codigo' => $codigo,
  'desconto' => $desconto,
  'data' => $data,
 
);




$result = json_encode(array('success'=>true, 'result'=>$dados));
echo $result;

?>