<?php
require_once("cabecalho.php");
?>

<?php
require_once("cabecalho-busca.php");
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
$nome_pag = 'promocoes.php';
 ?>

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">

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




              </div>
          </div>


          <div class="col-lg-9 col-md-7">

<h5>Produtos em Promoções</h5>

            <div class="row mt-4">

              <?php 
             $query = $pdo->query("SELECT * FROM produtos where promocao = 'Sim' and ativo = 'Sim' and estoque > 0 order by id LIMIT $limite, $itens_por_pagina");
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

              $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id' ");
              $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
              $valor_promo = $resp[0]['valor'];
              $desconto = $resp[0]['desconto'];
              $valor_promo = number_format($valor_promo, 2, ',', '.');
                  
                  //BUSCAR O TOTAL DE REGISTROS PARA PAGINAR
                  $query3 = $pdo->query("SELECT * FROM produtos where promocao = 'Sim' and ativo = 'Sim' and estoque > 0 ");
                  $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                  $num_total = @count($res3);
                  $num_paginas = ceil($num_total/$itens_por_pagina);

                  ?>

                  <div class="col-lg-4 col-md-6 col-sm-6 mt-4">
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

                <?php } ?>






            </div>
            <div class="product__pagination">
                <a href="<?php echo $nome_pag ?>?pagina=0"><i class="fa fa-long-arrow-left"></i></a>

                <?php 
                    for($i = 0; $i < @$num_paginas; $i++){
                        $estilo = '';
                        if($pagina == $i){
                            $estilo = 'bg-dark text-light';
                        }

                        if($pagina >= ($i - 2) && $pagina <= ($i + 2)){ ?>
                         <a href="<?php echo $nome_pag ?>?pagina=<?php echo $i ?>" class="<?php echo $estilo ?>"><?php echo $i + 1 ?></a>

                       <?php } 

                    }
                 ?>
                
                
                <a href="<?php echo $nome_pag ?>?pagina=<?php echo @$num_paginas - 1 ?>"><i class="fa fa-long-arrow-right"></i></a>
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