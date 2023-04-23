<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.1/moment.min.js"></script>
<style>batchChkBox
    .course-curriculum-accordion .lecture-group-title .title{
        max-width: 100%!important;
    }
    /*.course-curriculum-accordion .lecture-group-title .title{
        display: inline-block;
    }*/
    .custom-control-label::before{
        right: 7px;
        background-color: #dee2e6;
        top: 14px;
        left: auto;

    }
    .checkbox-checker{position: absolute;
        position: absolute;
        right: 0;
        top: 0;
        height: 43px;
        line-height: 43px;
        padding-right: 31px;
        margin-top: 10px;
    }
    .check-ivond{    position: absolute;
        right: 9px;
        top: 17px;
        z-index: 9;
        font-size: 11px;
        color: white;display: none}
    .checkbox-checker > input[type="checkbox"]:checked + .check-ivond{display: block !important;}

h5.title.rating {
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 10px;
}

.btn {
    width: 49%;
}
.btn-primary {
    color: #fff;
    background-color: #007bff!important;
    border-color: #007bff!important;
    padding: 11px 20px!important;
    font-size: 15px !important;
    border-radius: 2px !important;
    line-height: 1.35135 !important;
    font-weight: 600 !important;
    float: right;
}
</style>
<section class="course-content-area">
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-8">
                          <div class="course-curriculum-box">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left"><?php echo site_phrase('My_Batches'); ?></div>

                    </div>
                    <div class="course-curriculum-accordion">
                        <?php
                        // $sections = $this->crud_model->get_section('batches', $course_id)->result_array();
                       // print_r($payments);die;
                        foreach ($payments as $payment):
                             $my_batches = $this->Batch_model->get_batch_by_id($payment['batch_id'])->result_array();
                           // print_r($my_batches);die;
                            //$batches = $this->crud_model->get_section('batches', $payment['course_id'])->result_array();
                            $counter = 0;
                       foreach ($my_batches as $my_batch):
                            //print_r($batch['id']);die;
                            $instructor_name ='';
                            $instructors = $this->crud_model->get_Instructor($my_batch['instructor_id'])->result_array();

                                foreach ($instructors as $instructor):
                                    $instructor_name = $instructor['student_first_name'].' '.$instructor['student_last_name'];
                                endforeach;
                            
                                ?>

                                <div class="lecture-group-wrapper accordion-wrapper" style="position: relative">
                                    <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse<?php echo $my_batch['id']; ?>" aria-expanded='true'>
                                        <table style="min-width: 100%;">
                                            <tr><td class="title">
                                                    <?php  echo $my_batch['title']; ?>
                                                </td>
                                                <!--td class="title">
                                                    <span style="margin-left: 8px;font-weight: bold;color: #ec5252;">Instructor <!?php  echo $instructor_name; ?></span>
                                                </td-->
<td> <div class="cancel-btns">
                    					<button type="button" class="btn btn-primary" onclick="markattendance(<?php echo $my_batch['id']; ?>)">Mark Present</button>
    </div></td>


                                            </tr>
                                            <?php print $my_batch['title'];?>
                                            <tr><td>
                                                    <?php  echo $my_batch['description']; ?>                                  </td>
                                                <td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Number of Sessions <?php  echo $my_batch['number_of_sessions']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Total Price
                                                    <span class="item-price">
                                                   <span class="current-price"><?php echo currency($my_batch['batch_price']); ?></span>
                                               </span>

                                                </td>
                                            </tr>

                                        </table>
                                    </div>

                                    <div id="collapse<?php echo $my_batch['id']; ?>" class="lecture-list collapse <?php if($counter == 0) echo 'show'; ?>">
                                        <div id="calendar<?php echo $my_batch['id']; ?>" ></div>
                                    </div>
                                    
         
                    </div>

<div class="row">   
<div class="col-lg-4">
    
<div class="course-details" style=" padding-bottom: 10px;" id="course_rating_view_<?php echo $my_batch['id']; ?>">
                                  <h5 class="title rating">Rating</h5>
                                                      							<form class="" action="" method="post">
                    								<div class="form-group select">
                    									<div class="styled-select">
                    										<select class="form-control rating-section" name="star_rating" id="star_rating_of_course_<?php echo $my_batch['id']; ?>">
                    											<option value="1">1 Out of 5</option>
                    											<option value="2">2 Out of 5</option>
                    											<option value="3">3 Out of 5</option>
                    											<option value="4">4 Out of 5</option>
                    											<option value="5">5 Out of 5</option>
                    										</select>
                    									</div>
                    								</div>
                    								<div class="form-group add_top_<?php echo $my_batch['id']; ?>">
                    									<textarea name="review" id="review_of_a_course_<?php echo $my_batch['id']; ?>" class="form-control" style="height:120px;" placeholder="Write your review here"></textarea>
                    								</div>
    
    
    <div class="cancel-btns">
                    								<button type="" class="btn" onclick="publishRating(<?php echo $my_batch['id']; ?>)" name="button">Publish </button>
                    								<a href="javascript::" class="btn" onclick="toggleRatingView(<?php echo $my_batch['id']; ?>)" name="button">Cancel </a> </div>
                    							</form>
                                </div>
     </div>
