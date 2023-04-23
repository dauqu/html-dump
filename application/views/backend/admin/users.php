<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                <a href = "<?php echo site_url('admin/user_form/add_user_form'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_student'); ?></a>
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <h4 class="mb-3 header-title"><?php echo get_phrase('student'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('name'); ?></th>
                      <th><?php echo get_phrase('email'); ?>/Contact No.</th>
                      <th><?php echo get_phrase('enrolled_batches'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($users->result_array() as $key => $user): ?>
                          <tr>
                              <td><?php echo $key+1; ?></td>
                              <td>
                                  <img src="<?php echo $this->user_model->get_user_image_url($user['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                              </td>
                              <td><?php echo $user['student_first_name'].' '.$user['student_last_name']; ?>
                                <?php if($user['status'] != 1): ?>
                                  <small><p><?php echo get_phrase('status'); ?>: <span class="badge badge-danger-lighten"><?php echo get_phrase('unverified'); ?></span></p></small>
                                <?php endif; ?>
                              </td>
                              <td><?php echo $user['email']; ?> <br><?php echo $user['contact_no']; ?></td>
                              <td>
                                 <?php  $today_date = strtotime(date('D, Y-m-d'));
       				       // $payments = $this->crud_model->get_payment_by_userid($user['id'],$today_date);
                                     $payments = $this->crud_model->get_payment_by_userid_group_by_batchid($user['id'],$today_date);

                                    //$enrolled_courses = $this->crud_model->enrol_history_by_user_id($user['id']);
					
					?>
                                    <ul>
                                        <?php foreach ($payments as $payment):
                                            $my_batches = $this->Batch_model->get_batch_by_id($payment['id'])->result_array();
					         foreach ($my_batches as $batch):
						?>
                                            <li><?php echo $batch['title']; ?></li>
						<?php endforeach; ?>

                                        <?php endforeach; ?>
                                    </ul>
                              </td>
                              <td>
                                  <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/user_form/student_courses/'.$user['id']) ?>"><?php echo get_phrase('batches'); ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/user_form/edit_user_form/'.$user['id']) ?>"><?php echo get_phrase('edit'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/users/delete/'.$user['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
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
