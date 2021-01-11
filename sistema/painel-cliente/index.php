<?php 
require_once("../../conexao.php"); 
@session_start();

//VERIFICAR SE USUÁRIO ESTÁ AUTENTICADO
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}

$agora = date('Y-m-d');
//VARIÁVEIS PARA O MENU
$pag = @$_GET["pag"];
$menu1 = "pedidos";
$menu2 = "editarperfil";

//CONSULTAR O BANCO DE DADOS E TRAZER OS DADOS DO USUÁRIO
$res = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$dados[0]['nome'];
$email_usu = @$dados[0]['email'];
$cpf_usu = @$dados[0]['cpf'];
$nome_usu = @$dados[0]['nome'];
$sobrenome_usu = @$dados[0]['sobrenome'];
$telefone_usu = @$dados[0]['telefone'];

require_once("../../config.php");
require_once("../../conexao.php");
@session_start();

$id_usuario = @$_SESSION['id_usuario'];

//VERIFICAR TOTAIS DO CARRINHO
$res = $pdo->query("SELECT * from carrinho where id_usuario = '$id_usuario' and id_venda = 0 order by id asc");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

if($linhas == 0){
  $linhas = 0;
  $total = 0;
}

$total;
for ($i=0; $i < count($dados); $i++) { 
 foreach ($dados[$i] as $key => $value) {
 }

$combo = $dados[$i]['combo'];
$id_produto = $dados[$i]['id_produto'];
 $quantidade = $dados[$i]['quantidade'];

 if($combo == 'Sim'){
   $res_p = $pdo->query("SELECT * from combos where id = '$id_produto' ");
 }else{
  $res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
 }
 
 $dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);

 if($combo == 'Sim'){ 
  $promocao = ""; 
  $pasta = "combos";
 }else{
  $promocao = @$dados_p[0]['promocao']; 
  $pasta = "produtos";
 }

 if($promocao == 'Sim'){
  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id_produto' ");
  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
  $valor = $resp[0]['valor'];

}else{
  $valor = @$dados_p[0]['valor'];
}

$total_item = $valor * $quantidade;
@$total = @$total + $total_item;
}

