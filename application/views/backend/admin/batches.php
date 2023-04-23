
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('batches'); ?>
                    <a href="<?php echo site_url('admin/batch_form/add_batch'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_new_batch'); ?></a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('batch_list'); ?></h4>
                <form class="row justify-content-center" action="<?php echo site_url('admin/batches'); ?>" method="get">
                    <!-- Course Categories -->
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="category_id"><?php echo get_phrase('courses'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id">
                                <option value="<?php echo 'all'; ?>" <?php if($selected_course_id == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                <?php foreach ($courses->result_array() as $course): ?>
                                    <option value="<?php echo $course['id']; ?>" <?php if($selected_course_id == $course['id']) echo 'selected'; ?>><?php echo $course['title']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Course Status -->
                <div class="col-xl-2">
                    <div class="form-group">
                        <label for="status"><?php echo get_phrase('status'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
                            <option value="all" <?php if($selected_status == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                            <option value="active" <?php if($selected_status == 'active') echo 'selected'; ?>><?php echo get_phrase('active'); ?></option>
                            <option value="pending" <?php if($selected_status == 'pending') echo 'selected'; ?>><?php echo get_phrase('pending'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-2">
                    <label for=".." class="text-white">..</label>
                    <button type="submit" class="btn btn-primary btn-block" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </form>

            <div class="table-responsive-sm mt-4">
                <?php if (count($batches) > 0): ?>
                    <table id="course-datatable" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase('title'); ?></th>
                                <th><?php echo get_phrase('course'); ?></th>
                                <th><?php echo get_phrase('status'); ?></th>
                                <th><?php echo get_phrase('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              foreach ($batches as $key => $batch):

                                $course_details = $this->crud_model->get_course_by_id($batch['course_id'])->row_array();

                                $host_details = $this->user_model->get_all_user($batch['host_id'])->row_array();
                                if ($course['status'] == 'draft') {
                                    continue;
                                }
                            ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <strong><a href="<?php echo site_url('admin/batch_form/batch_edit/'.$batch['id']); ?>"><?php echo ellipsis($batch['title']); ?></a></strong><br>
                                        <small class="text-muted"><?php echo get_phrase('host').': <b>'.$host_details['student_first_name'].' '.$host_details['student_last_name'].'</b>'; ?></small>
                                    </td>
                                    <td>
                                        <strong><a href="<?php echo site_url('admin/course_form/course_edit/'.$course_details['id']); ?>"><?php echo ellipsis($course_details['title']); ?></a></strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($batch['status'] == 'pending'): ?>
                                            <i class="mdi mdi-circle" style="color: #FFC107; font-size: 19px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase($batch['status']); ?>"></i>
                                        <?php elseif ($batch['status'] == 'active'):?>
                                            <i class="mdi mdi-circle" style="color: #4CAF50; font-size: 19px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase($batch['status']); ?>"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropright dropright">
                                          <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="mdi mdi-dots-vertical"></i>
                                          </button>
                                          <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="<?php echo site_url('admin/batch_form/batch_edit/'.$batch['id']); ?>"><?php echo get_phrase('edit_this_batch');?></a></li>
                                              <li><a class="dropdown-item" href="<?php echo site_url('admin/schedules?view=list&batch_id='.$batch['id']); ?>"><?php echo get_phrase('schedules'); ?></a></li>
                                              <li><a class="dropdown-item" href="<?php echo site_url('admin/offline_payment?batch_id='.$batch['id']); ?>"><?php echo get_phrase('offline_payment');?></a></li>
                                              <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/batch_actions/delete/'.$batch['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                          </ul>
                                      </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if (count($batches) == 0): ?>
                    <div class="img-fluid w-100 text-center">
                      <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
                      <?php echo get_phrase('no_data_found'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
