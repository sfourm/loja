<?php 
    //TRAZER PALAVRAS CHAVES PARA POSTAGEM
    require_once("conexao.php");
    @session_start();

    $id_usuario = @$_SESSION['id_usuario'];
    $nivel_usuario = @$_SESSION['nivel_usuario'];
    $postagem_get = @$_GET['nome'];
    $query = $pdo->query("SELECT * FROM blog where nome_url = '$postagem_get' ");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $palavras = $res[0]['palavras'];
?>

<?php
    require_once("cabecalho.php");
?>

<?php
    require_once("cabecalho-busca.php");
?>

<?php 
    $query = $pdo->query("SELECT * FROM blog where nome_url = '$postagem_get' ");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $titulo = $res[0]['titulo'];
    $descricao_1 = $res[0]['descricao_1'];
    $descricao_2 = $res[0]['descricao_2'];
    $data = $res[0]['data'];
    $imagem = $res[0]['imagem'];
    $id_blog = $res[0]['id'];
    $data = implode('/', array_reverse(explode('-', $data)));

    //pegar os dados do Admin
    $query = $pdo->query("SELECT * FROM usuarios where nivel = 'Admin'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $nome_admin = $res[0]['nome'];
    $imagem_admin = $res[0]['imagem'];
?>
<!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 order-md-1 order-2">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__item">
                            <h4>Categorias</h4>
                            <ul>
                                <?php 
                                $query = $pdo->query("SELECT * FROM categorias order by nome asc ");
                                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                for ($i=0; $i < count($res); $i++) { 
                                foreach ($res[$i] as $key => $value) {}
                                $nome = $res[$i]['nome'];
                                $nome_url = $res[$i]['nome_url'];
                                ?>

                                <li><a href="sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="blog__sidebar__item">
                            <h4>Sub Categorias</h4>
                            <ul>
                                <?php 
                                $query = $pdo->query("SELECT * FROM sub_categorias order by nome asc ");
                                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                for ($i=0; $i < count($res); $i++) { 
                                foreach ($res[$i] as $key => $value) {}
                                
                                $nome = $res[$i]['nome'];
                                $nome_url = $res[$i]['nome_url'];
                                ?>
                                
                                <li><a href="produtos-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 order-md-1 order-1">
                    <div class="blog__details__text">
                        <img src="img/blog/<?php echo $imagem ?>" alt="">
                        <p><?php echo $descricao_1 ?></p>
                        <h3><?php echo $titulo ?></h3>
                        <p><?php echo $descricao_2 ?></p>
                    </div>
                    <div class="blog__details__content mb-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="blog__details__author">
                                    <div class="blog__details__author__pic">
                                        <img src="img/<?php echo @$imagem_admin ?>" alt="">
                                    </div>
                                    <div class="blog__details__author__text">
                                        <h6><?php echo @$nome_admin ?></h6>
                                        <span>Admin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if($id_usuario == null || $id_usuario == ""){
                            echo '<span class="mt-4">Deseja comentar a Postagem? Clique <a target="_blank" href="sistema" class="text-info"> aqui </a> para fazer Login ou se Cadastrar!</span>';
                        }else{
                    ?>

                    <div class="mb-4">
                        <form method="post">
                        <div class="form-group">
                            <label >Comentário <small>(Máx 500 Caracteres)</small> </label>
                            <textarea maxlength="1000" class="form-control" id="comentario" name="comentario"></textarea>
                        </div>
                        <div class="mt-1 text-right">
                        <button type="submit" name="btn-comentario" id="btn-comentario" class="btn btn-info">Publicar</button>
                        </div>
                        </form>
                    </div>

                    <div class="">
                        <h5>Comentários</h5>
                        <div class="mt-4">

                            <?php 
                                $query4 = $pdo->query("SELECT * from coment_blog where id_blog = '$id_blog' order by id desc");
                                $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                                for ($i2=0; $i2 < count($res4); $i2++) { 
                                    foreach ($res4[$i2] as $key => $value) {}

                                    $id_usu = $res4[$i2]['id_usuario'];
                                    $texto = $res4[$i2]['comentario'];
                                    $id_com = $res4[$i2]['id'];
                                    $data = $res4[$i2]['data'];
                                    $hora = $res4[$i2]['hora'];
                                    $data = implode('/', array_reverse(explode('-', $data)));

                                    $query = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                    $nome_cliente = $res[0]['nome'];
                            ?>

                                <div class="mb-4">
                                    <span class="mr-2"><u><i><?php echo $nome_cliente ?></i></u></span>
                                    <span class="text-muted"><i><small><?php echo $data ?> às </small></i></span>

                                    <span class="text-muted mr-2"><i><small> <?php echo $hora ?></small></i></span>
                                        <?php 
                                            if($nivel_usuario == 'Admin'){
                                        ?>
                                            <a href="blog-postagem.php?nome=<?php echo $postagem_get ?>&acao=deletar&id_coment=<?php echo $id_com ?>"><i class="fa fa-trash  text-danger"></i></a>
                                        <?php } ?>
                                    <br>
                                    <span class="text-muted"><i><small><?php echo $texto ?></small></i></span>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Related Blog Section Begin -->
    <section class="related-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-blog-title">
                        <h2>Postagens Recentes</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
                    $query = $pdo->query("SELECT * FROM blog where nome_url != '$postagem_get' order by id desc LIMIT 3");
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
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
<!-- Related Blog Section End -->

<?php 
  if(isset($_POST['btn-comentario'])){
    $comentario = $_POST['comentario'];
    $pdo->query("INSERT INTO coment_blog (id_blog, id_usuario, comentario, data, hora) VALUES ('$id_blog', '$id_usuario', '$comentario', curDate(), curTime())");
    echo "<script language='javascript'> window.location='blog-postagem.php?nome=$postagem_get' </script>";
}
?>

<?php 
  if(@$_GET['acao'] == 'deletar'){
    $id = $_GET['id_coment'];
    $pdo->query("DELETE from coment_blog WHERE id = '$id'");

    echo "<script language='javascript'> window.location='blog-postagem.php?nome=$postagem_get' </script>";   
}
?>
<?php
require_once("rodape.php");
?>