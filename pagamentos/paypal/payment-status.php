<?php
include_once("../../config.php");

?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <link rel="stylesheet" href="../css/estilos-site.css">
    <link rel="stylesheet" href="../css/estilos-padrao.css">
    <link rel="stylesheet" href="../css/cursos.css">
    <link rel="stylesheet" href="../css/detalhes_curso.css">

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <title>Pagamento Paypal</title>
</head>
<body>

	<!-- Modal Contatos -->
      <div id="modalPaypal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content">
            <form method="POST" action="">
              <div class="modal-header">
              
                <h5 class="modal-title"><small>Ir para o Painél do Cliente</small></h5>
               

                <button type="submit" class="close" name="fecharModal">&times;</button>
              </form>
            </div>
            
            <div class="modal-body">

              <p class="text-muted">Seu pagamento foi processado com sucesso, vá para o seu painel para maiores informações sobre prazos e envios.</p>

            </div>


            <a class="text-danger ml-2" href="../../sistema/painel-cliente/index.php?pag=pedidos" target="_blank">Ir para o Painél do Cliente</a>


            <div class="modal-footer">
                <small><span class="text-muted">WhatsApp <a class="text-muted" href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" alt="<?php echo $whatsapp ?>" target="_blank"><i class="fa fa-whatsapp mr-1 text-success"></i><?php echo $whatsapp ?></a> </small></span>
            </div>
                   
            
          </div>
        </div>
      </div>  


</body>
</html> 



 <script> $("#modalPaypal").modal("show"); </script> 