<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo $student_name; ?></h4>
                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('Batch'); ?></th>
                            <th><?php echo get_phrase('Course'); ?></th>
                            <th><?php echo get_phrase('start_date'); ?></th>
                            <th><?php echo get_phrase('end_date'); ?></th>
                            <th><?php echo get_phrase('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($batches as $key => $batch):

                            $batch_details = $this->Batch_model->get_batch_by_id($batch['batch_id'])->result_array();
                            $batch_title = '';
                            $course_title = '';

                            foreach ($batch_details as $batch_detail)
                            {
                                $batch_title = $batch_detail['title'];
                            }
                            $course_details = $this->crud_model->get_course_by_userid($batch['course_id'])->result_array();

                            foreach ($course_details as $course_detail)
                            {
                                $course_title = $course_detail['title'];
                            }
                            ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $batch_title; ?></td>
                                <td><?php echo $course_title; ?></td>
                                <td><?php echo date('Y-m-d',$batch['date_added']) ?></td>
                                <td><?php echo date('Y-m-d',$batch['schedule_expiry_date']) ?></td>
                                <td>
                                    <div class="dropright dropright">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                       <ul class="dropdown-menu">
                                           <li><a class="dropdown-item" href="<?php echo site_url('admin/student_courses_edit/'.$batch['id']); ?>"><?php echo get_phrase('edit');?></a></li>
                                           <li><a class="dropdown-item" href="<?php echo site_url('admin/student_course_attendance?user_id='.$user_id.'&payment_id='.$batch['id']); ?>"><?php echo get_phrase('attendance');?></a></li>
                                           <li><a class="dropdown-item" href="<?php echo site_url('admin/mark_attendance?user_id='.$user_id.'&payment_id='.$batch['id']); ?>"><?php echo get_phrase('mark_attendance');?></a></li>
                                     </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
