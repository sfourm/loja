<?php
    require_once("conexao.php");
 
?>

<!DOCTYPE html>
<html>
<head>
   <title>Descadastrar - <?php echo $nome_loja ?></title>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

      <link href="../css/login.css" rel="stylesheet">
      <script src="../js/login.js"></script>

      <link rel="shortcut icon" href="../img/logoicone1.ico" type="image/x-icon">
    <link rel="icon" href="../img/logoicone2.ico" type="image/x-icon">


</head>



<body>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
			<div id="first">
				<div class="myform form ">
					 <div class="logo mb-3">
						 <div class="col-md-12 text-center">
							<h1>Descadastrar</h1>
						 </div>
					</div>
                   <form method="post">
                           <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="text" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Insira seu Email">
                           </div>

                           <small><div align="center" id="div-mensagem-rec"></div></small>
                         
                          

                           <div class="col-md-12 text-center mt-4">
                              <button name="btn-descadastrar" id="btn-descadastrar" class=" btn btn-block mybtn btn-primary tx-tfm">Descadastrar</button>
                           </div>
                          
                         
                        </form>
                 
				</div>
			</div>
			  
			</div>
		</div>
      </div>   
         
</body>


</html>




<script type="text/javascript">
    $('#btn-descadastrar').click(function(event){
        event.preventDefault();
        
        $.ajax({
            url:"ajax-descadastrar.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Descadastrado da Lista com Sucesso!'){
                    
                    $('#div-mensagem-rec').addClass('text-success')
                    $('#div-mensagem-rec').text(msg);
                                        
                    }else if(msg.trim() === 'Preencha o Campo Email!'){
                      $('#div-mensagem-rec').addClass('text-danger')
                      $('#div-mensagem-rec').text(msg);

                    }else if(msg.trim() === 'Este email não está cadastrado!'){
                      $('#div-mensagem-rec').addClass('text-danger')
                      $('#div-mensagem-rec').text(msg);
                    }



                 else{
                    $('#div-mensagem-rec').addClass('text-danger')
                    $('#div-mensagem-rec').text('Deu erro ao Enviar o Formulário! Provavelmente seu servidor de hospedagem não está com permissão de envio habilitada ou você está em um servidor local');
                   

                 }
            }
        })
    })
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

  <script src="../js/mascara.js"></script>
