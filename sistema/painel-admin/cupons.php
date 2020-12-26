<?php 
$pag = "cupons";
require_once("../../conexao.php"); 
@session_start();

//VERIFICAR SE USUÁRIO ESTÁ AUTENTICADO
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
}

$hoje = date('Y-m-d');

//VERIFICAR SE TEM CUPOM VENCIDO E EXCLUIR
$query = $pdo->query("SELECT * FROM cupons WHERE data < curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
   for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
   }
   $id_cupom = $res[$i]['id'];
   $pdo->query("DELETE FROM cupons WHERE id = '$id_cupom' ");
}
?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Cupon</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Desconto R$</th>
                        <th>Código</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                   $query = $pdo->query("SELECT * FROM cupons order by id desc ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);
                   for ($i=0; $i < count($res); $i++) { 
                        foreach ($res[$i] as $key => $value) {}

                        $titulo = $res[$i]['titulo'];
                        $desconto = $res[$i]['desconto'];
                        $codigo = $res[$i]['codigo'];
                        $data = $res[$i]['data'];
                        $data = implode('/', array_reverse(explode('-', $data)));
                        $desconto = number_format($desconto, 2, ',', '.');
                      
                         $id = $res[$i]['id'];
                        ?>
                    <tr>
                        <td><?php echo $titulo ?></td>
                        <td>R$ <?php echo $desconto ?></td>
                        <td><?php echo $codigo ?></td>
                        <td><?php echo $data ?></td>
                       
                        <td>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo_modal = "Editar Registro";
                    $id2 = $_GET['id'];
                    $query = $pdo->query("SELECT * FROM cupons where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $titulo2 = $res[0]['titulo'];
                    $desconto2 = $res[0]['desconto'];
                    $codigo2 = $res[0]['codigo'];
                    $data2 = $res[0]['data'];
                } else {
                    $titulo_modal = "Inserir Registro";
                    $data2 = $hoje;
                }
                ?>
            
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo_modal ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label >Título</label>
                        <input value="<?php echo @$titulo2 ?>" type="text" class="form-control" id="titulo" name="titulo" placeholder="Descrição do Cupom">
                    </div>
                    
                     <div class="form-group">
                        <label >Desconto em R$</label>
                        <input value="<?php echo @$desconto2 ?>" type="number" class="form-control" id="desconto" name="desconto" placeholder="Valor do desconto em Reais">
                    </div>

                    <div class="form-group">
                        <label >Código do Cupom</label>
                        <input value="<?php echo @$codigo2 ?>" type="text" class="form-control" id="codigo" name="codigo" placeholder="Código do Cupom">
                    </div>

                     <div class="form-group">
                        <label >Data <small>(Até quando será válido)</small></label>
                        <input  type="date" class="form-control" id="data" name="data" value="<?php echo @$data2 ?>">
                    </div>

                    <small><div id="mensagem"></div></small> 
                </div>

                <div class="modal-footer">
                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$codigo2 ?>" type="hidden" name="antigo" id="antigo">
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
                <div id="mensagem_excluir" class="text-center"></div>
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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
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

<!--SCRIPT PARA CARREGAR IMAGEM -->
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false
        })
    });
</script>