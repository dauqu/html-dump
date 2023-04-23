
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('schedules'); ?>
<!--                    <a href="--><?php //echo site_url('admin/schedule_form/add_schedule?batch_id='.$selected_batch_id); ?><!--" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i>--><?php //echo get_phrase('add_new_schedule'); ?><!--</a>-->
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('schedule_list'); ?></h4>
                <form class="row justify-content-center" action="<?php echo site_url('admin/schedules'); ?>" method="get">
                    <!-- Course Categories -->
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="batch_id"><?php echo get_phrase('batches'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="batch_id" id="batch_id">
                                <option value="<?php echo 'all'; ?>" <?php if($selected_batch_id == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                <?php foreach ($batches as $batch):  ?>
                                    <option value="<?php echo $batch['id']; ?>" <?php if($selected_batch_id == $batch['id']) echo 'selected'; ?>><?php echo $batch['title']; ?></option>
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
                            <option value="waiting" <?php if($selected_status == 'waiting') echo 'selected'; ?>><?php echo get_phrase('upcoming'); ?></option>
                            <option value="end" <?php if($selected_status == 'end') echo 'selected'; ?>><?php echo get_phrase('previous'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-2">
                    <div class="form-group">
                        <label for="status"><?php echo get_phrase('users'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="user_id" id = 'user_id'>
                            <option value="all" <?php if($selected_user == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                            <?php foreach ($instructors as $instructor):?>

                                <option value="<?php echo $instructor['id']; ?>" <?php if($instructor['id'] == $selected_user ) echo 'selected'; ?>><?php echo $instructor['first_name'].' '.$instructor['last_name']; ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-xl-2">
                    <label for=".." class="text-white">..</label>
                    <button type="submit" class="btn btn-primary btn-block" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </form>

            <div class="table-responsive-sm mt-4">

            </div>
        </div>
    </div>
</div>
</div>