</div>



                                <?php
                                $counter++;
                        endforeach;
                        endforeach;
                        if($counter==0){
                            ?>
                            <div class="title float-left"><?php echo site_phrase('No_Batches_present'); ?></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<?php if ($course_details['video_url'] != ""):
    $provider = "";
    $video_details = array();
    if ($course_details['course_overview_provider'] == "html5") {
        $provider = 'html5';
    }else {
        $video_details = $this->video_model->getVideoDetails($course_details['video_url']);
        $provider = $video_details['provider'];
    }
    ?>
    <div class="modal fade" id="CoursePreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content course-preview-modal">
                <div class="modal-header">
                    <h5 class="modal-title"><span><?php echo site_phrase('course_preview') ?>:</span><?php echo $course_details['title']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="pausePreview()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="course-preview-video-wrap">
                        <div class="embed-responsive embed-responsive-16by9">
                            <?php if (strtolower(strtolower($provider)) == 'youtube'): ?>
                                <!------------- PLYR.IO ------------>
                            <link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">

                                <div class="plyr__video-embed" id="player">
                                    <iframe height="500" src="<?php echo $course_details['video_url'];?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                </div>

                                <script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
                                <script>const player = new Plyr('#player');</script>
                                <!------------- PLYR.IO ------------>
                            <?php elseif (strtolower($provider) == 'vimeo'): ?>
                                <!------------- PLYR.IO ------------>
                            <link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">
                                <div class="plyr__video-embed" id="player">
                                    <iframe height="500" src="https://player.vimeo.com/video/<?php echo $video_details['video_id']; ?>?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                </div>

                                <script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
                                <script>const player = new Plyr('#player');</script>
                                <!------------- PLYR.IO ------------>
                            <?php else :?>
                                <!------------- PLYR.IO ------------>
                            <link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">
                                <video poster="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['id']);?>" id="player" playsinline controls>
                                    <?php if (get_video_extension($course_details['video_url']) == 'mp4'): ?>
                                        <source src="<?php echo $course_details['video_url']; ?>" type="video/mp4">
                                    <?php elseif (get_video_extension($course_details['video_url']) == 'webm'): ?>
                                        <source src="<?php echo $course_details['video_url']; ?>" type="video/webm">
                                    <?php else: ?>
                                        <h4><?php site_phrase('video_url_is_not_supported'); ?></h4>
                                    <?php endif; ?>
                                </video>

                                <style media="screen">
                                    .plyr__video-wrapper {
                                        height: 450px;
                                    }
                                </style>

                                <script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
                                <script>const player = new Plyr('#player');</script>
                                <!------------- PLYR.IO ------------>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Modal -->

<style media="screen">
    .embed-responsive-16by9::before {
        padding-top : 0px;
    }
</style>
<script type="text/javascript">

    $(document).ready(function() {
        <?php
        foreach ($payments as $payment):

        $my_batches = $this->Batch_model->get_batch_by_id($payment['batch_id'])->result_array();
        $counter = 0;
       foreach ($my_batches as $batch):
       $schedules = $this->crud_model->get_batch_schedules($batch['id'])->result_array();
        ?>

        $('#calendar<?php echo $batch['id']; ?>').fullCalendar({

            eventSources: [
                {
                    color: '#727cf5',
                    textColor: '#ffffff',
                    events:[
                        <?php
                        $today_date = strtotime("+5 hours 30 min");
                        foreach ($schedules as $key => $schedule){
                        $post_time  = date("Y-m-d", $schedule['start_date']);
                        $time = date("H:i:s", $schedule['start_time']);
                        $start_time = $post_time. ' '.$time;
                        $end_time = date("H:i:s",$schedule['start_time'] + 60 * $schedule['duration']);
                        $end_date_time = $post_time.' '.$end_time;

                        ?>
                        {
                            color: '#00000',
                            title:"<?php  echo $schedule['title']?>",
                            start:"<?php echo $start_time ?>",
                            end:"<?php echo $end_date_time ?>",

                            <?php if($end_date_time > date('Y-m-d H:i:s',$today_date)){?>
                            color:'purple',
                            <?php if($time <= date('H:i:s',$today_date)){?>
                            url: '<?php  echo $schedule['join_url']?>',
                            <?php } ?>
                            <?php } ?>
                            <?php if(date('Y-m-d H:i:s',$today_date) > $end_date_time){?>
                            color:'grey'
                            <?php }?>
                        },
                        <?php } ?>
                    ],

                }

            ],
		eventClick: function(event) 
		{
    			if (event.url) 
			{
				window.open(event.url, "_blank");
				return false; 
				 
           	        }

        	               }

	    ,
            eventMouseover: function (data, event, view) {
                var start = event.start;
                tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#ccccff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'Start Time' + ': ' + moment(data.start).format("D-MMM-YY HH:mm") + '</br>'+ 'End Time' + ': ' + moment(data.end).format("D-MMM-YY HH:mm");

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
        <?php
              endforeach;
              endforeach;
              ?>
    });

function markattendance(batch_id) {

        $.ajax({
            url: '<?php echo site_url('home/attendance');?>',
            type : 'POST',
            data : {batch_id : batch_id},

            success: function(response)
            {
               
            }
        });
    }

</script>
