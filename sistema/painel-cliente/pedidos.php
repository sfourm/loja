<?php 
$pag = "pedidos";
require_once("../../conexao.php"); 
require_once("../../pagamentos/pagseguro/PagSeguro.class.php");
$PagSeguro = new PagSeguro();

@session_start();
$id_usuario = @$_SESSION['id_usuario'];
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente'){
  echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>



<!-- DataTales Example -->
<div class="card shadow mb-4">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Data</th>
            <th>Total</th>
            <th>Pago</th>
            <th>Status</th>
            <th>Produtos</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>

         <?php 

         $query_ped = $pdo->query("SELECT * FROM vendas where id_usuario = '$id_usuario' order by id desc ");
         $res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);

         for ($i=0; $i < @count($res_ped); $i++) { 
          foreach ($res_ped[$i] as $key => $value) {
          }

          $data = $res_ped[$i]['data'];
          $total = $res_ped[$i]['total'];
          $pago = $res_ped[$i]['pago'];
          $status = $res_ped[$i]['status'];
          $rastreio = $res_ped[$i]['rastreio'];
          $id_venda = $res_ped[$i]['id'];

                       //VERIFICAR SE O PAGAMENTO NO PAGSEGURO ESTÁ APROVADO 
          if($pago != 'Sim'){
            $P = $PagSeguro->getStatusByReference($id_venda);
            if($P == 3 || $P == 4){
              include_once('../../aprovar_compra.php');
            }
          }

          $data = implode('/', array_reverse(explode('-', $data)));
          $total = number_format($total, 2, ',', '.');



          $query2 = $pdo->query("SELECT * FROM carrinho where id_venda = '$id_venda' order by id desc ");
          $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
          $total_produtos = @count($res2);

          ?>


          <tr>


            <td>
              <?php 
              if($pago == 'Sim') {
                echo '<i class="fas fa-square mr-1 text-success"></i>';
              }else{

               echo '<i class="fas fa-square mr-1 text-danger"></i>';
             }?> 
             <?php echo $data ?>

           </td>
           <td>R$ <?php echo $total ?></td>


           <td>


            <?php if($pago != 'Sim'){  ?>
              <small><a target="_blank" class="text-danger" href="../../checkout.php?id_venda=<?php echo $id_venda ?>" title="Efetuar Pagamento">
                <i class="far fa-money-bill-alt mr-1 text-danger"></i>
              Pagar </a></small>
            <?php }else{ ?>
              <?php echo $pago ?>
            <?php } ?>
          </td>

          <td>

            <?php if($status == 'Enviado'){
              echo '<img src="../../img/correios.png" width"25px" height="25"><a class="text-primary" title="Código de Postagem"><small>'. $rastreio .'</small></a>';
            }else{
              echo $status;
            } ?>    
          </td>

          <td>
            <a href="" onclick="verProdutos('<?php echo $id_venda ?>')" title="Ver Produtos">
              <i class="fas fa-eye mr-1 text-primary"></i>
              <?php echo $total_produtos ?> Produto(s)
            </a>

          </td>


          <td>
           <?php 
           $query2 = $pdo->query("SELECT * FROM mensagem where id_venda = '$id_venda' order by id desc limit 1");
           $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
           $usuario_ultimo = @$res2[0]['usuario'];
           $total_msg = @count($res2);
           if($usuario_ultimo == 'Admin'){
            ?>
            <a href="index.php?pag=<?php echo $pag ?>&funcao=mensagem&id=<?php echo $id_venda ?>" class=' mr-1' title='Enviar Mensagem'> <span class="badge badge-warning"><?php echo $total_msg ?></span></a>
          <?php }else{ ?>
           <a href="index.php?pag=<?php echo $pag ?>&funcao=mensagem&id=<?php echo $id_venda ?>" class=' mr-1' title='Enviar Mensagem'> <span class="badge badge-success">0</span></a>
         <?php } ?>

         <?php if($pago != 'Sim'){  ?>
          <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id_venda ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>





</tbody>
</table>
</div>
</div>
</div>





<div class="modal" id="modalMensagem" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mensagens do Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-6 mb-2">
            <form method="post">
             <div class="form-group">
              <label >Nova Mensagem</label>
              <textarea maxlength="1000" class="form-control" id="titulo-mensagem" name="titulo-mensagem"></textarea>
            </div>



            <button type="submit" id="btn-mensagem" name="btn-mensagem" class="btn btn-info mt-2">Enviar</button>
          </form>
        </div>
        <div class="col-md-6 mb-2">

         <?php 
         $id_ven = $_GET['id'];
         $query2 = $pdo->query("SELECT * FROM mensagem where id_venda = '$id_ven' order by id desc");
         $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
         for ($i=0; $i < count($res2); $i++) { 
          foreach ($res2[$i] as $key => $value) {
          }

          $usuario = $res2[$i]['usuario'];
          $texto = $res2[$i]['texto'];
          $data = $res2[$i]['data'];
          $hora = $res2[$i]['hora'];
          $data = implode('/', array_reverse(explode('-', $data)));

          if($usuario == 'Admin'){
            echo '<p><small><i><u> Administrador:</i> </u>- <small>'.$data.' - '.$hora.'</small><br>' .$texto.'  </small></p>';
          }else{
            echo '<p><small><i><u> Cliente:</u></i> - <small>'.$data.' - '.$hora.'</small><br>' .$texto.' </small></p>';
          }

        }


        ?>

      </div>
    </div>

  </div>

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

        <div align="center" id="mensagem_excluir" class="">

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





<?php 



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "mensagem") {
  echo "<script>$('#modalMensagem').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
  echo "<script>$('#modal-deletar').modal('show');</script>";
}

?>


<?php 
if(isset($_POST["btn-mensagem"])){
  $id_venda = $_GET['id'];
  $texto = $_POST['titulo-mensagem'];
  $res = $pdo->prepare("INSERT mensagem SET id_venda = :id_venda, texto = :texto, usuario = :usuario, data = curDate(), hora = curTime()");
  $res->bindValue(":id_venda", $id_venda);
  $res->bindValue(":texto", $texto);
  $res->bindValue(":usuario", 'Cliente');
  $res->execute();

  echo "<script language='javascript'> window.location='index.php?pag=pedidos&funcao=mensagem&id=$id_venda' </script>";


} ?>


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






<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })

  });
