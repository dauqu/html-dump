<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        // Load product model
        $this->load->model('Batch_model');

        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
    }

    public function index() {
        if ($this->session->userdata('admin_login') == true) {
            $this->dashboard();
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }
    public function dashboard() {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index.php', $page_data);
    }

    public function blank_template() {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'blank_template';
        $this->load->view('backend/index.php', $page_data);
    }

    public function categories($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {

            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add') {
            $response = $this->crud_model->add_category();
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/categories'), 'refresh');
        }
        elseif ($param1 == "edit") {
            $response = $this->crud_model->edit_category($param2);
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/categories'), 'refresh');
        }
        elseif ($param1 == "delete") {
            $this->crud_model->delete_category($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(site_url('admin/categories'), 'refresh');
        }
        $page_data['page_name'] = 'categories';
        $page_data['page_title'] = get_phrase('categories');
        $page_data['categories'] = $this->crud_model->get_categories($param2);
        $this->load->view('backend/index', $page_data);
    }

    public function category_form($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == "add_category") {
            $page_data['page_name'] = 'category_add';
            $page_data['categories'] = $this->crud_model->get_categories()->result_array();
            $page_data['page_title'] = get_phrase('add_category');
        }
        if ($param1 == "edit_category") {
            $page_data['page_name'] = 'category_edit';
            $page_data['page_title'] = get_phrase('edit_category');
            $page_data['categories'] = $this->crud_model->get_categories()->result_array();
            $page_data['category_id'] = $param2;
        }

        $this->load->view('backend/index', $page_data);
    }

    public function sub_categories_by_category_id($category_id = 0) {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $category_id = $this->input->post('category_id');
        redirect(site_url("admin/sub_categories/$category_id"), 'refresh');
    }

    public function sub_category_form($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_sub_category') {
            $page_data['page_name'] = 'sub_category_add';
            $page_data['page_title'] = get_phrase('add_sub_category');
        }
        elseif ($param1 == 'edit_sub_category') {
            $page_data['page_name'] = 'sub_category_edit';
            $page_data['page_title'] = get_phrase('edit_sub_category');
            $page_data['sub_category_id'] = $param2;
        }
        $page_data['categories'] = $this->crud_model->get_categories();
        $this->load->view('backend/index', $page_data);
    }

    public function instructors($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if($param1 == "add"){
            $this->user_model->add_instructor();
            redirect(site_url('admin/instructors'), 'refresh');
        }
        elseif ($param1 == "edit") {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/instructors'), 'refresh');
        }
        elseif ($param1 == "delete") {
            $this->user_model->delete_user($param2);
            redirect(site_url('admin/instructors'), 'refresh');
        }

        $page_data['page_name'] = 'instructors';
        $page_data['page_title'] = get_phrase('instructor');
        $page_data['instructors'] = $this->user_model->get_instructor()->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_form($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add_instructor_form') {
            $page_data['page_name'] = 'instructor_add';
            $page_data['page_title'] = get_phrase('instructor_add');
            $this->load->view('backend/index', $page_data);
        }
        elseif ($param1 == 'edit_instructor_form') {
            $page_data['page_name'] = 'instructor_edit';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('instructor_edit');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function users($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == "add") {
            $this->user_model->add_user();
            redirect(site_url('admin/users'), 'refresh');
        }
        elseif ($param1 == "edit") {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/users'), 'refresh');
        }
        elseif ($param1 == "delete") {
            $this->user_model->delete_user($param2);
            redirect(site_url('admin/users'), 'refresh');
        }

        $page_data['page_name'] = 'users';
        $page_data['page_title'] = get_phrase('student');
        $page_data['users'] = $this->user_model->get_user($param2);
        $this->load->view('backend/index', $page_data);
    }

    public function user_form($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_user_form') {
            $page_data['page_name'] = 'user_add';
            $page_data['page_title'] = get_phrase('student_add');
            $this->load->view('backend/index', $page_data);
        }
        elseif ($param1 == 'edit_user_form') {
            $page_data['page_name'] = 'user_edit';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('student_edit');
            $this->load->view('backend/index', $page_data);
        }
        elseif ($param1 == 'student_courses') {

            $page_data['page_name'] = 'student_courses';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('student_courses');

            $user_details = $this->crud_model->get_user_details($param2)->result_array();

            $page_data['student_name'] = '';
            foreach ($user_details as $user_detail):
                $page_data['student_name']  = $user_detail['student_first_name'].' '.$user_detail['student_last_name'];
            endforeach;

            $batches = $this->Batch_model->get_student_batch_by_userid($param2)->result_array();
            $page_data['batches'] = $batches;
            $this->load->view('backend/index', $page_data);
        }
    }

    public function enrol_history($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 != "") {
            $date_range                   = $this->input->get('date_range');
            $date_range                   = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0]);
            $page_data['timestamp_end']   = strtotime($date_range[1]);
        }else {
            $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
            $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
            $page_data['timestamp_start']   = strtotime($first_day_of_month);
            $page_data['timestamp_end']     = strtotime($last_day_of_month);
        }
        $page_data['page_name'] = 'enrol_history';
        $page_data['enrol_history'] = $this->crud_model->enrol_history_by_date_range($page_data['timestamp_start'], $page_data['timestamp_end']);
        $page_data['page_title'] = get_phrase('enrol_history');
        $this->load->view('backend/index', $page_data);
    }

    public function enrol_student($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'enrol') {
            $this->crud_model->enrol_a_student_manually();
            redirect(site_url('admin/enrol_history'), 'refresh');
        }
        $page_data['page_name'] = 'enrol_student';
        $page_data['page_title'] = get_phrase('enrol_a_student');
        $this->load->view('backend/index', $page_data);
    }

   
   
    public function instructor_revenue($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['page_name'] = 'instructor_revenue';
        $page_data['payment_history'] = $this->crud_model->get_revenue_by_user_type("", "", 'instructor_revenue');
        $page_data['page_title'] = get_phrase('instructor_revenue');
        $this->load->view('backend/index', $page_data);
    }

    function invoice($payout_id = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'invoice';
        $page_data['payout_id'] = $payout_id;
        $page_data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $page_data);
    }

    public function payment_history_delete($param1 = "", $redirect_to = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->delete_payment_history($param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
        redirect(site_url('admin/'.$redirect_to), 'refresh');
    }

    public function enrol_history_delete($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->delete_enrol_history($param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
        redirect(site_url('admin/enrol_history'), 'refresh');
    }

    public function purchase_history() {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'purchase_history';
        $page_data['purchase_history'] = $this->crud_model->purchase_history();
        $page_data['page_title'] = get_phrase('purchase_history');
        $this->load->view('backend/index', $page_data);
    }

    public function system_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'system_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('flash_message', get_phrase('system_settings_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        if ($param1 == 'logo_upload') {
            move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/backend/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('backend_logo_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        if ($param1 == 'favicon_upload') {
            move_uploaded_file($_FILES['favicon']['tmp_name'], 'assets/favicon.png');
            $this->session->set_flashdata('flash_message', get_phrase('favicon_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        $page_data['languages']	 = $this->crud_model->get_all_languages();
        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function frontend_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'frontend_update') {
            $this->crud_model->update_frontend_settings();
            $this->session->set_flashdata('flash_message', get_phrase('frontend_settings_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'banner_image_update') {
            $this->crud_model->update_frontend_banner();
            $this->session->set_flashdata('flash_message', get_phrase('banner_image_update'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'light_logo') {
            $this->crud_model->update_light_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'dark_logo') {
            $this->crud_model->update_dark_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'small_logo') {
            $this->crud_model->update_small_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'favicon') {
            $this->crud_model->update_favicon();
            $this->session->set_flashdata('flash_message', get_phrase('favicon_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }

        $page_data['page_name'] = 'frontend_settings';
        $page_data['page_title'] = get_phrase('frontend_settings');
        $this->load->view('backend/index', $page_data);
    }
    public function payment_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'system_currency') {
            $this->crud_model->update_system_currency();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }
        if ($param1 == 'paypal_settings') {
            $this->crud_model->update_paypal_settings();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }
        if ($param1 == 'stripe_settings') {
            $this->crud_model->update_stripe_settings();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }
        if ($param1 == 'razorpay_settings') {
            $this->crud_model->update_razorpay_settings();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }

        $page_data['page_name'] = 'payment_settings';
        $page_data['page_title'] = get_phrase('payment_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function smtp_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'update') {
            $this->crud_model->update_smtp_settings();
            $this->session->set_flashdata('flash_message', get_phrase('smtp_settings_updated_successfully'));
            redirect(site_url('admin/smtp_settings'), 'refresh');
        }

        $page_data['page_name'] = 'smtp_settings';
        $page_data['page_title'] = get_phrase('smtp_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_settings($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'update') {
            $this->crud_model->update_instructor_settings();
            $this->session->set_flashdata('flash_message', get_phrase('instructor_settings_updated'));
            redirect(site_url('admin/instructor_settings'), 'refresh');
        }

        $page_data['page_name'] = 'instructor_settings';
        $page_data['page_title'] = get_phrase('instructor_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function theme_settings($action = '') {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name']  = 'theme_settings';
        $page_data['page_title'] = get_phrase('theme_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function theme_actions($action = "", $theme = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'activate') {
            $theme_to_active  = $this->input->post('theme');
            $installed_themes = $this->crud_model->get_installed_themes();
            if (in_array($theme_to_active, $installed_themes)) {
                $this->crud_model->activate_theme($theme_to_active);
                echo true;
            }else {
                echo false;
            }
        }
        elseif ($action == 'remove') {
            if ($theme == get_frontend_settings('theme')) {
                $this->session->set_flashdata('error_message', get_phrase('activate_a_theme_first'));
            }else{
                $this->crud_model->remove_files_and_folders(APPPATH.'/views/frontend/'.$theme);
                $this->crud_model->remove_files_and_folders(FCPATH.'/assets/frontend/'.$theme);
                $this->session->set_flashdata('flash_message', $theme.' '.get_phrase('theme_removed_successfully'));
            }
            redirect(site_url('admin/theme_settings'), 'refresh');
        }

    }

    // Batches section start
    public function batches()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['selected_course_id']   = isset($_GET['course_id']) ? $_GET['course_id'] : "all";
        $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";

        $page_data['page_name']              = 'batches';
        $page_data['courses']                = $this->crud_model->get_courses();
        $page_data['page_title']             = get_phrase('active_batches');

        $page_data['batches'] =          $this->Batch_model->get_batches($page_data['selected_status'],$page_data['selected_course_id'])->result_array();

        $this->load->view('backend/index', $page_data);
    }

    public function batch_form($param1 = "", $param2 = "") {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $languagesArr = array('English', 'Hindi', 'English/Hindi (Mix)');

        if ($param1 == 'add_batch') {
            $page_data['languages']	= $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['courses'] = $this->crud_model->get_courses()->result_array();

            $page_data['instructors'] = $this->user_model->get_instructor(0)->result_array();
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['hosts'] = $this->user_model->get_host(0)->result_array();

            $page_data['page_name'] = 'batch_add';
            $page_data['page_title'] = get_phrase('add_batch');


        }elseif ($param1 == 'batch_edit') {
            $this->is_drafted_batch($param2);
            $page_data['page_name'] = 'batch_edit';
            $page_data['batch_id'] =  $param2;
            $page_data['page_title'] = get_phrase('edit_batch');
            $page_data['languages']	= $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['courses'] = $this->crud_model->get_courses()->result_array();
            $page_data['instructors'] = $this->user_model->get_instructor(0)->result_array();
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['hosts'] = $this->user_model->get_host(0)->result_array();
        }
        $this->load->view('backend/index', $page_data);
    }

    public function batch_actions($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add") {
            $batch_id = $this->Batch_model->add_batch();
            //redirect(site_url('admin/batch_form/batch_edit/'.$batch_id), 'refresh');
          //  redirect(site_url('admin/batches'), 'refresh');
	    redirect(site_url('admin/batches?view=list&batch_id='.$batch_id), 'refresh');

        }
        elseif ($param1 == "edit") {

            $this->Batch_model->update_batch($param2);

            // CHECK IF LIVE CLASS ADDON EXISTS, ADD OR UPDATE IT TO ADDON MODEL
//            if (addon_status('live-class')) {
//                $this->load->model('addons/','liveclass_model');
//                $this->liveclass_model->update_live_class($param2);
//            }

            redirect(site_url('admin/batches'), 'refresh');
        }
        elseif ($param1 == 'delete') {
            $this->is_drafted_batch($param2);

            $this->Batch_model->delete_batch($param2);
            redirect(site_url('admin/batches'), 'refresh');
        }
    }

    // Batch section end

    // Schedule section

    public function schedules()
    {

        if ($this->session->userdata('admin_login') != true)
        {
            redirect(site_url('login'), 'refresh');
        }
        $today_date = strtotime(date('D, Y-m-d'));

        $page_data['selected_batch_id']        = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
       // $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";
       // $page_data['selected_user']        = isset($_GET['user_id']) ? $_GET['user_id'] : "all";
        $page_data['selected_view']        = isset($_GET['view']) ? $_GET['view'] : "list";

        $page_data['page_name']              = 'schedules';
        //$page_data['courses']                = $this->crud_model->get_courses();
        $page_data['batches']                = $this->Batch_model->get_batches()->result_array();
        $page_data['page_title']             = get_phrase('active_schedules');
        $page_data['current_timestamp'] = time();
        $page_data['today_date'] = $today_date;
        $page_data['schedules'] =          $this->Batch_model->get_schedules('all',$page_data['selected_batch_id'],'all' );
        $page_data['instructors'] = $this->user_model->get_all_user()->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function schedule_form($param1 = "", $param2 = "", $param3 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $languagesArr = array('English', 'Hindi', 'English/Hindi (Mix)');

        if($param3 != '0' && $param3 != '-1')
        {
            $batch_schedules = $this->Batch_model->get_schedules_by_batch_id($param3)->result_array();
            $counter = 0;
            $weekday_array = array();

            foreach ($batch_schedules as $batch_schedule)
            {
                $day = date('D', $batch_schedule['start_date']);

                if (!in_array($day, $weekday_array))
                {
                    array_push($weekday_array,$day);
                }
                if($counter==7)
                {
                    break;
                }
                $counter++;
            }
        }
        // print_r($weekday_array);die;

        if ($param1 == 'add_schedule')
        {
            $batch_id = isset($_GET['batch_id']) ? $_GET['batch_id'] : "";

            $page_data['languages'] = $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['courses'] = $this->crud_model->get_courses()->result_array();
            $batch_details = $this->Batch_model->get_batches('all','all')->result_array();

            // if (empty($batch_details)){
            // $this->session->set_flashdata('error_message', get_phrase('invalid_batch_id'));
            //   redirect(site_url('admin/schedules?view=list&batch_id='.$batch_id), 'refresh');
            //}
            // $course_detail = $this->crud_model->get_course_by_id($batch_detail['course_id'])->row_array();

            //$page_data['instructors'] = $this->user_model->get_instructor()->result_array();
            $page_data['instructors'] = $this->user_model->get_all_user()->result_array();
            $page_data['page_name'] = 'schedule_add';
            $page_data['page_title'] = get_phrase('add_schedule');
            //$page_data['course_detail'] = $course_detail;
            $page_data['batch_details'] = $batch_details;
            $page_data['batch_id'] = $batch_id;
	    

        }elseif ($param1 == 'schedule_edit')
        {
            $this->is_drafted_schedule($param2);
            $schedule_detail = $this->Batch_model->get_schedule_by_id($param2)->row_array();
            $start_day = date('D', $schedule_detail['start_date']);
            if (empty($schedule_detail))
            {
                $this->session->set_flashdata('error_message', get_phrase('invalid_schedule_id'));
                redirect(site_url('admin/schedules?view=list'), 'refresh');
            }
            $batch_details = $this->Batch_model->get_batches('all','all')->result_array();
            $course_detail = $this->crud_model->get_course_by_id($schedule_detail['course_id'])->row_array();

            $page_data['page_name'] = 'schedule_edit';
            $page_data['schedule_id'] =  $param2;
            $page_data['page_title'] = get_phrase('edit_schedule');
            $page_data['languages']	= $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['courses'] = $this->crud_model->get_courses()->result_array();
            $page_data['instructors'] = $this->user_model->get_all_user()->result_array();
            $page_data['course_detail'] = $course_detail;
            $page_data['batch_details'] = $batch_details;
            $page_data['schedule_detail'] = $schedule_detail;
            $page_data['start_day'] = $start_day;
            $page_data['batch_id'] = $schedule_detail['batch_id'];

            $meeting_detail = json_decode($schedule_detail['meeting_detail'], true);
            //print_r($meeting_detail);
            if($param3 == 0)
            {
                $page_data['occurrence_id'] = 0;
            }else{
                $page_data['occurrence_id'] = $param3;
            }
            if (!empty($meeting_detail['recurrence'])){
                $recurrence = $meeting_detail['recurrence'];
                $page_data['end_date'] = date('m/d/Y',strtotime($meeting_detail['recurrence']['end_date_time']));
            }else{
                $recurrence = array();
                $page_data['end_date'] = '';
            }
            $page_data['recurrence'] = $recurrence;
	
        }
        $this->load->view('backend/index', $page_data);
       
    }

    public function schedule_actions($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add")
        {
		$batch_id = isset($_GET['batch_id']) ? $_GET['batch_id'] : "";

             $this->Batch_model->add_schedule();
            //redirect(site_url('admin/batch_form/batch_edit/'.$batch_id), 'refresh');
//            if($batch_url_id)
           //     redirect(site_url('admin/schedules?batch_id='.$batch_url_id), 'refresh');
            redirect(site_url('admin/schedules?view=list&batch_id='.$batch_id), 'refresh');
        }
        elseif ($param1 == "edit")
        {
            $batch_id = isset($_GET['batch_id']) ? $_GET['batch_id'] : "";
            $schedule_id = isset($_GET['schedule_id']) ? $_GET['schedule_id'] : "";
            $this->Batch_model->update_schedule($batch_id,$schedule_id);
            // CHECK IF LIVE CLASS ADDON EXISTS, ADD OR UPDATE IT TO ADDON MODEL
//            if (addon_status('live-class')) {
//                $this->load->model('addons/Liveclass_model','liveclass_model');
//                $this->liveclass_model->update_live_class($param2);
//            }

            redirect(site_url('admin/schedules?view=list&batch_id='.$batch_id), 'refresh');
        }
        elseif ($param1 == 'delete')
        {
            $this->is_drafted_schedule($param2);
            $this->Batch_model->delete_schedule($param2);
            redirect(site_url('admin/schedules?view=list&batch_id='.$batch_id), 'refresh');
        }
    }

    // Schedule section end

    public function courses()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['selected_category_id']   = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $page_data['selected_instructor_id'] = isset($_GET['instructor_id']) ? $_GET['instructor_id'] : "all";
        $page_data['selected_price']         = isset($_GET['price']) ? $_GET['price'] : "all";
        $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";

        // Courses query is used for deciding if there is any course or not. Check the view you will get it
        $page_data['courses']                = $this->crud_model->filter_course_for_backend($page_data['selected_category_id'], $page_data['selected_instructor_id'], $page_data['selected_price'], $page_data['selected_status']);
        $page_data['status_wise_courses']    = $this->crud_model->get_status_wise_courses();
        $page_data['instructors']            = $this->user_model->get_instructor()->result_array();
        $page_data['page_name']              = 'courses-server-side';
        $page_data['categories']             = $this->crud_model->get_categories();
        $page_data['page_title']             = get_phrase('active_courses');
        $this->load->view('backend/index', $page_data);
    }

    // This function is responsible for loading the course data from server side for datatable SILENTLY
    public function get_courses() {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $courses = array();
        // Filter portion
        $filter_data['selected_category_id']   = $this->input->post('selected_category_id');
        $filter_data['selected_instructor_id'] = $this->input->post('selected_instructor_id');
        $filter_data['selected_price']         = $this->input->post('selected_price');
        $filter_data['selected_status']        = $this->input->post('selected_status');

        // Server side processing portion
        $columns = array(
            0 => '#',
            1 => 'title',
            2 => 'category',
            3 => 'lesson_and_section',
            4 => 'enrolled_student',
            5 => 'status',
            6 => 'price',
            7 => 'actions',
            8 => 'course_id'
        );

        // Coming from databale itself. Limit is the visible number of data
        $limit = html_escape($this->input->post('length'));
        $start = html_escape($this->input->post('start'));
        $order = "";
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData = $this->lazyload->count_all_courses($filter_data);
        $totalFiltered = $totalData;

        // This block of code is handling the search event of datatable
        if(empty($this->input->post('search')['value'])) {
            $courses = $this->lazyload->courses($limit, $start, $order, $dir, $filter_data);
        }
        else {
            $search = $this->input->post('search')['value'];
            $courses =  $this->lazyload->course_search($limit, $start, $search, $order, $dir, $filter_data);
            $totalFiltered = $this->lazyload->course_search_count($search);
        }

        // Fetch the data and make it as JSON format and return it.
        $data = array();
        if(!empty($courses)) {
            foreach ($courses as $key => $row) {
                $instructor_details = $this->user_model->get_all_user($row->user_id)->row_array();
                $category_details = $this->crud_model->get_category_details_by_id($row->sub_category_id)->row_array();
                $sections = $this->crud_model->get_section('course', $row->id);
                $lessons = $this->crud_model->get_lessons('course', $row->id);
                $enroll_history = $this->crud_model->enrol_history($row->id);

                $status_badge = "badge-success-lighten";
                if ($row->status == 'pending') {
                    $status_badge = "badge-danger-lighten";
                }elseif ($row->status == 'draft') {
                    $status_badge = "badge-dark-lighten";
                }

                $price_badge = "badge-dark-lighten";
                $price = 0;
                if ($row->is_free_course == null){
                    if ($row->discount_flag == 1) {
                        $price = currency($row->discounted_price);
                    }else{
                        $price = currency($row->price);
                    }
                }elseif ($row->is_free_course == 1){
                    $price_badge = "badge-success-lighten";
                    $price = get_phrase('free');
                }

                $view_course_on_frontend_url = site_url('home/course/'.rawurlencode(slugify($row->title)).'/'.$row->id);
                $edit_this_course_url = site_url('admin/course_form/course_edit/'.$row->id);
                $section_and_lesson_url = site_url('admin/course_form/course_edit/'.$row->id);

                $course_batch_url = site_url('admin/batches?course_id='.$row->id);

                if ($row->status == 'active') {
                    $course_status_changing_message = get_phrase('mark_as_pending');
                    if ($row->user_id != $this->session->userdata('user_id')) {
                        $course_status_changing_action = "showAjaxModal('".site_url('modal/popup/mail_on_course_status_changing_modal/pending/'.$row->id.'/'.$filter_data['selected_category_id'].'/'.$filter_data['selected_instructor_id'].'/'.$filter_data['selected_price'].'/'.$filter_data['selected_status'])."', '".$course_status_changing_message."')";
                    }else{
                        $course_status_changing_action = "confirm_modal('".site_url('admin/change_course_status_for_admin/pending/'.$row->id.'/'.$filter_data['selected_category_id'].'/'.$filter_data['selected_instructor_id'].'/'.$filter_data['selected_price'].'/'.$filter_data['selected_status'])."')";
                    }
                }else{
                    $course_status_changing_message = get_phrase('mark_as_active');
                    if ($row->user_id != $this->session->userdata('user_id')) {
                        $course_status_changing_action = "showAjaxModal('".site_url('modal/popup/mail_on_course_status_changing_modal/active/'.$row->id.'/'.$filter_data['selected_category_id'].'/'.$filter_data['selected_instructor_id'].'/'.$filter_data['selected_price'].'/'.$filter_data['selected_status'])."', '".$course_status_changing_message."')";
                    }else{
                        $course_status_changing_action = "confirm_modal('".site_url('admin/change_course_status_for_admin/active/'.$row->id.'/'.$filter_data['selected_category_id'].'/'.$filter_data['selected_instructor_id'].'/'.$filter_data['selected_price'].'/'.$filter_data['selected_status'])."')";
                    }
                }

                $delete_course_url = "confirm_modal('".site_url('admin/course_actions/delete/'.$row->id)."')";

                $action = '
                <div class="dropright dropright">
                <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="'.$view_course_on_frontend_url.'" target="_blank">'.get_phrase("view_course_on_frontend").'</a></li>
                <li><a class="dropdown-item" href="'.$edit_this_course_url.'">'.get_phrase("edit_this_course").'</a></li>
                <!--li><a class="dropdown-item" href=".$section_and_lesson_url.">.get_phrase("section_and_lesson").</a></li-->
                <li><a class="dropdown-item" href="javascript::" onclick="'.$course_status_changing_action.'">'.$course_status_changing_message.'</a></li>
                <li><a class="dropdown-item" href="'.$course_batch_url.'" >'.get_phrase("course_batches").'</a></li>        
                <li><a class="dropdown-item" href="javascript::" onclick="'.$delete_course_url.'">'.get_phrase("delete").'</a></li>
                </ul>
                </div>
                ';

                $nestedData['#'] = $key+1;
                $nestedData['title'] = '<strong><a href="'.site_url('admin/course_form/course_edit/'.$row->id).'">'.$row->title.'</a></strong><br>';
                $nestedData['category'] = '<span class="badge badge-dark-lighten">'.$category_details['name'].'</span>';

                $nestedData['lesson_and_section'] = '
                <small class="text-muted"><b>'.get_phrase('total_section').'</b>: '.$sections->num_rows().'</small><br>
                <small class="text-muted"><b>'.get_phrase('total_lesson').'</b>: '.$lessons->num_rows().'</small><br>';

                $nestedData['enrolled_student'] = '<small class="text-muted"><b>'.get_phrase('total_enrolment').'</b>: '.$enroll_history->num_rows().'</small>';

                $nestedData['status'] = '<span class="badge '.$status_badge.'">'.get_phrase($row->status).'</span>';

                $nestedData['price'] = '<span class="badge '.$price_badge.'">'.$price.'</span>';

                $nestedData['actions'] = $action;

                $nestedData['course_id'] = $row->id;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function pending_courses() {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }


        $page_data['page_name'] = 'pending_courses';
        $page_data['page_title'] = get_phrase('pending_courses');
        $this->load->view('backend/index', $page_data);
    }

    public function course_actions($param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add") {
            $course_id = $this->crud_model->add_course();
            redirect(site_url('admin/courses'), 'refresh');

        }
        elseif ($param1 == "edit") {
            $this->crud_model->update_course($param2);

            // CHECK IF LIVE CLASS ADDON EXISTS, ADD OR UPDATE IT TO ADDON MODEL
            if (addon_status('live-class')) {
                $this->load->model('addons/Liveclass_model','liveclass_model');
                $this->liveclass_model->update_live_class($param2);
            }

            redirect(site_url('admin/courses'), 'refresh');
        }
        elseif ($param1 == 'delete') {
            $this->is_drafted_course($param2);
            $this->crud_model->delete_course($param2);
            redirect(site_url('admin/courses'), 'refresh');
        }
    }


    public function course_form($param1 = "", $param2 = "") {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $languagesArr = array('English', 'Hindi', 'English/Hindi (Mix)');

        if ($param1 == 'add_course') {
            $page_data['languages']	= $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $page_data['page_name'] = 'course_add';
            $page_data['page_title'] = get_phrase('add_course');
            $this->load->view('backend/index', $page_data);

        }elseif ($param1 == 'course_edit') {
            $this->is_drafted_course($param2);
            $page_data['page_name'] = 'course_edit';
            $page_data['course_id'] =  $param2;
            $page_data['page_title'] = get_phrase('edit_course');
            $page_data['languages']	= $languagesArr; // $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/index', $page_data);
        }
    }

    private function is_drafted_course($course_id){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft') {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('admin/courses'), 'refresh');
        }
    }

    private function is_drafted_batch($batch_id){

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $batch_details = $this->Batch_model->get_batch_by_id($batch_id)->row_array();

        if ($batch_details['status'] == 'draft') {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_batch'));
            redirect(site_url('admin/batches'), 'refresh');
        }
    }

    private function is_drafted_schedule($schedule_id){

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $batch_details = $this->Batch_model->get_schedule_by_id($schedule_id)->row_array();

        if ($batch_details['status'] == 'draft') {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_batch'));
            redirect(site_url('admin/batches'), 'refresh');
        }
    }

    public function change_course_status($updated_status = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $course_id = $this->input->post('course_id');
        $category_id = $this->input->post('category_id');
        $instructor_id = $this->input->post('instructor_id');
        $price = $this->input->post('price');
        $status = $this->input->post('status');
        if (isset($_POST['mail_subject']) && isset($_POST['mail_body'])) {
            $mail_subject = $this->input->post('mail_subject');
            $mail_body = $this->input->post('mail_body');
            $this->email_model->send_mail_on_course_status_changing($course_id, $mail_subject, $mail_body);
        }
        $this->crud_model->change_course_status($updated_status, $course_id);
        $this->session->set_flashdata('flash_message', get_phrase('course_status_updated'));
        redirect(site_url('admin/courses?category_id='.$category_id.'&status='.$status.'&instructor_id='.$instructor_id.'&price='.$price), 'refresh');
    }

    public function change_course_status_for_admin($updated_status = "", $course_id = "", $category_id = "", $status = "", $instructor_id = "", $price = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->change_course_status($updated_status, $course_id);
        $this->session->set_flashdata('flash_message', get_phrase('course_status_updated'));
        redirect(site_url('admin/courses?category_id='.$category_id.'&status='.$status.'&instructor_id='.$instructor_id.'&price='.$price), 'refresh');
    }

    public function sections($param1 = "", $param2 = "", $param3 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param2 == 'add') {
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_added_successfully'));
        }
        elseif ($param2 == 'edit') {
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_updated_successfully'));
        }
        elseif ($param2 == 'delete') {
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_deleted_successfully'));
        }
        redirect(site_url('admin/course_form/course_edit/'.$param1));
    }

    public function lessons($course_id = "", $param1 = "", $param2 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_added_successfully'));
            redirect('admin/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'edit') {
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_updated_successfully'));
            redirect('admin/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'delete') {
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_deleted_successfully'));
            redirect('admin/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'filter') {
            redirect('admin/lessons/'.$this->input->post('course_id'));
        }
        $page_data['page_name'] = 'lessons';
        $page_data['lessons'] = $this->crud_model->get_lessons('course', $course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_title'] = get_phrase('lessons');
        $this->load->view('backend/index', $page_data);
    }

    public function watch_video($slugified_title = "", $lesson_id = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $lesson_details          = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
        $page_data['provider']   = $lesson_details['video_type'];
        $page_data['video_url']  = $lesson_details['video_url'];
        $page_data['lesson_id']  = $lesson_id;
        $page_data['page_name']  = 'video_player';
        $page_data['page_title'] = get_phrase('video_player');
        $this->load->view('backend/index', $page_data);
    }


    // Language Functions
    public function manage_language($param1 = '', $param2 = '', $param3 = ''){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_language') {
            $language = trimmer($this->input->post('language'));
            if ($language == 'n-a') {
                $this->session->set_flashdata('error_message', get_phrase('language_name_can_not_be_empty_or_can_not_have_special_characters'));
                redirect(site_url('admin/manage_language'), 'refresh');
            }
            saveDefaultJSONFile($language);
            $this->session->set_flashdata('flash_message', get_phrase('language_added_successfully'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $new_phrase = get_phrase($this->input->post('phrase'));
            $this->session->set_flashdata('flash_message', $new_phrase.' '.get_phrase('has_been_added_successfully'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }

        if ($param1 == 'delete_language') {
            if (file_exists('application/language/'.$param2.'.json')) {
                unlink('application/language/'.$param2.'.json');
                $this->session->set_flashdata('flash_message', get_phrase('language_deleted_successfully'));
                redirect(site_url('admin/manage_language'), 'refresh');
            }
        }
        $page_data['languages']				= $this->crud_model->get_all_languages();
        $page_data['page_name']				=	'manage_language';
        $page_data['page_title']			=	get_phrase('multi_language_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function update_phrase_with_ajax() {
        $current_editing_language = $this->input->post('currentEditingLanguage');
        $updatedValue = $this->input->post('updatedValue');
        $key = $this->input->post('key');
        saveJSONFile($current_editing_language, $key, $updatedValue);
        echo $current_editing_language.' '.$key.' '.$updatedValue;
    }

    function message($param1 = 'message_home', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
            redirect(site_url('admin/message/message_read/' . $message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
            redirect(site_url('admin/message/message_read/' . $param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2; // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name']               = 'message';
        $page_data['page_title']              = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $this->user_model->change_password($param2);
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('users', array(
            'id' => $this->session->userdata('user_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function paypal_checkout_for_instructor_revenue() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['amount_to_pay']         = $this->input->post('amount_to_pay');
        $page_data['payout_id']            = $this->input->post('payout_id');
        $page_data['instructor_name']       = $this->input->post('instructor_name');
        $page_data['production_client_id']  = $this->input->post('production_client_id');

        // BEFORE, CHECK PAYOUT AMOUNTS ARE VALID
        $payout_details = $this->crud_model->get_payouts($page_data['payout_id'], 'payout')->row_array();
        if ($payout_details['amount'] == $page_data['amount_to_pay'] && $payout_details['status'] == 0) {
            $this->load->view('backend/admin/paypal_checkout_for_instructor_revenue', $page_data);
        }else{
            $this->session->set_flashdata('error_message', get_phrase('invalid_payout_data'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }

    }


    // PAYPAL CHECKOUT ACTIONS
    public function paypal_payment($payout_id = "", $paypalPaymentID = "", $paypalPaymentToken = "", $paypalPayerID = "") {
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $instructor_id = $payout_details['user_id'];
        $instructor_data = $this->db->get_where('users', array('id' => $instructor_id))->row_array();
        $paypal_keys = json_decode($instructor_data['paypal_keys'], true);
        $production_client_id = $paypal_keys[0]['production_client_id'];
        $production_secret_key = $paypal_keys[0]['production_secret_key'];
        // $production_client_id = 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R';
        // $production_secret_key = 'EFI50pO1s1cV1cySQ85wg2Pncn4VOPxKvTLBhyeGtd1QHNac-OJFsQlS7GAwlXZSg2wtm-BOJ9Ar3XJy';

        //THIS IS HOW I CHECKED THE PAYPAL PAYMENT STATUS
        $status = $this->payment_model->paypal_payment($paypalPaymentID, $paypalPaymentToken, $paypalPayerID, $production_client_id, $production_secret_key);
        if (!$status) {
            $this->session->set_flashdata('error_message', get_phrase('an_error_occurred_during_payment'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }
        $this->crud_model->update_payout_status($payout_id, 'paypal');
        $this->session->set_flashdata('flash_message', get_phrase('payout_updated_successfully'));
        redirect(site_url('admin/instructor_payout'), 'refresh');
    }

    public function stripe_checkout_for_instructor_revenue($payout_id) {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        // BEFORE, CHECK PAYOUT AMOUNTS ARE VALID
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        if ($payout_details['amount'] > 0 && $payout_details['status'] == 0) {
            $page_data['user_details']    = $this->user_model->get_user($payout_details['user_id'])->row_array();
            $page_data['amount_to_pay']   = $payout_details['amount'];
            $page_data['payout_id']       = $payout_details['id'];
            $this->load->view('backend/admin/stripe_checkout_for_instructor_revenue', $page_data);
        }else{
            $this->session->set_flashdata('error_message', get_phrase('invalid_payout_data'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }
    }

    // STRIPE CHECKOUT ACTIONS
    public function stripe_payment($payout_id = "") {
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $instructor_id = $payout_details['user_id'];
        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $response = $this->payment_model->stripe_payment($instructor_id, true);

        if ($response['payment_status'] === 'succeeded') {
            $this->crud_model->update_payout_status($payout_id, 'stripe');
            $this->session->set_flashdata('flash_message', get_phrase('payout_updated_successfully'));
        }else{
            $this->session->set_flashdata('error_message', $response['status_msg']);
        }

        redirect(site_url('admin/instructor_payout'), 'refresh');
    }

    public function preview($course_id = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $this->is_drafted_course($course_id);
        if ($course_id > 0) {
            $courses = $this->crud_model->get_course_by_id($course_id);
            if ($courses->num_rows() > 0) {
                $course_details = $courses->row_array();
                redirect(site_url('home/lesson/'.rawurlencode(slugify($course_details['title'])).'/'.$course_details['id']), 'refresh');
            }
        }
        redirect(site_url('admin/courses'), 'refresh');
    }

    // Manage Quizes
    public function quizes($course_id = "", $action = "", $quiz_id = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_added_successfully'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_section($course_id, $quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_deleted_successfully'));
        }
        redirect(site_url('admin/course_form/course_edit/'.$course_id));
    }

    // Manage Quize Questions
    public function quiz_questions($quiz_id = "", $action = "", $question_id = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();

        if ($action == 'add') {
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        }

        elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        }

        elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
            redirect(site_url('admin/course_form/course_edit/'.$quiz_details['course_id']));
        }
    }

    // software about page
    function about() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['application_details'] = $this->crud_model->get_application_details();
        $page_data['page_name']  = 'about';
        $page_data['page_title'] = get_phrase('about');
        $this->load->view('backend/index', $page_data);
    }

    public function install_theme($theme_to_install = '')
    {

        if ($this->session->userdata('admin_login') != 1){
            redirect(site_url('login'), 'refresh');
        }

        $uninstalled_themes = $this->crud_model->get_uninstalled_themes();
        if (!in_array($theme_to_install, $uninstalled_themes)) {
            $this->session->set_flashdata('error_message', get_phrase('this_theme_is_not_available'));
            redirect(site_url('admin/theme_settings'));
        }

        $zipped_file_name = $theme_to_install;
        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        // Create update directory.
        $views_directory  = 'application/views/frontend';
        $assets_directory = 'assets/frontend';

        //Unzip theme zip file and remove zip file.
        $theme_path = 'themes/'.$zipped_file_name;
        $theme_zip = new ZipArchive;
        $theme_result = $theme_zip->open($theme_path);
        if ($theme_result === TRUE) {
            $theme_zip->extractTo('themes');
            $theme_zip->close();
        }

        // unzip the views zip file to the application>views folder
        $views_path = 'themes/'.$unzipped_file_name.'/views/'.$zipped_file_name;
        $views_zip = new ZipArchive;
        $views_result = $views_zip->open($views_path);
        if ($views_result === TRUE) {
            $views_zip->extractTo($views_directory);
            $views_zip->close();
        }

        // unzip the assets zip file to the assets/frontend folder
        $assets_path = 'themes/'.$unzipped_file_name.'/assets/'.$zipped_file_name;
        $assets_zip = new ZipArchive;
        $assets_result = $assets_zip->open($assets_path);
        if ($assets_result === TRUE) {
            $assets_zip->extractTo($assets_directory);
            $assets_zip->close();
        }

        unlink($theme_path);
        $this->crud_model->remove_files_and_folders('themes/'.$unzipped_file_name);
        $this->session->set_flashdata('flash_message', get_phrase('theme_imported_successfully'));
        redirect(site_url('admin/theme_settings'));
    }

    //ADDON MANAGER PORTION STARTS HERE
    public function addon($param1 = "", $param2 = "", $param3 = "") {
        if ($this->session->userdata('admin_login') != 1){
            redirect(site_url('login'), 'refresh');
        }
        // ADD NEW ADDON FORM
        if ($param1 == 'add') {

            $page_data['page_name'] = 'addon_add';
            $page_data['page_title'] = get_phrase('add_addon');
        }

        // INSTALLING AN ADDON
        if ($param1 == 'install') {
            $this->addon_model->install_addon();
        }

        // ACTIVATING AN ADDON
        if ($param1 == 'activate') {
            $update_message = $this->addon_model->addon_activate($param2);
            $this->session->set_flashdata('flash_message', get_phrase($update_message));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // DEACTIVATING AN ADDON
        if ($param1 == 'deactivate') {
            $update_message = $this->addon_model->addon_deactivate($param2);
            $this->session->set_flashdata('flash_message', get_phrase($update_message));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // REMOVING AN ADDON
        if ($param1 == 'delete') {
            $this->addon_model->addon_delete($param2);
            $this->session->set_flashdata('flash_message', get_phrase('addon_is_deleted_successfully'));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // SHOWING LIST OF INSTALLED ADDONS
        if (empty($param1)) {
            $page_data['page_name'] = 'addons';
            $page_data['addons'] = $this->addon_model->addon_list()->result_array();
            $page_data['page_title'] = get_phrase('addon_manager');
        }
        $this->load->view('backend/index', $page_data);
    }

    //AVAILABLE_ADDONS
    public function available_addons(){
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['page_name']  = 'available_addon';
        $page_data['page_title'] = get_phrase('available_addon');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_application($param1 = "", $param2 = ""){ // param1 is the status and param2 is the application id
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'approve' || $param1 == 'delete') {
            $this->user_model->update_status_of_application($param1, $param2);
        }
        $page_data['page_name']  = 'application_list';
        $page_data['page_title'] = get_phrase('instructor_application');
        $page_data['approved_applications'] = $this->user_model->get_approved_applications();
        $page_data['pending_applications'] = $this->user_model->get_pending_applications();
        $this->load->view('backend/index', $page_data);
    }


    // INSTRUCTOR PAYOUT SECTION
    public function instructor_payout($param1 = "") {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 != "") {
            $date_range                   = $this->input->get('date_range');
            $date_range                   = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0]);
            $page_data['timestamp_end']   = strtotime($date_range[1]);
        }else {
            $page_data['timestamp_start'] = strtotime(date('m/01/Y'));
            $page_data['timestamp_end']   = strtotime(date('m/t/Y'));
        }

        $page_data['page_name']  = 'instructor_payout';
        $page_data['page_title'] = get_phrase('instructor_payout');
        $page_data['completed_payouts'] = $this->crud_model->get_completed_payouts_by_date_range($page_data['timestamp_start'], $page_data['timestamp_end']);
        $page_data['pending_payouts'] = $this->crud_model->get_pending_payouts();
        $this->load->view('backend/index', $page_data);
    }




    // AJAX PORTION
    // this function is responsible for managing multiple choice question
    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/admin/manage_multiple_choices_options', $page_data);
    }

    public function ajax_get_sub_category($category_id) {
        $page_data['sub_categories'] = $this->crud_model->get_sub_categories($category_id);

        return $this->load->view('backend/admin/ajax_get_sub_category', $page_data);
    }

    public function ajax_get_section($course_id){
        $page_data['sections'] = $this->crud_model->get_section('course', $course_id)->result_array();
        return $this->load->view('backend/admin/ajax_get_section', $page_data);
    }

    public function ajax_get_video_details() {
        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }
    public function ajax_sort_section() {
        $section_json = $this->input->post('itemJSON');
        $this->crud_model->sort_section($section_json);
    }
    public function ajax_sort_lesson() {
        $lesson_json = $this->input->post('itemJSON');
        $this->crud_model->sort_lesson($lesson_json);
    }
    public function ajax_sort_question() {
        $question_json = $this->input->post('itemJSON');
        $this->crud_model->sort_question($question_json);
    }

    public function student_courses_edit($payment_id="")
    {
        $page_data['page_name'] = 'student_courses_edit';
        $payments = $this->Batch_model->get_course_payment_details($payment_id)->result_array();

        $course_detail = '';
        $batch_detail = '';
        $payment_detail = '';

        foreach ($payments as $payment)
        {
            $payment_detail = $payment;
        }

        $batch_details = $this->Batch_model->get_batch_by_id($payment_detail['batch_id'])->result_array();

        foreach ($batch_details as $batch)
        {
            $batch_detail = $batch;
        }

        $course_details = $this->crud_model->get_course_by_userid($payment_detail['course_id'])->result_array();

        foreach ($course_details as $course)
        {
            $course_detail = $course;
        }

        $page_data['payment_detail'] = $payment_detail;
        $page_data['batch_detail'] = $batch_detail;
        $page_data['course_detail'] = $course_detail;

        $this->load->view('backend/index', $page_data);
    }

    public function student_courses_update($payment_id="",$user_id="")
    {
        $start_date = $this->input->post('$start_date');
        $schedule_expiry_date = $this->input->post('$schedule_expiry_date');
        $schedule_last_date = $this->input->post('$schedule_last_date');
        $unpaid_schedule_date = $this->input->post('$unpaid_schedule_date');

        $this->Batch_model->student_courses_update($payment_id,$start_date,$schedule_expiry_date,$schedule_last_date,$unpaid_schedule_date);

        $page_data['page_name'] = 'student_courses';
        $page_data['user_id'] = $user_id;
        $page_data['page_title'] = get_phrase('student_courses');

        $this->load->view('backend/index', $page_data);
    }

    public function attendance($schedule_id="")
    {
        $schedule_id = $this->input->get('schedule_id');

        $schedules = $this->Batch_model->get_schedule_by_id($schedule_id)->result_array();

        $user_id = $this->session->userdata('user_id');


        // $response = $this->Batch_model->attendance($schedule_id,$user_id);

        $url='';
        foreach ($schedules as $key => $schedule)
        {
            $schdetails = json_decode($schedule['meeting_detail'], true);
            $url = $schdetails['start_url'];

        }

        print "<script>window.location.href = '".$url."'</script>";

    }

    public function offline_payment()
    {
        $page_data['batch_id'] = $_GET['batch_id'];

        $page_data['courses'] = $this->crud_model->get_courses(0,0,0)->result_array();

        $page_data['users'] = $this->user_model->get_user(0)->result_array();
        $payment_types = array('Paytm A','Paytm B','cash M','Axis bank','cash B');

        $page_data['payment_types']  = $payment_types;

        $page_data['page_name']  = 'offline_payment';
        $page_data['page_title'] = get_phrase('offline_payment');

        $this->load->view('backend/index', $page_data);

    }

    public function make_offline_payment()
    {

        $data['user_id'] = $this->input->post('student_id');
        $data['payment_type'] = $this->input->post('payment_type');
        $data['course_id'] = $this->input->post('course_id');
        $data['amount'] = $this->input->post('amount');
        $data['number_of_sessions'] = $this->input->post('number_of_sessions');
        $data['date_added']  = strtotime($this->input->post('schedule_start_date'));

        $data['batch_id'] = $_GET['batch_id'];

        $data['first_name'] = $this->input->post('first_name');
        $data['email_id'] = $this->input->post('email_id');
        $data['phone_no'] = $this->input->post('mobile_number');
        $data['schedule_expiry_date'] = strtotime($this->input->post('schedule_expiry_date'));
        $data['schedule_last_date'] = strtotime($this->input->post('schedule_last_date'));

        $response = $this->payment_model->payumoney_payment($data);

        redirect(site_url('admin/batches'), 'refresh');
    }

    public function student_course_attendance($user_id="",$payment_id="")
    {
        $page_data['page_name'] = "student_course_attendance";
        $page_data['page_title'] = site_phrase('student_course_attendance');

//        $page_data['user_id'] =  $_GET['user_id'];
//        $page_data['payment_id'] = $_GET['payment_id'];

        $user_id = $this->input->get('user_id');

        $payment_id = $this->input->get('payment_id');

        $payments = $this->crud_model->get_payment_by_batch_id($user_id,$payment_id);

        $page_data['payments'] = $payments;


        $this->load->view('backend/index', $page_data);
    }

    public function mark_attendance($user_id="",$payment_id="")
    {
        $page_data['page_name'] = "mark_attendance";
        $page_data['page_title'] = site_phrase('mark_attendance');

        $user_id = $this->input->get('user_id');

        $payment_id = $this->input->get('payment_id');

        $payments = $this->crud_model->get_payment_by_batch_id($user_id,$payment_id);

        foreach ($payments as $payment)
        {
                $schedules = $this->Batch_model->get_schedules_by_batch_id($payment['batch_id'])->result_array();
                $page_data['schedules'] = $schedules;
            
        }
        $page_data['user_id'] = $user_id;
        $page_data['payment_id'] = $payment_id;

        $this->load->view('backend/index', $page_data);
    }

    public function mark_student_attendance($user_id="",$schedule_id="",$status="",$payment_id="")
    {
        $schedule_id = $this->input->get('schedule_id');
        $user_id = $this->input->get('user_id');
        $payment_id = $this->input->get('payment_id');
        $status = $this->input->get('status');
        $schedules = $this->Batch_model->get_schedule_by_id($schedule_id)->result_array();

        $page_data['page_name'] = "mark_attendance";

        $page_data['page_title'] = site_phrase('mark_attendance');

      
        $page_data['page_name'] = "mark_attendance";
        $page_data['page_title'] = site_phrase('mark_attendance');

        $page_data['user_id'] = $user_id;
        $payments = $this->crud_model->get_payment_by_batch_id($user_id,$payment_id);


        foreach ($payments as $payment)
        {
           
           
                $schedules = $this->Batch_model->get_schedules_by_batch_id($payment['batch_id'])->result_array();

                if($status==1)
                {
                    $today_date = strtotime(date('D, d-M-Y'));
                    $response = $this->Batch_model->attendance($schedule_id,$user_id,$today_date,$payment['batch_id']);
                }

                $page_data['schedules'] = $schedules;
            
        }
        $page_data['payment_id'] = $payment_id;
        $this->load->view('backend/index', $page_data);
    }


   public function admin_revenue_csv()
   {
       $today_date = date('m/d/y');

        $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
        $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :   $today_date;

        $page_data['selected_student_id']   = isset($_GET['student_id']) ? $_GET['student_id'] : "all";
        $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
    
        $page_data['page_name'] = 'admin_revenue';
        $page_data['users'] = $this->user_model->get_all_user()->result_array();
        $page_data['batches']                = $this->Batch_model->get_batches()->result_array();

        $payment_history = $this->Batch_model->admin_revenue_report($page_data['selected_student_id'],$page_data['selected_batch_id'] ,$start_date,$end_date);
        $page_data['page_name'] = 'admin_revenue';

        $page_data['page_title'] = get_phrase('admin_revenue');

    
        $file_name = 'admin_revenue_report_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$file_name"); 
        header("Content-Type: application/csv;");

     
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("Student Name","Enrolled Batch","Enrolled Course","Total Amount","Enrolment Date","Expiry Date"); 
        fputcsv($file, $header);
        foreach ($payment_history as $value)
        { 
           fputcsv($file, $value); 
        }
        fclose($file); 
        exit; 
   }


   public function student_attendance_csv()
   {
            $today_date = date('m/d/y');

       	    $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :   $today_date;

            $page_data['selected_student_id']   = isset($_GET['student_id']) ? $_GET['student_id'] : "all";
            $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
    
            $page_data['page_name'] = 'student_attendance_report';
           	   
            $page_data['page_title'] = get_phrase('student_attendance_report');
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['batches']                = $this->Batch_model->get_batches()->result_array();
            
            $student_attendances = $this->Batch_model->student_attendance_report($page_data['selected_student_id'],$page_data['selected_batch_id'],$page_data['start_date'],$page_data['end_date'] );
           
            $file_name = 'student_attendance_report_'.date('Ymd').'.csv'; 
            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$file_name"); 
            header("Content-Type: application/csv;");
   
             
     		// file creation 
     		$file = fopen('php://output', 'w');
 
     		$header = array("Student Name","Enrolled Batch","Enrolled Course","Enrolment Date","Expiry Date"); 
     		fputcsv($file, $header);
     		foreach ($student_attendances as $value)
     		{ 
      			 fputcsv($file, $value); 
    		 }
    		 fclose($file); 
     		exit; 
     }

    public function student_attendance_report($param1 = "") {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == "filter") {
        //   $start_date                   = strtotime($this->input->get('start_date'));
            //$end_date                   = strtotime($this->input->get('end_date'));


            $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);
                       
            $page_data['selected_student_id']   = isset($_GET['student_id']) ? $_GET['student_id'] : "all";
            $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
		
	        $page_data['student_attendances'] = $this->Batch_model->student_attendance_report($page_data['selected_student_id'],$page_data['selected_batch_id'] ,$page_data['start_date'],$page_data['end_date']);
            $page_data['page_name'] = 'student_attendance_report';
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['batches']                = $this->Batch_model->get_batches()->result_array();


            $page_data['page_title'] = get_phrase('student_attendance_report');


        }else
         {
            $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            
            
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['batches']                = $this->Batch_model->get_batches()->result_array();
            
            $page_data['page_name'] = 'student_attendance_report';
            $page_data['student_attendances'] = $this->Batch_model->student_attendance_report('all','all',-1,-1);
            $page_data['page_title'] = get_phrase('student_attendance_report');
        }

        $this->load->view('backend/index', $page_data);
    }

    public function admin_revenue($param1 = "")
     {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        
        if ($param1 == "filter") 
        {
            $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);

                     
            $page_data['selected_student_id']   = isset($_GET['student_id']) ? $_GET['student_id'] : "all";
            $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
		
	    $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['batches']                = $this->Batch_model->get_batches()->result_array();

            $page_data['payment_history'] = $this->Batch_model->admin_revenue_report($page_data['selected_student_id'],$page_data['selected_batch_id'] ,$page_data['start_date'],$page_data['end_date']);
            $page_data['page_name'] = 'admin_revenue';

            $page_data['page_title'] = get_phrase('admin_revenue');


        }
        else
        {

            $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);
            
            $page_data['users'] = $this->user_model->get_all_user()->result_array();
            $page_data['batches']                = $this->Batch_model->get_batches()->result_array();
            $page_data['page_name'] = 'admin_revenue';
            $page_data['payment_history'] = $this->Batch_model->admin_revenue_report('all','all',-1,-1);
            $page_data['page_title'] = get_phrase('admin_revenue');
        }

        $this->load->view('backend/index', $page_data);
    }


    public function batch_schedule_report($param1 = "") 
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        
        if ($param1 == "filter") {
           $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);
            
            $page_data['selected_course_id']   = isset($_GET['course_id']) ? $_GET['course_id'] : "all";
            $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
            $page_data['courses']                = $this->crud_model->get_courses();
            $page_data['batches']  =              $this->Batch_model->get_batches()->result_array();

            $page_data['batch_schedules'] = $this->Batch_model->batch_schedule_report($page_data['selected_course_id'],$page_data['selected_batch_id'] ,$page_data['start_date'],$page_data['end_date']);
            $page_data['page_name'] = 'batch_schedule_report';

            $page_data['page_title'] = get_phrase('batch_schedule_report');


        }
        else
         {
            $today_date = date('m/d/y');
            $page_data['start_date']   = isset($_GET['start_date']) ? $_GET['start_date'] : "1/01/2020";
            $page_data['end_date']   = isset($_GET['end_date']) ? $_GET['end_date'] :  $today_date;
            $page_data['start_date'] = strtotime($page_data['start_date']);
            $page_data['end_date'] = strtotime($page_data['end_date']);

            $page_data['courses']                = $this->crud_model->get_courses();
            $page_data['batches']  =              $this->Batch_model->get_batches()->result_array();
            $page_data['page_name'] = 'batch_schedule_report';
            $page_data['batch_schedules'] = $this->Batch_model->batch_schedule_report('all','all',-1,-1);
            $page_data['page_title'] = get_phrase('batch_schedule_report');
        }

        $this->load->view('backend/index', $page_data);
    }
    
    public function batch_schedule_csv() 
    {
        $start_date                   = $this->input->get('start_date');
        $end_date                   = $this->input->get('end_date');
        $page_data['selected_course_id']   = isset($_GET['course_id']) ? $_GET['course_id'] : "all";
        $page_data['selected_batch_id']   = isset($_GET['batch_id']) ? $_GET['batch_id'] : "all";
        $page_data['page_name'] = 'batch_schedule_report';

        $page_data['page_title'] = get_phrase('batch_schedule_report');

        
        $batch_schedules = $this->Batch_model->batch_schedule_report($page_data['selected_course_id'],$page_data['selected_batch_id'],$start_date,$end_date);
       
        $file_name = 'batch_schedule_report_'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$file_name"); 
        header("Content-Type: application/csv;");

         
        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array("Schedule Title","Batch","Course","Start Date","Start Time","Join URL"); 
        fputcsv($file, $header);
        foreach ($batch_schedules as $value)
        { 
            fputcsv($file, $value); 
        }
        fclose($file); 
        exit; 
        

    }
}
