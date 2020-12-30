<?php 

include_once('../conexao.php');

$busca = $_GET['busca'];

if($busca == ''){
  $busca = date('Y-m-d');
}

$query = $pdo->query("SELECT * from vendas where data = '$busca' ");

 $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

    $data = implode('/', array_reverse(explode('-', $res[$i]['data'])));

    $cor = '';
    if($res[$i]['pago'] == 'Sim'){
      $cor = '#29a137';
    }else{
      $cor = '#e5705c';
    }

   
   //recuperar o nome do cliente
    $usuario = $res[$i]['id_usuario'];
    $query2 = $pdo->query("SELECT * from usuarios where id = '$usuario' ");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_cliente = $res2[0]['nome'];

    $data = $res[$i]['data'];
    $data = implode('/', array_reverse(explode('-', $res[$i]['data'])));

    $total = $res[$i]['total'];
    $total = number_format($total, 2, ',', '.');

 		$dados[] = array(
 			'data' => $data,
 			'total' => $total,
			'status' => $res[$i]['status'],
      'cliente' => $nome_cliente,
      'cor' => $cor,  
      'id'  => $res[$i]['id'],   
        
 		);

 		}

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;

 ?>