<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        }else {
            redirect(site_url('home/login'), 'refresh');
        }
    }

    public function validate_login($from = "") {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

//        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1);
        $credential = array('email' => $email, 'password' => sha1($password));

        // Checking login credential for admin
        $query = $this->db->get_where('users', $credential);
        $error = get_phrase('invalid_login_credentials');
        if ($query->num_rows() > 0) {
            $row = $query->row();
	 if($row->status == 1) {
                $this->session->set_userdata('user_id', $row->id);
                $this->session->set_userdata('role_id', $row->role_id);
                $this->session->set_userdata('role', get_user_role('user_role', $row->id));
                $this->session->set_userdata('name', $row->student_first_name.' '.$row->student_last_name);
                $this->session->set_userdata('is_instructor', $row->is_instructor);
                $this->session->set_flashdata('flash_message', get_phrase('welcome').' '.$row->student_first_name.' '.$row->student_last_name);
                if ($row->role_id == 1) {
                    $this->session->set_userdata('admin_login', '1');
                    redirect(site_url('admin/dashboard'), 'refresh');
                }else if($row->role_id == 2){
                    $this->session->set_userdata('user_login', '1');
                    redirect(site_url('home'), 'refresh');
                }
            }
            $error = 'Your email address has not been verified.';

        }

        $this->session->set_flashdata('error_message', $error);
        redirect(site_url('home/login'), 'refresh');
    } 
     public function register()
    {
  //       $captcha_response = trim($this->input->post('g-recaptcha-response'));
 
    //     if($captcha_response != '')
      //   {
        //     $keySecret = '6LdVogEbAAAAANx0BBJfpx0ZsUdLCcQ9lbCSC_bY';
 
          /*   $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$keySecret.'&response='.$_POST['g-recaptcha-response']);
             $finalResponse = json_decode($verifyResponse); 
             
 
             if($finalResponse['success'])
             {*/
                 $data['student_first_name'] = html_escape($this->input->post('student_first_name'));
                 $data['student_last_name']  = html_escape($this->input->post('student_last_name'));
                 $data['contact_no']  = html_escape($this->input->post('contact_no'));
                 $data['email']  = html_escape($this->input->post('email'));
                 $data['password']  = sha1($this->input->post('password'));
                 $data['date_of_birth']  = strtotime($this->input->post('date_of_birth'));
 
                 $verification_code =  md5(rand(100000000, 200000000));
                 $data['verification_code'] = $verification_code;
 
                 if (get_settings('student_email_verification') == 'enable')
                 {
                     $data['status'] = 0;
                 }else {
                     $data['status'] = 1;
                 }
                 $data['wishlist'] = json_encode(array());
                 $data['watch_history'] = json_encode(array());
                 $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
                 $social_links = array(
                     'facebook' => "",
                     'twitter'  => "",
                     'linkedin' => ""
                 );
                 $data['social_links'] = json_encode($social_links);
                 $data['role_id']  = 2;
 
                 // Add paypal keys
                 $paypal_info = array();
                 $paypal['production_client_id'] = "";
                 array_push($paypal_info, $paypal);
                 $data['paypal_keys'] = json_encode($paypal_info);
                 // Add Stripe keys
                 $stripe_info = array();
                 $stripe_keys = array(
                     'public_live_key' => "",
                     'secret_live_key' => ""
                 );
                 array_push($stripe_info, $stripe_keys);
                 $data['stripe_keys'] = json_encode($stripe_info);
 
                 $validity = $this->user_model->check_duplication('on_create', $data['email']);
 
                 if ($validity) {
                 //    print_r($data);die;
                     $user_id = $this->user_model->register_user($data);
                     $this->session->set_userdata('user_login', '1');
                     $this->session->set_userdata('user_id', $user_id);
                     $this->session->set_userdata('role_id', 2);
                     $this->session->set_userdata('role', get_user_role('user_role', 2));
                     $this->session->set_userdata('name', $data['student_first_name'].' '.$data['student_last_name']);

        if (get_settings('student_email_verification') == 'enable') {
            $this->email_model->send_email_verification_mail($data['email'], $verification_code, $data['student_first_name']);
            $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
        }else {
            $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done'));
        }

    }else {
$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
$page_data['page_name'] = 'sign_up';
$page_data['page_title'] = site_phrase('sign_up');
$this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
}
redirect(site_url('home'), 'refresh');

/*    }
    else
    {
        $this->session->set_flashdata('message', 'Validation Fail Try Again');
        $page_data['page_name'] = 'sign_up';
        $page_data['page_title'] = site_phrase('sign_up');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

}
else
{
    $this->session->set_flashdata('message', 'Validation Fail Try Again');

    $page_data['page_name'] = 'sign_up';
    $page_data['page_title'] = site_phrase('sign_up');
    $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
}

*/
}

public function logout($from = "") {
    //destroy sessions of specific userdata. We've done this for not removing the cart session
    $this->session_destroy();
    $this->session->set_userdata('cart_items', array());
    redirect(site_url('home/login'), 'refresh');

}

public function session_destroy() {
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('role_id');
    $this->session->unset_userdata('role');
    $this->session->unset_userdata('name');
    $this->session->unset_userdata('is_instructor');
    if ($this->session->userdata('admin_login') == 1) {
        $this->session->unset_userdata('admin_login');
    }else {
        $this->session->unset_userdata('user_login');
    }
}

function forgot_password($from = "") {
    $email = $this->input->post('email');
    //resetting user password here
    $new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);

    // Checking credential for admin
    $query = $this->db->get_where('users' , array('email' => $email));
    if ($query->num_rows() > 0)
    {
        $this->db->where('email' , $email);
        $this->db->update('users' , array('password' => sha1($new_password)));
        // send new password to user email
        $this->email_model->password_reset_email($new_password, $email);
        $this->session->set_flashdata('flash_message', get_phrase('please_check_your_email_for_new_password'));
        if ($from == 'backend') {
            redirect(site_url('login'), 'refresh');
        }else {
            redirect(site_url('home'), 'refresh');
        }
    }else {
        $this->session->set_flashdata('error_message', get_phrase('password_reset_failed'));
        if ($from == 'backend') {
            redirect(site_url('login'), 'refresh');
        }else {
            redirect(site_url('home'), 'refresh');
        }
    }
}

public function verify_email_address($verification_code = "") {
    $user_details = $this->db->get_where('users', array('verification_code' => $verification_code));
    if($user_details->num_rows() == 0) {
        $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
    }else {
        $user_details = $user_details->row_array();
        $updater = array(
            'status' => 1
        );
        $this->db->where('id', $user_details['id']);
        $this->db->update('users', $updater);
        $this->session->set_flashdata('flash_message', get_phrase('congratulations').'!'.get_phrase('your_email_address_has_been_successfully_verified').'.');
    }
    redirect(site_url('home'), 'refresh');
}


public function test_email()
{

    $data = [
        'email' => 'skanta.it@gmail.com',
        'first_name' => 'Sushikanta'
    ];
    $verification_code = '1234';
    $this->email_model->send_email_verification_mail($data['email'], $verification_code, $data['first_name']);

    // echo 'sdsdsds';
}

public function test_course_email()
{
    // $data = $this->user_model->get_user(10)->row();

    $this->email_model->course_purchase_notification_student(1, 24);

}
}
