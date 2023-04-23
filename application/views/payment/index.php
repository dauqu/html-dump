<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $page_title.' | '.get_settings('system_name'); ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="<?php echo get_settings('author') ?>" />

    <meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
    <meta name="description" content="<?php echo get_settings('website_description'); ?>" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php include 'includes_top.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- this meta viewport is required for BOLT //-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
    <!-- BOLT Sandbox/test //-->
    <script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
            color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
    <!-- BOLT Production/Live //-->
    <!--// script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script //-->
    <link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/bootstrap.min.css'; ?>">
    <link name="favicon" type="image/x-icon" href="<?php echo base_url().'uploads/system/favicon.png' ?>" rel="shortcut icon" />

</head>
<body>
<?php include 'payment_gateway.php'; ?>
<?php
include 'includes_bottom.php';
// include 'includes_top.php';
if(get_frontend_settings('cookie_status') == 'active'):
    include 'eu-cookie.php';
endif;
?>
</body>
</html>
