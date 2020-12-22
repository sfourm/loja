<?php


$redirectStr = '';
if(!empty($_GET['paymentID']) && !empty($_GET['token']) && !empty($_GET['payerID']) && !empty($_GET['pid']) ){

    // Include and initialize database class
   include_once('../../conexao.php');

    // Include and initialize paypal class
    include 'PaypalExpress.class.php';
    $paypal = new PaypalExpress;
    
    // Get payment info from URL
    $paymentID = $_GET['paymentID'];
    $token = $_GET['token'];
    $payerID = $_GET['payerID'];
    $productID = $_GET['pid'];

       
    // Validate transaction via PayPal API
    $paymentCheck = $paypal->validate($paymentID, $token, $payerID, $productID);
    
    // If the payment is valid and approved
    if($paymentCheck && @$paymentCheck->state == 'approved'){

        // Get the transaction data
        $id = $paymentCheck->id;
        $state = $paymentCheck->state;
        $payerFirstName = $paymentCheck->payer->payer_info->first_name;
        $payerLastName = $paymentCheck->payer->payer_info->last_name;
        $payerName = $payerFirstName.' '.$payerLastName;
        $payerEmail = $paymentCheck->payer->payer_info->email;
        $payerID = $paymentCheck->payer->payer_info->payer_id;
        $payerCountryCode = $paymentCheck->payer->payer_info->country_code;
        $paidAmount = $paymentCheck->transactions[0]->amount->details->subtotal;
        $currency = $paymentCheck->transactions[0]->amount->currency;
        
        // Get product details
        $conditions = array(
            'where' => array('id' => $productID),
            'return_type' => 'single'
        );

            
       
    }

     $id_venda = $productID;

         //neste arquivo temos a aprovação da matricula, o envio por email e o lançamento na tabela de vendas
        include_once('../../aprovar_compra.php');     
    
    // Redirect to payment status page

    header("Location:payment-status.php".$redirectStr);
}else{
    // Redirect to the home page
   header("Location:payment-status.php".$redirectStr);
}
?>