<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('batch_schedule'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('batch_schedule'); ?></h4>
		
<div class="row justify-content-md-center py-2">
                    
                    <div class="col-xl-12">
                        <form class="form" action="<?php echo site_url('admin/batch_schedule_report/filter') ?>" method="get">
                            <div class="row">
                            <div class="col-xl-6">

 <div class="row" data-select2-id="7">
        <div class="col-2">
                                   <div class="form-group">
                           		 <label for="course_id"><?php echo get_phrase('courses'); ?></label></div>
            </div>
            
              <div class="col-6" data-select2-id="6">
                           			 <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id">
                               			 <option value="all"><?php echo get_phrase('all'); ?></option>
                                       <?php foreach ($courses->result_array() as $course): ?>
                                            <option value="<?php echo $course['id']; ?>" <?php if($selected_course_id == $course['id'] ) echo 'selected';?>><?php echo $course['title']; ?></option>

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
				      		<a href="<?php echo site_url('admin/batch_schedule_csv?course_id='.$selected_course_id.'&batch_id='.$selected_batch_id.'&start_date='.$start_date.'&end_date='.$end_date); ?>">Export</a><br><br>
                                      
					</span>
                                    </div>


                            </div>
</form>                

                   <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('schedule_title'); ?></th>
                                <th><?php echo get_phrase('batch'); ?></th>
				                <th><?php echo get_phrase('course'); ?></th>
				                <th><?php echo get_phrase('start_time'); ?></th>
                                <th><?php echo get_phrase('join_url'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($batch_schedules as $schedule):
                             ?>
                                <tr class="gradeU">
					                <td><?php echo $schedule['schedule_title']; ?></td>
                                    <td><?php echo $schedule['batch']; ?></td>
                                    <td><?php echo $schedule['course']; ?></td>
				                    <td><?php echo date('D, d-M-Y H:i:s', $schedule['start_time']); ?></td>
                                    <td><?php echo $schedule['join_url']; ?></td>

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