@$total_c = number_format(@$total, 2, ',', '.');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Desenvolvimento de sites e sistemas web. Amplie sua marca com sites responsivos, otimizados e ideal para comercialização e engajamento. Sites e-commerce, portfólio, plataformas de curso e ensino a distancia, sites para casamentos e e diversos outros.">
    <meta name="keywords" content="criar site, sites, desenvolvimento web, sites em Passos-MG, sites em HTML, sites em CSS, desenvolvimento de sites, marketing, construção de sites, sistemas em Passos-MG, site em Passos-MG,">
    <link rel="shortcut icon" type="imagem/x-icon" href="../../img/icone.png"/>

    <?php if(@$palavras == ""){ ?>
    <meta name="keywords" content="criar site, sites, desenvolvimento web, sites em Passos-MG, sites em HTML, sites em CSS, desenvolvimento de sites, marketing, construção de sites, sistemas em Passos-MG, site em Passos-MG, comprar site, domínios em Passos-mg, Passos-mg, passos-mg">
    <?php }else{ ?>
    <meta name="keywords" content="<?php echo $palavras ?>">
    <?php } ?>

    <meta name="author" content="Samuel Sergio">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nome_loja ?></title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div> -->
    <div class="wrapper">
        <!-- Humberger Begin -->
        <div class="humberger__menu__overlay"></div>
        <div class="humberger__menu__wrapper">
            <div class="humberger__menu__logo">
                <a href="../../index.php"><img src="../../img/logo.png" alt=""></a>
            </div>
            <div class="humberger__menu__cart">
                <ul>
                    <li><a href="../../carrinho.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $linhas ?></span></a></li>
                </ul>
                <div class="header__cart__price d-lg-inline-block">item: <span>R$ <?php echo $total_c ?></span></div>
            </div>
            
            <nav class="humberger__menu__nav mobile-menu order-1">
                <ul >
                    <li><a class="active text-capitalize"><i class="fa fa-user mr-3"></i>Olá, <?php echo @$nome_usu?></a>
                        <ul class="header__menu__dropdown">
                            <li>
                                <a href="index.php">
                                    <i class="fa fa-home mr-2"></i>
                                    <span>Home</span>
                                </a>
                            </li>
        
                            <li>
                                <a href="index.php?pag=<?php echo $menu2 ?>">
                                    <i class="fa fa-user text-primary mr-3"></i>
                                    <span> Editar Perfil</span>
                                </a>
                            </li>
                                                
                            <li>
                                <a href="index.php?pag=<?php echo $menu1 ?>">
                                    <i class="fa fa-area-chart mr-2"></i>
                                    <span>Pedidos</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="../logout.php">
                                    <i class="fa fa-sign-out text-danger mr-3"></i>
                                    <span> Sair</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                <ul>
                    <li class="active"><a href="./index.php">Início</a></li>
                    <li><a href="#">Produtos</a>
                        <ul class="header__menu__dropdown">
                            <li><a href="../../produtos.php">Todos Produtos</a></li>
                            <li><a href="../../lista-produtos.php">Lista de Produtos</a></li>
                            <li><a href="../../sub-categorias.php">Sub Categorias</a></li>
                            <li><a href="../../promocoes.php">Promoções</a></li>
                            <li><a href="../../combos.php">Combos</a></li>
                        </ul>
                    </li>
                    <li><a href="../../blog.php">Blog</a></li>
                    
                    <li><a href="../../contatos.php">Contatos</a></li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
            <div class="header__top__right__social">
                <a target="_blank" href="https://facebook.com/webpassos2020"><i class="fa fa-facebook"></i></a>
                <a target="_blank" href="https://instagram.com/webpassos_"><i class="fa fa-instagram"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp"></i></a>
            </div>
            <div class="humberger__menu__contact">
                <ul>
                    <li><i class="fa fa-envelope"></i> <?php echo $email ?></li>
                    <li><?php echo $texto_destaque ?></li>
                </ul>
            </div>
        </div>
        <!-- Humberger End -->

        <!-- Header Section Begin -->
        <header class="header">
            <div class="header__top">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> <?php echo $email ?></li>
                                <li><?php echo $texto_destaque ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="https://www.facebook.com/webpassos2020" target="blank" rel="noopener noreferrer" title="Ir para página do Facebook"><i class="fa fa-facebook"></i></a>
                                <a href="https://www.instagram.com/webpassos_/" target="blank" rel="noopener noreferrer"><i class="fa fa-instagram"></i></a>
                                <a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp text-success"></i></a>
                            </div>
                            
                            <div class="header__top__right__auth">
                                <nav class="header__cliente">
                                    <ul>
                                        <li><a class=" text-capitalize"><i class="fa fa-user"></i>Olá, <?php echo @$nome_usu?></a>
                                            <ul class="header__cliente__dropdown">
                                                <li>
                                                    <a href="index.php">
                                                        <i class="fa fa-home fa-chart-area"></i>
                                                        <span>Home</span>
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="index.php?pag=<?php echo $menu2 ?>">
                                                        <i class="fa fa-user  mr-2 text-primary"></i>
                                                        <span>Editar Perfil</span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="index.php?pag=<?php echo $menu1 ?>">
                                                        <i class="fa fa-fw fa-chart-area"></i>
                                                        <span>Pedidos</span>
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../logout.php">
                                                        <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-danger"></i>Sair
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="header__logo">
                            <a href="../../index.php"><img src="../../img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <nav class="header__menu">
                            <ul>
                                <li class="active"><a href="../../index.php">Início</a></li>
                                <li><a href="#">Produtos</a>
                                    <ul class="header__menu__dropdown">
                                        <li><a href="../../produtos.php">Todos os Produtos</a></li>
                                        <li><a href="../../lista-produtos.php">Lista de Produtos</a></li>
                                        <li><a href="../../sub-categorias.php">Sub Categorias</a></li>
                                        <li><a href="../../promocoes.php">Promoções</a></li>
                                        <li><a href="../../combos.php">Combos</a></li>
                                    </ul>
                                </li>
                                <li><a href="../../blog.php">Blog</a></li>
                            
                                <li><a href="../../contatos.php">Contato</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3">
                        <div class="header__cart">
                            <ul>
                            <li><a href="../../carrinho.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $linhas ?></span></a></li>
                            </ul>
                            <div class="header__cart__price">item: <span>R$ <?php echo $total_c ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="humberger__open">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </header>
    <!-- Header Section End -->
    <!-- Hero Section Begin -->
        <section class="hero hero-normal">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="hero__categories">
                            <div class="hero__categories__all">
                                <i class="fa fa-bars"></i>
                                <span>Categorias</span>
                            </div>
                            <ul>
                                <?php 
                                    $query = $pdo->query("SELECT * FROM categorias order by nome asc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i=0; $i < count($res); $i++) { 
                                    foreach ($res[$i] as $key => $value) {
                                    }

                                    $nome = $res[$i]['nome'];

                                    $nome_url = $res[$i]['nome_url'];
                                    $id = $res[$i]['id'];
                                ?>
                            
                            <li><a href="../../sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>

                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="hero__search">
                            <div class="hero__search__form">
                                <form action="../../lista-produtos.php" method="get">
                                    <input name="txtBuscar" type="text" placeholder="Deseja buscar um Produto?">
                                    <button type="submit" class="site-btn">BUSCAR</button>
                                </form>
                            </div>
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <a class="text-info" target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp"></i></a>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h6><?php echo $whatsapp ?></h6>
                                    <span>Nosso WhatsApp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero Section End -->
        <container id="page-top" class="pt-6">
            <!-- Page Wrapper -->
            <div id="wrapper">
                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">
                    <!-- Main Content -->
                    <div id="content">
                        <!-- Begin Page Content -->
                        <div class="container-fluid">
                            <?php 
                            if ($pag == null) { 
                                include_once("home.php"); 
                            } else if ($pag==$menu1) {
                                include_once($menu1.".php");
                            } else if ($pag==$menu2) {
                                include_once($menu2.".php");
                            } else {
                                include_once("home.php");
                            }
                            ?>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->

<?php
require_once("rodape.php");
require_once("modal-carrinho.php");
?>


<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
<script src="../vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
<script src="../js/demo/chart-area-demo.js"></script>
<script src="../js/demo/chart-pie-demo.js"></script>
<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>
<script type="text/javascript">
    $('#form-dados').submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"editar-dados.php",
            method:"post",
            data:  $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Salvo com Sucesso!'){  
                    $('#mensagem-dados').addClass('text-success')
                    $('#mensagem-dados').text(msg);
                } else {
                    $('#mensagem-dados').addClass('text-danger')
                    $('#mensagem-dados').text(msg);
                }
            }
        })
    })
