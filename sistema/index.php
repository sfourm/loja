<?php
   require_once("../conexao.php");
   @session_start();

   //VERIFICAR SE EXISTE ALGUM CADASTRO NO BANCO, SE NÃO TIVER CADASTRAR O USUÁRIO ADMINISTRADOR
   $res = $pdo->query("SELECT * FROM usuarios"); 
   $dados = $res->fetchAll(PDO::FETCH_ASSOC);
   $senha_crip = md5('123');
   if(@count($dados) == 0){
   $res = $pdo->query("INSERT into usuarios (nome, cpf, email, senha, senha_crip, nivel, imagem) values ('Administrador', '000.000.000-00', '$email', '123', '$senha_crip', 'Admin', 'sem-foto.jpg')");
   }

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head >
      <title>Login - <?php echo $nome_loja ?></title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Desenvolvimento de sites e sistemas web. Amplie sua marca com sites responsivos, otimizados e ideal para comercialização e engajamento. Sites e-commerce, portfólio, plataformas de curso e ensino a distancia, sites para casamentos e e diversos outros.">
      <meta name="keywords" content="criar site, sites, desenvolvimento web, sites em Passos-MG, sites em HTML, sites em CSS, desenvolvimento de sites, marketing, construção de sites, sistemas em Passos-MG, site em Passos-MG,">
     
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link href="../css/login.css" rel="stylesheet">
      <link rel="shortcut icon" type="imagem/x-icon" href="../img/icone.png"/>
      
      <script src="../js/login.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
   </head>

   <body>
      <div class="container">
         <div class="row">
            <div class="col-md-5 mx-auto">
               <div id="first">
                  <div class="myform form ">
                     <div class="logo mb-3">
                        <div class="col-md-12 text-center pb-3">
                           <a href="../index.php"><img src="../img/logo.png" alt=""></a>
                        </div>
                        <?php
                        if(isset($_SESSION['dados_incorretos'])):
                        ?>
                        <div class="">
                        <p class="text-center">ERRO: Usuário ou senha inválidos.</p>
                        </div>
                        <?php
                        endif;
                        unset($_SESSION['dados_incorretos']);
                        ?>
                     </div>
                     <form action="autenticar.php" method="post" name="form-login" id="form-login">
                        <div class="form-group">
                           <label>Email ou CPF</label>
                           <input type="text" name="email_login"  class="form-control" id="email_login" aria-describedby="emailHelp" placeholder="Insira seu Email ou CPF" required>
                        </div>
                     
                        <div class="form-group">
                           <label class="d-block">Senha</label>
                           <input type="password" class="form-control d-inline-block" id="senha_login" name="senha_login" placeholder="Inserir Senha" maxlength="16" required>
                           <button class="d-inline-block form-control" type="button" onClick="mostrarSenhaLogin()"><i class="fa fa-eye"></i></button>
                        </div>
                     
                        <div class="col-md-12 text-center mt-4">
                           <button type="submit" class=" btn mybtn tx-tfm">Login</button>
                        </div>
                     
                        <div class="form-group mt-4">
                           <small>
                           <p class="text-center">Não possui Cadastro? <a href="#" data-toggle="modal" data-target="#modalCadastro">Cadastre-se</a></p>
                           <p class="text-center"><a class="text-danger" href="#" data-toggle="modal" data-target="#modalRecuperar">Recuperar Senha?</a></p>
                           </small>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>      
   </body>
</html>

<!-- Modal -->
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastre-se</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form method="post" id="form-cadastrar" name="form-cadastrar">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label >Nome</label>
                        <input type="text" class="form-control text-capitalize" id="nome" name="nome" placeholder="Nome" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Sobrenome</label>
                        <input type="text" class="form-control text-capitalize" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <label >Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label >CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group d-inline">
                        <label  class="d-block">Senha</label>
                        <input  type="password" class="form-control d-inline-block" id="senha" name="senha" placeholder="Inserir Senha" for="senha" minlength="8" maxlength="16" required>
                        <button class="d-inline-block form-control" type="button" onClick="mostrarSenha()"><i class="fa fa-eye"></i></button>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group d-inline">
                        <label class="d-block">Confirmar Senha</label>
                        <input type="password" class="form-control d-inline-block" id="confirmar-senha" name="confirmar-senha" minlength="8" maxlength="16" placeholder="Confirmar Senha" required>
                        <button class="d-inline-block form-control" type="button" onClick="mostrarConfSenha()"><i class="fa fa-eye"></i></button>
                     </div>
                  </div>
               </div>
               <small><div class="text-center" id="div-mensagem"></div></small>
               <div class="modal-footer text-center align-content-center d-flex">
                  <button type="submit" id="btn-cadastrar" class="btn btn-dark">Cadastrar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<!-- Modal Recuperar -->
<div class="modal fade" id="modalRecuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" id="email-recuperar" name="email-recuperar" placeholder="Seu Email">
               </div>

               <small><div id="div-mensagem-rec"></div></small>
            </form>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
   
            <button type="button" id="btn-recuperar" class="btn btn-dark">Recuperar</button>
         </div>
      </div>
   </div>
</div>

<?php 
if (@$_GET["email_rodape"] != null) {
    echo "<script>$('#modalCadastro').modal('show');</script>";
}
?>

<script type="text/javascript">
   $('#form-cadastrar').submit(function(event){
      event.preventDefault();
      $.ajax({
         url:"cadastrar.php",
         method:"post",
         data: $('form').serialize(),
         dataType: "text",
         success: function(msg){
            if(msg.trim() === 'Cadastrado com Sucesso!'){
               $('#div-mensagem').removeClass('text-danger')
               $('#div-mensagem').addClass('text-success')
               $('#div-mensagem').text(msg);
            
            } else {
               $('#div-mensagem').addClass('text-danger')
               $('#div-mensagem').text(msg);

            }
         }
      })
   })
</script>

<script type="text/javascript">
   $('#btn-recuperar').click(function(event){
      event.preventDefault();
      $.ajax({
         url:"recuperar.php",
         method:"post",
         data: $('form').serialize(),
         dataType: "text",
         success: function(msg){
            if(msg.trim() === 'Senha Enviada para o Email!'){
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
               $('#div-mensagem-rec').addClass('text-alert')
               $('#div-mensagem-rec').text('Deu erro ao Enviar o Formulário! Provavelmente seu servidor de hospedagem não está com permissão de envio habilitada ou você está em um servidor local');
            }
         }
      })
   })
</script>

<script type="text/javascript">                        
function mostrarConfSenha() {
  var senha = document.getElementById("confirmar-senha");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>

<script type="text/javascript">                        
function mostrarSenha() {
  var senha = document.getElementById("senha");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>

<script type="text/javascript">                        
function mostrarSenhaLogin() {
  var senha = document.getElementById("senha_login");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../js/mascara.js"></script>
