<?php 

include_once('conexao.php');

$id = $_GET['busca'];
  
$res_todos = $pdo->query("SELECT * FROM vendas where id = '$id'");
$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
$status = $dados_total[0]['status'];
$rastreio = $dados_total[0]['rastreio'];
$id_usuario = $dados_total[0]['id_usuario'];

$res2 = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$cpf_usuario = $dados2[0]['cpf'];

$res2 = $pdo->query("SELECT * FROM clientes where cpf = '$cpf_usuario'");
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
$nome = $dados2[0]['nome'];
$email = $dados2[0]['email'];
$telefone = $dados2[0]['telefone'];
$rua = $dados2[0]['rua'];
$numero = $dados2[0]['numero'];
$bairro = $dados2[0]['bairro'];   
$cidade = $dados2[0]['cidade'];  
$cep = $dados2[0]['cep'];  
$estado = $dados2[0]['estado'];  

 		$dados = array(
 			'status' => $status,
      'rastreio' => $rastreio,
 			'telefone' => $telefone,
      'email' => $email,
      'nome' => $nome,
      'cpf' => $cpf_usuario,
      'rua' => $rua,
      'numero' => $numero,
      'bairro' => $bairro,
      'cidade' => $cidade,
      'estado' => $estado,
      'cep' => $cep,
      
 		);

 		

        
 $result = json_encode(array('success'=>true, 'result'=>$dados));
 echo $result;

 ?>