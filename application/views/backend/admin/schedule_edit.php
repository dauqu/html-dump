<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('edit_schedule'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div-- class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('schedule_edit_form'); ?></h4>

                    <form class="required-form"  action="<?php echo site_url('admin/schedule_actions/edit?batch_id='.$batch_id.'&schedule_id='.$schedule_id); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title"><?php echo get_phrase('title'); ?><span class="required">*</span></label>
                            <input type="text" class="form-control" id="title" name = "title" value="<?php echo $schedule_detail['title'];?>" required>
                            <input type="hidden" class="form-control"  id="occurrence_id" name = "occurrence_id" value="<?php echo $occurrence_id;?>">
                            <input type="hidden" class="form-control"  id="meeting_id" name = "meeting_id" value="<?php echo $schedule_detail['meeting_id'];?>">

                        </div>

                        <div class="form-group">
                            <label for="start_date"><?php echo get_phrase('start_date'); ?><span class="required">*</span></label>
                            <input type="text" name="start_date" readonly class="form-control date" id="start_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo date('m/d/Y', $schedule_detail['start_date'])?>">
                        </div>

                        <div class="form-group">
                            <label for="start_time"><?php echo get_phrase('start_time'); ?><span class="required">*</span></label>
                            <input type="text" name="start_time" class="form-control" id="start_time" data-toggle="timepicker" data-single-date-picker="true" value="<?php echo date('h:i:s A', $schedule_detail['start_time']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="duration"><?php echo get_phrase('duration'); ?> <small>(minutes)</small><span class="required">*</span></label>
                            <input type="text"  name="duration" class="form-control" id="duration"  data-single-date-picker="true" value="<?php echo $schedule_detail['duration']; ?>" onfocusout="validateDuration()">
                        </div>
                        <div class="form-group">
                            <label for="time_zone"><?php echo get_phrase('time_zone'); ?></label>
                            <input type="text" name="time_zone" class="form-control" id="time_zone"   value="Asia/Kolkata" readonly>
                        </div>



                        <div class="form-group">
                            <label for="password"><?php echo get_phrase('password'); ?><span class="required">*</span></label>
                            <input type="text" name="password" class="form-control date" id="password" maxlength="10" required value="<?php echo $schedule_detail['password'];?>">
                        </div>


                        <div class="form-group">
                            <label for="meeting_id"><?php echo get_phrase('meeting_id'); ?><span class="required">*</span></label>
                            <input type="text" name="meeting_id" class="form-control " id="meeting_id"  value="<?php echo $schedule_detail['meeting_id'];?>" required >
                        </div>

                        <div class="form-group">
                            <label for="join_url"><?php echo get_phrase('join_url'); ?><span class="required">*</span></label>
                            <input type="url"  name="join_url" class="form-control " value="<?php echo $schedule_detail['join_url'];?>" placeholder="Please enter http or https " id="meeting_url"  required >
                        </div>



                        <div class="form-group">
                            <label for="batch_id"><?php echo get_phrase('batch'); ?><span class="required">*</span></label>
                            <select disabled class="form-control select2" data-toggle="select2" name="batch_id" id="batch_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($batch_details as $batch_detail):?>
				   <option value="<?php echo $batch_detail['id']; ?>" <?php if( $batch_detail['id'] == $schedule_detail['batch_id']) echo 'selected';?>><?php echo $batch_detail['title']; ?></option>
                               <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="host_id"><?php echo get_phrase('Host'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="host_id" id="host_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($instructors as $instructor):?>

                                    <option value="<?php echo $instructor['id']; ?>" <?php if($instructor['id'] == $schedule_detail['host_id'] ) echo 'selected'; ?>><?php echo $instructor['student_first_name'].' '.$instructor['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label for="alternative_hosts">--><?php //echo get_phrase('alternative_hosts'); ?><!--</label>-->
<!--                            <input type="text" name="alternative_hosts" class="form-control date" id="alternative_hosts">-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="status"><?php echo get_phrase('status'); ?><span class="required">*</span></label>

                                <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
                                    <option value="active" <?php if($selected_status == 'active') echo 'selected'; ?>><?php echo get_phrase('active'); ?></option>
                                    <option value="pending" <?php if($selected_status == 'pending') echo 'selected'; ?>><?php echo get_phrase('pending'); ?></option>
                                </select>

                        </div>


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
