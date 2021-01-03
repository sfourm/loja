<?php 
require_once("config.php");
require_once("conexao.php");
@session_start();

$id_usuario = @$_SESSION['id_usuario'];

//VERIFICAR TOTAIS DO CARRINHO
$res = $pdo->query("SELECT * from carrinho where id_usuario = '$id_usuario' and id_venda = 0 order by id asc");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

//VARIÁVEIS PARA O MENU
$pag = @$_GET["pag"];
$menu1 = "pedidos";
$menu2 = "editarperfil";

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

$res = @$pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$dados[0]['nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Desenvolvimento de sites e sistemas web. Amplie sua marca com sites responsivos, otimizados e ideal para comercialização e engajamento. Sites e-commerce, portfólio, plataformas de curso e ensino a distancia, sites para casamentos e e diversos outros.">
    <meta name="keywords" content="criar site, sites, desenvolvimento web, sites em Passos-MG, sites em HTML, sites em CSS, desenvolvimento de sites, marketing, construção de sites, sistemas em Passos-MG, site em Passos-MG,">
    <link rel="shortcut icon" type="imagem/x-icon" href="img/icone.png"/>

    <meta name="description" content="Venda de Roupas Masculina e Feminina">
    <?php if(@$palavras == ""){ ?>
    <meta name="keywords" content="criar site, sites, desenvolvimento web, sites em Passos-MG, sites em HTML, sites em CSS, desenvolvimento de sites, marketing, construção de sites, sistemas em Passos-MG, site em Passos-MG, comprar site, domínios em Passos-mg, Passos-mg, passos-mg">
    <?php }else{ ?>
    <meta name="keywords" content="<?php echo $palavras ?>">
    <?php } ?>

    <meta name="author" content="Samuel Sergio">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nome_loja ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <div class="wrapper">
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div> -->

        <!-- Humberger Begin -->
        <div class="humberger__menu__overlay"></div>
        <div class="humberger__menu__wrapper">
            <div class="humberger__menu__logo">
                <a href="index.php"><img src="img/logo.png" alt=""></a>
            </div>
            <div class="humberger__menu__cart">
                <ul>
                    <li><a href="carrinho.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $linhas ?></span></a></li>
                </ul>
                <div class="header__cart__price d-lg-inline-block">item: <span>R$ <?php echo $total_c ?></span></div>
            </div>
            
            <nav class="humberger__menu__nav mobile-menu order-1">
                <ul >
                    <?php 
                    if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente'){
                        ?>
                        <a href="sistema"><i class="fa fa-user"></i> Login</a>
                    <?php } else { ?>
                        <li><a class="active text-capitalize" href="sistema/painel-cliente/index.php"><i class="fa fa-user mr-3"></i>Olá, <?php echo @$nome_usu?></a>
                            <ul class="header__menu__dropdown">
                                <li>
                                    <a href="sistema/painel-cliente/index.php">
                                        <i class="fa fa-home mr-2"></i>
                                        <span>Home</span>
                                    </a>
                                </li>
            
                                <li>
                                    <a href="sistema/painel-cliente/index.php?pag=<?php echo $menu2 ?>">
                                        <i class="fa fa-user text-primary mr-3"></i>
                                        <span> Editar Perfil</span>
                                    </a>
                                </li>
                                                    
                                <li>
                                    <a href="sistema/painel-cliente/index.php?pag=<?php echo $menu1 ?>">
                                        <i class="fa fa-area-chart mr-2"></i>
                                        <span>Pedidos</span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="sistema/logout.php">
                                        <i class="fa fa-sign-out text-danger mr-3"></i>
                                        <span> Sair</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                
                <ul>
                    <li class="active"><a href="./index.php">Início</a></li>
                    <li><a href="#">Produtos</a>
                        <ul class="header__menu__dropdown">
                            <li><a href="produtos.php">Todos Produtos</a></li>
                            <li><a href="lista-produtos.php">Lista de Produtos</a></li>
                            <li><a href="sub-categorias.php">Sub Categorias</a></li>
                            <li><a href="promocoes.php">Promoções</a></li>
                            <li><a href="combos.php">Combos</a></li>
                        </ul>
                    </li>
                    <li><a href="blog.php">Blog</a></li>
                    
                    <li><a href="contatos.php">Contatos</a></li>
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
                                <a target="_blank" title="Ir para página do Facebook" href="#"><i class="fa fa-facebook"></i></a>
                                <a target="_blank" href="#"><i class="fa fa-instagram"></i></a>
                                <a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp text-success"></i></a>
                            </div>

                            <div class="header__top__right__auth">
                                <?php 
                                if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente'){
                                    ?>
                                    <a href="sistema"><i class="fa fa-user"></i> Login</a>
                                <?php } else { ?>
                                    <div class="header__top__right__auth">
                                        <nav class="header__cliente">
                                            <ul>
                                                <li><a class="text-capitalize"><i class="fa fa-user"></i>Olá, <?php echo @$nome_usu?></a>
                                                    <ul class="header__cliente__dropdown">
                                                        <li>
                                                            <a href="sistema/painel-cliente/index.php">
                                                                <i class="fa fa-home "></i>
                                                                <span>Home</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="sistema/painel-cliente/index.php?pag=<?php echo $menu2 ?>">
                                                                <i class="fa fa-user fa-sm fa-fw mr-2 text-primary"></i>Editar Perfil
                                                            </a>
                                                        </li>
                                                        
                                                        
                                                        
                                                        <li>
                                                            <a href="sistema/painel-cliente/index.php?pag=<?php echo $menu1 ?>">
                                                                <i class="fa fa-area-chart fa-fw "></i>
                                                                <span>Pedidos</span>
                                                            </a>
                                                        </li>
                                                        
                                                        <li>
                                                            <a href="sistema/logout.php">
                                                                <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-danger"></i>Sair
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="header__logo">
                            <a href="./index.php"><img src="img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <nav class="header__menu">
                            <ul>
                                <li class="active"><a href="./index.php">Início</a></li>
                                <li><a href="#">Produtos</a>
                                    <ul class="header__menu__dropdown">
                                        <li><a href="produtos.php">Produtos</a></li>
                                        <li><a href="lista-produtos.php">Lista de Produtos</a></li>
                                        <li><a href="sub-categorias.php">Sub Categorias</a></li>
                                        <li><a href="promocoes.php">Promoções</a></li>
                                        <li><a href="combos.php">Combos</a></li>
                                    </ul>
                                </li>
                                <li><a href="blog.php">Blog</a></li>
                            
                                <li><a href="contatos.php">Contato</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3">
                        <div class="header__cart">
                            <ul>
                            <li><a href="carrinho.php"><i class="fa fa-shopping-bag"></i> <span><?php echo $linhas ?></span></a></li>
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

