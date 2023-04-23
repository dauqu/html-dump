<?php
// RazorPay API configuration
$user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
$userName = $user_details['student_first_name'].' '.$user_details['student_last_name'];
$email = $user_details['email'];
$contact = $user_details['contact_no'];
$currency = get_settings('razorpay_currency');
$payment_request='';

// Convert product price to cent
$razorpayAmount = round($total_price_of_checking_out*100, 2);

if ($razorpay[0]->razorpay_mode == 'on') {
    define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_key);
    define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_key);
} else {
    define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_live_key);
    define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_live_key);
}

define('RAZORPAY_SUCCESS_URL', 'home/razorpay_payment/'.$user_details['id'].'/'.$payment_request);
if ($payment_request == "only_for_mobile") {
    define('RAZORPAY_CANCEL_URL', site_url('home/payment'));
}else{
    $course_id = $this->session->userdata('cart_items');
    define('RAZORPAY_CANCEL_URL','home/payment_success_mobile/' . $course_id[0] . '/' . $user_details['id'] . '/error');
}

?>
<style type="text/css">
    .main {
        margin-left:30px;
        font-family:Verdana, Geneva, sans-serif, serif;
    }
    .text {
        float:left;
        width:180px;
    }
    .dv {
        margin-bottom:5px;
    }
</style>

<div class="main">
    <div id="razorpayPaymentResponse" class="text-danger"></div>

    <!-- Buy button -->
    <div id="buynow" style="height: 45px;">
        <button class="stripe-button payment-button float-right buy_now" id="razorPayButton"><?php echo get_phrase("pay_with_razorpay"); ?></button>
    </div>


</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var SITEURL = "<?php echo base_url() ?>";
    $('body').on('click', '.buy_now', function(e){
        $('.buy_now').attr('disabled',true);
        var totalAmount = "<?php echo $razorpayAmount ?>";
        var product_id =  "1";
        var options = {
            "key": "<?php echo RAZOR_API_KEY  ?>",
            "amount": totalAmount, // 2000 paise = INR 20
            "name": "<?php echo $userName ?>",
            "email":"<?php echo $email ?>",
            "contact":"<?php echo $contact ?>",
            "currency": "<?php echo $currency ?>",
            "description": "Payment",
            "image": "http://localhost/young-achievers/uploads/system/logo-dark.png",
            "prefill":{"email":"<?php echo $email ?>","contact":"<?php echo $contact ?>"},
            "handler": function (response){
                $.ajax({
                    url: SITEURL + "<?php echo RAZORPAY_SUCCESS_URL ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        razorpay_payment_id: response , totalAmount : totalAmount ,product_id : product_id,
                    },
                    success: function (msg) {
                        window.location.href = SITEURL + 'home/RazorThankYou';
                    },
                    error:function (msg) {
                        
                    }
                });
            },
            "theme": {
                "color": "#528FF0"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    });
</script>
