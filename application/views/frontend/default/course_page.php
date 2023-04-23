<?php
$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
//$instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.1/moment.min.js"></script>
<style>batchChkBox
    .course-curriculum-accordion .lecture-group-title .title{
        max-width: 100%!important;
    }
    /*.course-curriculum-accordion .lecture-group-title .title{
        display: inline-block;
    }*/

   input.custom-control-input{
        right: 7px;
        background-color: #fff!important;
        top: 14px;
        left: auto;
        color: #000;
        border: 2px solid#000;
        width: 1.3rem;
        height: 1.3rem;
        z-index: 999;
        opacity: 11;
    }
    .checkbox-checker{position: absolute;
        position: absolute;
        right: 39px;
        top: -8px;
        height: 43px;
        line-height: 43px;
        padding-right: 31px;
        margin-top: 10px;
    }
    .check-ivond{    
        position: absolute;
        right: 11px;
        top: 17px;
       z-index: 9;
       font-size: 12px;
        color:#ec5252;
       display: none
    }

.custom-control-input:checked~.custom-control-label::before {
    background: none!important;
}

.custom-control-label::before{
    position: absolute;
    top: .25rem;
    left: 0;
    display:none;
    width: 1rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  background: none!important;}


.course-curriculum-accordion .lecture-group-title .title {
    max-width: 100%;
    font-weight: 600;
}


.title.float-right.buy-again {
    color: #007bff;
    font-weight: 800;
}
     

    .checkbox-checker > input[type="checkbox"]:checked + .check-ivond{display: block !important;}
