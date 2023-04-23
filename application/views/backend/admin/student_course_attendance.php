<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.1/moment.min.js"></script>
<style>batchChkBox
    .course-curriculum-accordion .lecture-group-title .title{
        display: inline-block;
    }
    .custom-control-label::before{
        right: 7px;
        background-color: #dee2e6;
        top: 14px;
        left: auto;

    }
    .checkbox-checker{position: absolute;
        right: 0;
        top: 0;
        height: 43px;
        line-height: 43px;
        padding-right: 31px;}
    .check-ivond{    position: absolute;
        right: 9px;
        top: 17px;
        z-index: 9;
        font-size: 11px;
        color: white;display: none}
    .checkbox-checker > input[type="checkbox"]:checked + .check-ivond{display: block !important;}

</style>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php $page_title; ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="my-courses-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="course-curriculum-box">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left"><?php echo site_phrase('my_courses'); ?></div>
                   </div>
                    <?php
                    // $sections = $this->crud_model->get_section('batches', $course_id)->result_array();



                    foreach ($payments as $payment):

                        $batch_details = $this->Batch_model->get_batch_by_id($payment['batch_id'])->result_array();

                        $counter = 0;

                        foreach ($batch_details as $batch):

                            $instructors = $this->crud_model->get_Instructor($batch['instructor_id'])->result_array();
                            $instructor_name ='';

                            foreach ($instructors as $instructor):
                                $instructor_name = $instructor['student_first_name'].' '.$instructor['student_last_name'];
                            endforeach;
                            ?>
                            <div class="course-curriculum-accordion">
                                <div class="lecture-group-wrapper accordion-wrapper" style="position: relative">
                                    <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse<?php echo $payment['id']; ?>" aria-expanded="<?php if($counter == 0) echo 'true'; else echo 'false' ; ?>">
                                        <div class="title float-left">
                                            <?php  echo $batch['title']; ?>
                                        </div>
                                        <div class="title">
                                             <span style="    margin-left: 8px;
    font-weight: bold;
    color: #ec5252;">Instructor <?php  echo $instructor_name; ?></span>
                                        </div>
                                    </div>

                                    <div id="collapse<?php echo $payment['id']; ?>" class="lecture-list collapse <?php if($counter == 0) echo 'show'; ?>">
                                        <div id="calendar<?php echo $payment['id']; ?>" ></div>
                                    </div>
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

                    <?php endforeach; ?>
                </div>
           </div>
        </div>
    </div>
    <div class="col-lg-4"></div>
    </div>
</section>


<script type="text/javascript">
    function convertTimetoString(sec){
        var d = new Date(sec);

        var fullDate = d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        return fullDate ;
    }

    function getCourseDetailsForRatingModal(course_id) {
        $.ajax({
            type : 'POST',
            url : '<?php echo site_url('home/get_course_details'); ?>',
            data : {course_id : course_id},
            success : function(response){
                $('#course_title_1').append(response);
                $('#course_title_2').append(response);
                $('#course_thumbnail_1').attr('src', "<?php echo base_url().'uploads/thumbnails/course_thumbnails/';?>"+course_id+".jpg");
                $('#course_thumbnail_2').attr('src', "<?php echo base_url().'uploads/thumbnails/course_thumbnails/';?>"+course_id+".jpg");
                $('#course_id_for_rating').val(course_id);
                // $('#instructor_details').text(course_id);
                console.log(response);
            }
        });
    }

    $(document).ready(function() {
        <?php
        foreach ($payments as $payment):

        $batch_details = $this->Batch_model->get_batch_by_id($payment['batch_id'])->result_array();

        $counter = 0;

        foreach ($batch_details as $batch):

        $schedule_start_date = $payment['date_added'];

        $schedule_expiry_date = $payment['schedule_expiry_date'];

        $schedule_last_date = $payment['schedule_last_date'];

        $unpaid_schedule_date = $payment['unpaid_schedule_date'];

        $schedules = '';

        if($unpaid_schedule_date==null or $unpaid_schedule_date=='')
        {
            $schedules = $this->crud_model->get_student_batch_schedules($batch['id'],$schedule_start_date,$schedule_expiry_date)->result_array();
        }
        if($schedule_expiry_date > $unpaid_schedule_date)
        {
            $schedules = $this->crud_model->get_student_batch_schedules($batch['id'],$schedule_start_date,$schedule_expiry_date)->result_array();
        }
        else if($schedule_expiry_date < $unpaid_schedule_date)
        {
            $schedules = $this->crud_model->get_student_batch_schedules($batch['id'],$schedule_start_date,$unpaid_schedule_date)->result_array();
        }
        $today_date = strtotime("now");
        ?>

        $('#calendar<?php echo $payment['id']; ?>').fullCalendar({

            eventSources: [
                {
                    color: '#727cf5',
                    textColor: '#ffffff',
                    events:[
                        <?php foreach ($schedules as $key => $schedule)
                        {
                            $post_time  = date("Y-m-d", $schedule['start_date']);
                            $time = date("H:i:s", $schedule['start_time']);
                            $start_time = $post_time. ' '.$time;
                            $end_time = date("H:i:s",$schedule['start_time'] + 60 * $schedule['duration']);
                            $end_date_time = $post_time.' '.$end_time;

                            $attendances = $this->crud_model->get_student_batch_attendance($schedule['id'],$payment['user_id'])->result_array();
                            $status = 'absent';
				
                            foreach ($attendances as $attendance)
                            {
                                $status = 'present';
                            }
 
                        ?>
                        {

                            color: '#00000',
                            title:"<?php echo $schedule['id'] ?>",
                            start:"<?php echo $start_time ?>",
                            end:"<?php echo $end_date_time ?>",

                            <?php if($today_date  >= $start_time){?>
                            <?php if($status == 'absent'){?>
                            color:'red'
                            <?php }?>
                            <?php if($status == 'present'){?>
                            color:'green'
                            <?php }?>
                            <?php }?>
                        },
                        <?php } ?>
                    ],


                }

            ],
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
        <?php endforeach; ?>
        <?php endforeach; ?>
    });
</script>
