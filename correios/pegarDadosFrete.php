<?php 


include("classCorreios.php");
include("../conexao.php");

$CepOrigem=$cep_origem;
$CepDestino=$_POST['cep2'];
$Peso=$_POST['total_peso'];
$Formato=$formato_frete;
$Comprimento=$comprimento_caixa;
$Altura=$altura_caixa;
$Largura=$largura_caixa;
$MaoPropria=$mao_propria;
$ValorDeclarado=$valor_declarado;
$AvisoRecebimento=$aviso_recebimento;
$Codigo=$_POST['codigo_servico'];
$Diametro=$diametro_caixa;

if(@$Peso == 0 || @$Peso == "" || @$Peso == null){
	echo "<script language='javascript'> window.alert('O produto está sem peso!') </script>";
	exit();
}

if($CepDestino == ""){
	echo '<span><small>Preencha o CEP de Destino!</small></span>';
	exit();
}

$Correios=new ClassCorreios();
$Correios->pesquisaPrecoPrazo($CepOrigem,$CepDestino,$Peso,$Formato,$Comprimento,$Altura,$Largura,$MaoPropria,$ValorDeclarado,$AvisoRecebimento,$Codigo,$Diametro);

 ?>