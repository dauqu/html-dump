<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();

    }

    public function index() {

        //Load email library
        $this->load->library('email');


        //SMTP & mail configuration
        $config = array(
            'protocol'  => get_settings('protocol'),
            'smtp_host' => get_settings('smtp_host'),
            'smtp_port' => get_settings('smtp_port'),
            'smtp_user' => get_settings('smtp_user'),
            'smtp_pass' => get_settings('smtp_pass'),
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );

       /* $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_port' => '587',
            'smtp_user' =>'youngachievers',
            'smtp_pass' => 'Young#111',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );*/

        /*$config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_port' => '587',
            'smtp_user' =>'quizzwizz',
            'smtp_pass' => '?7%rW_z_rM7FvJY',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );*/

        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

//        $email_data = array('subject' => $sub, 'message' => $msg);
//
//        if ($email_type == "verification") {
//            $email_data['redirect_url'] = $redirect_url;
//        }
//
//        $htmlContent = $this->load->view('email/template', $email_data, TRUE);
         $htmlContent = 'Hello world 2';
        $to = 'skanta.it@gmail.com';
        $from = 'info@youngachievers.in';
        $sub = 'Test email from young achievers';
        $this->email->to($to);
        $this->email->from($from);
        $this->email->subject($sub);
        $this->email->message($htmlContent);

        //Send email
       $result= $this->email->send();
        print_r($result);

       echo  'data';
    }


}