</style>
<section class="course-header-area">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="course-header-wrap">
                    <h1 class="title"><?php echo $course_details['title']; ?></h1>
                    <p class="subtitle"><?php echo $course_details['short_description']; ?></p>
                    <div class="rating-row">
                        <span class="course-badge best-seller"><?php echo ucfirst($course_details['level']); ?></span>
                        <!--?php
                        $total_rating =  $this->crud_model->get_ratings('course', $course_details['id'], true)->row()->rating;
                        $number_of_ratings = $this->crud_model->get_ratings('course', $course_details['id'])->num_rows();

                        if ($number_of_ratings > 0) {
                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                        }else {
                            $average_ceil_rating = 0;
                        }

                        for($i = 1; $i < 6; $i++):?>
                            <!?php if ($i <= $average_ceil_rating): ?>
                                <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                            <!?php else: ?>
                                <i class="fas fa-star"></i>
                            <!?php endif; ?>
                        <!?php endfor; ?>
                        <span class="d-inline-block average-rating"><!?php echo $average_ceil_rating; ?></span><span>(<!?php echo $number_of_ratings.' '.site_phrase('ratings'); ?>)</span>
                        <span class="enrolled-num">
            <?php
                        //  $number_of_enrolments = $this->crud_model->enrol_history($course_details['id'])->num_rows();
                        //echo $number_of_enrolments.' '.site_phrase('students_enrolled');
                        ?>
          </span-->
                    </div>
                    <div class="created-row">
                        <?php if ($course_details['last_modified'] > 0): ?>
                            <span class="last-updated-date"><?php echo site_phrase('last_updated : ').' '.date('D, d-M-Y', $course_details['last_modified']); ?></span>
                        <?php else: ?>
                            <span class="last-updated-date"><?php echo site_phrase('last_updated : ').' '.date('D, d-M-Y', $course_details['date_added']); ?></span>
                        <?php endif; ?>
                        <span class="comment"><i class="fas fa-comment"></i><?php echo ucfirst($course_details['language']); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="course-sidebar natural">

                    <div class="course-sidebar-text-box">
                            <!-- WISHLIST BUTTON -->
                            <div class="buy-btns">
                                <button class="btn btn-add-wishlist <?php echo $this->crud_model->is_added_to_wishlist($course_details['id']) ? 'active' : ''; ?>" type="button" id = "<?php echo $course_details['id']; ?>" onclick="refreshShoppingCart(this)">
                                    <?php
                                    if($this->crud_model->is_added_to_wishlist($course_details['id'])){
                                        echo site_phrase('added_to_wishlist');
                                    }  else{
                                        echo site_phrase('add_to_wishlist');
                                    }
                                    ?>
                                </button>
                            </div>
                                <div class="buy-btns">
                                    <a href = "javascript::" class="btn btn-buy-now" id = "course_<?php echo $course_details['id']; ?>" onclick="handleBuyNow(this)"><?php echo site_phrase('buy_now'); ?></a>
                                    <?php if (in_array($course_details['id'], $this->session->userdata('cart_items'))): ?>
                                        <button class="btn btn-add-cart addedToCart" type="button"  id = "<?php echo $course_details['id']; ?>" onclick="handleCartItems(this)"><?php echo site_phrase('added_to_cart'); ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-add-cart" type="button" id = "<?php echo $course_details['id']; ?>" onclick="handleCartItems(this)"><?php echo site_phrase('add_to_cart'); ?></button>
                                    <?php endif; ?>
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 
<section class="course-content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <div class="what-you-get-box">
                    <div class="what-you-get-title"><?php echo site_phrase('what_will_i_learn'); ?>?</div>
                    <ul class="what-you-get__items">
                        <label hidden id="cartBatchId" name ="cartBatchId"/>
                        <?php foreach (json_decode($course_details['outcomes']) as $outcome): ?>
                            <?php if ($outcome != ""): ?>
                                <li><?php echo $outcome; ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <br>
                <div class="course-curriculum-box">
                    <div class="course-curriculum-accordion">
                        <?php
                        // $sections = $this->crud_model->get_section('batches', $course_id)->result_array();
                        $batches = $this->crud_model->get_section('batches', $course_id);
                        $counter = 0;

                        foreach ($batches as $batch):
                            $instructor_name ='';
                            $instructors = $this->crud_model->get_Instructor($batch['instructor_id'])->result_array();
                            $my_batches = $this->crud_model->purchase_history_by_batch_id($batch['id'])->result_array();

                            
                                foreach ($instructors as $instructor):
                                    $instructor_name = $instructor['student_first_name'].' '.$instructor['student_last_name'];
                                endforeach;
                                ?>

                                <div class="lecture-group-wrapper accordion-wrapper" style="position: relative">
                                    <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse<?php echo $batch['id']; ?>" aria-expanded="<?php if($counter == 0) echo 'true'; else echo 'false' ; ?>">
                                        <table style="min-width: 100%;">
                                            <tr><td class="title">
                                                    <?php  echo $batch['title']; ?>

                                                </td>
                                                <td class="title">
							<span style="margin-left: 8px;font-weight: bold;color: #ec5252;">Instructor <?php  echo $instructor_name; ?></span>

						  
                                                </td>
                                            </tr>
                                            <tr><td>
                                                    <?php  echo $batch['description']; ?>                                  </td>
                                                <td>
						 <?php if(count($my_batches)>0)  {?>
								  <div class="title float-right buy-again"><?php echo site_phrase('buy_again'); ?></div>

                                                <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Number of Sessions <?php  echo $batch['number_of_sessions']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Total Price
                                                    <span class="item-price">
                                                   <span class="current-price"><?php echo currency($batch['batch_price']); ?></span>
                                               </span>

                                                </td>
                                            </tr>

                                        </table>
                                    </div>


				<div class="title float-right checkbox-checker">
                                        
<input type="checkbox" name="check[]" class="custom-control-input" value="<?php echo $course_details['id'].'_'.$batch['id']; ?>"/>
<label class="custom-control-label" for="add_batch_to_cart">
                                        </label>


                                    </div>
                                                                        <div id="collapse<?php echo $batch['id']; ?>" class="lecture-list collapse <?php if($counter == 0) echo 'show'; ?>">
                                        <div id="calendar<?php echo $batch['id']; ?>" ></div>
                                    </div>
                                </div>
                                <?php
                                $counter++;
                        endforeach;
                        if($counter==0){
                            ?>
                            <div class="title float-left"><?php echo site_phrase('No_Batches_present_for_this_course'); ?></div>
                            <?php
                        }
                        ?>
                    </div>

                </div>
                <div class="requirements-box">
                    <div class="requirements-title"><?php echo site_phrase('requirements'); ?></div>
                    <div class="requirements-content">
                        <ul class="requirements__list">
                            <?php foreach (json_decode($course_details['requirements']) as $requirement): ?>
                                <?php if ($requirement != ""): ?>
                                    <li><?php echo $requirement; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="description-box view-more-parent">
                    <div class="view-more" onclick="viewMore(this,'hide')">+ <?php echo site_phrase('view_more'); ?></div>
                    <div class="description-title"><?php echo site_phrase('description'); ?></div>
                    <div class="description-content-wrap">
                        <div class="description-content">
                            <?php echo $course_details['description']; ?>
                        </div>
                    </div>
                </div>



                </div>

            </div>
           </section>

<style media="screen">
    .embed-responsive-16by9::before {
        padding-top : 0px;
    }
</style>
<script type="text/javascript">

   var vals = [];


    function convertTimetoString(sec)
    {
        var d = new Date(sec);

        var fullDate = d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        return fullDate ;
    }

  

    function handleCartItems(elem) {

        url1 = '<?php echo site_url('home/handleCartItems');?>';
        url2 = '<?php echo site_url('home/refreshWishList');?>';

        if(vals.length==0)
        {
            alert("Please select a Batch.");
            return;
        }

        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : vals},
            success: function(response)
            {
                $('#cart_items').html(response);
                if ($(elem).hasClass('addedToCart')) {
                    $(elem).removeClass('addedToCart')
                    $(elem).text("<?php echo site_phrase('add_to_cart'); ?>");
                }else {
                    $(elem).addClass('addedToCart')
                    $(elem).text("<?php echo site_phrase('add_to_cart'); ?>");
                }
                $.ajax({
                    url: url2,
                    type : 'POST',
                    success: function(response)
                    {
                        $('#wishlist_items').html(response);
                    }
                });
            }
        });

    }

    function handleBuyNow(elem) {

        url1 = '<?php echo site_url('home/handleCartItemForBuyNowButton');?>';
        url2 = '<?php echo site_url('home/refreshWishList');?>';
        urlToRedirect = '<?php echo site_url('home/shopping_cart'); ?>';
      //  var explodedArray = elem.id.split("_");
        //var course_id = explodedArray[1];


        if(vals.length==0)
        {
            alert("Please select a Batch.");
            return;
        }

        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : vals},
            success: function(response)
            {
                $('#cart_items').html(response);
                $.ajax({
                    url: url2,
                    type : 'POST',
                    success: function(response)
                    {

                        $('#wishlist_items').html(response);

                        //toastr.warning('<?php echo site_phrase('please_wait').'....'; ?>');
                        //setTimeout(
                          //  function()
                            //{
                              //  window.location.replace(urlToRedirect);
                            //}, 1500);
                    }
                });
            }
        });
    }

    function handleEnrolledButton() {
        $.ajax({
            url: '<?php echo site_url('home/isLoggedIn');?>',
            success: function(response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }
            }
        });
    }

    function handleAddToWishlist(elem) {
        $.ajax({
            url: '<?php echo site_url('home/handleWishList');?>',
            type : 'POST',
            data : {course_id : elem.id},
            success: function(response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }else {
                    if ($(elem).hasClass('active')) {
                        $(elem).removeClass('active');
                        $(elem).text("<?php echo site_phrase('add_to_wishlist'); ?>");
                    }else {
                        $(elem).addClass('active');
                        $(elem).text("<?php echo site_phrase('added_to_wishlist'); ?>");
                    }
                    $('#wishlist_items').html(response);
                }
            }
        });
    }

    function pausePreview() {
        player.pause();
    }



    $(".custom-control-input").click(function (){

        if(!$(this).children(".custom-control-input").is(":checked")){
            $(this).children(".custom-control-input").prop("checked",true);
            var batchId = $(this).val();
	     vals = [];
             vals.push(batchId);


        }else{
            $(this).children(".custom-control-input").prop("checked",false);
            vals.pop($(this).children(".custom-control-input").val());

        }

    })

    $("#cartBatchId").val(vals);


    $(document).ready(function() {
        <?php foreach ($batches as $batch ):
        $schedules = $this->crud_model->get_batch_schedules($batch['id'])->result_array();

        ?>

        $('#calendar<?php echo $batch['id']; ?>').fullCalendar({

            eventSources: [
                {
                    color: '#727cf5',
                    textColor: '#ffffff',
                    events:[
                        <?php

                        // $today_date = strtotime("+4 hours 30 min");
                        foreach ($schedules as $key => $schedule){

                        $post_time  = date("Y-m-d", $schedule['start_date']);
                        $time = date("H:i:s", $schedule['start_time']);
                        $start_time = $post_time. ' '.$time;
                        $end_time = date("H:i:s",$schedule['start_time'] + 60 * $schedule['duration']);
                        $end_date_time = $post_time.' '.$end_time;
                        ?>
                        { color: '#00000',
                            title:"<?php  echo $schedule['title']?>",
                            start:"<?php echo $start_time ?>",
                            end:"<?php echo $end_date_time ?>",

                            <?php if($end_date_time > date('Y-m-d H:i:s',$today_date)){?>
                            color:'purple',
                            <?php } ?>
                            <?php if(date('Y-m-d H:i:s',$today_date) > $end_date_time){?>
                            color:'grey'
                            <?php } ?>
                        },
                        <?php } ?>
                    ],



                }

            ],
            eventMouseover: function (data, event, view) {
                var start = event.start;
                tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#ccccff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'Start' + ': ' + moment(data.start).format("D-MMM-YY HH:mm") + '</br>'+ 'End' + ': ' + moment(data.end).format("D-MMM-YY HH:mm");


                $("body").append(tooltip);
                $(this).mouseover(function (e) {
                    $(this).css('z-index', 10000);
                    $('.tooltiptopicevent').fadeIn('500');
                    $('.tooltiptopicevent').fadeTo('10', 1.9);
                }).mousemove(function (e) {
                    $('.tooltiptopicevent').css('top', e.pageY + 10);
                    $('.tooltiptopicevent').css('left', e.pageX + 20);
                });


            },
        });
        <?php endforeach; ?>
    });
$(".custom-control-input").change(function() {
  $(".custom-control-input").prop('checked', false);
  $(this).prop('checked', true);
});

</script>
