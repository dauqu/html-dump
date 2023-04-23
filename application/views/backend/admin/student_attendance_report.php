<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('student_attendance_report'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('student_attendance_report'); ?></h4>
                 <div class="row justify-content-md-center py-2">
                    
                    <div class="col-xl-12">
                        <form class="form" action="<?php echo site_url('admin/student_attendance_report/filter') ?>" method="get">
                            <div class="row">
                            <div class="col-xl-6">

 <div class="row" data-select2-id="7">
        <div class="col-2">
                                   <div class="form-group">
                           		 <label for="student_id"><?php echo get_phrase('student'); ?></label></div>
            </div>
            
              <div class="col-6" data-select2-id="6">
                           			 <select class="form-control select2" data-toggle="select2" name="student_id" id="student_id">
                               			 <option value="all"><?php echo get_phrase('all'); ?></option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo $user['id']; ?>" <?php if($selected_student_id == $user['id'] ) echo 'selected';?>><?php echo $user['student_first_name'].' '.$user['student_last_name']; ?></option>

                                <?php endforeach; ?>
                            </select>
                        
                     </div></div>

                                </div>
                                <div class="col-xl-6">
<div class="row" data-select2-id="7">
        <div class="col-2">

                                        <div class="form-group">
                                            <label for="batch_id"><?php echo get_phrase('batches'); ?></label>
</div>
</div>

 <div class="col-6" data-select2-id="6">
                                            <select class="form-control select2" data-toggle="select2" name="batch_id" id="batch_id">
                                                    <option value ="all" ><?php echo get_phrase('all'); ?></option>
                                                    <?php  foreach ($batches as $batch):  ?>
                                                         <option value="<?php echo $batch['id']; ?>" <?php if($selected_batch_id == $batch['id'] ) echo 'selected';?>><?php echo $batch['title']; ?></option>
                                                     <?php endforeach; ?>
                                            </select>
</div>
</div>
                                             <input type="hidden" name="view" value="<?php echo $selected_view; ?>">
                                         </div>
                                                             
                                
                            </div></div></div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label for="start_date"><?php echo get_phrase('start_date'); ?></label>
                                         <input type="text" name="start_date" class="form-control date" id="start_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo date('m/d/Y', $start_date)?>">
                                    </div>
                                </div>
                                 <div class="col-xl-4">
                                     <div class="form-group">
                                         <label for="end_date"><?php echo get_phrase('end_date'); ?></label>
                                         <input type="text" name="end_date" class="form-control date" id="end_date" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo date('m/d/Y', $end_date)?>">
                                     </div>
                                   </div> 
				
                                
                                    <div class="col-xl-4 expoxt-box" style="padding-top: 28px;">
                                        <button type="submit" class="btn btn-info" id="submit-button" onclick="update_date_range();"> Filter</button>
					<span> 
				   <a href="<?php echo site_url('admin/student_attendance_csv?student_id='.$selected_student_id.'&batch_id='.$selected_batch_id.'&start_date='.$start_date.'&end_date='.$end_date); ?>">Export</a><br><br>
                                       
</span>
                                    </div>


                            </div>
                        </form>

                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('schedule'); ?></th>
                                <th><?php echo get_phrase('batch'); ?></th>
				                <th><?php echo get_phrase('student_name'); ?></th>
				                <th><?php echo get_phrase('meeting_date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($student_attendances as $student_attendance):
                             ?>
                                <tr class="gradeU">
                                     <td><?php echo $student_attendance['schedule']; ?></td>
                                     <td><?php echo $student_attendance['batch']; ?></td>
				                     <td><?php echo $student_attendance['student_first_name'].' '.$student_attendance['student_last_name']; ?></td>
                                     <td><?php echo date('D, d-M-Y', $student_attendance['meeting_date']); ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
  </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
function update_date_range()
{
    var x = $("#selectedValue").html();
    $("#date_range").val(x);
}
</script>
