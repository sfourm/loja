<?php 
$pag = "estoque";
require_once("../../conexao.php"); 
@session_start();

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
                        <th>Produto</th>
                       <th>Estoque</th>
                        <th>Fazer Pedido</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $query = $pdo->query("SELECT * FROM produtos where estoque <= '$nivel_estoque' order by estoque asc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($res); $i++) { 
                        foreach ($res[$i] as $key => $value) {}
                        $nome = $res[$i]['nome'];
                        $estoque = $res[$i]['estoque'];
                        $id = $res[$i]['id'];?>
                    <tr>
                        <td><?php echo $nome ?></td>
                        <td><?php echo $estoque ?></td>
                        <td><a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Fazer Pedido'><i class='far fa-edit'></i></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                    $id2 = $_GET['id'];
                    $query = $pdo->query("SELECT * FROM produtos where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome2 = $res[0]['nome'];                               
                ?>
                
                <h5 class="modal-title" id="exampleModalLabel">Entrada - <?php echo $nome2 ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label >Quantidade <small>Entrada no Estoque</small></label>
                        <input  type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Insira a quantidade ao estoque">
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

<?php 
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
  
    echo "<script>$('#modalDados').modal('show');</script>";
}
?>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: pag + "/entrada-estoque.php",
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false
        })
    });
</script>