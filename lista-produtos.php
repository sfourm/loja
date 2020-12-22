<?php
require_once("cabecalho.php");
require_once("conexao.php");
?>

<?php 
//PEGAR PAGINA ATUAL PARA PAGINAÇAO
if(@$_GET['pagina'] != null){
    $pag = $_GET['pagina'];
}else{
    $pag = 0;
}

$limite = $pag * @$itens_por_pagina;
$pagina = $pag;
$nome_pag = 'lista-produtos.php';
?>


<?php 
//recuperar o nome da subcat para filtrar os produtos
$subcategoria_get = @$_GET['nome'];
$query = $pdo->query("SELECT * FROM sub_categorias where nome_url = '$subcategoria_get' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_subcategoria = @$res[0]['id'];
 ?>


 <?php 
//recuperar o valor inicial e valor final para filtrar produto
$valor_inicial = @$_GET['valor-inicial'];
$valor_final = @$_GET['valor-final'];
 ?>

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Categorias</h4>
                        <ul>
                            <?php 
                            $query = $pdo->query("SELECT * FROM categorias order by nome asc ");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < count($res); $i++) { 
                              foreach ($res[$i] as $key => $value) {
                              }

                              $nome = $res[$i]['nome'];

                              $nome_url = $res[$i]['nome_url'];

                              ?>
                              <li><a href="sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>

                          <?php } ?>

                      </ul>
                  </div>

                  <div class="sidebar__item">
                    <h4>Sub Categorias</h4>
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

    </div>
</div>


<div class="col-lg-9 col-md-7">

    <div class="row">

        <div class="hero__search__form mb-4">
            <form action="lista-produtos.php" method="GET">

                <input type="text" name="txtBuscar" placeholder="Deseja buscar um Produto?" value="<?php echo @$_GET['txtBuscar'] ?>">
                <button type="submit" class="site-btn">BUSCAR</button>
            </form>
        </div>
    </div>


   


        <?php
        if(@$_GET['txtBuscar'] != "") {
            $buscar = '%'.@$_GET['txtBuscar'].'%';

        }else{
            $buscar = '%';
        }
        
        if($subcategoria_get == "" and $valor_inicial == "") {
        $query = $pdo->query("SELECT * FROM produtos where (nome LIKE '$buscar' or palavras like '$buscar') and ativo = 'Sim' and estoque > 0 order by id desc LIMIT $limite, $itens_por_pagina ");
        }else if($valor_inicial != ""){
            $query = $pdo->query("SELECT * FROM produtos where valor >= '$valor_inicial' and valor <= '$valor_final' and ativo = 'Sim' and estoque > 0 order by id desc");
        }

        else{
            $query = $pdo->query("SELECT * FROM produtos where sub_categoria = '$id_subcategoria' and ativo = 'Sim' and estoque > 0 order by id desc");
        }
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_prod = @count($res);
        if(@$_GET['txtBuscar'] != "" or @$id_subcategoria!= "" or @$valor_inicial!= "") {
        echo $total_prod.' Produtos Encontrados!';
        }

        echo '<div class="row mt-4">';

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

   //BUSCAR O TOTAL DE REGISTROS PARA PAGINAR
          $query3 = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and estoque > 0");
          $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
          $num_total = @count($res3);
          $num_paginas = ceil($num_total/$itens_por_pagina);

          if($promocao == 'Sim'){
            $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
            $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
            $valor_promo = $resp[0]['valor'];
            $desconto = $resp[0]['desconto'];
            $valor_promo = number_format($valor_promo, 2, ',', '.');




            ?>

            <div class="col-lg-4 col-md-6 col-sm-6">
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
       <div class="featured__item">
        <div class="featured__item__pic set-bg" data-setbg="img/produtos/<?php echo $imagem ?>">
            <ul class="featured__item__pic__hover">
                <li><a href="produto-<?php echo $nome_url ?>"><i class="fa fa-eye"></i></a></li>
                <li><a href="" onclick="carrinhoModal('<?php echo $id ?>','Não')"><i class="fa fa-shopping-cart"></i></a>
            </ul>
        </div>
        <div class="featured__item__text">
            <a href="produto-<?php echo $nome_url ?>"><h6><?php echo $nome ?></h6>
                <h5>R$ <?php echo $valor ?></h5></a>
            </div>
        </div>
    </div>

<?php } } ?>



</div>

<?php if(@$_GET['txtBuscar'] == "" and @$id_subcategoria == "" and @$valor_inicial == ""){ ?>
<div class="product__pagination">
                <a href="<?php echo $nome_pag ?>?pagina=0"><i class="fa fa-long-arrow-left"></i></a>

                <?php 
                    for($i = 0; $i < @$num_paginas; $i++){
                        $estilo = '';
                        if($pagina == $i){
                            $estilo = 'bg-info text-light';
                        }

                        if($pagina >= ($i - 2) && $pagina <= ($i + 2)){ ?>
                         <a href="<?php echo $nome_pag ?>?pagina=<?php echo $i ?>" class="<?php echo $estilo ?>"><?php echo $i + 1 ?></a>

                       <?php } 

                    }
                 ?>
                
                
                <a href="<?php echo $nome_pag ?>?pagina=<?php echo $num_paginas - 1 ?>"><i class="fa fa-long-arrow-right"></i></a>
 </div>
<?php } ?>


</div>
</div>
</div>
</section>
<!-- Product Section End -->

<?php

require_once("rodape.php");
require_once("modal-carrinho.php");
?>