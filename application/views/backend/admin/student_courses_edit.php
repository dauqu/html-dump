
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('edit_batch'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('batch_edit_form'); ?></h4>

                    <form class="required-form" action="<?php echo site_url('admin/student_courses_update/'.$payment_detail['id'].'/'.$payment_detail['user_id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title"><?php echo get_phrase('batch_title'); ?><span class="required">*</span></label>
                            <input type="text" class="form-control" id="batch_title" name = "batch_title" value="<?php echo batch_detail['title']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description"><?php echo get_phrase('course_title'); ?></label>
                            <input type="text" class="form-control" id="course_title" name = "course_title" value="<?php echo $course_detail['title']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description"><?php echo get_phrase('number_of_hours'); ?></label>
                            <input type="text" class="form-control" id="number_of_hours" name = "number_of_hours" value="<?php echo $payment_detail['number_of_hours']; ?>"  readonly>
                        </div>

                        <div class="form-group">
                            <label for="description"><?php echo get_phrase('number_of_sessions'); ?></label>
                            <input type="text" class="form-control" id="number_of_sessions" name = "number_of_sessions" value="<?php echo $payment_detail['number_of_sessions']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="start_date"><?php echo get_phrase('schedule_start_date'); ?><span class="required">*</span></label>
                            <input type="text" name="start_date" class="form-control date" id="start_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $payment_detail['date_added']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="schedule_expiry_date"><?php echo get_phrase('schedule_expiry_date'); ?><span class="required">*</span></label>
                            <input type="text" name="schedule_expiry_date" class="form-control date" id="schedule_expiry_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $payment_detail['schedule_expiry_date']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="schedule_last_date"><?php echo get_phrase('schedule_last_date'); ?><span class="required">*</span></label>
                            <input type="text" name="schedule_last_date" class="form-control date" id="schedule_last_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $payment_detail['schedule_last_date']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="unpaid_schedule"><?php echo get_phrase('unpaid_schedule_date'); ?><span class="required">*</span></label>
                          <?php if($payment_detail['unpaid_schedule_date']!=''){?>
                            <input type="date" name="unpaid_schedule_date" class="form-control date" id="unpaid_schedule_date"  value="<?php echo  date('m/d/Y', $payment_detail['unpaid_schedule_date']); ?>" >
                          <?php }else{?>
                              <input type="date" name="unpaid_schedule_date" class="form-control date" id="unpaid_schedule_date" value ='' >
                          <?php } ?>
                        </div>

                        <button type="button" class="btn btn-primary"  onclick="checkRequiredFields()" ><?php echo get_phrase("submit"); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<script type="text/javascript">
    // $(document).ready(function () {
    //      $('#unpaid_schedule_date').datepicker({ dateFormat: "mm/dd/yy", changeMonth: true,
    //         changeYear: true, yearRange: '1900:2030', defaultDate: null
    //     });
    //
    // });

</script>

