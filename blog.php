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
    $nome_pag = 'blog.php';
?>

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">

                <?php 
                    $query = $pdo->query("SELECT * FROM blog order by id desc LIMIT $limite, $itens_por_pagina");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i=0; $i < count($res); $i++) { 
                        foreach ($res[$i] as $key => $value) {}

                        $titulo = $res[$i]['titulo'];
                        $imagem = $res[$i]['imagem'];
                        $data = $res[$i]['data'];
                        $id = $res[$i]['id'];
                        $nome_url = $res[$i]['nome_url'];
                        $data = implode('/', array_reverse(explode('-', $data)));
                        $query2 = $pdo->query("SELECT * FROM coment_blog where id_blog = '$id' ");
                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $total_itens = @count($res2);

                        //BUSCAR O TOTAL DE REGISTROS PARA PAGINAR
                        $query3 = $pdo->query("SELECT * FROM blog ");
                        $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                        $num_total = @count($res3);
                        $num_paginas = ceil($num_total/$itens_por_pagina);
                ?>

                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/<?php echo $imagem ?>" width="100%" height="250" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> <?php echo $data ?></li>
                                <li><i class="fa fa-comment-o"></i> <?php echo $total_itens ?></li>
                            </ul>
                            <h5><a href="postagem-<?php echo $nome_url ?>"><?php echo $titulo ?></a></h5>
                            <a href="postagem-<?php echo $nome_url ?>" class="blog__btn">VEJA MAIS <span class="arrow_right"></span></a>
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
                
                <a href="<?php echo $nome_pag ?>?pagina=<?php echo $num_paginas - 1 ?>"><i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

   <?php
require_once("rodape.php");
?>