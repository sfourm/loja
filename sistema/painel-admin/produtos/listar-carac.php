<?php
require_once("../../../conexao.php"); 

$id_prod = @$_POST['txtid']; 
$pag = "produtos";

$query = $pdo->query("SELECT * FROM carac_prod where id_prod = '" . $id_prod . "' ");
echo "<div class='ml-2'>";
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
  foreach ($res[$i] as $key => $value) {}
  $id_carac = $res[$i]['id_carac'];
  //recuperar o nome da carac
  $query2 = $pdo->query("SELECT * from carac where id = '$id_carac' ");
  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
  $nome_carac = @$res2[0]['nome'];
                  
  echo "<span class='mb-2'><small><small><small><i class='text-info fas fa-circle mr-1'></i></small></small></small><a title='Adicionar Item' class='text-info' href='#' onClick='addItem(". $res[$i]['id'] .")'> ".$nome_carac."</a> <a title='Deletar Caracteristica' href='#' onClick='deletarCarac(". $res[$i]['id'] .")'><small><small><i class='text-danger fas fa-times ml-1'></i></small></small></a></span><br>";
  }

echo "</div>";
?>
