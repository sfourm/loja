<?php 
$pag = "produtos";
require_once("../../conexao.php"); 
@session_start();

//VERIFICAR SE O USUÁRIO ESTÁ AUTENTICADO
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
  echo "<script language='javascript'> window.location='../index.php' </script>";
}
$agora = date('Y-m-d');
?>

<div class="row mt-4 mb-4">
  <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Produto</a>
  <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Valor</th>
            <th>Estoque</th>
            <th>SubCategoria</th>
            <th>Imagem</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          <?php 
          $query = $pdo->query("SELECT * FROM produtos order by id desc ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          for ($i=0; $i < count($res); $i++) { 
            foreach ($res[$i] as $key => $value) {}
            $nome = $res[$i]['nome'];
            $valor = $res[$i]['valor'];
            $estoque = $res[$i]['estoque'];
            $sub_cat = $res[$i]['sub_categoria'];
            $imagem = $res[$i]['imagem'];
            $ativo = $res[$i]['ativo'];
            $promocao = $res[$i]['promocao'];
            $id = $res[$i]['id'];
            $valor = number_format($valor, 2, ',', '.');

            //recuperar o nome da categoria
            $query2 = $pdo->query("SELECT * from sub_categorias where id = '$sub_cat' ");
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            @$nome_cat = $res2[0]['nome'];

            $classe = "";
            if($ativo == "Sim"){
              $classe = "text-success";
            }else{
              $classe = "text-secondary";
            }
          ?>
          <tr>
            <td>
              <i class='fas fa-square <?php echo $classe ?>'></i>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=carac&id=<?php echo $id ?>" class="text-info"><?php echo $nome ?></a>
            </td>
            <td>R$ <?php echo $valor ?></td>
            <td><?php echo $estoque ?></td>
            <td><?php echo $nome_cat ?></td>
            <td><img src="../../img/produtos/<?php echo $imagem ?>" width="50"></td>

            <td>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=imagens&id=<?php echo $id ?>" class='text-info mr-1' title='Inserir Imagens'><i class='fas fa-images'></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=promocao&id=<?php echo $id ?>" class=' mr-1' title='Adicionar Promoção'>
                <?php if($promocao == 'Sim'){
                  echo "<i class='fas fa-coins text-success'></i>";
                }else{
                  echo "<i class='fas fa-coins text-danger'></i>";
                } ?>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 
        if (@$_GET['funcao'] == 'editar') {
          $titulo = "Editar Registro";
          $id2 = $_GET['id'];
          $query = $pdo->query("SELECT * FROM produtos where id = '" . $id2 . "' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $nome2 = $res[0]['nome'];
          $imagem2 = $res[0]['imagem'];
          $sub_cat2 = $res[0]['sub_categoria'];
          $valor2 = $res[0]['valor'];
          $estoque2 = $res[0]['estoque'];
          $descricao2 = $res[0]['descricao'];
          $desc_longa2 = $res[0]['descricao_longa'];
          $tipo_envio2 = $res[0]['tipo_envio'];
          $palavras2 = $res[0]['palavras'];
          $ativo2 = $res[0]['ativo'];
          $peso2 = $res[0]['peso'];
          $largura2 = $res[0]['largura'];
          $altura2 = $res[0]['altura'];
          $comprimento2 = $res[0]['comprimento'];
          $modelo2 = $res[0]['modelo'];
          $valor_frete2 = $res[0]['valor_frete'];
          $nome_cat2 = $res[0]['categoria'];
          $link2 = $res[0]['link'];
        } else {
          $titulo = "Inserir Registro";
        }
        ?>
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label >Nome</label>
                <input value="<?php echo @$nome2 ?>" type="text" class="form-control form-control-sm" id="nome-cat" name="nome-cat" placeholder="Nome">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Categoria</label>
                <select class="form-control form-control-sm" name="categoria" id="categoria">
                  <?php 
                  if (@$_GET['funcao'] == 'editar') {
                    $query = $pdo->query("SELECT * from categorias where id = '$nome_cat2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nomeCat = $res[0]['nome'];
                    echo "<option value='".$nome_cat2."' >" . $nomeCat . "</option>";
                  }
                  $query2 = $pdo->query("SELECT * from categorias order by nome asc ");
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  for ($i=0; $i < count($res2); $i++) { 
                    foreach ($res2[$i] as $key => $value) {
                    }
                    if(@$nomeCat != $res2[$i]['nome']){
                    echo "<option value='".$res2[$i]['id']."' >" . $res2[$i]['nome'] . "</option>"; 
                    }
                  }
                  ?>
                </select>
                <input  type="hidden" id="txtCat" name="txtCat">
                <input value="<?php echo @$sub_cat2 ?>" type="hidden" id="txtSub" name="txtSub">
              </div>
            </div>
           
            <div class="col-md-4">
              <div class="form-group">
                <label >Sub Categoria</label>
                <span id="listar-subcat"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label >Descrição Curta <small>(500 caracteres)</small></label>
            <textarea maxlength="500" class="form-control form-control-sm" id="descricao" name="descricao" ><?php echo @$descricao2 ?></textarea>
          </div>

          <div class="form-group">
            <label >Descrição Longa </label>
            <textarea  class="form-control form-control-sm" id="descricao_longa" name="descricao_longa" ><?php echo @$desc_longa2 ?></textarea>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label >Valor</label>
                <input value="<?php echo @$valor2 ?>" type="text" class="form-control form-control-sm" id="valor" name="valor" placeholder="Valor">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Estoque</label>
                <input value="<?php echo @$estoque2 ?>" type="text" class="form-control form-control-sm" id="estoque" name="estoque" placeholder="Quantidade">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Tipo Envio</label>
                <select class="form-control form-control-sm" name="tipo_envio" id="tipo_envio">
                  <?php 
                    if (@$_GET['funcao'] == 'editar') {
                      $query = $pdo->query("SELECT * from tipo_envios where id = '$tipo_envio2' ");
                      $res = $query->fetchAll(PDO::FETCH_ASSOC);
                      $nomeTipo = $res[0]['nome'];
                      echo "<option value='".$tipo_envio2."' >" . $nomeTipo . "</option>";
                    }
                    $query2 = $pdo->query("SELECT * from tipo_envios order by nome asc ");
                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($res2); $i++) { 
                      foreach ($res2[$i] as $key => $value) {
                      }
                      if(@$nomeTipo != $res2[$i]['nome']){
                        echo "<option value='".$res2[$i]['id']."' >" . $res2[$i]['nome'] . "</option>"; 
                      }
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Ativo</label>
                <select class="form-control form-control-sm" name="ativo" id="ativo">
                  <?php 
                    if (@$_GET['funcao'] == 'editar') {
                      echo "<option value='".$ativo2."' >" . $ativo2 . "</option>";
                    }

                    if(@$ativo2 != "Sim"){
                    echo "<option value='Sim'>Sim</option>"; 
                    }

                    if(@$ativo2 != "Não"){
                      echo "<option value='Não'>Não</option>"; 
                    }
                  ?>
                </select>               
              </div>
            </div>
          </div>

          <div class="form-group">
            <label >Palavras Chaves</label>
            <input value="<?php echo @$palavras2 ?>" type="text" class="form-control form-control-sm" id="palavras" name="palavras" placeholder="Palavras Chave">
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
              <label >Peso <small><small>(em KG - Ex: 200g seria 0.2)</small></small></label>
              <input value="<?php echo @$peso2 ?>" type="text" class="form-control form-control-sm" id="peso" name="peso" placeholder="Peso em KG">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Largura</label>
                <input value="<?php echo @$largura2 ?>" type="text" class="form-control form-control-sm" id="largura" name="largura" placeholder="Largura">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Altura</label>
                <input value="<?php echo @$altura2 ?>" type="text" class="form-control form-control-sm" id="altura" name="altura" placeholder="Altura">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label >Comprimento</label>
                <input value="<?php echo @$comprimento2 ?>" type="text" class="form-control form-control-sm" id="comprimento" name="comprimento" placeholder="Comprimento">
              </div>
            </div>
          </div>      

          <div class="form-group">
              <label >Link <small>(Se for Produto Digital)</small></label>
              <input value="<?php echo @$link2 ?>" type="text" class="form-control form-control-sm" id="link" name="link" placeholder="Link para Produto Digital">
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label >Modelo</label>
                <input value="<?php echo @$modelo2 ?>" type="text" class="form-control form-control-sm" id="modelo" name="modelo" placeholder="Modelo">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label >Valor Frete</label>
                <input value="<?php echo @$valor_frete2 ?>" type="text" class="form-control form-control-sm" id="valor-frete" name="valor-frete" placeholder="Valor Fixo Frete">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label >Imagem</label>
                <input type="file" value="<?php echo @$imagem2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
              </div>
              <?php if(@$imagem2 != ""){ ?>
                <img src="../../img/produtos/<?php echo $imagem2 ?>" width="100" height="100" id="target">
              <?php  }else{ ?>
                <img src="../../img/produtos/sem-foto.jpg" width="100" height="100" id="target">
              <?php } ?>
            </div>
          </div>
          <small><div id="mensagem"></div></small> 
        </div>
        <div class="modal-footer">
          <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
          <input value="<?php echo @$nome2 ?>" type="hidden" name="antigo" id="antigo">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deseja realmente Excluir este Registro?</p>
        <div id="mensagem_excluir" class="text-center">

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
        <form method="post">
          <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>
          <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>






<div class="modal" id="modal-imagens" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imagens do Produto</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-fotos" method="POST" enctype="multipart/form-data" >
          <div class="row">
            <div class="col-md-5">
              <div class="col-md-12 form-group">
                <label>Imagem do Produto</label>
                <input type="file" class="form-control-file" id="imgproduto" name="imgproduto" onchange="carregarImgProduto();">
              </div>

              <div class="col-md-12 mb-2">
                <img src="../../img/produtos/detalhes/sem-foto.jpg" alt="Carregue sua Imagem" id="targetImgProduto" width="100%">
              </div>
            </div>
            <div class="col-md-7" id="listar-img"></div>
          </div>

          <div class="col-md-12" class="text-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-fotos">Cancelar</button>
            <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>">
            <button type="submit" id="btn-fotos" name="btn-fotos" class="btn btn-info">Salvar</button>
          </div>
          <small><div id="mensagem_fotos" class="text-center"></div></small>   
        </form>
      </div>
    </div>
  </div>
</div>   

<div class="modal" id="modalDeletarImg" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deseja realmente Excluir esta Imagem?</p>
        <div id="mensagem_excluir_img" class="text-center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-img">Cancelar</button>
        <form method="post">
          <input type="hidden" name="id_foto" id="id_foto">                  
          <button type="button" id="btn-deletar-img" name="btn-deletar-img" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-carac" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Característica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="form-carac">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >Característica</label>
                <select class="form-control form-control-sm" name="caract" id="caract">
                  <?php 
                  $query2 = $pdo->query("SELECT * from carac order by nome asc ");
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  for ($i=0; $i < count($res2); $i++) { 
                    foreach ($res2[$i] as $key => $value) {
                    }
                    echo "<option value='".$res2[$i]['id']."' >" . $res2[$i]['nome'] . "</option>"; 
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6" id="listar-carac"></div>
          </div>
          <small><div id="mensagem_carac" class="text-center"></div></small>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-carac">Cancelar</button>
            <input type="hidden" id="txtid"  name="txtid" value="<?php echo @$_GET['id'] ?>">
            <button type="button" id="btn-add-carac" name="btn-add-carac" class="btn btn-info">Adicionar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDeletarCarac" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Característica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deseja realmente Excluir esta Característica?</p>
        <div id="mensagem_excluir_carac" class="text-center"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-carac-deletar">Cancelar</button>
        <form method="post">
          <input type="hidden" name="id_carac" id="id_carac">                  
          <button type="button" id="btn-deletar-carac" name="btn-deletar-carac" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalAddItem" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="form-item-listar">
          <input type="hidden" name="id_carac_item_2" id="id_carac_item_2">
          <a id="btn-item-listar" name="btn-item-listar">
          </a>
        </form>
        <form method="post" id="form-item">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >*Descrição</label>
                <input value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome-item" name="nome-item" placeholder="Descrição do item">
              </div>

              <div class="form-group">
                <label >Valor Item <small>Se Existir - (Ex: Código Hexadecimal da Cor)<small></label>
                <input value="<?php echo @$nome2 ?>" type="text" class="form-control" id="valor-item" name="valor-item" placeholder="Valor Item Ex #FFFFFF">
              </div>
            </div>

            <div class="col-md-12" id="listar-itens"></div>
          </div>
          <div id="mensagem_item" class="text-center"></div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-item">Cancelar</button>
            <input type="hidden" name="id_carac_item" id="id_carac_item">                  
            <button type="button" id="btn-item" name="btn-item" class="btn btn-info">Adcionar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDeletarItem" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deseja realmente Excluir este Item?</p>
        <div id="mensagem_excluir_item" class="text-center">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-item-deletar">Cancelar</button>
        <form method="post">
          <input type="hidden" name="id_item_carac" id="id_item_carac">                  
          <button type="button" id="btn-deletar-item" name="btn-deletar-item" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalPromocao" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Promoção</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $id_pro = @$_GET['id'];
        $res = $pdo->query("SELECT * FROM promocoes where id_produto = '$id_pro'"); 
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        if(@count($dados) > 0){
          $valor_promo = $dados[0]['valor'];
          $data_ini = $dados[0]['data_inicio'];
          $data_fin = $dados[0]['data_final'];
          $ativo2 = $dados[0]['ativo'];
          $desconto = $dados[0]['desconto'];
          $editar = 'sim';
          $texto_promocao = 'Valor Promocional deste Produto - '.$valor_promo;
        }else{
          $editar = 'não';
          $data_ini = $agora;
          $data_fin = $agora;
        }
        ?>
        <form method="post" id="form-promocao">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >% do Desconto <small>(Ex: 20, 30)</small></label>
                <input  type="number" class="form-control" id="valor-promocao" name="valor-promocao" placeholder="Valor em % Ex 15" value="<?php echo @$desconto ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label >Ativo</label>
                <select class="form-control form-control-sm" name="ativo-promocao" id="ativo-promocao">
                  <?php 
                    if (@$editar == 'sim') {

                      echo "<option value='".$ativo2."' >" . $ativo2 . "</option>";
                    }

                    if(@$ativo2 != "Sim"){
                    echo "<option value='Sim'>Sim</option>"; 
                    }

                    if(@$ativo2 != "Não"){
                      echo "<option value='Não'>Não</option>"; 
                    }
                  ?>
                </select>               
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >Data Inicio</label>
                <input  type="date" class="form-control" id="data-inicial-promocao" name="data-inicial-promocao" value="<?php echo $data_ini ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label >Data Final</label>
                <input  type="date" class="form-control" id="data-final-promocao" name="data-final-promocao" value="<?php echo $data_fin ?>">
              </div>
            </div>
          </div>
          <p class="text-success"><?php echo @$texto_promocao ?></p>
          <div id="mensagem_promocao" class="text-center"></div>
        
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-promocao">Cancelar</button>
            <input type="hidden" name="id-promocao" id="id-promocao" value="<?php echo @$_GET['id'] ?>">                  
            <button type="button" id="btn-promocao" name="btn-promocao" class="btn btn-info">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php 
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
  echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
  echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
  echo "<script>$('#modal-deletar').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "imagens") {
  echo "<script>$('#modal-imagens').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "carac") {
  echo "<script>$('#modal-carac').modal('show'); </script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "promocao") {
  echo "<script>$('#modalPromocao').modal('show'); </script>";
}
?>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,
      success: function (mensagem) {
        $('#mensagem').removeClass()
        if (mensagem.trim() == "Salvo com Sucesso!!") {
          //$('#nome').val('');
          //$('#cpf').val('');
          $('#btn-fechar').click();
          window.location = "index.php?pag="+pag;
        } else {
          $('#mensagem').addClass('text-danger')
        }
        $('#mensagem').text(mensagem)
      },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {  // Custom XMLHttpRequest
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
        myXhr.upload.addEventListener('progress', function () {
          /* faz alguma coisa durante o progresso do upload */
        }, false);
      }
      return myXhr;
      }
    });
  });
