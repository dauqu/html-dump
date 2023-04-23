<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('schedules'); ?>
                    <a href="<?php echo site_url('admin/schedule_form/add_schedule?batch_id='.$selected_batch_id); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_new_schedule'); ?></a>

                    <?php  $queryString = array();
                    if(isset($_GET['batch_id']))
                        $queryString['batch_id']=$_GET['batch_id'];
                    if(isset($_GET['status']))
                        $queryString['status']= $_GET['status'];
                    if(isset($_GET['user_id']))
                        $queryString['user_id']= $_GET['user_id'];
                    if(isset($_GET['view'])){
                        if($_GET['view'] == 'list'){
                            $queryString['view']= 'cal';
                            $v_text = 'calender_view';
                            $class = 'mdi-calendar';
                        }
                        if($_GET['view'] == 'cal'){
                            $class = 'mdi-view-list';
                            $v_text = 'list_view';
                            $queryString['view']= 'list';
                        }
                    }
                    ?>
                    <a href="<?php echo site_url('admin/schedules?'.http_build_query($queryString)); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi <?php echo $class; ?> "></i><?php echo get_phrase( $v_text); ?></a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('schedule_list'); ?></h4>
                <form class="row justify-content-center" action="<?php echo site_url('admin/schedules?view='.$GET['view']); ?>" method="get">
                    <!-- Course Categories -->
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="batch_id"><?php echo get_phrase('batches'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="batch_id" id="batch_id">
                                <option value ="all" ><?php echo get_phrase('all'); ?></option>
                                <?php  foreach ($batches as $batch):  ?>
                                    <option value="<?php echo $batch['id']; ?>"><?php echo $batch['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="view" value="<?php echo $selected_view; ?>">
                        </div>
                    </div>

                    <!-- Course Status -->
                    
                    <div class="col-xl-2">
                        <label for=".." class="text-white">..</label>
                        <button type="submit" class="btn btn-primary btn-block" ><?php echo get_phrase('filter'); ?></button>

                    </div>
                </form>

                <div class="table-responsive-sm mt-4" id="list1" style="display: none;">
                    <?php
                    $events =array();
                    if (count($schedules) > 0): ?>
                        <table id="course-datatable" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase('title'); ?></th>
                                <th><?php echo get_phrase('start_date'); ?></th>
                                <th><?php echo get_phrase('start_time'); ?></th>
                                <th><?php echo get_phrase('duration'); ?></th>
                                <th><?php echo get_phrase('batch'); ?></th>
                                <th><?php echo get_phrase('action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($schedules as $key => $schedule):
//print_r($schedule);die;
                                $events[$k]['title'] = $schedule['title'];
                                $events[$k]['start'] = date('Y-m-d',$schedule['start_date']);
                                $events[$k]['end'] = date('Y-m-d',$schedule['start_time']);

                                $schedule_detail = json_decode($schedule['meeting_detail'], true);

                                $course_details = $this->crud_model->get_course_by_id($schedule['course_id'])->row_array();
                                $batch_detail = $this->Batch_model->get_batch_by_id($schedule['batch_id'])->row_array();
                                $host_details = $this->user_model->get_all_user($schedule['host_id'])->row_array();

//                                if ($course['status'] == 'draft') {
//                                    continue;;
//                                }
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <strong><a href="<?php echo site_url('admin/schedule_form/schedule_edit/'.$schedule['id']); ?>"><?php echo ellipsis($schedule['title']); ?></a></strong><br>
                                        <small class="text-muted"><?php echo get_phrase('host').': <b>'.$host_details['student_first_name'].' '.$host_details['student_last_name'].'</b>'; ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo date('d-m-Y',$schedule['start_date']); ?>,<?php echo date('D', $schedule['start_date']); ?></small><br>
                                        <!--                                        <small class="text-muted">--><?php //echo '<b>'.get_phrase('total_lesson').'</b>: '.$lessons->num_rows(); ?><!--</small><br>-->
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo date('h:i:s A',$schedule['start_time']) ?></small><br>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo $schedule['duration']. ' minutes'; ?></small><br>
                                    </td>

                                    <td>
                                        <strong class="text-muted"><a href="<?php echo site_url('admin/batch_form/batch_edit/'.$batch_detail['id']);?>"> <?php echo $batch_detail['title']; ?></a></strong><br>
                                    </td>
                                    <td>
                                        <div class="dropright dropright">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php if (is_null($schedule['occurrence_id'])  || ($schedule['occurrence_id'] == 0) ): ?>
                                                    <li><a class="dropdown-item" href="<?php echo site_url('admin/schedule_form/schedule_edit/'.$schedule['id'].'/-1'); ?>"><?php echo get_phrase('edit_schedule');?></a></li>
                                                <?php else: ?>
                                                    <li><a class="dropdown-item" href="<?php echo site_url('admin/schedule_form/schedule_edit/'.$schedule['id'].'/'.$batch_detail['id']); ?>"><?php echo get_phrase('edit_all_occurrences_of_schedule');?></a></li>
                                                    <li><a class="dropdown-item" href="<?php echo site_url('admin/schedule_form/schedule_edit/'.$schedule['id'].'/0'); ?>"><?php echo get_phrase('edit_this_occurrences_of_schedule');?></a></li>

                                                <?php endif; ?>
                                                <!--  --><?php //if($schedule['status']== 'waiting'): ?>
                                                <li><a class="dropdown-item" href="<?php echo $schedule_detail['start_url'] ?>" target="blank"><?php echo get_phrase('start_meeting');?></a></li>
                                                <!--                                              --><?php //endif ?>
                                                <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/schedule_actions/delete/'.$schedule['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <?php if (count($schedules) == 0): ?>
                        <div class="img-fluid w-100 text-center">
                            <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
                            <?php echo get_phrase('no_data_found'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class=" mt-4" id="cal" style="display: none">
                    <div id="calendar" ></div>
                </div>

            </div>
        </div>
    </div>

    <script >
        function convertTimetoString(sec){
            var d = new Date(sec);

            var fullDate = d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
            return fullDate ;
        }
        $(document).ready(function() {
            let sv = "<?php echo $_GET['view']; ?>";
            if(sv == 'cal') {
                $('#cal').css('display', 'block');
                $('#list1').css('display', 'none');
            }
            if(sv == 'list') {
                $('#list1').css('display', 'block');
                $('#cal').css('display', 'none');
            }
            $('#calendar').fullCalendar({

                eventSources: [
                    {
                        color: '#727cf5',
                        textColor: '#ffffff',
                        events:[
                            <?php
                      //      date_default_timezone_set("Asia/Calcutta");
                           // $today_date = strtotime("+4 hours 30 min");
                            foreach ($schedules as $key => $schedule){

                            $post_time  = date("Y-m-d", $schedule['start_date']);
                            $time = date("H:i:s", $schedule['start_date']);
                            $start_time = $post_time. ' '.$time;
                            $end_time = date("H:i:s",$schedule['start_date'] + 60 * $schedule['duration']);
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
