<?php
require_once("cabecalho.php");
require_once("conexao.php");
@session_start();
?>




<!-- Hero Section Begin -->
<section class="hero">
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
              $nome_url = $res[$i]['nome_url'];?>
              
              <li><a href="sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></li><?php } ?>

          </ul>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="hero__search">
          <div class="hero__search__form">
           <form action="lista-produtos.php" method="get">

            <input name="txtBuscar" type="text" placeholder="Deseja buscar um Produto?">
            <button type="submit" class="site-btn">BUSCAR</button>
          </form>
        </div>
        <div class="hero__search__phone">
          <div class="hero__search__phone__icon">
            <a class="text-info" target="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_link ?>" title="<?php echo $whatsapp ?>"><i class="fa fa-whatsapp"></i></a>
          </div>
          <div class="hero__search__phone__text">
            <h6><?php echo $whatsapp ?></h6>
            <span>Nosso WhatsApp</span>
          </div>
        </div>
      </div>
      <div class="hero__item set-bg bg-light" data-setbg="img/hero/banner.jpg">
        <div class="hero__text">
          <span><?php echo strToUpper($nome_loja) ?></span>
          <h2>Produtos de<br />Primeira Linha</h2>
          <p>Aqui você encontra os melhores preços!!</p>
          <a href="produtos.php" class="primary-btn">COMPRAR AGORA</a>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
  <div class="container">
    <div class="row">
      <div class="categories__slider owl-carousel">

       <?php 
       $query = $pdo->query("SELECT * FROM categorias order by id ");
       $res = $query->fetchAll(PDO::FETCH_ASSOC);

       for ($i=0; $i < count($res); $i++) { 
        foreach ($res[$i] as $key => $value) {
        }

        $nome = $res[$i]['nome'];
        $imagem = $res[$i]['imagem'];
        $nome_url = $res[$i]['nome_url'];?>

        <div class="col-lg-3">
          <div class="categories__item set-bg" data-setbg="img/categorias/<?php echo $imagem ?>">
            <h5><a href="sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></h5>
          </div>
        </div>

      <?php } ?>
    </div>
  </div>
</div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title">
         <a class="text-dark" href="produtos.php"><span ><small>Ver + Produtos</small></span></a>
         <h2>Produtos Destaques </h2>

       </div>
       <div class="featured__controls">
        <ul>
         <?php 
         $query = $pdo->query("SELECT * FROM sub_categorias order by id limit 5 ");
         $res = $query->fetchAll(PDO::FETCH_ASSOC);

         for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $nome = $res[$i]['nome'];

          $nome_url = $res[$i]['nome_url'];

          ?>
          <li><a href="produtos-<?php echo $nome_url ?>" class="text-dark"><?php echo $nome ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<div class="row featured__filter">


 <?php 
 $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by vendas desc limit 8 ");
 $res = $query->fetchAll(PDO::FETCH_ASSOC);

 for ($i=0; $i < count($res); $i++) { 
  foreach ($res[$i] as $key => $value) {
  }

  $nome = $res[$i]['nome'];
  $valor = $res[$i]['valor'];
  $nome_url = $res[$i]['nome_url'];
  $imagem = $res[$i]['imagem'];
  $promocao = $res[$i]['promocao'];
  $id = $res[$i]['id'];

  $valor = number_format($valor, 2, ',', '.');

  if($promocao == 'Sim'){
    $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
    $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
    $valor_promo = $resp[0]['valor'];
    $desconto = $resp[0]['desconto'];
    $valor_promo = number_format($valor_promo, 2, ',', '.');?>

    <div class="col-lg-3 col-md-4 col-sm-6 mix sapatos fresh-meat">
      <div class="product__discount__item">
        <div class="product__discount__item__pic set-bg"
        data-setbg="img/produtos/<?php echo $imagem ?>">
        <div class="product__discount__percent">-<?php echo $desconto ?>%</div>
        <ul class="product__item__pic__hover">
         <li><a href="produto-<?php echo $nome_url ?>"><i class="fa fa-eye"></i></a></li>

         <li><a href="" onclick="carrinhoModal('<?php echo $id ?>','Não')"><i class="fa fa-shopping-cart"></i></a>

         </ul>
       </div>
       <div class="product__discount__item__text">

        <h5><a href="produto-<?php echo $nome_url ?>"><?php echo $nome ?></a></h5>
        <div class="product__item__price">R$ <?php echo $valor_promo ?> <span>R$ <?php echo $valor ?></span></div>
      </div>
    </div>
  </div>

<?php }else{ ?>

  <div class="col-lg-3 col-md-4 col-sm-6 mix sapatos fresh-meat">
    <div class="featured__item">
      <div class="featured__item__pic set-bg" data-setbg="img/produtos/<?php echo $imagem ?>">
        <ul class="featured__item__pic__hover">
          <li><a href="produto-<?php echo $nome_url ?>"><i class="fa fa-eye"></i></a></li>

          <li><a href="" onclick="carrinhoModal('<?php echo $id ?>','Não')"><i class="fa fa-shopping-cart"></i></a>
        </ul>
      </div>
      <div class="featured__item__text">
        <a href="produto-<?php echo $nome_url ?>"><h6><?php echo $nome ?></h6><h5>R$ <?php echo $valor ?></h5></a>
      </div>
    </div>
  </div>

    <?php } } ?>

  </div>
