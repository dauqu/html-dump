<?php
// PAYUMONEY API configuration
$payumoney_keys = get_settings('payumoney_keys');
$values = json_decode($payumoney_keys);
if ($values[0]->testmode == 'on') {
    $public_key = $values[0]->payumoney_public_key;
    $private_key = $values[0]->payumoney_secret_key;
    $public_key ="A0LRStCV";
    $private_key ="ou7nnlLARP";
} else {
    $public_key = $values[0]->payumoney_public_live_key;
    $private_key = $values[0]->payumoney_secret_live_key;

    $public_key ="A0LRStCV";
    $private_key ="ou7nnlLARP";
}

define('PAYUMONEY_API_KEY', $private_key);
define('PAYUMONEY_PUBLISHABLE_KEY', $public_key);

$cartItems = $this->session->userdata('cart_items');
$product_info='';
foreach ($cartItems as $key => $batches_arr):
    $product_info ="[".$key.",(";

foreach ($batches_arr as $batch):
    $product_info = $product_info.$batch['id'].',';
    endforeach;
    $product_info = $product_info.")],";
    endforeach;


if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
    //Request hash
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if(strcasecmp($contentType, 'application/json') == 0){
        $data = json_decode(file_get_contents('php://input'));
        $hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
        $json=array();
        $json['success'] = $hash;
        echo json_encode($json);

    }
    exit(0);
}

function getCallbackUrl()
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   // print $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/home/payumoney_success';die;

    return $protocol . $_SERVER['HTTP_HOST'] .'/young-achievers/home/payumoney_success';
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
    <div id="payumoneyPaymentResponse" class="text-danger"></div>

    <!--form action="#" id="payment_form"-->
    <form action="https://secure.payu.in/_payment" id="payment_form"  name="payment_form" method=POST >
        <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
        <input type="hidden" id="surl" name="surl" value="<?php echo getCallbackUrl(); ?>" />
        <input type="hidden" id="furl" name="furl" value="<?php echo getCallbackUrl(); ?>" />
        <input  type="hidden" type="text" id="key" name="key" placeholder="Merchant Key" value="<?php echo $public_key; ?>" />

        <input  type="hidden" type="text" id="salt" name="salt" placeholder="Merchant Salt" value="<?php echo $private_key; ?>"  />

        <!--input  type="hidden" type="text" id="key" name="key" placeholder="Merchant Key" value="<!?php echo $public_key; ?>" />

        <input  type="hidden" type="text" id="salt" name="salt" placeholder="Merchant Salt" value="<!?php echo $private_key; ?>" /-->


        <input  type="hidden" type="text" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,99999999)?>" />

        <input type="hidden" type="text" id="amount" name="amount" placeholder="Amount" value="<?php echo $total_price_of_checking_out; ?>"  />
        <input type="hidden" type="text" id="productinfo" name="productinfo" placeholder="Product Info" value="<?php echo $product_info; ?>" />
        <input type="hidden" id="hash" name="hash" placeholder="Hash" value="" />

        <div class="dv">
            <span class="text"><label>First Name:</label></span>
            <span><input type="text" id="firstname" name="firstname" placeholder="First Name" value="" /></span>
        </div>

        <div class="dv">
            <span class="text"><label>Email ID:</label></span>
            <span><input type="text" id="email" name="email" placeholder="Email ID" value="" /></span>
        </div>

        <div class="dv">
            <span class="text"><label>Mobile/Cell Number:</label></span>
            <span><input type="text" id="phone" name="phone" placeholder="Mobile/Cell Number" value="" /></span>
        </div>


        <div class="dv payumoney-button payment-button float-right"><input type="submit" value="<?php echo get_phrase("pay_with_payumoney"); ?>"  /></div>
        <!--button class="payumoney-button payment-button float-right" id="payumoneyButton" onclick="launchBOLT();return false;"><!?php echo get_phrase("pay_with_payumoney"); ?></button>

        <!--div><input type="submit" value="Pay" onclick="launchBOLT(); return false;" /></div-->
    </form>
</div>
<script type="text/javascript"><!--
    $('#payment_form').bind('keyup blur', function(){
       
        $.ajax({
            url: '/young-achievers/home/generateHash',
            type: 'post',
            data: JSON.stringify({
                key: $('#key').val(),
                salt: $('#salt').val(),
                txnid: $('#txnid').val(),
                amount: $('#amount').val(),
                pinfo: $('#productinfo').val(),
                fname: $('#firstname').val(),
                email: $('#email').val(),
                mobile: $('#mobile').val(),
                udf5: $('#udf5').val()
            }),
            contentType: "application/json",
            dataType: 'json',
            success: function(json) {
                if (json['error']) {
                    $('#alertinfo').html('<i class="fa fa-info-circle"></i>'+json['error']);
                }
                else if (json['success']) {
                    $('#hash').val(json['success']);
                }
            }
        });
    });
    //-->
</script>

