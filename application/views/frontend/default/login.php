<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo $page_title; ?>
                            </a>
                        </li>
                    </ol>
                </nav>
                <h1 class="category-name">
                    <?php echo site_phrase('registered_user'); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<?php echo $this->session->userdata('is_instructor'); ?>
<section class="category-course-list-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
              <div class="user-dashboard-box mt-3">
                  <div class="user-dashboard-content w-100 login-form">
                      <div class="content-title-box">
                          <div class="title"><?php echo site_phrase('login'); ?></div>
                          <div class="subtitle"><?php echo site_phrase('provide_your_valid_login_credentials'); ?>.</div>
                      </div>
                      <form action="<?php echo site_url('login/validate_login/user'); ?>" method="post">
                          <div class="content-box">
                              <div class="basic-group">
                                  <div class="form-group">
                                      <label for="login-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo site_phrase('email'); ?>:</label>
                                      <input type="email" class="form-control" name = "email" id="login-email" placeholder="<?php echo site_phrase('email'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="login-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo site_phrase('password'); ?>:</label>
                                      <input type="password" class="form-control" name = "password" placeholder="<?php echo site_phrase('password'); ?>" value="" required>
                                  </div>
                              </div>
                          </div>
                          <div class="content-update-box">
                              <button type="submit" class="btn"><?php echo site_phrase('login'); ?></button>
                          </div>
                          <div class="forgot-pass text-center">
                              <span><?php echo site_phrase('or'); ?></span>
                              <a href="javascript::" onclick="toggoleForm('forgot_password')"><?php echo site_phrase('forgot_password'); ?></a>
                          </div>
                          <div class="account-have text-center">
                              <?php echo site_phrase('do_not_have_an_account'); ?>? <a href="javascript::" onclick="toggoleForm('registration')"><?php echo site_phrase('sign_up'); ?></a>
                          </div>
                      </form>
                  </div>
                  <div class="user-dashboard-content w-100 register-form hidden">
                      <div class="content-title-box">
                          <div class="title"><?php echo site_phrase('registration_form'); ?></div>
                          <div class="subtitle"><?php echo site_phrase('sign_up_and_start_learning'); ?>.</div>
                      </div>
                      <form action="<?php echo site_url('login/register'); ?>" method="post">
                          <div class="content-box">
                              <div class="basic-group">
                                  <div class="form-group">
                                      <label for="first_name"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php echo site_phrase('student_first_name'); ?>:</label>
                                      <input type="text" class="form-control" name = "student_first_name" id="student_first_name" placeholder="<?php echo site_phrase('student_first_name'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="last_name"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php echo site_phrase('student_last_name'); ?>:</label>
                                      <input type="text" class="form-control" name = "student_last_name" id="student_last_name" placeholder="<?php echo site_phrase('student_last_name'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="registration-mobile"><span class="input-field-icon"><i class="fas fa-phone"></i></span> <?php echo site_phrase('contact_no'); ?>:</label>
                                      <input  type="text" pattern="\d*" maxlength="20" class="form-control" name = "contact_no" id="registration-mobile" placeholder="<?php echo site_phrase('contact_no'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="date_of_birth"><?php echo get_phrase('date_of_birth'); ?></label>
                                      <input type="date" name="date_of_birth" class="form-control date" id="date_of_birth" data-toggle="date-picker" data-single-date-picker="true" value="" required>

                                  </div>
                                  <div class="form-group">
                                      <label for="registration-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo site_phrase('email'); ?>:</label>
                                      <input type=""  type="email" class="form-control" name = "email" id="registration-email" placeholder="<?php echo site_phrase('email'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="registration-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo site_phrase('password'); ?>:</label>
                                      <input type="password" class="form-control" name = "password" id="registration-password" placeholder="<?php echo site_phrase('password'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <div class="g-recaptcha" data-sitekey="6LcGLwcaAAAAADLViBDxR7a5BWCodnOBsDdG1U11"></div>
                                  </div>
                              </div>
                          </div>
                          <div class="content-update-box">
                              <button type="submit" class="btn"><?php echo site_phrase('sign_up'); ?></button>
                          </div>
                          <div class="account-have text-center">
                              <?php echo site_phrase('already_have_an_account'); ?>? <a href="javascript::" onclick="toggoleForm('login')"><?php echo site_phrase('login'); ?></a>
                          </div>
                      </form>
                  </div>

                  <div class="user-dashboard-content w-100 forgot-password-form hidden">
                      <div class="content-title-box">
                          <div class="title"><?php echo site_phrase('forgot_password'); ?></div>
                          <div class="subtitle"><?php echo site_phrase('provide_your_email_address_to_get_password'); ?>.</div>
                      </div>
                      <form action="<?php echo site_url('login/forgot_password/frontend'); ?>" method="post">
                          <div class="content-box">
                              <div class="basic-group">
                                  <div class="form-group">
                                      <label for="forgot-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo site_phrase('email'); ?>:</label>
                                      <input type="email" class="form-control" name = "email" id="forgot-email" placeholder="<?php echo site_phrase('email'); ?>" value="" required>
                                      <small class="form-text text-muted"><?php echo site_phrase('provide_your_email_address_to_get_password'); ?>.</small>
                                  </div>
                              </div>
                          </div>
                          <div class="content-update-box">
                              <button type="submit" class="btn"><?php echo site_phrase('reset_password'); ?></button>
                          </div>
                          <div class="forgot-pass text-center">
                              <?php echo site_phrase('want_to_go_back'); ?>? <a href="javascript::" onclick="toggoleForm('login')"><?php echo site_phrase('login'); ?></a>
                          </div>
                      </form>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
  function toggoleForm(form_type) {
    if (form_type === 'login') {
      $('.login-form').show();
      $('.forgot-password-form').hide();
      $('.register-form').hide();
    }else if (form_type === 'registration') {
      $('.login-form').hide();
      $('.forgot-password-form').hide();
      $('.register-form').show();
    }else if (form_type === 'forgot_password') {
      $('.login-form').hide();
      $('.forgot-password-form').show();
      $('.register-form').hide();
    }
  }
</script>
