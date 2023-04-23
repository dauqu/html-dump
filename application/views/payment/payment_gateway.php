<style>
    body {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .payment-header-text {
        font-size: 23px;

    }

    .close-btn-light {
        padding-left: 10px;
        padding-right: 10px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        font-size: 25px;
        background-color: #F1EAE9;
        color: #a45e72;
        border-radius: 5px;
    }

    .close-btn-light:hover {
        padding-left: 10px;
        padding-right: 10px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        font-size: 25px;
        background-color: #a45e72;
        color: #FFFFFF;
        border-radius: 5px;
    }

    .payment-header {
        font-size: 18px;
    }

    .item {
        width: 100%;
        height: 50px;
        display: block;
    }

    .count-item {
        padding-left: 13px;
        padding-right: 13px;
        padding-top: 5px;
        padding-bottom: 5px;

        margin-bottom: 100%;
        margin-right: 18px;
        margin-top: 8px;

        color: #00B491;
        background-color: #DEF6F3;
        border-radius: 5px;
        float: left;
    }

    .item-title {
        font-weight: bold;
        font-size: 13.5px;
        display: block;
        margin-top: 6px;
    }

    .item-price {
        float: right;
        color: #00B491;
    }

    .by-owner {
        font-size: 11px;
        color: #76767E;
        display: block;
        margin-top: -3px;
    }

    .total {
        border-radius: 8px 0px 0px 8px;
        background-color: #DBF3F0;
        padding: 10px;
        padding-left: 30px;
        padding-right: 30px;
        font-size: 18px;
    }

    .total-price {
        border-radius: 0px 8px 8px 0px;
        background-color: #CCD4DD;
        padding: 10px;
        padding-left: 25px;
        padding-right: 25px;
        font-size: 18px;
    }

    .indicated-price {
        padding-bottom: 20px;
        margin-bottom: 0px;
    }

    .payment-button {
        background-color: #1DBDA0;
        border-radius: 8px;
        padding: 10px;
        padding-left: 30px;
        padding-right: 30px;
        color: #fff;
        border: none;
        font-size: 18px;
    }

    .payment-gateway {
        border: 2px solid #D3DCDD;
        border-radius: 5px;
        padding-top: 15px;
        padding-bottom: 15px;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .payment-gateway:hover {
        border: 2px solid #00D04F;
        border-radius: 5px;
        padding-top: 15px;
        padding-bottom: 15px;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .payment-gateway-icon {
        width: 80%;
        float: right;
    }

    .tick-icon {
        margin: 0px;
        padding: 0px;
        width: 15%;
        float: left;
        display: none;
    }

    .paypal-form,
    .stripe-form {
        display: none;
    }
    .payumoney-form,.razorpay-form {
        display: none;
    }

    @media only screen and (max-width: 600px) {

        .paypal,
        .stripe,.payumoney {
            margin-left: 5px;
            width: 70%;
        }
    }
</style>

<?php
$paypal = json_decode(get_settings('paypal'));
$stripe = json_decode(get_settings('stripe_keys'));
$payumoney = json_decode(get_settings('payumoney_keys'));
$razorpay = json_decode(get_settings('razorpay_keys'));
$total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');

?>

<div class="container">

   <div class="row justify-content-center">
                <div class="col-md-10">

<div class="card shadow-sm">    
         <div class="card-body">     

    <div class="row justify-content-center mb-5">
        <div class="col-md-12">

                    <span class="payment-header-text justify-content-center d-flex"><b><?php echo get_phrase('make_payment'); ?></b></span>
                    
                </div>
            </div>
  
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row  justify-content-center">
                <div class="col-md-3">
                    <p class="pb-2 payment-header"><?php echo get_phrase('select_payment'); ?> <?php echo get_phrase('gateway'); ?></p>

                   <?php if ($razorpay[0]->razorpay_active != 0): ?>
                        <div class="row payment-gateway razorpay" onclick="selectedPaymentGateway('razorpay')">
                            <div class="col-12">
                                <img class="tick-icon payumoney-icon" id ='payumoney-icon' src="<?php echo base_url('assets/payment/tick.png'); ?>">
                                <!--img class="payment-gateway-icon" src="<!?php echo base_url('assets/payment/pay_u_money.png'); ?>"-->
                                <img class="payment-gateway-icon"  src="<?php echo base_url('assets/payment/razor.png'); ?>" style="width:125px;height: 34px; ">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!--paystack payment gateway addon-->
                    <!--razorpay payment gateway addon-->
                    <?php
                    if (addon_status('razorpay') == 1) :
                        include "razorpay_payment_gateway.php";
                    endif;
                    ?>
                    <!--instamojo payment gateway addon-->
                    <?php
                    if (addon_status('instamojo') == 1) :
                        include "instamojo_payment_gateway.php";
                    endif;
                    ?>
                    <!--pagseguro payment gateway addon-->
                    <?php
                    if (addon_status('pagseguro') == 1) :
                        include "pagseguro_payment_gateway.php";
                    endif;
                    ?>
                    <!--mercadopago payment gateway addon-->
                    <?php
                    if (addon_status('mercadopago') == 1) :
                        include "mercadopago_payment_gateway.php";
                    endif;
                    ?>
                    <!--ccavenue payment gateway addon-->
                    <?php
                    if (addon_status('ccavenue') == 1) :
                        include "ccavenue_payment_gateway.php";
                    endif;
                    ?>
                    <!--flutterwave payment gateway addon-->
                    <?php
                    if (addon_status('flutterwave') == 1) :
                        include "flutterwave_payment_gateway.php";
                    endif;
                    ?>
                    <!--paytm payment gateway addon-->
                    <?php
                    if (addon_status('paytm') == 1) :
                        include "paytm_payment_gateway.php";
                    endif;
                    ?>

                    <!--offline payment gateway addon-->
                    <?php
                    if (addon_status('offline_payment') == 1) :
                        include "offline_payment_gateway.php";
                    endif;
                    ?>
                </div>

                
                <div class="col-md-8">
                    <div class="w-100">
                        <p class="pb-2 payment-header text-center"><?php echo get_phrase('order'); ?> <?php echo get_phrase('summary'); ?></p>
                        <?php $counter = 0; $total_price  = 0;
                            $cartItems = $this->session->userdata('cart_items'); ?>
                        <?php foreach ($cartItems as $batches_arr):

                        //    $course_details = $this->crud_model->get_course_by_id($batches_arr)->row_array();

                            $counter++;

                      //      $instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array(); ?>

                           
                               <?php 

                                        $batches = array();
                                        $batch_details = $this->Batch_model->get_batch_by_id($batches_arr['id'])->row_array();?>
                                        <table class="table" style="width: 100%">

                                         <tr>
                                       <td>
                                           <div class="name prd-name">
                                                  <?php echo site_phrase('Batch - '); ?><?php  echo $batches_arr['name']; ?>
                                           </div>
                                       </td>
                                         <td>
                                               <div class="name prd-name">
                                                  <?php  echo $batches_arr['qty']; ?>
                                               </div>
                                         </td>
                                         <td>
                                             <div class="name prd-name">
                                                 <?php $total_price += $batches_arr['price']*$batches_arr['qty']; ?>
                                                 <?php  echo $batches_arr['price']*$batches_arr['qty']; ?>
                                             </div>
                                         </td>
                                         </tr>
                                     </table>
                                    </span>

                            </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="w-100 float-left mt-4 indicated-price">
                        <div class="float-right total-price"><?php echo currency($total_price_of_checking_out); ?></div>
                        <div class="float-right total"><?php echo get_phrase('total'); ?></div>
                    </div>
                    <div class="w-100 float-left">
                        <form action="<?php echo site_url('home/paypal_checkout'); ?>" method="post" class="paypal-form form">
                            <hr class="border mb-4">
                            <input type="hidden" name="total_price_of_checking_out" value="<?php echo $total_price_of_checking_out; ?>">
                            <button type="submit" class="payment-button float-right"><?php echo get_phrase('pay_by_paypal'); ?></button>
                        </form>

                        <div class="razorpay-form form">
                            <form action="<?php echo site_url('home/pay'); ?>" method="post" class="razorpay-form form">

                                <hr class="border mb-4">
                                <input type="hidden" name="total_price_of_checking_out" value="<?php echo $total_price_of_checking_out; ?>">
                                <button type="submit" class="payment-button float-right"><?php echo get_phrase('pay_by_razorpay'); ?></button>
                                <?php //include "razorpay/razorpay_payment_gateway_form.php"; ?>
                            </form>
                        </div>
                        <!--Paystack payment gateway addon-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

  </div>

          
<script type="text/javascript">
    function selectedPaymentGateway(gateway) {
        if (gateway == 'paypal') {

            $(".payment-gateway").css("border", "2px solid #D3DCDD");
            $('.tick-icon').hide();
            $('.form').hide();

            $(".paypal").css("border", "2px solid #00D04F");
            $('.paypal-icon').show();
            $('.paypal-form').show();
        }
        else if (gateway == 'razorpay') {

            $(".payment-gateway").css("border", "2px solid #D3DCDD");
            $('#payumoney-icon').hide();
            $('.form').hide();

            $(".razorpay").css("border", "2px solid #00D04F");
            $('#payumoney-icon').hide();
            $('.razorpay-form').show();

        }
    }
</script>
