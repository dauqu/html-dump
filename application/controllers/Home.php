<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."libraries/Razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        // $this->load->library('stripe');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        // Load cart library
        $this->load->library('cart');

        // Load product model
        $this->load->model('Batch_model');

        // CHECK CUSTOM SESSION DATA
        $this->session_data();
    }

    public function index() {
        $this->home();
    }

    public function home() {
        $page_data['page_name'] = "home";
        $page_data['page_title'] = site_phrase('home');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function shopping_cart() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $page_data['page_name'] = "shopping_cart";
        $page_data['page_title'] = site_phrase('shopping_cart');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function courses() {
        if (!$this->session->userdata('layout')) {
            $this->session->set_userdata('layout', 'list');
        }
        $layout = $this->session->userdata('layout');
        $selected_category_id = "all";
        $selected_price = "all";
        $selected_level = "all";
        $selected_language = "all";
        $selected_rating = "all";
        // Get the category ids
        if (isset($_GET['category']) && !empty($_GET['category'] && $_GET['category'] != "all")) {
            $selected_category_id = $this->crud_model->get_category_id($_GET['category']);
        }

        // Get the selected price
        if (isset($_GET['price']) && !empty($_GET['price'])) {
            $selected_price = $_GET['price'];
        }

        // Get the selected level
        if (isset($_GET['level']) && !empty($_GET['level'])) {
            $selected_level = $_GET['level'];
        }

        // Get the selected language
        if (isset($_GET['language']) && !empty($_GET['language'])) {
            $selected_language = $_GET['language'];
        }

        // Get the selected rating
        if (isset($_GET['rating']) && !empty($_GET['rating'])) {
            $selected_rating = $_GET['rating'];
        }


        if ($selected_category_id == "all" && $selected_price == "all" && $selected_level == 'all' && $selected_language == 'all' && $selected_rating == 'all') {
            $this->db->where('status', 'active');
            $total_rows = $this->db->get('course')->num_rows();
            $config = array();
            $config = pagintaion($total_rows, 6);
            $config['base_url']  = site_url('home/courses/');
            $this->pagination->initialize($config);
            $this->db->where('status', 'active');
            $page_data['courses'] = $this->db->get('course', $config['per_page'], $this->uri->segment(3))->result_array();
        }else {
            $courses = $this->crud_model->filter_course($selected_category_id, $selected_price, $selected_level, $selected_language, $selected_rating);
            $page_data['courses'] = $courses;
        }

        $page_data['page_name']  = "courses_page";
        $page_data['page_title'] = site_phrase('courses');
        $page_data['layout']     = $layout;
        $page_data['selected_category_id']     = $selected_category_id;
        $page_data['selected_price']     = $selected_price;
        $page_data['selected_level']     = $selected_level;
        $page_data['selected_language']     = $selected_language;
        $page_data['selected_rating']     = $selected_rating;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function set_layout_to_session() {
        $layout = $this->input->post('layout');
        $this->session->set_userdata('layout', $layout);
    }

    public function course($slug = "", $course_id = "") {
        $this->access_denied_courses($course_id);
        $today_date = strtotime(date('D, Y-m-d'));
        $page_data['course_id'] = $course_id;
        $page_data['page_name'] = "course_page";
        $page_data['page_title'] = site_phrase('course');
        $page_data['today_date'] = $today_date;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function instructor_page($instructor_id = "") {
        $page_data['page_name'] = "instructor_page";
        $page_data['page_title'] = site_phrase('instructor_page');
        $page_data['instructor_id'] = $instructor_id;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function my_courses() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }
        $today_date = strtotime(date('D, Y-m-d'));
        $user_id = $this->session->userdata('user_id');
        $payments = $this->crud_model->get_payment_by_userid_group_by_batchid($user_id,$today_date);
        $page_data['payments'] = $payments;

        $page_data['page_name'] = "my_courses";
        $page_data['page_title'] = site_phrase("my_courses");
        $page_data['current_timestamp'] = time();
        $page_data['today_date'] = $today_date;
        //echo '<pre>'; print_r($page_data);
        //echo $this->db->last_query();
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    public function my_messages($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }
        if ($param1 == 'read_message') {
            $page_data['message_thread_code'] = $param2;
        }
        elseif ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', site_phrase('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $message_thread_code), 'refresh');
        }
        elseif ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', site_phrase('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $param2), 'refresh');
        }
        $page_data['page_name'] = "my_messages";
        $page_data['page_title'] = site_phrase('my_messages');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function my_notifications() {
        $page_data['page_name'] = "my_notifications";
        $page_data['page_title'] = site_phrase('my_notifications');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function my_wishlist() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $page_data['page_name'] = "my_wishlist";
        $page_data['page_title'] = site_phrase('my_wishlist');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function purchase_history() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        $total_rows = $this->crud_model->purchase_history($this->session->userdata('user_id'))->num_rows();
        $config = array();
        $config = pagintaion($total_rows, 10);
        $config['base_url']  = site_url('home/purchase_history');
        $this->pagination->initialize($config);
        $page_data['per_page']   = $config['per_page'];

        if(addon_status('offline_payment') == 1):
            $this->load->model('addons/offline_payment_model');
            $page_data['pending_offline_payment_history'] = $this->offline_payment_model->pending_offline_payment($this->session->userdata('user_id'))->result_array();
        endif;

        $page_data['page_name']  = "purchase_history";
        $page_data['page_title'] = site_phrase('purchase_history');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function profile($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        if ($param1 == 'user_profile') {
            $page_data['page_name'] = "user_profile";
            $page_data['page_title'] = site_phrase('user_profile');
        }elseif ($param1 == 'user_credentials') {
            $page_data['page_name'] = "user_credentials";
            $page_data['page_title'] = site_phrase('credentials');
        }elseif ($param1 == 'user_photo') {
            $page_data['page_name'] = "update_user_photo";
            $page_data['page_title'] = site_phrase('update_user_photo');
        }
        $page_data['user_details'] = $this->user_model->get_user($this->session->userdata('user_id'));
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function update_profile($param1 = "") {
        if ($param1 == 'update_basics') {
            $this->user_model->edit_user($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_profile'), 'refresh');
        }elseif ($param1 == "update_credentials") {
            $this->user_model->update_account_settings($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_credentials'), 'refresh');
        }elseif ($param1 == "update_photo") {
            $this->user_model->upload_user_image($this->session->userdata('user_id'));
            $this->session->set_flashdata('flash_message', site_phrase('updated_successfully'));
            redirect(site_url('home/profile/user_photo'), 'refresh');
        }

    }

    public function handleWishList($return_number = "") {
        if ($this->session->userdata('user_login') != 1) {
            echo false;
        }else {
            if (isset($_POST['course_id'])) {
                $course_id = $this->input->post('course_id');
                $this->crud_model->handleWishList($course_id);
            }
            if($return_number == 'true'){
                echo sizeof($this->crud_model->getWishLists());
            }else{
                $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
            }
        }
    }

    public function handleCartItems($return_number = "")
   {
        $data['cartItems'] = $this->session->userdata('cart_items');

        if (count($data['cartItems'])==0)
        {
            $this->session->set_userdata('cart_items', array());
        }

      
        $course_id = $this->input->post('course_id');
        $dataItems = array();

        foreach($course_id as $val)
        {
	
            $dataArr =array();

            $dataArr = explode('_',$val);

            $course_id = $dataArr[0];
            $batch_id = $dataArr[1];

            // print("$dataArr[1]::::"+$dataArr[1]);
            $batch_details = $this->Batch_model->get_batch_by_id($dataArr[1])->row_array();
       
            // print_r($batch_details);
            $data['cartItems'] = $this->session->userdata('cart_items');
       
            $itemsArray = !empty($data['cartItems'])?$data['cartItems']:$dataItems;

            if(count($data['cartItems'])>0)
            {
                $courswArray = array();
                $alreadyExists =0;

                foreach ($data['cartItems'] as $batch)
                {

                    $courswArray  = $batch;
                    if($batch['id']==$dataArr[1])
                    {
                        $alreadyExists =1;
                    }


                }
                if(!$alreadyExists)
                {
                    $new_batch = array(array(
                        'id'    => $dataArr[1],
                        'qty'    => 1,
                        'price'    => $batch_details['batch_price'],
                        'name'    => $batch_details['title']
                    ));
                    $courswArray123 = array_merge($data['cartItems'], $new_batch);

                    // $data['cartItems'][$batch_id] =  $courswArray123;
                    $this->session->set_userdata('cart_items',$courswArray123);

                }
            }else{
                // $dataItems[$dataArr[0]][] = array(
                //   'id'    => $dataArr[1],
                // 'qty'    => 1,
                // 'price'    => $batch_details['batch_price'],
                // 'name'    => $batch_details['title']
                //);
                $arr =  array(array(
                    'id'    => $dataArr[1],
                    'qty'    => 1,
                    'price'    => $batch_details['batch_price'],
                    'name'    => $batch_details['title']
                ));

                $this->session->set_userdata('cart_items',$arr);
            }

        }

        if($return_number == 'true'){
            echo sizeof($data['cartItems']);
        }else{
            $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
        }

    }
    public function refreshCartItems($return_number = "")
    {
        
        $data['cartItems'] = $this->session->userdata('cart_items');


        if (count($data['cartItems'])==0)
        {
            $this->session->set_userdata('cart_items', array());
        }

        $data['cartItems'] = $this->session->userdata('cart_items');

        $course_id = $this->input->post('course_id');
        $dataItems =array();

        $val =$course_id;

        $dataArr =array();

        $dataArr = explode('_',$val);
        $course_id = $dataArr[0];

        $batch_details = $this->Batch_model->get_batch_by_id($dataArr[1])->row_array();

        $itemsArray = !empty($data['cartItems'])?$data['cartItems']:$dataItems;

        if(count($data['cartItems'])>0)
        {
            $courswArray = $data['cartItems'];
            $alreadyExists =0;

            foreach ($courswArray as $batch)
            {

                if($batch['id']==$dataArr[1])
		{
                    $alreadyExists =1;

                }
            }

            if(!$alreadyExists)
            {

                $new_batch = array(array(
                    'id'    => $dataArr[1],
                    'qty'    => $dataArr[2],
                    'price'    => $batch_details['batch_price'],
                    'name'    => $batch_details['title']
                ));


                $courswArray123 = array_merge($courswArray, $new_batch);


              //  $data['cartItems'][$course_id] =  $courswArray123;

                $this->session->set_userdata('cart_items',$courswArray123);

            }else{
               
                foreach ($courswArray as $batch)
                {

                    if($batch['id']==$dataArr[1])
                    {
                        $key = array_search($batch, $courswArray);

                        unset($courswArray[$key]);
                        $new_batch = array(array(
                            'id'    => $dataArr[1],
                            'qty'    => $dataArr[2],
                            'price'    => $batch_details['batch_price'],
                            'name'    => $batch_details['title']
                        ));

                        $courswArray123 = array_merge($courswArray, $new_batch);

                    //    $data['cartItems'][$course_id] =  $courswArray123;

                        $this->session->set_userdata('cart_items',$courswArray123);

                    }
                }

            }
        }else{

            $dataItems[$dataArr[0]][] = array(
                'id'    => $dataArr[1],
                'qty'    => $dataArr[2],
                'price'    => $batch_details['batch_price'],
                'name'    => $batch_details['title']
            );

            $this->session->set_userdata('cart_items',$dataItems);
        }
 

    }

    public function removeCartItems() {


        $data['cartItems'] = $this->session->userdata('cart_items');

        if (count($data['cartItems'])==0) {
            $this->session->set_userdata('cart_items', array());
        }

        $data['cartItems'] = $this->session->userdata('cart_items');

        $course_id = $this->input->post('course_id');
        $dataItems =array();

        $val =$course_id;

        $dataArr =array();

        $dataArr = explode('_',$val);
        $course_id = $dataArr[0];

        $batch_details = $this->Batch_model->get_batch_by_id($dataArr[1])->row_array();

        $itemsArray = !empty($data['cartItems'])?$data['cartItems']:$dataItems;

        if(count($data['cartItems'])>0)
        {
            $courswArray = $data['cartItems'];
            $alreadyExists =0;

            foreach ($courswArray as $batch)
            {

                if($batch['id']==$dataArr[1])
                {
                    $key = array_search($batch, $courswArray);
                    unset($courswArray[$key]);
                   // $data['cartItems'] =  $courswArray;

                    $this->session->set_userdata('cart_items',$courswArray);

                }
            }

        }
    }

    public function handleCartItemForBuyNowButton($return_number = "")
    {
	
        //if (!$this->session->userdata('cart_items')) {
          //  $this->session->set_userdata('cart_items', array());
        //}

        //$course_id = $this->input->post('course_id');
        //$previous_cart_items = $this->session->userdata('cart_items');
        //if (!in_array($course_id, $previous_cart_items)) {
          //  array_push($previous_cart_items, $course_id);
        //}
        //$this->session->set_userdata('cart_items', $previous_cart_items);

        $data['cartItems'] = $this->session->userdata('cart_items');

        if (count($data['cartItems'])==0)
        {
            $this->session->set_userdata('cart_items', array());
        }

      
        $course_id = $this->input->post('course_id');
        $dataItems = array();

        foreach($course_id as $val)
        {
	
            $dataArr =array();

            $dataArr = explode('_',$val);

            $course_id = $dataArr[0];
            $batch_id = $dataArr[1];

            // print("$dataArr[1]::::"+$dataArr[1]);
            $batch_details = $this->Batch_model->get_batch_by_id($dataArr[1])->row_array();
       
            // print_r($batch_details);
            $data['cartItems'] = $this->session->userdata('cart_items');
       
            $itemsArray = !empty($data['cartItems'])?$data['cartItems']:$dataItems;

            if(count($data['cartItems'])>0)
            {
                $courswArray = array();
                $alreadyExists =0;

                foreach ($data['cartItems'] as $batch)
                {

                    $courswArray  = $batch;
                    if($batch['id']==$dataArr[1])
                    {
                        $alreadyExists =1;
                    }


                }
                if(!$alreadyExists)
                {
                    $new_batch = array(array(
                        'id'    => $dataArr[1],
                        'qty'    => 1,
                        'price'    => $batch_details['batch_price'],
                        'name'    => $batch_details['title']
                    ));
                    $courswArray123 = array_merge($data['cartItems'], $new_batch);

                    // $data['cartItems'][$batch_id] =  $courswArray123;
                    $this->session->set_userdata('cart_items',$courswArray123);

                }
            }else{
                // $dataItems[$dataArr[0]][] = array(
                //   'id'    => $dataArr[1],
                // 'qty'    => 1,
                // 'price'    => $batch_details['batch_price'],
                // 'name'    => $batch_details['title']
                //);
                $arr =  array(array(
                    'id'    => $dataArr[1],
                    'qty'    => 1,
                    'price'    => $batch_details['batch_price'],
                    'name'    => $batch_details['title']
                ));

                $this->session->set_userdata('cart_items',$arr);
            }

        }

        if($return_number == 'true'){
            echo sizeof($data['cartItems']);
         

        }else{


            $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
echo '<script>window.location.href="https://youngachievers.in/home/shopping_cart"</script>';

        }
        
       //  redirect(site_url('home/shopping_cart'), 'refresh');
    }

    public function refreshWishList() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
    }

    public function refreshShoppingCart() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/shopping_cart_inner_view');
    }

    public function isLoggedIn() {
        if ($this->session->userdata('user_login') == 1)
            echo true;
        else
            echo false;
    }

    //choose payment gateway
    public function payment(){
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        $page_data['total_price_of_checking_out'] = $this->session->userdata('total_price_of_checking_out');
        $page_data['page_title'] = site_phrase("payment_gateway");
        $this->load->view('payment/index', $page_data);
    }

    // SHOW PAYPAL CHECKOUT PAGE
    public function paypal_checkout($payment_request = "only_for_mobile") {
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
            redirect('home', 'refresh');

        //checking price
        if($this->session->userdata('total_price_of_checking_out') == $this->input->post('total_price_of_checking_out')):
            $total_price_of_checking_out = $this->input->post('total_price_of_checking_out');
        else:
            $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        endif;
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/paypal_checkout', $page_data);
    }

    // PAYPAL CHECKOUT ACTIONS
    public function paypal_payment($user_id = "", $amount_paid = "", $paymentID = "", $paymentToken = "", $payerID = "", $payment_request_mobile = "") {
        $paypal_keys = get_settings('paypal');
        $paypal = json_decode($paypal_keys);

        if ($paypal[0]->mode == 'sandbox') {
            $paypalClientID = $paypal[0]->sandbox_client_id;
            $paypalSecret   = $paypal[0]->sandbox_secret_key;
        }else{
            $paypalClientID = $paypal[0]->production_client_id;
            $paypalSecret   = $paypal[0]->production_secret_key;
        }

        //THIS IS HOW I CHECKED THE PAYPAL PAYMENT STATUS
        $status = $this->payment_model->paypal_payment($paymentID, $paymentToken, $payerID, $paypalClientID, $paypalSecret);
        if (!$status) {
            $this->session->set_flashdata('error_message', site_phrase('an_error_occurred_during_payment'));
            redirect('home', 'refresh');
        }
        $this->crud_model->enrol_student($user_id);
        $this->crud_model->course_purchase($user_id, 'paypal', $amount_paid);
        $this->email_model->course_purchase_notification($user_id, 'paypal', $amount_paid);
        $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
        if($payment_request_mobile == 'true'):
            $course_id = $this->session->userdata('cart_items');
            redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/paid', 'refresh');
        else:
            $this->session->set_userdata('cart_items', array());
            redirect('home', 'refresh');
        endif;

    }

    // SHOW STRIPE CHECKOUT PAGE
    public function stripe_checkout($payment_request = "only_for_mobile") {

        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
            redirect('home', 'refresh');

        //checking price
        $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('payment/stripe/stripe_checkout', $page_data);
    }

    // STRIPE CHECKOUT ACTIONS
    public function stripe_payment($user_id = "", $payment_request_mobile = "") {
        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $response = $this->payment_model->razorpay_payment($user_id);

        if ($response['payment_status'] === 'succeeded') {
            // STUDENT ENROLMENT OPERATIONS AFTER A SUCCESSFUL PAYMENT
            $this->crud_model->enrol_student($user_id);
            $this->crud_model->course_purchase($user_id, 'stripe', $response['paid_amount']);
            $this->email_model->course_purchase_notification($user_id, 'stripe', $response['paid_amount']);

            if($payment_request_mobile == 'true'):
                $course_id = $this->session->userdata('cart_items');
                $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/paid', 'refresh');
            else:
                $this->session->set_userdata('cart_items', array());
                $this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                redirect('home', 'refresh');
            endif;
        }else{
            if($payment_request_mobile == 'true'):
                $course_id = $this->session->userdata('cart_items');
                $this->session->set_flashdata('flash_message', $response['status_msg']);
                redirect('home/payment_success_mobile/'.$course_id[0].'/'.$user_id.'/error', 'refresh');
            else:
                $this->session->set_flashdata('error_message', $response['status_msg']);
                redirect('home', 'refresh');
            endif;

        }

    }



    public function my_courses_by_category() {
        $category_id = $this->input->post('category_id');
        $course_details = $this->crud_model->get_my_courses_by_category_id($category_id)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }

    public function lesson($course_name="",$batch_id = "")
    {
        $batch_details = $this->Batch_model->get_batch_by_id($batch_id)->result_array();

        foreach ($batch_details as $key => $batch_detail)
        {
            $page_data['batch_details'] = $batch_detail;
            $page_data['course_name'] = $batch_detail['title'];
        }

        $schedules = $this->Batch_model->get_schedules('all',$batch_id,'all','');

        $user_id = $this->session->userdata('user_id');
        $response = $this->Batch_model->batch_attendance($batch_id,$user_id);
        $url='';

        $page_data['page_name']  = 'lessons';
        $page_data['schedules'] = $schedules;

        if ($this->session->userdata('user_login') != 1){
            if ($this->session->userdata('admin_login') != 1){
                redirect('home', 'refresh');
            }
        }
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    public function search($search_string = "") {
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search_string = $_GET['query'];
            $page_data['courses'] = $this->crud_model->get_courses_by_search_string($search_string)->result_array();
        }else {
            $this->session->set_flashdata('error_message', site_phrase('no_search_value_found'));
            redirect(site_url(), 'refresh');
        }

        if (!$this->session->userdata('layout')) {
            $this->session->set_userdata('layout', 'list');
        }
        $page_data['layout']     = $this->session->userdata('layout');
        $page_data['page_name'] = 'courses_page';
        $page_data['search_string'] = $search_string;
        $page_data['page_title'] = site_phrase('search_results');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function my_courses_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_my_courses_by_search_string($search_string)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }

    public function get_my_wishlists_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_courses_of_wishlists_by_search_string($search_string);
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }

    public function reload_my_wishlists() {
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }

    public function get_course_details() {
        $course_id = $this->input->post('course_id');
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        echo $course_details['title'];
    }

    public function rate_course() {
        $data['review'] = $this->input->post('review');
        $data['ratable_id'] = $this->input->post('batch_id');
        $data['ratable_type'] = 'batch';
        $data['rating'] = $this->input->post('starRating');
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['user_id'] = $this->session->userdata('user_id');
        $this->crud_model->rate($data);
    }

    public function about_us() {
        $page_data['page_name'] = 'about_us';
        $page_data['page_title'] = site_phrase('about_us');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function terms_and_condition() {
        $page_data['page_name'] = 'terms_and_condition';
        $page_data['page_title'] = site_phrase('terms_and_condition');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function privacy_policy() {
        $page_data['page_name'] = 'privacy_policy';
        $page_data['page_title'] = site_phrase('privacy_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
    public function cookie_policy() {
        $page_data['page_name'] = 'cookie_policy';
        $page_data['page_title'] = site_phrase('cookie_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }


    // Version 1.1
    public function dashboard($param1 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == "") {
            $page_data['type'] = 'active';
        }else {
            $page_data['type'] = $param1;
        }

        $page_data['page_name']  = 'instructor_dashboard';
        $page_data['page_title'] = site_phrase('instructor_dashboard');
        $page_data['user_id']    = $this->session->userdata('user_id');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function create_course() {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        $page_data['page_name'] = 'create_course';
        $page_data['page_title'] = site_phrase('create_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function edit_course($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param2 == "") {
            $page_data['type']   = 'edit_course';
        }else {
            $page_data['type']   = $param2;
        }
        $page_data['page_name']  = 'manage_course_details';
        $page_data['course_id']  = $param1;
        $page_data['page_title'] = site_phrase('edit_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function course_action($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == 'create') {
            if (isset($_POST['create_course'])) {
                $this->crud_model->add_course();
                redirect(site_url('home/create_course'), 'refresh');
            }else {
                $this->crud_model->add_course('save_to_draft');
                redirect(site_url('home/create_course'), 'refresh');
            }
        }elseif ($param1 == 'edit') {
            if (isset($_POST['publish'])) {
                $this->crud_model->update_course($param2, 'publish');
                redirect(site_url('home/dashboard'), 'refresh');
            }else {
                $this->crud_model->update_course($param2, 'save_to_draft');
                redirect(site_url('home/dashboard'), 'refresh');
            }
        }
    }


    public function sections($action = "", $course_id = "", $section_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($action == "add") {
            $this->crud_model->add_section($course_id);

        }elseif ($action == "edit") {
            $this->crud_model->edit_section($section_id);

        }elseif ($action == "delete") {
            $this->crud_model->delete_section($course_id, $section_id);
            $this->session->set_flashdata('flash_message', site_phrase('section_deleted'));
            redirect(site_url("home/edit_course/$course_id/manage_section"), 'refresh');

        }elseif ($action == "serialize_section") {
            $container = array();
            $serialization = json_decode($this->input->post('updatedSerialization'));
            foreach ($serialization as $key) {
                array_push($container, $key->id);
            }
            $json = json_encode($container);
            $this->crud_model->serialize_section($course_id, $json);
        }
        $page_data['course_id'] = $course_id;
        $page_data['course_details'] = $this->crud_model->get_course_by_id($course_id)->row_array();
        return $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_section', $page_data);
    }

    public function manage_lessons($action = "", $course_id = "", $lesson_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        if ($action == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', site_phrase('lesson_added'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', site_phrase('lesson_updated'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', site_phrase('lesson_deleted'));
        }
        redirect('home/edit_course/'.$course_id.'/manage_lesson');
    }

    public function lesson_editing_form($lesson_id = "", $course_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $page_data['type']      = 'manage_lesson';
        $page_data['course_id'] = $course_id;
        $page_data['lesson_id'] = $lesson_id;
        $page_data['page_name']  = 'lesson_edit';
        $page_data['page_title'] = site_phrase('update_lesson');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function download($filename = "") {
        $tmp           = explode('.', $filename);
        $fileExtension = strtolower(end($tmp));
        $yourFile = base_url().'uploads/lesson_files/'.$filename;
        $file = @fopen($yourFile, "rb");

        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
    }

    // Version 1.3 codes
    public function get_enrolled_to_free_course($course_id) {
        if ($this->session->userdata('user_login') == 1) {
            $this->crud_model->enrol_to_free_course($course_id, $this->session->userdata('user_id'));
            redirect(site_url('home/my_courses'), 'refresh');
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }

    // Version 1.4 codes
    public function login() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        }
        $page_data['page_name'] = 'login';
        $page_data['page_title'] = site_phrase('login');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function sign_up() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        }
        $page_data['page_name'] = 'sign_up';
        $page_data['page_title'] = site_phrase('sign_up');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function forgot_password() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        }
        $page_data['page_name'] = 'forgot_password';
        $page_data['page_title'] = site_phrase('forgot_password');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function submit_quiz($from = "") {
        $submitted_quiz_info = array();
        $container = array();
        $quiz_id = $this->input->post('lesson_id');
        $quiz_questions = $this->crud_model->get_quiz_questions($quiz_id)->result_array();
        $total_correct_answers = 0;
        foreach ($quiz_questions as $quiz_question) {
            $submitted_answer_status = 0;
            $correct_answers = json_decode($quiz_question['correct_answers']);
            $submitted_answers = array();
            foreach ($this->input->post($quiz_question['id']) as $each_submission) {
                if (isset($each_submission)) {
                    array_push($submitted_answers, $each_submission);
                }
            }
            sort($correct_answers);
            sort($submitted_answers);
            if ($correct_answers == $submitted_answers) {
                $submitted_answer_status = 1;
                $total_correct_answers++;
            }
            $container = array(
                "question_id" => $quiz_question['id'],
                'submitted_answer_status' => $submitted_answer_status,
                "submitted_answers" => json_encode($submitted_answers),
                "correct_answers"  => json_encode($correct_answers),
            );
            array_push($submitted_quiz_info, $container);
        }
        $page_data['submitted_quiz_info']   = $submitted_quiz_info;
        $page_data['total_correct_answers'] = $total_correct_answers;
        $page_data['total_questions'] = count($quiz_questions);
        if ($from == 'mobile') {
            $this->load->view('mobile/quiz_result', $page_data);
        }else{
            $this->load->view('lessons/quiz_result', $page_data);
        }
    }

    private function access_denied_courses($course_id){
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft' && $course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', site_phrase('you_do_not_have_permission_to_access_this_course'));
            redirect(site_url('home'), 'refresh');
        }elseif ($course_details['status'] == 'pending') {
            if ($course_details['user_id'] != $this->session->userdata('user_id') && $this->session->userdata('role_id') != 1) {
                $this->session->set_flashdata('error_message', site_phrase('you_do_not_have_permission_to_access_this_course'));
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function invoice($purchase_history_id = '') {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $purchase_history = $this->crud_model->get_payment_details_by_id($purchase_history_id);
        if ($purchase_history['user_id'] != $this->session->userdata('user_id')) {
            redirect('home', 'refresh');
        }
        $page_data['payment_info'] = $purchase_history;
        $page_data['page_name'] = 'invoice';
        $page_data['page_title'] = 'invoice';
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    public function page_not_found() {
        $page_data['page_name'] = '404';
        $page_data['page_title'] = site_phrase('404_page_not_found');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }

    // AJAX CALL FUNCTION FOR CHECKING COURSE PROGRESS
    function check_course_progress($course_id) {
        echo course_progress($course_id);
    }

    // This is the function for rendering quiz web view for mobile
    public function quiz_mobile_web_view($lesson_id = "") {
        $data['lesson_details'] = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
        $data['page_name'] = 'quiz';
        $this->load->view('mobile/index', $data);
    }


    // CHECK CUSTOM SESSION DATA
    public function session_data() {
        // SESSION DATA FOR CART
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        // SESSION DATA FOR FRONTEND LANGUAGE
        if (!$this->session->userdata('language')) {
            $this->session->set_userdata('language', get_settings('language'));
        }

    }

    // SETTING FRONTEND LANGUAGE
    public function site_language() {
        $selected_language = $this->input->post('language');
        $this->session->set_userdata('language', $selected_language);
        echo true;
    }


    //FOR MOBILE
    public function course_purchase($auth_token = '', $course_id  = ''){
        $this->load->model('jwt_model');
        if(empty($auth_token) || $auth_token == "null"){
            $page_data['cart_item'] = $course_id;
            $page_data['user_id'] = '';
            $page_data['is_login_now'] = 0;
            $page_data['enroll_type'] = null;
            $page_data['page_name'] = 'shopping_cart';
            $this->load->view('mobile/index', $page_data);
        }else{

            $logged_in_user_details = json_decode($this->jwt_model->token_data_get($auth_token), true);

            if ($logged_in_user_details['user_id'] > 0) {

                $credential = array('id' => $logged_in_user_details['user_id'], 'status' => 1, 'role_id' => 2);
                $query = $this->db->get_where('users', $credential);
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $page_data['cart_item'] = $course_id;
                    $page_data['user_id'] = $row->id;
                    $page_data['is_login_now'] = 1;
                    $page_data['enroll_type'] = null;
                    $page_data['page_name'] = 'shopping_cart';

                    $cart_item = array($course_id);
                    $this->session->set_userdata('cart_items', $cart_item);
                    $this->session->set_userdata('user_login', '1');
                    $this->session->set_userdata('user_id', $row->id);
                    $this->session->set_userdata('role_id', $row->role_id);
                    $this->session->set_userdata('role', get_user_role('user_role', $row->id));
                    $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
                    $this->load->view('mobile/index', $page_data);
                }
            }

        }
    }

    //FOR MOBILE
    public function get_enrolled_to_free_course_mobile($course_id ="", $user_id ="", $get_request = "") {
        if ($get_request == "true") {
            $this->crud_model->enrol_to_free_course_mobile($course_id, $user_id);
        }
    }

    //FOR MOBILE
    public function payment_success_mobile($course_id = "", $user_id = "", $enroll_type = ""){
        if($course_id > 0 && $user_id > 0):
            $page_data['cart_item'] = $course_id;
            $page_data['user_id'] = $user_id;
            $page_data['is_login_now'] = 1;
            $page_data['enroll_type'] = $enroll_type;
            $page_data['page_name'] = 'shopping_cart';

            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('role_id');
            $this->session->unset_userdata('role');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('user_login');
            $this->session->unset_userdata('cart_items');

            $this->load->view('mobile/index', $page_data);
        endif;
    }

    //FOR MOBILE
    public function payment_gateway_mobile($course_id = "", $user_id = ""){
        if($course_id > 0 && $user_id > 0):
            $page_data['page_name'] = 'payment_gateway';
            $this->load->view('mobile/index', $page_data);
        endif;
    }

    public function generateHash()
    {
        if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
            //Request hash
            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
            if(strcasecmp($contentType, 'application/json') == 0){
                $data = json_decode(file_get_contents('php://input'));
                $hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
                $json=array();
                $json['success'] = $hash;
                echo json_encode($json);

            }
            exit(0);
        }
    }

    public function payumoney_success()
    {
        $page_data['page_name'] = "Success";
        $postdata = $_POST;
        $msg = '';

        $cartItems = $this->session->userdata('cart_items');
        $user_id = $this->session->userdata('user_id');

        foreach ($cartItems as $key => $batches_arr):

            foreach ($batches_arr as $batch):

                $batch_detail = $this->Batch_model->get_batch_by_id($batch['id'])->row_array();
                $number_of_sessions = $batch_detail['number_of_sessions']*$batch['qty'];

                $today_date = strtotime(date('D, d-M-Y')) + 86400;
                $tomorrow = strtotime('tomorrow');

                $batch_schedule_detail = $this->Batch_model->get_schedules('all',$batch['id'],'all',$tomorrow);

                $schedule_count = 1;
                $schedule_expiry_date = '';

                foreach ($batch_schedule_detail as $batch_schedule):
                    if($schedule_count == $number_of_sessions)
                    {
                        $schedule_expiry_date = $batch_schedule['start_date'];
                    }
                    $schedule_last_date = $batch_schedule['start_date'];
                    $schedule_count ++;
                endforeach;

                $this->updatePaymentDetails($postdata,$user_id,$key,$batch['id'],$schedule_expiry_date,$schedule_last_date);
            endforeach;

        endforeach;

    }

    function updatePaymentDetails($postdata,$user_id,$course_id,$batch_id,$schedule_expiry_date,$schedule_last_date)
    {
        if (isset($postdata ['key'])) {

            $key				=   $postdata['key'];
            $salt				=   $postdata['salt'];
            $txnid 				= 	$postdata['txnid'];
            $amount      		= 	$postdata['amount'];
            $productInfo  		= 	$postdata['productinfo'];
            $firstname    		= 	$postdata['firstname'];
            $email        		=	$postdata['email'];
            $udf5				=   $postdata['udf5'];
            $mihpayid			=	$postdata['mihpayid'];
            $status				= 	$postdata['status'];
            $resphash				= 	$postdata['hash'];

//        //Calculate response hash to verify
            $keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
            $keyArray 	  		= 	explode("|",$keyString);
            $reverseKeyArray 	= 	array_reverse($keyArray);
            $reverseKeyString	=	implode("|",$reverseKeyArray);
            $CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));

            $data['user_id'] = $user_id;
            $data['payment_type'] = 'payumoney';
            $data['course_id'] = $course_id;
            $data['amount'] = $postdata['amount'];


            $today_date = strtotime(date('D, d-M-Y'));

            $data['date_added']  = $today_date;

            $data['batch_id'] = $batch_id;

            $data['first_name'] = $postdata['firstname'];
            $data['email_id'] = $postdata['email'];
            $data['phone_no'] = $postdata['mihpayid'];

            if ($status == 'success'  && $resphash == $CalcHashString) {
                $msg = "Transaction Successful and Hash Verified...";
                //Do success order processing here...
            }
            else {
                //tampered or failed
                $msg = "Payment failed for Hasn not verified...";
            }

            $data['schedule_expiry_date'] = $schedule_expiry_date;
            $data['message'] = $msg;
            $data['transaction_id'] = $postdata['txnid'];
            $data['schedule_last_date'] = $schedule_last_date;

            $response = $this->payment_model->payumoney_payment($data);

            $this->session->set_userdata('cart_items', array());

        }
        else exit(0);
    }

    public function attendance()
    {

     	$batch_id = $this->input->post('batch_id');
 
        $today_date = strtotime(date('D, d-M-Y'));
        $schedules = $this->Batch_model->get_schedule_by_batch_id($batch_id, $today_date);

        $user_id = $this->session->userdata('user_id');


        // CHECK USER OR ADMIN LOGIN STATUS

        $this->is_logged_in();

        foreach ($schedules as $schedule)
        {
            $response = $this->Batch_model->attendance($schedule['id'],$user_id,$today_date,$schedule['batch_id']);

            $page_data['schedule_id']  = $schedule_id;
            $page_data['page_name']  = 'lessons';

            $page_data['schdetails'] = $schedule;
        }
        $page_data['logged_user_details'] = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();

        //   print "<script>window.location.href = '".$url."'</script>";
        $this->load->view('lessons/live_class', $page_data);
    }


    // razorpay
    public function pay()
    {
        $razorpay = json_decode(get_settings('razorpay_keys'));
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        $userName = $user_details['student_first_name'].' '.$user_details['student_last_name'];
        $email = $user_details['email'];
        $contact = $user_details['contact_no'];
        $currency = get_settings('razorpay_currency');
        $payment_request='';


// Convert product price to cent
        //$razorpayAmount = round($total_price_of_checking_out*100, 2);

        if ($razorpay[0]->razorpay_mode == 'on') {
            define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_key);
            define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_key);
        } else {
            define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_live_key);
            define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_live_key);
        }



        $api = new Api(RAZOR_API_KEY, RAZOR_SECRET_KEY);
        /**
         * You can calculate payment amount as per your logic
         * Always set the amount from backend for security reasons
         */
        //$_SESSION['payable_amount'] = $total_price_of_checking_out;
        $razorpayOrder = $api->order->create(array(
            'receipt'         => rand(),
            'amount'          => $total_price_of_checking_out * 100, // 2000 rupees in paise
            'currency'        => $currency,
            'payment_capture' => 1 // auto capture
        ));

        $amount = $razorpayOrder['amount'];
        $razorpayOrderId = $razorpayOrder['id'];
        $_SESSION['razorpay_order_id'] = $razorpayOrderId;
        $_SESSION['payable_amount'] = $razorpayOrderId;
        $data = $this->prepareData($amount,$razorpayOrderId,$userName,$email,$contact,$currency,RAZOR_API_KEY,RAZOR_SECRET_KEY);
        $this->load->view('payment/razorpay/rezorpay',array('data' => $data));
    }
    /**
     * This function verifies the payment,after successful payment
     */
    public function verify()
    {
        $success = true;
        $error = "payment_failed";
        $resp ='';
        $payment_request_mobile =false;

        $razorpay = json_decode(get_settings('razorpay_keys'));
        if ($razorpay[0]->razorpay_mode == 'on') {
            define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_key);
            define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_key);
        } else {
            define('RAZOR_API_KEY', $razorpay[0]->razorpay_public_live_key);
            define('RAZOR_SECRET_KEY', $razorpay[0]->razorpay_secret_live_key);
        }


        if (empty($_POST['razorpay_payment_id']) === false) {
            $api = new Api(RAZOR_API_KEY, RAZOR_SECRET_KEY);
            try {
                $attributes = array(
                    'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
                $api->utility->verifyPaymentSignature($attributes);
            } catch(SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay_Error : ' . $e->getMessage();
            }
        }


        /**
         * Call this function from where ever you want
         * to save save data before of after the payment
         */

        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        if ($success === true) 
        {

            $payable_amount = $this->session->userdata('total_price_of_checking_out');

            $cartItems= $this->session->userdata('cart_items');

            foreach ($cartItems as $batches_arr)
            {
                $data['user_id'] = $user_details['id'];
                $data['payment_type'] = 'razorpay';

                $date = new DateTime();
                $today_date = $date->getTimestamp();

                $batch_details = $this->Batch_model->get_batch_by_id($batches_arr['id'])->row_array();

                $data['course_id'] = $batch_details['course_id'];

                $data['amount'] = $batches_arr['price']*$batches_arr['qty'];
                $data['number_of_sessions'] = $batches_arr['qty'];
                $data['date_added']  = $today_date;

                $data['batch_id'] = $batches_arr['id'];

                $schedule_rows = $this->Batch_model->batch_schedule_expirydate($batches_arr['id'],$batches_arr['qty']);

                $schedule_last_rows = $this->Batch_model->batch_schedule_lastdate($batches_arr['id']);

		foreach ($schedule_rows as $schedule)
                {
			$schedule_expiry_date = $schedule['start_time'];
		}

		foreach ($schedule_last_rows as $schedule)
                {
			$schedule_last_date = $schedule['start_time'];
		}


                $data['schedule_expiry_date'] = $schedule_expiry_date;
                $data['schedule_last_date'] = $schedule_last_date;

                $response = $this->payment_model->payumoney_payment($data);

		$this->session->set_userdata('cart_items', array());

            }

            
            $this->email_model->course_purchase_notification($user_details['id'], 'razorpay', $payable_amount);


            if($payment_request_mobile == 'true'):

                $course_id ='';

                //$this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                //redirect('home/payment_success_mobile/'.$course_id.'/'.$user_details['id'].'/paid', 'refresh');
            else:
                //$this->session->set_userdata('cart_items', array());
                //$this->session->set_flashdata('flash_message', site_phrase('payment_successfully_done'));
                redirect('home', 'refresh');
            endif;
        }else {
            
                $this->session->set_flashdata('error_message', $error);
		$this->session->set_userdata('cart_items', array());

                redirect('home', 'refresh');
            }
    }


        
                  
    /**
     * This function preprares payment parameters
     * @param $amount
     * @param $razorpayOrderId
     * @return array
     */
    public function prepareData($amount,$razorpayOrderId,$userName,$email,$contact,$currency,$key)
    {
        $data = array(
            "key" => $key,
            "amount" => $amount,
            "currency"=>$currency,
            "description" => "payment",
            "image" => "http://localhost/young-achievers/uploads/system/logo-dark.png",
            "prefill" => array(
                "name"  => $userName,
                "email"  => $email,
                "contact" => $contact,
            ),
            "notes"  => array(
                "merchant_order_id" => rand(),
            ),
            "theme"  => array(
                "color"  => "#F37254"
            ),
            "order_id" => $razorpayOrderId,
        );
        return $data;
    }

    // CHECK USER LOGGID IN OR NOT
    public function is_logged_in() {
        if ($this->session->userdata('user_login') != 1 && $this->session->userdata('admin_login') != 1){
            redirect('home', 'refresh');
        }
    }
}
