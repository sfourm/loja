<?php 
$pag = "vendas";
require_once("../../conexao.php"); 
require_once("../../pagamentos/pagseguro/PagSeguro.class.php");
$PagSeguro = new PagSeguro();
@session_start();
$id_usuario = @$_SESSION['id_usuario'];
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
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
                       
                        <th>Status</th>
                        <th>Produtos</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                   <?php 

                   $query_ped = $pdo->query("SELECT * FROM vendas order by id desc ");
                   $res_ped = $query_ped->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res_ped); $i++) { 
                      foreach ($res_ped[$i] as $key => $value) {
                      }

                      $data = $res_ped[$i]['data'];
                      $total = $res_ped[$i]['total'];
                      $pago = $res_ped[$i]['pago'];
                      $status = $res_ped[$i]['status'];
                      $rastreio = $res_ped[$i]['rastreio'];
                      $id_venda = $res_ped[$i]['id'];

                       //VERIFICAR SE O PAGAMENTO NO PAGSEGURO ESTÁ APROVADO
                      /*
                         $P = $PagSeguro->getStatusByReference($id_venda);
                         if($P == 3 || $P == 4){
                            include_once('../../aprovar_compra.php');
                        }
                        */

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
                           <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id_venda ?>" class='text-primary mr-1' title='Editar Status'><i class='far fa-edit'></i></a>

                             <?php 
                                 $query2 = $pdo->query("SELECT * FROM mensagem where id_venda = '$id_venda' order by id desc limit 1");
                            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $usuario_ultimo = @$res2[0]['usuario'];
                            $total_msg = @count($res2);
                            if($usuario_ultimo == 'Cliente'){
                              ?>
                             <a href="index.php?pag=<?php echo $pag ?>&funcao=mensagem&id=<?php echo $id_venda ?>" class=' mr-1' title='Enviar Mensagem'> <span class="badge badge-warning"><?php echo $total_msg ?></span></a>
                         <?php }else{ ?>
                             <a href="index.php?pag=<?php echo $pag ?>&funcao=mensagem&id=<?php echo $id_venda ?>" class=' mr-1' title='Enviar Mensagem'> <span class="badge badge-success">0</span></a>
                        <?php } ?>

                             <?php if($pago != 'Sim'){  ?>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id_venda ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

                            <a href="index.php?pag=<?php echo $pag ?>&funcao=aprovar&id=<?php echo $id_venda ?>" class='text-success mr-1' title='Aprovar Pagamento'><i class='far fa-check-circle'></i></a>

                           

                             <?php } ?>

                              <a href="index.php?pag=<?php echo $pag ?>&funcao=cliente&id=<?php echo $id_venda ?>" class='text-info mr-1' title='Dados Cliente'><i class='far fa-user'></i></a>
                             
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
                        echo '<p><small><i><u> Administrador:</u></i> - <small>'.$data.' - '.$hora.'</small><br>' .$texto.' </p></small> ';
                      }else{
                        echo '<p><small><i><u> Cliente: </u></i>- <small>'.$data.' - '.$hora.'</small><br>' .$texto.' </p></small> ';
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







<div class="modal" id="modal-aprovar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aprovar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Aprovar o pagamento desta venda?</p>

                <div align="center" id="mensagem_aprovar" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-aprovar">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="submit" id="btn-aprovar" name="btn-aprovar" class="btn btn-success">Aprovar</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM vendas where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $rastreio = $res[0]['rastreio'];
                    $status = $res[0]['status'];
                                                            


                ?>
                
                <h5 class="modal-title" id="exampleModalLabel">Editar Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">


                   <div class="form-group">
                        <label >Status</label>
                        <select class="form-control form-control-sm" name="status" id="status">

                           <option value="Não Enviado" <?php if(@$status == 'Não Enviado'){ ?> selected <?php } ?>>Não Enviado</option>
                            <option value="Enviado" <?php if(@$status == 'Enviado'){ ?> selected <?php } ?>>Enviado</option>
                             <option value="Entregue" <?php if(@$status == 'Entregue'){ ?> selected <?php } ?>>Entregue</option>
                             <option value="Disponivel" <?php if(@$status == 'Disponivel'){ ?> selected <?php } ?>>Disponivel</option>
                              <option value="Retirada" <?php if(@$status == 'Retirada'){ ?> selected <?php } ?>>Retirada</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label >Rastreio</label>
                        <input value="<?php echo @$rastreio ?>" type="text" class="form-control" id="rastreio" name="rastreio" placeholder="Código de Postagem (se Houver)">
                    </div>

                  
                   

                    <small>
                        <div id="mensagem_editar">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
               

                    <button type="button" id="btn-cancelar-editar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-editar" id="btn-editar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal" id="modal-cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                 $id_ven = @$_GET['id'];
                  $query_v = $pdo->query("SELECT * FROM vendas where id = '$id_ven' ");
                   $res_v = $query_v->fetchAll(PDO::FETCH_ASSOC);
                   $id_usu = $res_v[0]['id_usuario'];

                   $query_u = $pdo->query("SELECT * FROM usuarios where id = '$id_usu' ");
                   $res_u = $query_u->fetchAll(PDO::FETCH_ASSOC);
                   $cpf_usu = $res_u[0]['cpf'];

                $query = $pdo->query("SELECT * FROM clientes where cpf = '$cpf_usu' ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);
                
                  $nome = $res[0]['nome'];
                  $cpf = $res[0]['cpf'];
                  $telefone = $res[0]['telefone'];
                  $rua = $res[0]['rua'];
                  $numero = $res[0]['numero'];
                  $cep = $res[0]['cep'];
                  $bairro = $res[0]['bairro'];
                  $cidade = $res[0]['cidade'];
                  $estado = $res[0]['estado'];
                  $email_cli = $res[0]['email'];
                  

                 ?>

                
                <span><b>Nome: </b><?php echo $nome ?> </span><br>
                <span><b>CPF: </b> <?php echo $cpf ?></span><span class="ml-2"><b>Email:</b> <?php echo $email_cli ?></span><br>
                
                <span><b>Rua: <?php echo $rua ?></b> </span> <span class="ml-2"><b>Número: </b> <?php echo $numero ?></span><br>
                <span><b>Bairro: </b> <?php echo $bairro ?></span><span class="ml-2"><b>Cidade: </b> <?php echo $cidade ?></span><br>
                
                <span><b>Estado: </b> <?php echo $estado ?></span><span class="ml-2"><b>CEP: </b> <?php echo $cep ?></span><br>
                

                

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

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalEditar').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aprovar") {
    echo "<script>$('#modal-aprovar').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "cliente") {
    echo "<script>$('#modal-cliente').modal('show');</script>";
}

?>


<?php 
if(isset($_POST["btn-mensagem"])){
$id_venda = $_GET['id'];
$texto = $_POST['titulo-mensagem'];
$res = $pdo->prepare("INSERT mensagem SET id_venda = :id_venda, texto = :texto, usuario = :usuario, data = curDate(), hora = curTime()");
        $res->bindValue(":id_venda", $id_venda);
        $res->bindValue(":texto", $texto);
        $res->bindValue(":usuario", 'Admin');
        $res->execute();

echo "<script language='javascript'> window.location='index.php?pag=vendas&funcao=mensagem&id=$id_venda' </script>";


} ?>



<?php 
if(isset($_POST["btn-aprovar"])){
$id_venda = $_GET['id'];

require('../../aprovar_compra.php');

echo "<script language='javascript'> window.location='index.php?pag=vendas' </script>";


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





<!--AJAX PARA EDITAR DADOS -->
<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-editar').click(function (event) {

            event.preventDefault();

            $.ajax({
                url: pag + "/editar-status.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    if (mensagem.trim() === 'Editado com Sucesso!!') {


                        $('#btn-cancelar-editar').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_editar').addClass('text-danger')
                    $('#mensagem_editar').text(mensagem)



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


        <h5 class="cart-inline-title">Produtos da Venda</h5>
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





<!--AJAX PARA INSERÇÃO DOS DADOS VINDO DE UMA FUNÇÃO -->
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





