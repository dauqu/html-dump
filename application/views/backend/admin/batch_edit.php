<?php
    $batch_details = $this->Batch_model->get_batch_by_id($batch_id)->row_array();
?>
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

                    <form class="required-form" action="<?php echo site_url('admin/batch_actions/edit/'.$batch_id); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title"><?php echo get_phrase('title'); ?><span class="required">*</span></label>
                            <input type="text" class="form-control" id="title" name = "title" value="<?php echo $batch_details['title']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description"><?php echo get_phrase('description'); ?></label>
                           <textarea name="description" id = "summernote-basic" class="form-control"><?php echo $batch_details['description']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="hours"><?php echo get_phrase('total_hours'); ?><span class="required">*</span></label>
                            <input type="number" min="1" max="50" class="form-control" id="hours" name = "hours" value="<?php echo $batch_details['hours']; ?>"required>
                        </div>
                        <div class="form-group">
                            <label for="total_number_of_sessions"><?php echo get_phrase('total_number_of_sessions'); ?><span class="required">*</span></label>
                            <input type="number" class="form-control" id="total_number_of_sessions" name = "total_number_of_sessions" value="<?php echo $batch_details['total_number_of_sessions']; ?>"  min="1" max="20" required>
                        </div>

                        <div class="form-group">
                            <label for="max_strength"><?php echo get_phrase('max_strength'); ?></label>
                            <input type="number" min="1" max="50" class="form-control" id="max_strength" name = "max_strength" value="<?php echo $batch_details['max_strength']; ?>" onfocusout="validateMaxStrength()"  >
                        </div>

                        <div class="form-group">
                            <label for="min_age"><?php echo get_phrase('min_age'); ?></label>
                            <input type="number" min="1" max="50" class="form-control" id="min_age" name = "min_age" value="<?php echo $batch_details['min_age']; ?>" onfocusout="validateMinAge()">
                        </div>

                        <div class="form-group">
                            <label for="max_age"><?php echo get_phrase('max_age'); ?><span class="required">*</span></label>
                            <input type="number" min="1" max="50" class="form-control" id="max_age" name = "max_age" value="<?php echo $batch_details['max_age']; ?>" required  onfocusout="validateMaxAge()">
                        </div>

                        <div class="form-group">
                            <label for="course_id"><?php echo get_phrase('course'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id"  required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($courses as $course): ?>

                                    <option value="<?php echo $course['id']; ?>" <?php if($batch_details['course_id'] == $course['id'] ) echo 'selected';?>><?php echo $course['title']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="host_id"><?php echo get_phrase('host'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="host_id" id="host_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($hosts as $host):?>

                                    <option value="<?php echo $host['id']; ?>" <?php if($batch_details['host_id'] == $host['id'] ) echo 'selected';?>><?php echo $host['student_first_name'].' '.$host['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="instructor_id"><?php echo get_phrase('instructor'); ?><span class="required">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="instructor_id" id="instructor_id" required>
                                <option value="0"><?php echo get_phrase('none'); ?></option>
                                <?php foreach ($instructors as $instructor):?>

                                    <option value="<?php echo $instructor['id']; ?>" <?php if($batch_details['instructor_id'] == $instructor['id'] ) echo 'selected';?>><?php echo $instructor['student_first_name'].' '.$instructor['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date"><?php echo get_phrase('start_date'); ?><span class="required">*</span></label>
                            <input type="text" name="start_date" class="form-control date" id="start_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $batch_details['start_date']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="status"><?php echo get_phrase('status'); ?><span class="required">*</span></label>

                            <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
                                <option value="active" <?php if($batch_details['status'] == 'active') echo 'selected'; ?>><?php echo get_phrase('active'); ?></option>
                                <option value="pending" <?php if($batch_details['status'] == 'pending') echo 'selected'; ?>><?php echo get_phrase('pending'); ?></option>
                            </select>

                        </div>
                       <div class="form-group">
				<h5 class="mb-3 header-title"><?php echo get_phrase('price_details'); ?></h5>
			</div>
                        <div class="form-group">
                            <input type="checkbox" class="custom-control-input" name="is_free_batch" id="is_free_batch" value="<?php echo $batch_details['is_free_batch']; ?>" onclick="isfreebatch()">
                            <label class="custom-control-label" for="is_free_batch"><?php echo get_phrase('check_if_this_is_a_free_batch'); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="price"><?php echo get_phrase('number_of_sessions'); ?></label>
                            <input type="number" class="form-control" id="number_of_sessions" name = "number_of_sessions" placeholder="<?php echo get_phrase('enter_number_of_sessions'); ?>"  value="<?php echo $batch_details['number_of_sessions']; ?>" min="1" max="20" >
                        </div>
                        <div class="form-group">
                            <label for="price"><?php echo get_phrase('batch_price').' ('.currency_code_and_symbol().')'; ?></label>
                            <input type="number" class="form-control" id="batch_price" name = "batch_price" placeholder="<?php echo get_phrase('enter_batch_price'); ?>" min="0" value="<?php echo $batch_details['batch_price']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="custom-control-input" name="discount_flag" id="discount_flag" value="<?php echo $batch_details['discounted_price']; ?>" onclick="isdiscountedprice()">
                            <label class="custom-control-label" for="discount_flag"><?php echo get_phrase('check_if_this_batch_has_discount'); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="discounted_price"><?php echo get_phrase('discounted_price').' ('.currency_code_and_symbol().')'; ?></label>
                            <input type="number" class="form-control" name="discounted_price" id="discounted_price" onkeyup="calculateDiscountPercentage(this.value)" min="0" value="<?php echo $batch_details['discounted_price']; ?>">
                            <small class="text-muted"><?php echo get_phrase('this_batch_has'); ?> <span id = "discounted_percentage" class="text-danger">0%</span> <?php echo get_phrase('discount'); ?></small>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase("submit"); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script type="text/javascript">

    $(document).ready(function() {

        var checkBox = document.getElementById("is_free_batch");

        var discountcheckBox = document.getElementById("discount_flag");

        if (checkBox.value == 1)
        {
            document.getElementById("is_free_batch").checked = true;
            document.getElementById("number_of_sessions").disabled = true;
            document.getElementById("batch_price").disabled = true;
            document.getElementById("discount_flag").disabled = true;
            document.getElementById("discounted_price").disabled = true;
        }

        if (discountcheckBox.value == 1)
        {
            document.getElementById("discount_flag").disabled = false;
            document.getElementById("discounted_price").disabled = false;
        }

        });

    function checkCategoryType(category_type) {
        if (category_type > 0) {
            $('#thumbnail-picker-area').hide();
            $('#icon-picker-area').hide();
        }else {
            $('#thumbnail-picker-area').show();
            $('#icon-picker-area').show();
        }
    }

    function isfreebatch()
    {
        var checkBox = document.getElementById("is_free_batch");

        if (checkBox.checked == true)
        {
            document.getElementById("number_of_sessions").value = '';
            document.getElementById("number_of_sessions").disabled = true;

            document.getElementById("batch_price").value = '';
            document.getElementById("batch_price").disabled = true;

            document.getElementById("discount_flag").value = '';
            document.getElementById("discount_flag").disabled = true;

            document.getElementById("discounted_price").value = '';
            document.getElementById("discounted_price").disabled = true;
        }
        else
        {
            document.getElementById("number_of_sessions").disabled = false;
            document.getElementById("batch_price").disabled = false;
            document.getElementById("discount_flag").disabled = false;
            document.getElementById("discounted_price").disabled = false;
        }
    }

    function isdiscountedprice()
    {
        var discountcheckBox = document.getElementById("discount_flag");

        if (discountcheckBox.value == 1)
        {
            document.getElementById("discount_flag").disabled = false;
            document.getElementById("discounted_price").disabled = false;
        }

    }

 function validateMaxStrength()
   {
	var max  = document.getElementById("max_strength").value;
	if(max > 50)
	{
		alert("Maximum value for Max Strength is 50");
		document.getElementById("max_strength").value = 50;
	}
	if(max < 1)
	{
		alert("Minimum value for Max Strength is 1");
		document.getElementById("max_strength").value = 1;
	}

	
   }



   function validateMinAge()
   {
	var age = document.getElementById("min_age").value;
	if(age > 20)
	{
		alert("Maximum value for Age is 20");
		document.getElementById("min_age").value = 20;
	}
	if(age < 5)
	{
		alert("Minimum value for Age is 5");
		document.getElementById("min_age").value = 5;
	}


   }

function validateMaxAge()
   {
	var age = document.getElementById("max_age").value;
	if(age > 20)
	{
		alert("Maximum value for Age is 20");
		document.getElementById("max_age").value = 20;
	}
	if(age < 5)
	{
		alert("Minimum value for Age is 5");
		document.getElementById("max_age").value = 5;
	}


   }


</script>
