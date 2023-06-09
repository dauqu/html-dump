<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function password_reset_email($new_password = '' , $email = '')
	{
		$query = $this->db->get_where('users' , array('email' => $email));
		if($query->num_rows() > 0)
		{

			$email_msg	=	"Your password has been changed.";
			$email_msg	.=	"Your new password is : ".$new_password."<br />";

			$email_sub	=	"Password reset request";
			$email_to	=	$email;
			//$this->do_email($email_msg , $email_sub , $email_to);
			$this->send_smtp_mail($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function send_email_verification_mail($to = "", $verification_code = "", $name = '') {
		$redirect_url = site_url('login/verify_email_address/'.$verification_code);
		$subject 		= "Verify Email Address";
		$email_msg	=	"<b>Hello $name,</b>";
		$email_msg	.=	"<p>Welcome to youngachievers.in.</p><p>Click on the link below to verify your account.</p>";
		$this->send_smtp_mail($email_msg, $subject, $to, get_settings('system_email'), 'verification', $redirect_url);
	}

	public function send_mail_on_course_status_changing($course_id = "", $mail_subject = "", $mail_body = "") {
		$instructor_id		 = 0;
		$course_details    = $this->crud_model->get_course_by_id($course_id)->row_array();
		if ($course_details['user_id'] != "") {
			$instructor_id = $course_details['user_id'];
		}else {
			$instructor_id = $this->session->userdata('user_id');
		}
		$instuctor_details = $this->user_model->get_all_user($instructor_id)->row_array();
		$email_from = get_settings('system_email');

		$this->send_smtp_mail($mail_body, $mail_subject, $instuctor_details['email'], $email_from);
	}

	public function course_purchase_notification($student_id = "", $payment_method = "", $amount_paid = ""){
		$purchased_courses 	= $this->session->userdata('cart_items');
		$student_data 		= $this->user_model->get_user($student_id)->row_array();
		$student_full_name 	= $student_data['student_first_name'].' '.$student_data['student_last_name'];
		$admin_id 			= $this->user_model->get_admin_details()->row('id');
	    foreach ($purchased_courses as $k => $purchased_courses) {
	    	$course_owner_user_id = $this->crud_model->get_course_by_id($k)->row('user_id');
	    	if($course_owner_user_id == $admin_id):
				$this->course_purchase_notification_instructor($k, $student_full_name, $student_data['email']);
				$this->course_purchase_notification_student($k, $student_id);
			else:
				$this->course_purchase_notification_admin($k, $student_full_name, $student_data['email'], $amount_paid);
				$this->course_purchase_notification_instructor($k, $student_full_name, $student_data['email']);
				$this->course_purchase_notification_student($k, $student_id);
			endif;
	    }
	}

	public function course_purchase_notification_admin($course_id = "", $student_full_name = "", $student_email = "", $amount = ""){
		$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
		$admin_email_to = $this->user_model->get_admin_details()->row('email');
		$instructor_details = $this->user_model->get_user($course_details['user_id'])->row_array();
		$subject = "The course has sold out";
		$admin_msg = "<h2>".$course_details['title']."</h2>";
		$admin_msg .= "<h3><b><u><span style='color: #2ec75e;'>Course Price : ".currency($amount)."</span></u></b></h3>";
		$admin_msg .= "<p><b>Course owner:</b></p>";
		$admin_msg .= "<p>Name: <b>".$instructor_details['student_first_name']." ".$instructor_details['student_first_name']."</b></p>";
		$admin_msg .= "<p>Email: <b>".$instructor_details['email']."</b></p>";
		$admin_msg .= "<hr style='opacity: .4;'>";
		$admin_msg .= "<p><b>Bought the course:-</b></p>";
		$admin_msg .= "<p>Name: <b>".$student_full_name."</b></p>";
		$admin_msg .= "<p>Email: <b>".$student_email."</b></p>";
		$this->send_smtp_mail($admin_msg, $subject, $admin_email_to);
	}

	public function course_purchase_notification_instructor($course_id = "",$student_full_name = "", $student_email = ""){
		$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
		$instructor_email_to = $this->user_model->get_user($course_details['user_id'])->row('email');
		$subject = "The course has sold out";
		$instructor_msg = "<h2>".$course_details['title']."</h2>";
		$instructor_msg .= "<p>Congratulation!! Your <b>".$course_details['title']."</b> courses have been sold.</p>";
		$instructor_msg .= "<p><b>Bought the course:-</b></p>";
		$instructor_msg .= "<p>Name: <b>".$student_full_name."</b></p>";
		$instructor_msg .= "<p>Email: <b>".$student_email."</b></p>";
		$this->send_smtp_mail($instructor_msg, $subject, $instructor_email_to);
	}

	public function course_purchase_notification_student($course_id = "", $student_id = ""){
		$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
		$student = $this->user_model->get_user($student_id)->row();
		$student_email_to = $student->email;
		$student_name = $student->student_first_name;
		$instructor_details = $this->user_model->get_user($course_details['user_id'])->row_array();
		$subject = "Course Purchase";
        $student_msg	=	"<b>Hello $student_name,</b>";
		//$student_msg = "<h2>".$course_details['title']."</h2>";
		$student_msg .= "<p><b>Thanks for subscribing the ".$course_details['title']." from youngachievers.in.!!</b></p>";
		$student_msg .= "<hr style='opacity: .4;'>";
		$student_msg .= "<p><b>We shall connect with you over the call:</b></p>";
		$student_msg .= "<p>- Batch details</p>";
		$student_msg .= "<p>- Add you to relevant what's app group</p>";
		$student_msg .= "<p></p><br><br>";
		$student_msg .= "<p><b>Thanks for giving us the opportunity to serve you.</b></p>";
//		$student_msg .= "<p>Name: <b>".$instructor_details['first_name']." ".$instructor_details['last_name']."</b></p>";
//		$student_msg .= "<p>Email: <b>".$instructor_details['email']."</b></p>";
		$this->send_smtp_mail($student_msg, $subject, $student_email_to);
	}

	public function notify_on_certificate_generate($user_id = "", $course_id = "") {
		$checker = array(
			'course_id' => $course_id,
			'student_id' => $user_id
		);
		$result = $this->db->get_where('certificates', $checker)->row_array();
		$certificate_link = site_url('certificate/'.$result['shareable_url']);
		$course_details    = $this->crud_model->get_course_by_id($course_id)->row_array();
		$user_details = $this->user_model->get_all_user($user_id)->row_array();
		$email_from = get_settings('system_email');
		$subject 		= "Course Completion Notification";
		$email_msg	=	"<b>Congratulations!!</b> ". $user_details['first_name']." ".$user_details['last_name'].",";
		$email_msg	.=	"<p>You have successfully completed the course named, <b>".$course_details['title'].".</b></p>";
		$email_msg	.=	"<p>You can get your course completion certificate from here <b>".$certificate_link.".</b></p>";
		$this->send_smtp_mail($email_msg, $subject, $user_details['email'], $email_from);
	}

	public function suspended_offline_payment($user_id = ""){
		$user_details = $this->user_model->get_all_user($user_id)->row_array();
		$email_from = get_settings('system_email');
		$subject 	= "Suspended Offline Payment";
		$email_msg  = "<p>Your offline payment has been <b style='color: red;'>suspended</b> !</p>";
		$email_msg .= "<p>Please provide a valid document of your payment.</p>";

		$this->send_smtp_mail($email_msg, $subject, $user_details['email'], $email_from);
	}

	public function send_smtp_mail($msg=NULL, $sub=NULL, $to=NULL, $from=NULL, $email_type=NULL, $redirect_url=NULL) {
		//Load email library
		$this->load->library('email');

		if($from == NULL)
			$from		=	$this->db->get_where('settings' , array('key' => 'system_email'))->row()->value;

		//SMTP & mail configuration
		$config = array(
			//'protocol'  => get_settings('protocol'),
//            'smtp_host' => get_settings('smtp_host'),
//            'smtp_port' => get_settings('smtp_port'),
//            'smtp_user' => get_settings('smtp_user'),
//			'smtp_pass' => get_settings('smtp_pass'),
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_port' => '587',
            'smtp_user' => 'apikey',
            'smtp_pass' => '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',
                  'mailtype'  => 'html'
			//'charset'   => 'iso-8859-1'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$email_data = array('subject' => $sub, 'message' => $msg);

		if ($email_type == "verification") {
			$email_data['redirect_url'] = $redirect_url;
		}

		$htmlContent = $this->load->view('email/template', $email_data, TRUE);
		// $htmlContent = $msg;
        //echo $htmlContent;
       $to = 'rittika.sharma@glocalview.com';
		$this->email->to($to);
        $from = 'info@youngachievers.in';
		$this->email->from($from, get_settings('system_name'));
		$this->email->subject($sub);
		$this->email->message($htmlContent);

       // print($to);
        //print($from);
        //print($sub);
        //print($htmlContent);die;
		//Send email
		$this->email->send();

//        $this->email->initialize(array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'smtp.sendgrid.net',
//            'smtp_user' => 'apikey',
//            'smtp_pass' => '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',
//            'smtp_port' => 587,
//            'crlf' => "\r\n",
//            'newline' => "\r\n"
//        ));
//
//        $this->email->from('glocalhub2021@gmail.com', 'Your Name');
//        $this->email->to('rittika.sharma@glocalview.com');
//        $this->email->cc('rittika.sharma@glocalview.com');
//        $this->email->bcc('rittika.sharma@glocalview.com');
//        $this->email->subject('Email Test');
//        $this->email->message('Testing the email class.');
//        $this->email->send();

    }
}
