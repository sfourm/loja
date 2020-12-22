<?php 

include_once('../conexao.php');


$query = $pdo->query("SELECT * FROM cupons order by id desc  ");

 $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

    $data = implode('/', array_reverse(explode('-', $res[$i]['data'])));
    $desconto = number_format($res[$i]['desconto'], 2, ',', '.');
       
   
 		$dados[] = array(
 			'data' => $data,
 			'titulo' => $res[$i]['titulo'],
			'desconto' => $desconto,
      'codigo' => $res[$i]['codigo'],
      
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