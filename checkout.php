<?php
require_once("cabecalho.php");
require_once("conexao.php");

//includes para o mercado pago
include_once("pagamentos/mercadopago/lib/mercadopago.php");
include_once("pagamentos/mercadopago/PagamentoMP.php");
$pagar = new PagamentoMP;

?>

<?php
require_once("cabecalho-busca.php");

@session_start();

if(@$_SESSION['id_usuario'] == null){
    echo "<script language='javascript'> window.location='sistema' </script>";

}

$id_venda = @$_GET['id_venda'];
$id_usuario = @$_SESSION['id_usuario'];
$nome_usuario = @$_SESSION['nome_usuario'];
//$cpf_usuario = @$_SESSION['cpf_usuario'];
$email_usuario = @$_SESSION['email_usuario'];
$total = 0;
$frete_correios;

$res = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$cpf_usuario = $dados[0]['cpf'];

$res = $pdo->query("SELECT * from clientes where cpf = '$cpf_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$telefone = $dados[0]['telefone'];
$rua = $dados[0]['rua'];
$numero = $dados[0]['numero'];
$bairro = $dados[0]['bairro'];
$complemento = $dados[0]['complemento'];
$cep = $dados[0]['cep'];
$cidade = $dados[0]['cidade'];
$estado = $dados[0]['estado'];
?>

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form bg-light pl-4 pt-4">
            <h4>Confirmar Dados (Entrega)</h4>
            <form method="post" id="form-dados">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Nome Completo<span>*</span></p>
                                    <input type="text" value="<?php echo @$nome_usuario ?>" name="nome" id="nome">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>CPF<span>*</span></p>
                                    <input value="<?php echo $cpf_usuario ?>" type="text" name="cpf" id="cpf">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input value="<?php echo $email_usuario ?>" type="text" name="email" id="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Telefone<span>*</span></p>
                                    <input type="text" value="<?php echo $telefone ?>" name="telefone" id="telefone">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Rua<span>*</span></p>
                                    <input type="text" value="<?php echo $rua ?>" name="rua" id="rua">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="checkout__input">
                                    <p>Número<span>*</span></p>
                                    <input type="text" value="<?php echo $numero ?>" name="numero" id="numero">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="checkout__input">
                                    <p>Bairro<span>*</span></p>
                                    <input type="text" value="<?php echo $bairro ?>" name="bairro" id="bairro">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="checkout__input">
                                    <p>Complemento<span></span></p>
                                    <input type="text" value="<?php echo $complemento ?>" name="complemento" id="complemento">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkout__input">
                                    <p>CEP<span>*</span></p>
                                    <input type="text" value="<?php echo $cep ?>" name="cep" id="cep">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkout__input">
                                    <p>Cidade<span>*</span></p>
                                    <input type="text" value="<?php echo $cidade ?>" name="cidade" id="cidade">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="checkout__input">
                                    <p>Estado<span>*</span></p>
                                    <select name="estado" id="estado">
                                        <option value="AC" <?php if(@$estado == 'AC'){ ?> selected <?php } ?> >AC</option>
                                        <option value="AL" <?php if(@$estado == 'AL'){ ?> selected <?php } ?>>AL</option>
                                        <option value="AP" <?php if(@$estado == 'AP'){ ?> selected <?php } ?>>AP</option>
                                        <option value="AM" <?php if(@$estado == 'AM'){ ?> selected <?php } ?>>AM</option>
                                        <option value="BA" <?php if(@$estado == 'BA'){ ?> selected <?php } ?>>BA</option>
                                        <option value="CE" <?php if(@$estado == 'CE'){ ?> selected <?php } ?>>CE</option>
                                        <option value="DF" <?php if(@$estado == 'DF'){ ?> selected <?php } ?>>DF</option>
                                        <option value="ES" <?php if(@$estado == 'ES'){ ?> selected <?php } ?>>ES</option>
                                        <option value="GO" <?php if(@$estado == 'GO'){ ?> selected <?php } ?>>GO</option>
                                        <option value="MA" <?php if(@$estado == 'MA'){ ?> selected <?php } ?>>MA</option>
                                        <option value="MT" <?php if(@$estado == 'MT'){ ?> selected <?php } ?>>MT</option>
                                        <option value="MS" <?php if(@$estado == 'MS'){ ?> selected <?php } ?>>MS</option>
                                        <option value="MG" <?php if(@$estado == 'MG'){ ?> selected <?php } ?>>MG</option>
                                        <option value="PA" <?php if(@$estado == 'PA'){ ?> selected <?php } ?>>PA</option>
                                        <option value="PB" <?php if(@$estado == 'PB'){ ?> selected <?php } ?>>PB</option>
                                        <option value="PR" <?php if(@$estado == 'PR'){ ?> selected <?php } ?>>PR</option>
                                        <option value="PE" <?php if(@$estado == 'PE'){ ?> selected <?php } ?>>PE</option>
                                        <option value="PI" <?php if(@$estado == 'PI'){ ?> selected <?php } ?>>PI</option>
                                        <option value="RJ" <?php if(@$estado == 'RJ'){ ?> selected <?php } ?>>RJ</option>
                                        <option value="RN" <?php if(@$estado == 'RN'){ ?> selected <?php } ?>>RN</option>
                                        <option value="RS" <?php if(@$estado == 'RS'){ ?> selected <?php } ?>>RS</option>
                                        <option value="RO" <?php if(@$estado == 'RO'){ ?> selected <?php } ?>>RO</option>
                                        <option value="RR" <?php if(@$estado == 'RR'){ ?> selected <?php } ?>>RR</option>
                                        <option value="SC" <?php if(@$estado == 'SC'){ ?> selected <?php } ?>>SC</option>
                                        <option value="SP" <?php if(@$estado == 'SP'){ ?> selected <?php } ?>>SP</option>
                                        <option value="SE" <?php if(@$estado == 'SE'){ ?> selected <?php } ?>>SE</option>
                                        <option value="TO" <?php if(@$estado == 'TO'){ ?> selected <?php } ?>>TO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="checkout__input">
                                    <p>Informações do Pedido <small>(Caso tenha alguma dúvida)</small><span></span></p>
                                    <input type="text" maxlength="1000" name="comentario" id="comentario" style="height:100px;">
                                </div>                           
                            </div>
                        </div>
                        <div class="shoping__continue">
                            <div class="shoping__discount">
                                <h5>Cupom de Desconto</h5>
                                <form method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <input name="cupom" id="cupom" type="text" placeholder="Entre com o código do seu cupom">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <button id="btn-cupom" type="submit" class="site-btn bg-dark">APLICAR CUPOM</button>
                                            </div>
                                        </div>
                                    </div>  
                                    <div id="mensagem-cupom"></div> 
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Sua Compra</h4>
                            <div class="checkout__order__products">Produtos <span>Total</span></div>
                            <ul>
                                <?php 
                                $res = $pdo->query("SELECT * from carrinho where id_usuario = '$id_usuario' and id_venda = 0 order by id asc");
                                $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                                $linhas = count($dados);

                                if($linhas == 0){
                                    $linhas = 0;
                                    $total = 0;
                                }

                                $total;
                                $total_peso;
                            
                                for ($i=0; $i < count($dados); $i++) { 
                                foreach ($dados[$i] as $key => $value) {}

                                $id_produto = $dados[$i]['id_produto'];    
                                $quantidade = $dados[$i]['quantidade'];
                                $id_carrinho = $dados[$i]['id'];
                                $combo = $dados[$i]['combo'];

                                if ($combo == 'Sim'){
                                    $res_p = $pdo->query("SELECT * from combos where id = '$id_produto' ");
                                } else {
                                $res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
                                }

                                $dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
                                $nome_produto = $dados_p[0]['nome'];
                                $tipo_envio = $dados_p[0]['tipo_envio'];
                                $valor_frete = $dados_p[0]['valor_frete'];
                                $querye = $pdo->query("SELECT * FROM tipo_envios where id = '$tipo_envio' ");
                                    $rese = $querye->fetchAll(PDO::FETCH_ASSOC);
                                    $envio = $rese[0]['nome'];
                                    if ($envio == 'Correios'){
                                        $frete_correios = 'Sim';
                                        $peso = $dados_p[0]['peso'];
                                        @$total_peso = @$total_peso + $peso;
                                        @$existe_frete = 'Sim';
                                    }
                                    if ($envio == 'Valor Fixo'){
                                        @$existe_frete = 'Sim';
                                    }

                                if ($combo == 'Sim'){ 
                                    $promocao = ""; 
                                    $pasta = "combos";
                                } else {
                                    $promocao = $dados_p[0]['promocao']; 
                                    $pasta = "produtos";
                                }

                                if ($promocao == 'Sim'){
                                    $queryp = $pdo->query("SELECT * FROM promocoes where id_produto = '$id_produto' ");
                                    $resp = $queryp->fetchAll(PDO::FETCH_ASSOC);
                                    $valor = $resp[0]['valor'];
                                } else {
                                    $valor = $dados_p[0]['valor'];
                                }
                                $imagem = $dados_p[0]['imagem'];
                                $total_item = $valor * $quantidade;
                                @$total = @$total + $total_item;
                                if ($valor_frete > 0){
                                        
                                    @$total = @$total + @$valor_frete;
                                }

                                $valor = number_format( $valor , 2, ',', '.');
                                    //$total = number_format( $total , 2, ',', '.');
                                    $total_item = number_format( $total_item , 2, ',', '.');
                                ?>

                                <li><?php echo $nome_produto ?> <span>R$<?php echo $total_item ?></span></li>
                                <?php if($valor_frete > 0){ ?>
                                    <p class="text-danger text-right"><small>Frete Fixo : <?php echo $valor_frete ?></small></p>
                                <?php } ?>

                                <?php } 
                                @$total = number_format(@$total, 2, ',', '.');
                                ?>
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>R$ <?php echo $total ?></span></div>

                            <?php if(@$frete_correios == 'Sim' && $retirada_local == 'sim'){ ?>
                            <div class="row mt-2 mb-4 pl-3">
                                <div class="form-check">
                                    <input type="checkbox" value="sim" class="form-check-input" id="local" name="local">
                                    <label class="form-check-label" for="exampleCheck1">Retirar no Local</label>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if(@$frete_correios == 'Sim'){ ?>
                            <div id="div-frete" class="checkout__order__total">Calcular Frete<br> 
                                <div class="checkout__input py-2">
                                    <form id="frm" method="post">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input type="hidden" value="<?php echo @$total_peso ?>" name="total_peso" id="total_peso">
                                                <div class="checkout__input">
                                                    <input type="text" name="cep2" id="cep2" placeholder="CEP">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="checkout__input">
                                                    <select name="codigo_servico" id="codigo_servico">
                                                        <option value="0">Escolher</option>
                                                        <option value="40010">Sedex</option>
                                                        <option value="41106">PAC</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div id="listar-frete"></div>
                                </div>
                            </div>
                            <?php } ?>                               
                            <div  class="checkout__order__total">Total <span id="total_final"></span></div>                     
                            <input type="hidden" value="0" id="vlr_frete" name="vlr_frete">
                            <input type="hidden" value="<?php echo @$frete_correios ?>" id="existe_frete" name="existe_frete">
                            <input type="hidden" value="<?php echo @$total ?>" id="total_compra" name="total_compra">
                            <input type="hidden" value="<?php echo @$cpf_usuario ?>" id="antigo" name="antigo">
                            <button id="btn-finalizar" type="submit" class="site-btn bg-success">FINALIZAR COMPRA</button>
                            <small><div class="mt-2" id="mensagem-finalizar"></div></small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

<!-- Modal -->
<div class="modal fade" id="modalPagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">...</div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once("rodape.php");
?>

<script type="text/javascript">
  $( document ).ready(function() {
    var total = "<?=$total?>";
    var id_venda = "<?=$id_venda?>";
    if (total == "0,00" &&  id_venda == ""){
        window.location="produtos.php";
    }
    total = "R$ " + total;
    $('#total_final').text(total);
    $('#total_pgto').text(total);
  })
</script>

<script type="text/javascript">
    $('#btn-cupom').click(function(event){
        event.preventDefault();      
        $.ajax({
            url:"cupom/usar-cupom.php",
            method:"post",
            data: $('form').serialize(),
            dataType: "text",
            success: function(msg){
                if(msg.trim() === 'Insira um valor para o Cupom'){
                    $('#mensagem-cupom').addClass('text-danger')
                    $('#mensagem-cupom').text(msg);
                } else if (msg.trim() === 'Esse código de cupom é inexistente!'){
                    $('#mensagem-cupom').addClass('text-danger')
                    $('#mensagem-cupom').text(msg);
                }else{
                    var tot;
                    total_final = $('#total_final').text();
                    total_final = total_final.replace(",",".");
                    total_final = total_final.replace("R$","");
                    tot = parseFloat(total_final) - parseFloat(msg);
                    tot = tot.toFixed(2);
                    $('#total_compra').val(tot);
                    tot = "R$ " + tot.replace(".",",");
                    console.log(tot);
                    $('#total_final').text(tot);
                    $('#total_pgto').text(tot);

                    $('#mensagem-cupom').addClass('text-success')
                    $('#mensagem-cupom').text("Cupom de desconto no valor de R$" + msg + " Reais");
                }
            }
        })
    })
</script>

<script type="text/javascript">
    $('#codigo_servico').change(function(event){
        event.preventDefault();
        $.ajax({
            url:  "correios/pegarDadosFrete.php",
            method: "post",
            data: $('#frm').serialize(),
            dataType: "html",
            success: function(result){

                var array = result.split(" ");
                var tot_frete = array[7];
                tot_frete = tot_frete.replace(",",".");
                vlr_frete_antigo = $('#vlr_frete').val();
                console.log(vlr_frete_antigo);
                console.log(tot_frete);
                total_final = $('#total_final').text();
                total_final = total_final.replace(",",".");
                total_final = total_final.replace("R$","");
                tot = parseFloat(total_final) + parseFloat(tot_frete) - parseFloat(vlr_frete_antigo);
                tot = tot.toFixed(2);
                $('#total_compra').val(tot);
                tot = "R$ " + tot.replace(".",",");
                console.log(tot);
                $('#total_final').text(tot);
                $('#total_pgto').text(tot);

                $('#listar-frete').html(result);
                $('#vlr_frete').val(tot_frete);
                $('#mensagem-finalizar').text("");
            },
        })
    })
</script>

<script type="text/javascript">
    $('#btn-finalizar').click(function(event){
        event.preventDefault();
        $.ajax({
            url:  "finalizar-compra.php",
            method: "post",
            data: $('#form-dados').serialize(),
            dataType: "html",
            success: function(msg){
                console.log(msg);
                if(msg.trim() === 'Selecione um CEP válido para o Frete!'){
                    $('#listar-frete').html('');
                    $('#mensagem-finalizar').addClass('text-danger')
                    $('#mensagem-finalizar').text(msg);
                } else if (msg.trim() === 'Preencha o Campo Rua!'){
                    $('#mensagem-finalizar').addClass('text-danger')
                    $('#mensagem-finalizar').text(msg);
                } else {
                    window.location="checkout.php?id_venda=" + msg;
                }
            },
        })
    })
</script>

<script type="text/javascript">
    $('#local').change(function(event){
        event.preventDefault();
        $('#mensagem-finalizar').text("");
        var check = document.getElementsByName("local"); 
        for (var i=0;i<check.length;i++){ 
            if (check[i].checked == true){ 
                document.getElementById("div-frete").style.display = 'none';
            } else {
            document.getElementById("div-frete").style.display = 'block';
            }
        }
    })
</script>

<?php 
require_once("modal-pagamento.php");
 ?>
