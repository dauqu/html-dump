<?php
$batch_details = $this->Batch_model->get_batch_by_id($batch_id)->row_array();
$tomorrow = strtotime('tomorrow');
$batch_schedule_detail = $this->Batch_model->get_schedules('all',$_GET['batch_id'],'all',$tomorrow);
$schedule_count = 1;
$schedule_expiry_date = '';
$schedule_last_date = '';
foreach ($batch_schedule_detail as $batch_schedule):
    $schedule_count ++;

    $schedule_last_date = $batch_schedule['start_date'];
    
    if($schedule_count == $batch_details['number_of_sessions'])
    {
        $schedule_expiry_date = $batch_schedule['start_date'];
    }
    endforeach;
?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('offline_payment'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('batch_offline_payment'); ?></h4>

                    <form class="required-form" action="<?php echo site_url('admin/make_offline_payment?batch_id='.$batch_id); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title"><?php echo get_phrase('title'); ?><span class="required">*</span></label>
                            <input type="text" class="form-control" id="title" name = "title" value="<?php echo $batch_details['title']; ?>" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="student_id"><?php echo get_phrase('student'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="student_id" id="student_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>" <?php if($batch_details['host_id'] == $user['id'] ) echo 'selected';?>><?php echo $user['student_first_name'].' '.$user['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course_id"><?php echo get_phrase('course'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id"  required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php  foreach ($courses as $course):  ?>

                                    <option value="<?php echo $course['id']; ?>" <?php if($batch_details['course_id'] == $course['id'] ) echo 'selected';?>><?php echo $course['title']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_type"><?php echo get_phrase('payment_type'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="payment_type" id="payment_type" required>
                                <?php  foreach ($payment_types as $payment_type):  ?>
                                    <option value="<?php echo $payment_type; ?>"><?php echo $payment_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="number_of_sessions"><?php echo get_phrase('number_of_sessions'); ?><span class="required">*</span></label>
                            <input type="number" class="form-control" id="number_of_sessions" name = "number_of_sessions" onchange="updateScheduleExpiryDate()" placeholder="<?php echo get_phrase('number_of_sessions'); ?>"  value="<?php echo $batch_details['number_of_sessions']; ?>" min="1" max="20" required >
                        </div>

                        <div class="form-group">
                            <label for="amount"><?php echo get_phrase('amount'); ?><span class="required">*</span></label>
                            <input type="number" class="form-control" id="amount" name = "amount" placeholder="<?php echo get_phrase('amount'); ?>" min="0" value="<?php echo $batch_details['batch_price']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="schedule_start_date"><?php echo get_phrase('schedule_start_date'); ?><span class="required">*</span></label>
                            <input type="text" name="schedule_start_date" class="form-control date" id="schedule_start_date" data-toggle="date-picker" data-single-date-picker="true" ">
                        </div>

                        <div class="form-group">
                            <label for="schedule_expiry_date"><?php echo get_phrase('schedule_expiry_date'); ?><span class="required">*</span></label>
                            <input type="text" name="schedule_expiry_date" class="form-control date" id="schedule_expiry_date" data-toggle="date-picker" data-single-date-picker="true" value = "<?php echo date('m/d/Y', $schedule_expiry_date); ?>">
                        </div>

                        <div class="form-group">
                            <label for="schedule_last_date"><?php echo get_phrase('schedule_last_date'); ?><span class="required">*</span></label>
                            <input type="text" name="schedule_last_date" class="form-control date" id="schedule_last_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $schedule_last_date); ?>">
                        </div>

			<div class="form-group">
				<h5 class="mb-3 header-title"><?php echo get_phrase('payment_made_by'); ?></h5>
			</div>

                        <div class="form-group">
                            <label for="first_name"><?php echo get_phrase('first_name'); ?></label>
                            <input type="text" class="form-control" id="first_name" name = "first_name">
                        </div>

                        <div class="form-group">
                            <label for="email_id"><?php echo get_phrase('email_id'); ?></label>
                            <input type="text" class="form-control" id="email_id" name = "email_id" >
                        </div>

                        <div class="form-group">
                            <label for="mobile_number"><?php echo get_phrase('mobile_number'); ?></label>
                            <input type="text" class="form-control" id="mobile_number" name = "mobile_number">
                        </div>


                        <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase("submit"); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script type="text/javascript">
    function updateScheduleExpiryDate()
    {
        var number_of_sessions = document.getElementById("number_of_sessions").value;

        url1 = '<?php echo site_url('home/updateScheduleExpiryDate');?>';

        $.ajax({
            url: url1,
            type : 'POST',
            data : { batch_id : <?php $_GET['batch_id'] ?>, number_of_sessions : number_of_sessions },
            success: function(response)
            {

                $(document).ready(function(){
                    location.reload(true);

                });

            }
        });


    }

    function checkCategoryType(category_type) {
        if (category_type > 0) {
            $('#thumbnail-picker-area').hide();
            $('#icon-picker-area').hide();
        }else {
            $('#thumbnail-picker-area').show();
            $('#icon-picker-area').show();
        }
    }
</script>
