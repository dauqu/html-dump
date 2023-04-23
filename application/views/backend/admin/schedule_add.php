<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('add_new_schedule'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('schedule_add_form'); ?></h4>

                    <form class="required-form" action="<?php echo site_url('admin/schedule_actions/add?batch_id='.$batch_id); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title"><?php echo get_phrase('title'); ?><span class="required">*</span></label>
                            <input type="text" class="form-control" id="title" name = "title" required>
                        </div>

                        <div class="form-group">
                            <label for="start_date"><?php echo get_phrase('start_date'); ?><span class="required">*</span></label>
                            <input type="text" name="start_date" class="form-control date" readonly id="start_date" data-toggle="date-picker" data-single-date-picker="true">
                            <!--                            <input type="hidden" name="total_batch_hours" value="--><?php //echo $batch_detail['hours'] ?><!--">-->
                        </div>

                        <div class="form-group">
                            <label for="start_time"><?php echo get_phrase('start_time'); ?><span class="required">*</span></label>
                            <input type="text" name="start_time" class="form-control" id="start_time" data-toggle="timepicker" data-single-date-picker="true" value="<?php echo date('h:i:s A', $live_class['time']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="hours"><?php echo get_phrase('duration'); ?> <small>(minutes)</small><span class="required">*</span></label>
                            <input type="number" name="duration" class="form-control" id="duration" onfocusout="validateDuration()">
                        </div>

                        <div class="form-group">
                            <label for="start_date"><?php echo get_phrase('end_date'); ?><span class="required">*</span></label>
                            <input type="text" name="end_date" class="form-control date" readonly id="end_date" data-toggle="date-picker" data-single-date-picker="true">
                        </div>

                        <div class="form-group">
                            <label for="meeting_id"><?php echo get_phrase('meeting_id'); ?><span class="required">*</span></label>
                            <input type="text" name="meeting_id" class="form-control " id="meeting_id"  required >
                        </div>

                        <div class="form-group">
                            <label for="join_url"><?php echo get_phrase('join_url'); ?><span class="required">*</span></label>
                            <input type="url"  name="join_url" class="form-control " placeholder="Please enter http or https " id="meeting_url"  required >
                        </div>

                        <div class="form-group">
                            <label for="time_zone"><?php echo get_phrase('time_zone'); ?></label>
                            <input type="text" name="time_zone" class="form-control" id="time_zone"   value="Asia/Kolkata" readonly>
                        </div>
                        <div class="form-group">
                            <label for="recurring"></label>
                            <input type="checkbox" name="recurring"  id="recurring" >&nbsp;&nbsp;<?php echo get_phrase('recurring_meeting'); ?>
                        </div>
                        <div id="recurring_div" style="display: none;">
                            <div class="form-group">
                                <label for="recurence_type"></label>
                               <select name="recurence_type" class="form-control" id="recurence_type">
                                   <option value="1"><?php echo get_phrase('daily'); ?></option>
                                   <option value="2"><?php echo get_phrase('weekly'); ?></option>
                               </select>
                            </div>
                        </div>

                        <div class="weekDays-selector">
                            <input type="checkbox" id="weekday-mon" name="weekday[]" value="1" class="weekday" />
                            <label for="weekday-mon">Mon</label>
                            <input type="checkbox" id="weekday-tue" name="weekday[]" value="2"  class="weekday" />
                            <label for="weekday-tue">Tue</label>
                            <input type="checkbox" id="weekday-wed" name="weekday[]" value="3"  class="weekday" />
                            <label for="weekday-wed">Wed</label>
                            <input type="checkbox" id="weekday-wed" name="weekday[]" value="4"  class="weekday" />
                            <label for="weekday-thu">Thu</label>
                            <input type="checkbox" id="weekday-fri" name="weekday[]" value="5"  class="weekday" />
                            <label for="weekday-fri">Fri</label>
                            <input type="checkbox" id="weekday-sat" name="weekday[]"  value="6"  class="weekday" />
                            <label for="weekday-sat">Sat</label>
                            <input type="checkbox" id="weekday-sun" name="weekday[]" value="7"  class="weekday" />
                            <label for="weekday-sun">Sun</label>
                        </div>

                        <div class="form-group">
                            <label for="password"><?php echo get_phrase('password'); ?><span class="required">*</span></label>
                            <input type="text" name="password" class="form-control date" id="password" maxlength="10" required>
<!--                            <input type="hidden" name="total_batch_hours" value="--><!--?php //echo $batch_detail['hours'] ?><--">-->
                        </div>

                        <!--div class="form-group">
                            <label for="course_id"><!?php echo get_phrase('course'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id" required>
                                <option value="<!?php echo $course_detail['id']; ?>"><!?php echo $course_detail['title']; ?></option>
                            </select>
                        </div-->

                        <div class="form-group">
                            <label for="batch_id"><?php echo get_phrase('batch'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="batch_id" id="batch_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($batch_details as $batch_detail):?>

                                     <option value="<?php echo $batch_detail['id']; ?>" <?php if($batch_id == $batch_detail['id'] ) echo 'selected';?>><?php echo $batch_detail['title']; ?></option>
                               <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="host_id"><?php echo get_phrase('host'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="host_id" id="host_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($instructors as $instructor):?>

                                    <option value="<?php echo $instructor['id']; ?>" ><?php echo $instructor['student_first_name'].' '.$instructor['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label for="alternative_hosts">--><?php //echo get_phrase('alternative_hosts'); ?><!--</label>-->
<!--                            <input type="text" name="alternative_hosts" class="form-control date" id="alternative_hosts">-->
<!--                        </div>-->

                        <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase("submit"); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script type="text/javascript">
    function checkCategoryType(category_type) {
        if (category_type > 0) {
            $('#thumbnail-picker-area').hide();
            $('#icon-picker-area').hide();
        }else {
            $('#thumbnail-picker-area').show();
            $('#icon-picker-area').show();
        }
    }
    
    $(document).ready(function () {
        var recuring = $('#recurring').val();
        if(recuring==1)
        {
           $('#recurring_div').css('display','block');
            $('.weekDays-selector').css('display','none');
        }

        $('#recurring').click(function () {
            if($(this).prop('checked'))
                $('#recurring_div').css('display','block');
            else
                $('#recurring_div').css('display','none');
        });

        var recurence_type = $('#recurence_type').val();
        if(recurence_type == 2)
        {
            $('.weekDays-selector').css('display','block');
        }else{
            $('.weekDays-selector').css('display','none');
        }
    });

    $('#recurence_type').change(function () {
        var selected_val = $(this).val();

        if(selected_val == 2)
        {
            $('.weekDays-selector').css('display','block');
        }
        else
        {
            $('.weekDays-selector').css('display','none');
        }
    });



    function ValidURL(str) {
        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        if(!regex .test(str)) {
            alert("Please enter valid URL.");
            return false;
        } else {
            return true;
        }
    }

   function validateDuration()
   {
	var duration = document.getElementById("duration").value;
	if(duration > 60)
	{
		alert("Maximum value for duration is 60");
		document.getElementById("duration").value = 60;
	}
	if(duration < 30)
	{
		alert("Minimum value for duration is 30");
		document.getElementById("duration").value = 30;
	}



  }




</script>
