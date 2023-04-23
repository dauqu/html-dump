<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('schedule_list'); ?></h4>

                <div id="list1">
                    <?php
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
                                        <small class="text-muted"><?php echo date('d-m-Y',$schedule['start_date']); ?></small><br>
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
                                                   <li><a class="dropdown-item" href="<?php echo site_url('admin/mark_student_attendance?user_id='.$user_id.'&schedule_id='.$schedule['id'].'&status=1&payment_id='.$payment_id);?>"><?php echo get_phrase('mark_present');?></a></li>
                                                   <li><a class="dropdown-item" href="<?php echo site_url('admin/mark_student_attendance?user_id='.$user_id.'&schedule_id='.$schedule['id'].'&status=0&payment_id='.$payment_id);?>"><?php echo get_phrase('mark_absent');?></a></li>
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


            </div>
        </div>
    </div>

