<?php 
include_once("conexao.php");

//$id_venda = 63;

$res = $pdo->query("SELECT * FROM vendas where id = '$id_venda'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$id_usuario = $dados[0]['id_usuario'];
$pago = $dados[0]['pago'];




if($pago != 'Sim'){

$res = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$cpf_usuario = $dados[0]['cpf'];
$email_usuario = $dados[0]['email'];
$nome_usuario = $dados[0]['nome'];



//atualizar o status da venda
$pdo->query("UPDATE vendas SET pago = 'Sim' where id = '$id_venda' ");

//incrementar um cartão para o cliente
$res = $pdo->query("SELECT * FROM clientes where cpf = '$cpf_usuario'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$cartao = $dados[0]['cartoes'];
$total_cartoes = $cartao + 1;
if($total_cartoes >= $total_cartoes_troca){
	$total_cartoes = 0;
	$data_cupom = date('Y-m-d', strtotime("+".$dias_uso_cupom." days"));
	$data_cupom_formatada = implode('/', array_reverse(explode('-', $data_cupom)));

	$pdo->query("INSERT INTO cupons (titulo, desconto, codigo, data) VALUES ('Cupom por Cartões', '$valor_cupom_cartao', '$cpf_usuario', '$data_cupom')");

	//ENVIAR EMAIL PARA O CLIENTE INFORMANDO DO SEU NOVO CUPOM DE BRINDE
$destinatario = $email_usuario;
$assunto = $nome_loja . ' - Novo Cupom de Desconto';
    $mensagem = utf8_decode('Parabéns, você ganhou um novo cupom de desconto no valor de '.$valor_cupom_cartao.' reais, poderá usar até o dia '.$data_cupom_formatada.' o seu código para uso do cupom é '.$cpf_usuario);
    $mensagem_sem_codific = 'Parabéns, você ganhou um novo cupom de desconto no valor de '.$valor_cupom_cartao.' reais, poderá usar até o dia '.$data_cupom_formatada.' o seu código para uso do cupom é '.$cpf_usuario;
    $cabecalhos = "From: ".$email;
    @mail($destinatario, $assunto, $mensagem, $cabecalhos);
    


//informar do cupom na mensagem da ultima compra
$pdo->query("INSERT mensagem SET id_venda = '$id_venda', texto = '$mensagem_sem_codific', usuario = 'Admin', data = curDate(), hora = curTime()");
		
}
$pdo->query("UPDATE clientes SET cartoes = '$total_cartoes' where cpf = '$cpf_usuario'");



//incrementar uma venda nos produtos
$res = $pdo->query("SELECT * FROM carrinho where id_venda = '$id_venda'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < @count($dados); $i++) { 
     foreach ($dados[$i] as $key => $value) {
}
$id_produto = $dados[$i]['id_produto'];
$combo = $dados[$i]['combo'];
$quantidade = $dados[$i]['quantidade'];

if($combo != 'Sim'){
    $res2 = $pdo->query("SELECT * FROM produtos where id = '$id_produto'");
    $dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
    $vendas = $dados2[0]['vendas'];
    $estoque = $dados2[0]['estoque'];

    $tip_envio = $dados2[0]['tipo_envio'];

    $res3 = $pdo->query("SELECT * FROM tipo_envios where id = '$tip_envio'");
    $dados3 = $res3->fetchAll(PDO::FETCH_ASSOC);
    $nome_envio = $dados3[0]['nome'];

    $total_vendas = $vendas + 1;

    if($nome_envio == 'Digital'){
        $total_estoque = $estoque;
    }else{
        $total_estoque = $estoque - $quantidade;
    }
    

    $pdo->query("UPDATE produtos SET vendas = '$total_vendas', estoque = '$total_estoque' where id = '$id_produto'");
    
}else{
    $res2 = $pdo->query("SELECT * FROM combos where id = '$id_produto'");
    $dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
    $vendas = $dados2[0]['vendas'];
    $total_vendas = $vendas + 1;
    $pdo->query("UPDATE combos SET vendas = '$total_vendas' where id = '$id_produto'");

    $res_combo = $pdo->query("SELECT * FROM prod_combos where id_combo = '$id_produto'");
    $dados_combo = $res_combo->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i < @count($dados_combo); $i++) { 
        foreach ($dados_combo[$i] as $key => $value) {
    }

    $id_prod_combo = $dados_combo[$i]['id_produto'];
    $res_prod_combo = $pdo->query("SELECT * FROM produtos where id = '$id_prod_combo'");
    $dados_prod_combo = $res_prod_combo->fetchAll(PDO::FETCH_ASSOC);
    $estoque = $dados_prod_combo[0]['estoque'];
    $total_estoque = $estoque - 1;
    $pdo->query("UPDATE produtos SET estoque = '$total_estoque' where id = '$id_prod_combo'");
}

}

    
}




//ENVIAR EMAIL PARA O CLIENTE INFORMANDO DA COMPRA

$to = $email_usuario;
$url_painel = $url_loja.'sistema/painel-cliente/index.php?pag=pedidos/';
$subject = $nome_loja . ' - Compra Aprovada';
$message = "Obrigado $nome_usuario ! Sua compra foi aprovada, acesse o seu painel do cliente clicando <a title='$url_painel' href='$url_painel' target='_blank'>aqui</a> para poder acompanhar seu pedido!";

$dest = $email;
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$headers .= "From: " .$dest;
@mail($to, $subject, $message, $headers);
    



$to = $email;
$subject = $nome_loja . ' - Nova Compra Aprovada';
$message = "Você recebeu uma compra de $nome_usuario, o email do cliente é $email_usuario o email do adm é $destinatario2 e o do cliente é $destinatario";

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$headers .= "From: " .$nome_loja;
@mail($to, $subject, $message, $headers);



}

 ?>