</script>




<!-- Modal -->
<div class="modal fade" id="modalProdutos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
    <div class="modal-content mb-4">
      <div class="modal-header">


        <h5 class="cart-inline-title">Produtos da Compra</h5>
        <input type="hidden" id="txtquantidade">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div id='listar-produtos'></div>;
        
        <small><div align="center" id="mensagem"></div></small>



      </div>


    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalAvaliar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document" style="overflow-y: initial !important">
    <div class="modal-content mb-4">
      <div class="modal-header">


        <h5 class="cart-inline-title">Avaliar Produto</h5>
        <input type="hidden" id="txtquantidade">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

      <form method="post">

       <div class="form-group">
        <label >Nota</label>
        <select class="form-control form-control-sm" name="nota" id="nota">
          <option value='5'>5</option>
          <option value='4'>4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>               
      </div>


      <div class="form-group">
        <label >Comentário</label>
        <textarea maxlength="500" class="form-control form-control-sm" id="comentario" name="comentario" ></textarea>
      </div>

      <input type="hidden" id="id-produto" name="id-produto">


      <small><div align="center" id="mensagem-avaliar"></div></small>



    </div>

    <div class="modal-footer">

  <button type="button" id="btn-fechar-avaliar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  <button type="button" name="btn-avaliar" id="btn-avaliar" class="btn btn-primary">Salvar</button>
</div>
</form>


  </div>
</div>
</div>




<script>
  function verProdutos(idvenda) {
    var pag = "<?=$pag?>";
    event.preventDefault();

    $.ajax({
      url:  pag + "/listar-produtos.php",
      method: "post",
      data: {idvenda},
      dataType: "html",
      success: function(result){
        $("#modalProdutos").modal("show");  
        $('#listar-produtos').html(result)

      },
    })
  }
</script>




<script>
  function avaliar(idproduto) {
    
    event.preventDefault();
    console.log(idproduto)
    $("#modalAvaliar").modal("show");
    $('#id-produto').val(idproduto);
    $('#mensagem-avaliar').text("");
  }
</script>




<script type="text/javascript">
    $('#btn-avaliar').click(function(event){
      var pag = "<?=$pag?>";
        event.preventDefault();
        console.log('ssss')
        $.ajax({
            url: pag + "/inserir-avaliacao.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Cadastrado com Sucesso!'){
                                        
                    $('#btn-fechar-avaliar').click();
                   
                } else{
                    $('#mensagem-avaliar').addClass('text-danger')
                    $('#mensagem-avaliar').text(msg);
                   

                 }
            }
        })
    })
</script>


