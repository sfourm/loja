<?php
require_once("cabecalho.php");
?>

<?php
require_once("cabecalho-busca.php");
?>


<!-- Product Section Begin -->
<section class="product spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-5">
        <div class="sidebar">
          <div class="sidebar__item">
            <h4>SubCategorias</h4>
            <ul>
              <?php 
              $query = $pdo->query("SELECT * FROM sub_categorias order by nome asc ");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);

              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];

                $nome_url = $res[$i]['nome_url'];

                ?>
                <li><a href="produtos-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>

              <?php } ?>

            </ul>
          </div>
          <div class="sidebar__item">
            <h4>Filtrar Por Valor R$</h4>
            <div class="price-range-wrap">
              <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
              data-min="10" data-max="1000">
              <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
              <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
              <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
            <div class="range-slider">
              <div class="price-input">
                <form method="get" action="lista-produtos.php" name="form_valor">
                  <input type="text" name="valor-inicial" id="minamount">
                  <input type="text" name="valor-final" id="maxamount">
                  <a href="#" onclick="document.form_valor.submit(); return false;" class="text-dark">
                    <i class="fa fa-search ml-2"></i>
                  </a>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="sidebar__item spad d-none d-md-block">
          <div class="latest-product__text">
            <h4>Lançamentos</h4>


            <div class="latest-product__slider owl-carousel">
              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by id desc limit 6 ");
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
                      <div class="col-md-7">
                        <div class="latest-product__item__pic">
                          <img src="img/produtos/<?php echo $imagem ?>" alt="">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="latest-product__item__text">
                          <h6><?php echo $nome ?></h6>
                          <span>R$ <?php echo $valor ?></span>
                        </div>
                      </div>
                    </div>
                  </a>

                <?php } ?>


              </div>


              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by id desc limit 6,6 ");
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
                    <div class="col-md-7">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                  </a>

                <?php } ?>


              </div>



              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by id desc limit 12,6 ");
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
                    <div class="col-md-7">
                      <div class="latest-product__item__pic">
                        <img src="img/produtos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-5">
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


        <div class="sidebar__item spad d-none d-md-block">
          <div class="latest-product__text">
            <h4>Combos</h4>


            <div class="latest-product__slider owl-carousel">


              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by id desc limit 6 ");
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
                    <div class="col-md-7">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                  </a>

                <?php } ?>


              </div>


              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by id desc limit 6,6 ");
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
                    <div class="col-md-7">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="latest-product__item__text">
                        <h6><?php echo $nome ?></h6>
                        <span>R$ <?php echo $valor ?></span>
                      </div>
                    </div>
                  </div>
                  </a>

                <?php } ?>


              </div>



              <div class="latest-prdouct__slider__item">

                <?php 
                $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim'  order by id desc limit 12,6 ");
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
                    <div class="col-md-7">
                      <div class="latest-product__item__pic">
                        <img src="img/combos/<?php echo $imagem ?>" alt="">
                      </div>
                    </div>
                    <div class="col-md-5">
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


    <div class="col-lg-9 col-md-7">
      <div class="product__discount">
        <div class="section-title product__discount__title">
          <h2>Promoções</h2><span class="ml-2"><a class="text-muted" href="promocoes.php" title="Ver todas as Promoções"><small><i class="fa fa-eye mr-1"></i>Ver Todas</small></a></span>
        </div>
        <div class="row">
          <div class="product__discount__slider owl-carousel">

           <?php 
           $query = $pdo->query("SELECT * FROM produtos where promocao = 'Sim' and ativo = 'Sim' and estoque > 0");
           $res = $query->fetchAll(PDO::FETCH_ASSOC);

           for ($i=0; $i < count($res); $i++) { 
            foreach ($res[$i] as $key => $value) {
            }

            $nome = $res[$i]['nome'];
            $valor_old = $res[$i]['valor'];
            $nome_url = $res[$i]['nome_url'];
            $imagem = $res[$i]['imagem'];
            $id = $res[$i]['id'];
            $valo_old = number_format($valor_old, 2, ',', '.');

            $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
            $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
            $valor = $resp[0]['valor'];
            $desconto = $resp[0]['desconto'];
            $valor = number_format($valor, 2, ',', '.');
            ?>


            <div class="col-lg-4">
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
                <div class="product__item__price">R$ <?php echo $valor ?> <span>R$ <?php echo $valor_old ?></span></div>
              </div>
            </div>
          </div>

        <?php } ?>



      </div>
    </div>
  </div>

  <div class="section-title product__discount__title">
    <h2>Mais Vendidos</h2>
    <span class="ml-2"><a class="text-muted" href="lista-produtos.php" title="Ver todos os Produtos"><small><i class="fa fa-eye mr-1"></i>Ver Todos</small></a></span>
  </div>

  <div class="row">

   <?php 
   $query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0 order by vendas desc limit 6");
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
      $valor_promo = number_format($valor_promo, 2, ',', '.');

      ?>

      <div class="col-lg-4">
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


    <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="product__item">
        <div class="product__item__pic set-bg" data-setbg="img/produtos/<?php echo $imagem ?>">
          <ul class="product__item__pic__hover">
            <li><a href="produto-<?php echo $nome_url ?>"><i class="fa fa-eye"></i></a></li>

            <li><a href="" onclick="carrinhoModal('<?php echo $id ?>','Não')"><i class="fa fa-shopping-cart"></i></a>

            </ul>
          </div>
          <div class="product__item__text">
            <a href="produto-<?php echo $nome_url ?>"><h6><?php echo $nome ?></h6>
              <h5><?php echo $valor ?></h5></a>
            </div>
          </div>
        </div>

      <?php } } ?>


    </div>





    <div class="section-title product__discount__title mt-4">
      <h2>Combos Mais Vendidos</h2>
      <span class="ml-2"><a class="text-muted" href="combos.php" title="Ver todos os Combos"><small><i class="fa fa-eye mr-1"></i>Ver Todos</small></a></span>
    </div>

    <div class="row">

     <?php 
     $query = $pdo->query("SELECT * FROM combos where ativo = 'Sim' order by vendas desc limit 6 ");
     $res = $query->fetchAll(PDO::FETCH_ASSOC);

     for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }

      $nome = $res[$i]['nome'];
      $valor = $res[$i]['valor'];
      $nome_url = $res[$i]['nome_url'];
      $imagem = $res[$i]['imagem'];
      $id = $res[$i]['id'];

      $valor = number_format($valor, 2, ',', '.');
      ?>


      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="product__item">
          <div class="product__item__pic set-bg" data-setbg="img/combos/<?php echo $imagem ?>">
            <ul class="product__item__pic__hover">
              <li><a href="combo-<?php echo $nome_url ?>"><i class="fa fa-eye"></i></a></li>
              <li><a href="" onclick="carrinhoModal('<?php echo $id ?>','Sim')"><i class="fa fa-shopping-cart"></i></a>
              </ul>
            </div>
            <div class="product__item__text">
              <a href="combo-<?php echo $nome_url ?>"><h6><?php echo $nome ?></h6>
                <h5><?php echo $valor ?></h5></a>
              </div>
            </div>
          </div>


        <?php } ?>


      </div>



    </div>
  </div>
</div>
</section>
<!-- Product Section End -->


<?php

require_once("rodape.php");
require_once("modal-carrinho.php");

?>