</script>

<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
  $(document).ready(function () {
    var pag = "<?=$pag?>";
    $('#btn-deletar').click(function (event) {
      event.preventDefault();
      $.ajax({
        url: pag + "/excluir.php",
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() === 'Excluído com Sucesso!!') {
            $('#btn-cancelar-excluir').click();
            window.location = "index.php?pag=" + pag;
          }
          $('#mensagem_excluir').text(mensagem)
        },
      })
    })
  })
</script>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-fotos").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: pag + "/inserir-imagens.php",
      type: 'POST',
      data: formData,
      success: function (mensagem) {
        $('#mensagem').removeClass()
        if (mensagem.trim() == "Salvo com Sucesso!!") {
         $('#mensagem_fotos').addClass('text-success')
         $('#mensagem_fotos').text(mensagem)
         listarImagensProd();
       } else {
        $('#mensagem_fotos').addClass('text-danger')
      }
      $('#mensagem_fotos').text(mensagem)
    },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {  // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function () {
            /* faz alguma coisa durante o progresso do upload */
          }, false);
        }
        return myXhr;
      }
    });
  });
</script>

<script type="text/javascript">
  function listarImagensProd() {
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/listar-imagens.php",
      method: "post",
      data: $('form').serialize(),
      dataType: "html",
      success: function (result) {
        $('#listar-img').html(result);
      }
    })
  }
