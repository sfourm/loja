
<!-- Modal -->
<div class="modal fade" id="modalCarrinho" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
    <div class="modal-content mb-4" style="overflow-y: auto; overflow-x: hidden">
      <div class="modal-header">
        <h5 class="cart-inline-title">Carrinho:<span id="total_itens" class="ml-1"> </span> Produto(s)</h5>
        <input type="hidden" id="txtquantidade">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" method="POST">
        <div class="modal-body">
          <?php 
          if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Cliente'){
            echo "Você precisa fazer Login para adicionar produtos ao carrinho!! Clique <a class='text-info' href='sistema'>aqui</a> para efetuar Login!";
          }else{
            echo "<div id='listar-carrinho'></div>";
          }
          ?>
          <small><div class="text-center" id="mensagem"></div></small>
        </div>

        <div class="row pr-5 pl-5">
          <div class="col-md-6">
            <h4>Total: R$ <span id="valor_total" class="ml-1"> </span></h4>
          </div>

          <div class="col-md-6 mb-4 text-right">
            <a type="button" id="btn-comprar"  class="bg-secondary text-light primary-btn btn-sm" data-dismiss="modal">Comprar mais</a>
            <a href="" onclick="finalizarPedido()" type="submit" name="btn-finalizar" id="btn-finalizar" class="primary-btn btn-dark bg-dark btn-sm">Finalizar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-caract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="cart-inline-title">Características do Produto</h5>
        <input type="hidden" id="txtquantidade">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-4">
               <div id='listar-caract'></div>
            </div>

            <div class="col-md-6">
              <div id='div-listar-carac-itens'></div>
            </div>

            <small><div class="text-center" id="mensagem-caract"></div></small>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--AJAX PARA INSERÇÃO DOS DADOS VINDO DE UMA FUNÇÃO -->
<script>
function carrinhoModal(idproduto, combo) {
  event.preventDefault();
  console.log(combo); 
  $.ajax({
    url: "carrinho/inserir-carrinho.php",
    method: "post",
    data: {idproduto, combo},
    dataType: "text",
    success: function(mensagem){
      $('#mensagem').removeClass()

      if(mensagem == 'Cadastrado com Sucesso!!'){
        atualizarCarrinho();
        $("#modalCarrinho").modal("show");
        //$('#mensagem').text(mensagem);
      }else{
        $("#modalCarrinho").modal("show");  
        $('#mensagem').text(mensagem);
      }
    },
  })
}
</script>

<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
  $( document ).ready(function() {
    atualizarCarrinho();
  })
</script>

<script>
function atualizarCarrinho() {
  $.ajax({
    url:  "carrinho/listar-carrinho.php",
    method: "post",
    data: $('#frm').serialize(),
    dataType: "html",
    success: function(result){
        $('#listar-carrinho').html(result)
      },
    })
  }
</script>

<script>
  function deletarCarrinho(id) {
    event.preventDefault();    
    $.ajax({
      url: "carrinho/excluir-carrinho.php",
      method: "post",
      data: {id},
      dataType: "text",
      success: function(mensagem){
        $('#mensagem').removeClass()
        if (mensagem == 'Excluido com Sucesso!!'){
          atualizarCarrinho();
          //$("#modal-carrinho").modal("show");
        } else {}
        $('#mensagem').text(mensagem)
      },
    })
  }
</script>

<script type="text/javascript">
  function editarCarrinho(id) {
    var quantidade = document.getElementById('txtquantidade').value;
    event.preventDefault();
    $.ajax({
      url: "carrinho/editar-carrinho.php",
      method: "post",
      data: {id, quantidade},
      dataType: "text",
      success: function(mensagem){
        $('#mensagem').removeClass()
        if (mensagem == 'Editado com Sucesso!!'){
          atualizarCarrinho();
          //$("#modal-carrinho").modal("show");
        } else {}
        $('#mensagem').text(mensagem)
      },
    })
  }
</script>

<script type="text/javascript">
  function addCarac(id, id_carrinho) {       
    event.preventDefault();
    $.ajax({
      url: "carrinho/carac-produtos.php",
      method: "post",
      data: {id, id_carrinho},
      dataType: "text",
      success: function(mensagem){
        $('#mensagem-caract').removeClass()
        $("#modal-caract").modal("show");
        $('#listar-caract').html(mensagem)
      },    
    })
  }
</script>

<script type="text/javascript">
  function finalizarPedido() {       
    event.preventDefault();     
    $.ajax({
      url: "carrinho/verificar-carac.php",
      method: "post",
      data: {},
      dataType: "text",
      success: function(mensagem){
        if(mensagem.trim() === 'Selecione as Características dos Produtos!'){
          $('#mensagem').addClass('text-danger');
          $('#mensagem').text(mensagem);
        }else{
          window.location="checkout.php";
          //$('#mensagem').text(mensagem);
        }
      },    
    })
  }
</script>