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
</style>


<section class="course-content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="course-curriculum-box">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left"><?php echo $course_name;?></div>
                        <div class="float-right">
              <span class="total-lectures">
                <?php //echo $this->crud_model->get_lessons('course', $course_details['id'])->num_rows().' '.site_phrase('lessons'); ?>
              </span>
                            <span class="total-time">
                <?php
                //echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course_details['id']);
                ?>
              </span>
                        </div>
                    </div>
                    <div class="course-curriculum-accordion">
                        <?php

                            $instructor_name ='';

                           $instructors = $this->crud_model->get_Instructor($batch_details['instructor_id'])->result_array();

                           foreach ($instructors as $instructor):
                                 $instructor_name = $instructor['student_first_name'].' '.$instructor['student_last_name'];
                           endforeach;
                            ?>

                                <div class="lecture-group-wrapper accordion-wrapper" style="position: relative">
                                    <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse<?php echo $batch['id']; ?>" aria-expanded="<?php if($counter == 0) echo 'true'; else echo 'false' ; ?>">

                                    <table style="min-width: 100%;">
                                            <tr><td class="title">
                                                    <?php  echo $batch_details['title']; ?>

                                                </td>
                                                <td class="title">
                                                    <span style="margin-left: 8px;font-weight: bold;color: #ec5252;">Instructor <?php  echo $instructor_name; ?></span>
                                                </td>
                                            </tr>
                                            <tr><td>
                                                    <?php  echo $batch_details['description']; ?>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Number of Sessions <?php  echo $batch_details['number_of_sessions']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="title float-left">
                                                    Total Price
                                                    <span class="item-price">
                                                   <span class="current-price"><?php echo currency($batch_details['batch_price']); ?></span>
                                               </span>

                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    </div>

                        <div id="collapse<?php echo $batch_details['id']; ?>" class="lecture-list">
                            <div id="calendar<?php echo $batch_details['id']; ?>" ></div>
                        </div>

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

    function convertTimetoString(sec){
        var d = new Date(sec);

        var fullDate = d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        return fullDate ;
    }

    $(document).ready(function() {
        $('#calendar<?php  echo $batch_details['id']; ?>').fullCalendar({

            eventSources: [
                {
                    color: '#727cf5',
                    textColor: '#ffffff',
                    events:[
                        <?php
                        $today_date = strtotime("+4 hours 30 min");

                        foreach ($schedules as $key => $schedule){

                        $post_time  = date("Y-m-d", $schedule['start_date']);
                        $time = date("H:i:s", $schedule['start_time']);
                        $start_time = $post_time. ' '.$time;
                        $end_time = date("H:i:s",$schedule['start_time'] + 60 * $schedule['duration']);
                        $end_date_time = $post_time.' '.$end_time;
                       //$schedule['title']
                        ?>
                        {
                            color: '#00000',
                            title:"<?php  echo $schedule['title']?>",
                            start:"<?php echo $start_time ?>",
                            end:"<?php echo $end_date_time ?>",

                            <?php if((date('Y-m-d H:i:s',$today_date)  >= $start_time) && (date('Y-m-d H:i:s',$today_date) < $end_date_time)){?>
                               url : "<?php echo "http://localhost/young-achievers/home/attendance?schedule_id=".$schedule['id'] ?>" ,
                            <?php } ?>

                            <?php if($end_date_time > date('Y-m-d H:i:s',$today_date)){?>
                            color:'purple',
                            <?php } ?>
                            <?php if(date('Y-m-d H:i:s',$today_date) > $end_date_time){?>
                            color:'grey'
                            <?php }?>
                        },
                        <?php } ?>
                    ],


                }

            ],eventClick: function(event) {
                // If extern url/domain
                if (event.url.indexOf(document.location.hostname) === -1) {
                    // Open url in new window
                   window.open(event.url, "_blank");
                   // Deactivate original link
                    return false;
                }
            },
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

    });
</script>