</script>

<script type="text/javascript">
  function listarCarac() {
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/listar-carac.php",
      method: "post",
      data: $('#form-carac').serialize(),
      dataType: "html",
      success: function (result) {
        $('#listar-carac').html(result);
      }
    })
  }
</script>

<script type="text/javascript">
  $('#btn-item-listar').click(function(event){
    event.preventDefault();
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/listar-itens.php",
      method: "post",
      data: $('#form-item-listar').serialize(),
      dataType: "html",
      success: function (result) {
        $('#listar-itens').html(result);
      }
    })
  })
</script>

<!--FUNCAO PARA CHAMAR MODAL DE DELETAR IMAGEM DAS FOTOS -->
<script type="text/javascript">
  function deletarImg(img) {
    document.getElementById('id_foto').value = img;
    $('#modalDeletarImg').modal('show');
  }
</script>

<!--FUNCAO PARA CHAMAR MODAL DE DELETAR CARAC DOS PRODUTOS -->
<script type="text/javascript">
  function deletarCarac(id) {
    document.getElementById('id_carac').value = id;
    $('#modalDeletarCarac').modal('show');
  }
</script>

<!--FUNCAO PARA CHAMAR MODAL DE DELETAR ITEM DA CARAC -->
<script type="text/javascript">
  function deletarItem(id) {
    document.getElementById('id_item_carac').value = id;
    $('#modalDeletarItem').modal('show');
  }
