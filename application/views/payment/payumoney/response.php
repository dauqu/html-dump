<?php

$msg = '';

$cartItems = $this->session->userdata('cart_items');
$user_id = $this->session->userdata('user_id');
$product_info='';

foreach ($cartItems as $key => $batches_arr):
    $product_info ="[".$key.",(";

    foreach ($batches_arr as $batch):
        $product_info = $product_info.$batch['id'].',';

        updatePaymentDetails($user_id,$key,$batch['id']);
    endforeach;
    $product_info = $product_info.")],";
endforeach;


?>

