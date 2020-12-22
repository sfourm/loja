<?php 
require_once("conexao.php");
 ?>
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
                          <li><a href="sub-categoria-de-<?php echo $nome_url ?>"><?php echo $nome ?></a></li>

                          <?php } ?>
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
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->