</script>

<!--FUNCAO PARA CHAMAR MODAL DE ADD ITEM A CARAC -->
<script type="text/javascript">
  function addItem(id) {
    document.getElementById('id_carac_item').value = id;
    document.getElementById('id_carac_item_2').value = id;
    $('#btn-item-listar').click();
    $('#modalAddItem').modal('show');
  }
</script>

<!--AJAX PARA EXCLUSÃO DAS IMAGENS -->
<script type="text/javascript">
  $(document).ready(function () {
    var pag = "<?=$pag?>";
    $('#btn-deletar-img').click(function (event) {
      event.preventDefault();
      $.ajax({
        url: pag + "/excluir-imagem.php",
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() === 'Excluído com Sucesso!!') {
            $('#mensagem_fotos').text(mensagem)
            $('#btn-cancelar-img').click();
            listarImagensProd();
          }
          $('#mensagem_excluir_img').text(mensagem)
        },
      })
    })
  })
</script>

<!--AJAX PARA EXCLUSÃO DAS CARAC -->
<script type="text/javascript">
  $(document).ready(function () {
    var pag = "<?=$pag?>";
    $('#btn-deletar-carac').click(function (event) {
      event.preventDefault();
      $.ajax({
        url: pag + "/excluir-carac.php",
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() === 'Excluído com Sucesso!!') {
            $('#btn-cancelar-carac-deletar').click();
            $('#mensagem_carac').text(mensagem)
            listarCarac();
          }
          $('#mensagem_excluir_carac').text(mensagem)
        },
      })
    })
  })
