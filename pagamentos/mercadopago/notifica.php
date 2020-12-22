<?php 
 if($_GET['collection_id'] || $_GET['id']){
   
     
                   // Conexão
   require_once 'lib/mercadopago.php';  // Biblioteca Mercado Pago
   require_once 'PagamentoMP.php';            // Classe Pagamento
   
   $pagar = new PagamentoMP;
   
   if(isset($_GET['collection_id'])):
    $id =  $_GET['collection_id'];
   elseif(isset($_GET['id'])):
    $id =  $_GET['id'];
   endif; 
   
   
   $retorno = $pagar->Retorno($id , $pdo);
   if($retorno){
      // Redirecionar usuario
      echo '<script>location.href="../../sistema/painel-cliente/index.php?pag=pedidos"</script>';
   }else{
     // Redirecionar usuario e informar erro ao admin
      echo '<script>location.href="../../sistema/painel-cliente/index.php?pag=pedidos"</script>';
      
     
   }
   
 }
 
 
?>