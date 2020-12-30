<?php 

include_once('../conexao.php');

$postjson = json_decode(file_get_contents("php://input"), true);


   if(@$postjson['id'] == ''){
      $query = $pdo->prepare("INSERT INTO cupons (titulo, desconto, codigo, data) VALUES (:titulo, :desconto, :codigo, :data)");
   }else{
     $query = $pdo->prepare("UPDATE cupons SET titulo = :titulo, desconto = :desconto, codigo = :codigo, data = :data WHERE id = :id ");

     $query->bindValue(":id", $postjson['id']);
   }
 	
  
       $query->bindValue(":titulo", $postjson['titulo']);
       $query->bindValue(":codigo", $postjson['codigo']);
       $query->bindValue(":data", $postjson['dataInserir']);
       $query->bindValue(":desconto", $postjson['desconto']);
    
       

      
       $query->execute();
  
             
  
      if($query){
        $result = json_encode(array('success'=>true));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }

        echo $result;
 

 
     


?>