</script>

<!--AJAX PARA EXCLUSÃO DOS ITENS -->
<script type="text/javascript">
  $(document).ready(function () {
    var pag = "<?=$pag?>";
    $('#btn-deletar-item').click(function (event) {
      event.preventDefault();
      $.ajax({
        url: pag + "/excluir-item.php",
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function (mensagem) {
          if (mensagem.trim() === 'Excluído com Sucesso!!') {
            $('#btn-cancelar-item-deletar').click();
            $('#mensagem_item').text(mensagem)
            $('#btn-item-listar').click();
          }
          $('#mensagem_excluir_item').text(mensagem)
        },
      })
    })
  })
</script>

<!--SCRIPT QUE É EXECUTADO AO CARREGAR A PÁGINA -->
<script type="text/javascript">
  $(document).ready(function () {
    listarImagensProd();
    listarCarac();
    document.getElementById('txtCat').value = document.getElementById('categoria').value;
    listarSubCat();
  })
</script>

<script type="text/javascript">
  function listarSubCat() {
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/listar-subcat.php",
      method: "post",
      data: $('form').serialize(),
      dataType: "html",
      success: function (result) {
        $('#listar-subcat').html(result);
      }
    })
  }
</script>

<!-- Script para buscar pelo select -->
<script type="text/javascript">
  $('#categoria').change(function () {
    document.getElementById('txtCat').value = $(this).val();
    document.getElementById('txtSub').value = "";
    listarSubCat();
  })