</div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
  <div class="container">
    <div class="row pb-3">

     <?php 
     $query = $pdo->query("SELECT * FROM promocao_banner where ativo = 'Sim' order by id desc limit 2 ");
     $res = $query->fetchAll(PDO::FETCH_ASSOC);

     for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

      $titulo = $res[$i]['titulo'];
      $link = $res[$i]['link'];

      $imagem = $res[$i]['imagem'];?>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="banner__pic">
          <a href="<?php echo $link ?>" title="<?php echo $titulo ?>"> <img src="img/promocoes/<?php echo $imagem ?>" alt="<?php echo $titulo ?>"> </a>
        </div>
      </div>
   <?php } ?>
 </div>
</div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad d-none d-md-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="latest-product__text">
          <h4>Produtos Recentes</h4>
          <div class="latest-product__slider owl-carousel">
            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos order by id desc limit 3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }?>

                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by id desc limit 3,3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }

                ?>
                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by id desc limit 6,3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }
                ?>

                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                 <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="latest-product__text">
          <h4>Mais Vendidos</h4>
          <div class="latest-product__slider owl-carousel">
            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by vendas desc limit 3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }
                ?>

                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>

              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by vendas desc limit 3,3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }
                ?>

                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by vendas desc limit 6,3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $promocao = $res[$i]['promocao'];
                $id = $res[$i]['id'];

                if($promocao == 'Sim'){
                  $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
                  $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                  $valor = $resp[0]['valor'];
                  $valor = number_format($valor, 2, ',', '.');
                }else{
                  $valor = number_format($valor, 2, ',', '.');
                }
                ?>

                <a href="produto-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="latest-product__text">
          <h4>Combos</h4>
          <div class="latest-product__slider owl-carousel">
            <div class="latest-product__slider__item">
              <?php 
              $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by id desc limit 3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $valor = number_format($valor, 2, ',', '.');
                ?>

                <a href="combo-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>

              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
            <?php 
              $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by id desc limit 3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];
                $valor = number_format($valor, 2, ',', '.');
                ?>

                <a href="combo-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>

              <?php } ?>
            </div>

            <div class="latest-product__slider__item">
            <?php 
              $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by id desc limit 3 ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $valor = $res[$i]['valor'];
                $nome_url = $res[$i]['nome_url'];
                $imagem = $res[$i]['imagem'];

                $valor = number_format($valor, 2, ',', '.');
                ?>

                <a href="combo-<?php echo $nome_url ?>" class="latest-product__item">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                </a>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Latest Product Section End -->



<?php
require_once("rodape.php");
require_once("modal-carrinho.php");

?>






