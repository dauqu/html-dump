<?php
    $social_links = json_decode($user_details['social_links'], true);
 ?>
 <section class="page-header-area my-course-area">
     <div class="container">
         <div class="row">
             <div class="col">
                 <h1 class="page-title"><?php echo site_phrase('user_profile'); ?></h1>
                 <ul>
                     <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo site_phrase('all_courses'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo site_phrase('wishlists'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo site_phrase('my_messages'); ?></a></li>
                     <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo site_phrase('purchase_history'); ?></a></li>
                     <li class="active"><a href=""><?php echo site_phrase('user_profile'); ?></a></li>
                 </ul>
             </div>
         </div>
     </div>
 </section>

<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                        <div class="user-box">
                            <img src="<?php echo base_url().'uploads/user_image/'.$this->session->userdata('user_id').'.jpg';?>" alt="" class="img-fluid">
                            <div class="name">
                                <div class="name"><?php echo $user_details['student_first_name'].' '.$user_details['student_last_name']; ?></div>
                            </div>
                        </div>
                        <div class="user-dashboard-menu">
                            <ul>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo site_phrase('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo site_phrase('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo site_phrase('photo'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo site_phrase('profile'); ?></div>
                            <div class="subtitle"><?php echo site_phrase('add_information_about_yourself_to_share_on_your_profile'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_basics'); ?>" method="post">
                            <div class="content-box">
                                <div class="basic-group">
                                    <div class="form-group">
                                        <label for="first-name"><?php echo site_phrase('first_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "student_first_name" id="FristName" placeholder="<?php echo site_phrase('first_name'); ?>" value="<?php echo $user_details['student_first_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="last-name"><?php echo site_phrase('last_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "student_last_name" placeholder="<?php echo site_phrase('last_name'); ?>" value="<?php echo $user_details['student_last_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-no"><?php echo site_phrase('contact_no'); ?>:</label>
                                        <input type="text" pattern="\d*" maxlength="20" class="form-control" name = "contact_no" placeholder="<?php echo site_phrase('contact_no'); ?>" value="<?php echo $user_details['contact_no']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_of_birth"><?php echo get_phrase('date_of_birth'); ?></label>
                                        <input type="text" name="date_of_birth" class="form-control date" id="date_of_birth" data-toggle="date-picker" data-single-date-picker="true" value="<?php echo  date('m/d/Y', $user_details['date_of_birth']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="blood-group"><?php echo site_phrase('blood_group'); ?>:</label>
                                        <input type="text" class="form-control" name = "blood_group" placeholder="<?php echo site_phrase('blood_group'); ?>" value="<?php echo $user_details['blood_group']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Address"><?php echo site_phrase('Address'); ?>:</label>
                                        <textarea class="form-control author-biography-editor" name = "address" id="address"><?php echo $user_details['address']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="father-name"><?php echo site_phrase('father_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "father_name" placeholder="<?php echo site_phrase('father_name'); ?>" value="<?php echo $user_details['father_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="father-contact-no"><?php echo site_phrase('father_contact_no'); ?>:</label>
                                        <input type="text" pattern="\d*" maxlength="20" class="form-control" name = "father_contact_no" placeholder="<?php echo site_phrase('father_contact_no'); ?>" value="<?php echo $user_details['father_contact_no']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="father-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo site_phrase('father_email'); ?>:</label>
                                        <input type=""  type="father_email" class="form-control" name = "father_email" id="father_email" placeholder="<?php echo site_phrase('father_email'); ?>" value="<?php echo $user_details['father_email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="mother-name"><?php echo site_phrase('mother_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "mother_name" placeholder="<?php echo site_phrase('mother_name'); ?>" value="<?php echo $user_details['mother_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="mother-contact-no"><?php echo site_phrase('mother_contact_no'); ?>:</label>
                                        <input type="text" pattern="\d*" maxlength="20" class="form-control" name = "mother_contact_no" placeholder="<?php echo site_phrase('mother_contact_no'); ?>" value="<?php echo $user_details['mother_contact_no']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="mother-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo site_phrase('mother_email'); ?>:</label>
                                        <input type=""  type="mother_email" class="form-control" name = "mother_email" id="mother-email" placeholder="<?php echo site_phrase('mother_email'); ?>" value="<?php echo $user_details['mother_email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Address"><?php echo site_phrase('Please share, things you want Young Achievers to be mindful of about student'); ?>:</label>
                                        <textarea class="form-control author-biography-editor" name = "biography" id="biography"><?php echo $user_details['biography']; ?></textarea>
                                    </div>
                                </div>
                                <div class="link-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "twitter_link" placeholder="<?php echo site_phrase('twitter_link'); ?>" value="<?php echo $social_links['twitter']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_twitter_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "facebook_link" placeholder="<?php echo site_phrase('facebook_link'); ?>" value="<?php echo $social_links['facebook']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_facebook_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "linkedin_link" placeholder="<?php echo site_phrase('linkedin_link'); ?>" value="<?php echo $social_links['linkedin']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_linkedin_link'); ?>.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