</script>

<!--SCRIPT PARA CARREGAR IMAGEM PRINCIPAL -->
<script type="text/javascript">
  function carregarImg() {
    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
      target.src = reader.result;
    };
    if (file) {
      reader.readAsDataURL(file);
    } else {
      target.src = "";
    }
  }
</script>

<!--SCRIPT PARA CARREGAR IMAGENS DO PRODUTO -->
<script type="text/javascript">
  function carregarImgProduto() {
    var target = document.getElementById('targetImgProduto');
    var file = document.querySelector("input[id=imgproduto]").files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
      target.src = reader.result;
    };
    if (file) {
      reader.readAsDataURL(file);
    } else {
      target.src = "";
    }
  }
</script>

<script type="text/javascript">
  $('#btn-add-carac').click(function(event){
    event.preventDefault();
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/add-carac.php",
      method:"post",
      data: $('#form-carac').serialize(),
      dataType: "text",
      success: function(msg){
        if(msg.trim() === 'Salvo com Sucesso!!'){
          $('#mensagem_carac').addClass('text-success')
          $('#mensagem_carac').text(msg);
          listarCarac();
        }
        else{
          $('#mensagem_carac').addClass('text-danger')
          $('#mensagem_carac').text(msg);
        }
      }
    })
  })
</script>

<script type="text/javascript">
  $('#btn-item').click(function(event){
    event.preventDefault();
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/add-item.php",
      method:"post",
      data: $('#form-item').serialize(),
      dataType: "text",
      success: function(msg){
        if(msg.trim() === 'Salvo com Sucesso!!'){
          $('#mensagem_item').addClass('text-success')
          $('#mensagem_item').text(msg);
          $('#btn-item-listar').click();
          document.getElementById('nome-item').value = "";
          document.getElementById('nome-item').focus();
        }
        else{
          $('#mensagem_item').addClass('text-danger')
          $('#mensagem_item').text(msg);
        }
      }
    })
  })
</script>

<script type="text/javascript">
  $('#btn-promocao').click(function(event){
    event.preventDefault();
    var pag = "<?=$pag?>";
    $.ajax({
      url: pag + "/add-promocao.php",
      method:"post",
      data: $('#form-promocao').serialize(),
      dataType: "text",
      success: function(msg){
        if(msg.trim() === 'Salvo com Sucesso!!'){
          $('#btn-cancelar-promocao').click();
          window.location = "index.php?pag="+pag;
        }
        else{
          $('#mensagem_promocao').addClass('text-danger')
          $('#mensagem_promocao').text(msg);
        }
      }
    })
  })
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })
  });
</script>