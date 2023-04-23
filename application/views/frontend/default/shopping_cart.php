<style>
    .cart-course-wrapper{
        justify-content: initial;
    }
    .product-batchs{
        font-size: 18px;
        color: #084484 !important;
        margin-bottom: 4px !important;
    }
    body .cart-course-wrapper .details .prd-name{
        display: inline-block !important;
        font-size: 13px;
        margin-top: 0px;
        background: #ec5252;
        color: white !important;
        padding: 4px;
        border-radius: 3px;
        font-weight: 600 !important;
    }
    .wrapper-cour{    display: flex;
        justify-content: space-between;
        margin-top: 10px;}
    .cart-course-wrapper .details{    -webkit-box-flex: 0;
        -ms-flex: 0 0 53%;
        flex: 0 0 83%;
        max-width: 83%;
        padding-left: 10px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.1/moment.min.js"></script>
<?php
$actual_price = 0;
$total_price  = 0;
$courses = array();


$cartItems = $this->session->userdata('cart_items');

//                            foreach ($this->session->userdata('cart_items') as $cart_item):
//                                $course_batch_arr = explode('_',$cart_item);
//                            if (in_array($course_batch_arr[0], $courses))
//                              {
//
//                              }
//                            else{
//                                array_push($courses, $course_batch_arr[0]);
//                            }
//                            endforeach;
?>
<section class="page-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo site_phrase('shopping_cart'); ?></a></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo site_phrase('shopping_cart'); ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="cart-list-area">
    <div class="container">
        <div class="row" id = "cart_items_details">
            <div class="col-lg-9">

                <div class="in-cart-box">
                    <div class="title"><?php echo sizeof($cartItems).' '.site_phrase('courses_in_cart'); ?></div>
                    <div class="">
                        <ul class="cart-course-list">
                            <li>
                                <div class="cart-course-wrapper">

                                    <div class="details">
                                        <table class="table" style="width: 100%">
                                            <tr>
                                                <th>Title</th>
                                                <th>Sessions</th>
                                                <th>Price</th>
                                                <th>SubTotal</th>
                                                <th>Action</th>
                                            </tr>


                                            <?php
                                            $counter = 0;
                                            foreach ($cartItems as $batch):

                                                $batches = array();
                                                //  print_r($batch);

                                                $batch_details = $this->Batch_model->get_batch_by_id($batch['id'])->row_array();


                                                $instructors = $this->crud_model->get_Instructor($batch_details['instructor_id'])->result_array();
                                                $instructor_name ='';


                                                $total_hours = $batch_details['hours'];
                                                $number_of_sessions = $batch_details['number_of_sessions'];
                                                $total_number_of_sessions = $batch_details['total_number_of_sessions'];

                                                // print_r($batch);die;

                                                $val = floor($total_number_of_sessions/$number_of_sessions);

                                                $quantities = array();

                                                for($i=1;$i<=$val;$i++){
                                                    $quantities[] = $number_of_sessions*$i;
                                                }

                                                foreach ($instructors as $instructor):
                                                    $instructor_name = $instructor['student_first_name'].' '.$instructor['student_last_name'];
                                                endforeach;
                                                ?>
                                                <div class="wrapper-cour">
                                                    <tr>
                                                        <td>
                                                            <div class="name prd-name">
                                                                <?php echo site_phrase('Batch - '); ?><?php  echo $batch_details['title']; ?>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control"  name="quantity" id="quantity" onchange="updatePrice(this,<?php echo $batch_details['course_id']; ?>, <?php echo $batch_details['id']; ?>)" >
                                                                    <option value="0"><?php echo get_phrase('Sessions'); ?></option>
                                                                    <?php $q = 1; foreach ($quantities as $quantity):?>

                                                                        <option value="<?php echo $q; ?>" <?php echo  ($q==$batch['qty']? 'selected':'')?>><?php echo $quantity; ?></option>

                                                                        <?php $q++; endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="name prd-name" id="price_<?php echo $batch_details['id']; ?>" data-price="<?php echo $batch['price']; ?>">
                                                                <?php  echo currency($batch['price']); ?>

                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="price">
                                                                <a href="">
                                                                    <?php if ($course_details['discount_flag'] == 1): ?>
                                                                        <div id="discounted_price_<?php echo $batch_details['id']; ?>" class="current-price" >
                                                                            <?php
                                                                            $total_price += $batch['qty']*$batch_details['discounted_price'];
                                                                            echo currency($batch['qty']*$batch_details['discounted_price']);
                                                                            ?>
                                                                        </div>
                                                                        <div id="current-price_<?php echo $batch_details['id']; ?>" class="original-price" >
                                                                            <?php
                                                                            $actual_price += $batch['qty']*$batch_details['batch_price'];
                                                                            echo currency($batch['qty']*$batch_details['batch_price']);
                                                                            ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="current-price" id="discounted_price_<?php echo $batch_details['id']; ?>" >
                                                                            <?php
                                                                            $actual_price += $batch['qty']*$batch_details['batch_price'];
                                                                            $total_price  += $batch['qty']*$batch_details['batch_price'];
                                                                            echo currency($batch['qty']*$batch_details['batch_price']);
                                                                            ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <span class="coupon-tag">
<!--                                                            <i class="fas fa-tag"></i>-->
                                                        </span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="move-remove">
                                                                <div id = "<?php echo $batch['id']; ?>" onclick="removeFromCartList(this, <?php echo $batch_details['course_id']; ?>,<?php echo $batch_details['id']; ?>)"><?php echo site_phrase('remove'); ?></div>
                                                                <!-- <div>Move to Wishlist</div> -->
                                                            </div>
                                                        </td>
                                                </div>
                                                <?php
                                                $counter++;

                                            endforeach; ?>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </li>


                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="cart-sidebar">
                    <div class="total"><?php echo site_phrase('total'); ?>:</div>
                    <span id = "total_price_of_checking_out" hidden><?php echo $total_price; $this->session->set_userdata('total_price_of_checking_out', $total_price);?>
                    </span>
                    <div class="total-price"><?php echo currency($total_price); ?></div>
                    <div class="total-original-price">
                        <?php if ($course_details['discount_flag'] == 1): ?>
                            <span class="original-price"><?php echo currency($actual_price); ?></span>
                        <?php endif; ?>
                        <!-- <span class="discount-rate">95% off</span> -->
                    </div>
                    <button type="button" class="btn btn-primary btn-block checkout-btn" onclick="handleCheckOut()"><?php echo site_phrase('checkout'); ?></button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://www.paypalobjects.com/js/external/dg.js"></script>
<script>
    var dgFlow = new PAYPAL.apps.DGFlow({ trigger: 'submitBtn' });
    dgFlow = top.dgFlow || top.opener.top.dgFlow;
    dgFlow.closeFlow();
    // top.close();
</script>

<script type="text/javascript">
    function removeFromCartList(obj, course_id, batch_id)
    {
        var value = course_id + '_' + batch_id ;

        url1 = '<?php echo site_url('home/removeCartItems');?>';

        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : value },
            success: function(response)
            {

                $(document).ready(function(){
                    location.reload(true);

                });

            }
        });


    }

    function handleCheckOut() {
        $.ajax({
            url: '<?php echo site_url('home/isLoggedIn');?>',
            success: function(response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }else if("<?php echo $total_price; ?>" > 0){
                    // $('#paymentModal').modal('show');
                    //$('.total_price_of_checking_out').val($('#total_price_of_checking_out').text());

                    window.location.replace("<?php echo site_url('home/payment'); ?>");
                }else{
                    toastr.error('<?php echo site_phrase('there_are_no_courses_on_your_cart');?>');
                }
            }
        });
    }

    function handleCartItems(elem) {
        url1 = '<?php echo site_url('home/handleCartItems');?>';
        url2 = '<?php echo site_url('home/refreshWishList');?>';
        url3 = '<?php echo site_url('home/refreshShoppingCart');?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : elem.id},
            success: function(response)
            {
                $('#cart_items').html(response);
                if ($(elem).hasClass('addedToCart')) {
                    $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                    $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('add_to_cart'); ?>");
                }else {
                    $('.big-cart-button-'+elem.id).addClass('addedToCart')
                    $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('added_to_cart'); ?>");
                }
                $.ajax({
                    url: url2,
                    type : 'POST',
                    success: function(response)
                    {
                        $('#wishlist_items').html(response);
                    }
                });

                $.ajax({
                    url: url3,
                    type : 'POST',
                    success: function(response)
                    {
                        $('#cart_items_details').html(response);
                    }
                });
            }
        });
    }
    function updatePrice(obj, course_id, batch_id){

        var selectedValue = obj.value;
        var price = $("#price_"+batch_id).attr('data-price');

        if(price=='')
        {
            var price = $("#discounted_price_"+batch_id).attr('data-price');
        }
        var cal_price = selectedValue*price;

        $("#discounted_price_"+batch_id).attr('data-price',cal_price);
        $("#discounted_price_"+batch_id).text(cal_price);

        var value = course_id + '_' + batch_id + '_' + selectedValue;
        url1 = '<?php echo site_url('home/refreshCartItems');?>';

        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : value },
            success: function(response)
            {

                $(document).ready(function(){
                    location.reload(true);

                });

            }
        });

    }
    /*
    $('#quantity').change(function (){
        var selectedValue = $(this).val();
        var price = $('.current-price').attr('data-price');
        alert(" Value: " + selectedValue+"quantity "+price);
        })
    */

    // function updatebatchprice(quantity) {
    //     var selectedText = quantity.options[quantity.selectedIndex].innerHTML;
    //     var selectedValue = quantity.value;
    //     var plant = document.getElementsByClassName('current-price');
    //     alert(plant.dataset);
    //     var quantity123 = plant.dataset.price;
    //     alert("Selected Text: " + selectedText + " Value: " + selectedValue+"quantity "+quantity123);
    // }
</script>
