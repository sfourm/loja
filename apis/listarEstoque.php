<?php 

include_once('../conexao.php');


$query = $pdo->query("SELECT * FROM produtos where estoque <= '$nivel_estoque' order by estoque asc ");

 $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

      
   
 		$dados[] = array(
 			'nome' => $res[$i]['nome'],
 			'estoque' => $res[$i]['estoque'],
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