</script>

<script type="text/javascript">
    $('#form-endereco').submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"editar-endereco.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Salvo com Sucesso!'){                 
                    $('#mensagem-endereco').addClass('text-success')
                    $('#mensagem-endereco').text(msg);;
                } else {
                    $('#mensagem-endereco').addClass('text-danger')
                    $('#mensagem-endereco').text(msg);
                }
            }
        })
    })
</script>

<script type="text/javascript">
    $('#form-senha').submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"editar-senha.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Salvo com Sucesso!'){                 
                    $('#mensagem-senha').addClass('text-success')
                    $('#mensagem-senha').text(msg);;
                } else {
                    $('#mensagem-senha').addClass('text-danger')
                    $('#mensagem-senha').text(msg);
                }
            }
        })
    })
</script>

<script type="text/javascript">
    $('#btn-salvar-email').click(function(event){
        event.preventDefault();
        $('#mensagem-email-marketing').addClass('text-info')
        $('#mensagem-email-marketing').removeClass('text-danger')
        $('#mensagem-email-marketing').removeClass('text-success')
        $('#mensagem-email-marketing').text('Enviando')
        $.ajax({
            url:"email-marketing.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
               if(msg.trim() === 'Enviado com Sucesso!'){
                    $('#mensagem-email-marketing').removeClass('text-info')
                    $('#mensagem-email-marketing').addClass('text-success')
                    $('#mensagem-email-marketing').text(msg);
                    $('#assunto-email').val('');
                    $('#link-email').val('');
                    $('#mensagem-email').val('');
                 }else if(msg.trim() === 'Preencha o Campo Assunto!'){
                    $('#mensagem-email-marketing').addClass('text-danger')
                    $('#mensagem-email-marketing').text(msg);
                 }else if(msg.trim() === 'Preencha o Campo Mensagem!'){
                    $('#mensagem-email-marketing').addClass('text-danger')
                    $('#mensagem-email-marketing').text(msg);
                 }
                 else{
                    $('#mensagem-email-marketing').addClass('text-danger')
                    $('#mensagem-email-marketing').text('Deu erro ao Enviar o Formulário! Provavelmente seu servidor de hospedagem não está com permissão de envio habilitada ou você está em um servidor local!');
                    //$('#div-mensagem').text(msg);
                 }
            }
        })
    })
</script>
<script>                        
function mostrarConfSenha() {
  var senha = document.getElementById("conf-senha");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>

<script>                        
function mostrarSenha() {
  var senha = document.getElementById("senha");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../../js/mascara.js"></script>