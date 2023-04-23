<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->load->model('Zoom_model');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function get_batches($param1='', $param2='')
    {
        if($param1!='' && $param1!='all')
        {
            $this->db->where('status',$param1);
        }
        if($param2!='' && $param2!='all'){
            $this->db->where('course_id',$param2);
        }

        return $this->db->get('batches');
    }

    public function add_schedule($param1 = "")
    {

        $batch_detail = $this->get_course_by_Batchid($this->input->post('batch_id'))->row_array();

        if($this->is_already_engaged( $this->input->post('host_id') ,$this->input->post('start_date') , $this->input->post('start_time') ) ){
            $this->session->set_flashdata('error_message', get_phrase('User is already engaged at selected date and time'));
            return ;
        }

        //create meeting code

        $recurence_type= $this->input->post('recurence_type');
        if($recurence_type==1){
            $date_arr=array(1,2,3,4,5,6,7);
        }
        else{
            $date_arr=$this->input->post('weekday');
        }


        $start_date_time= strtotime($this->input->post('start_date'));
        $end_date_time= strtotime($this->input->post('end_date'));
        $start_date= date('Y-m-d',$start_date_time );
        $end_date= date('Y-m-d',$end_date_time);

        $start_time_time= strtotime($this->input->post('start_time'));
        $his= date('H:i:s',$start_time_time);
        $start_time = strtotime("1970-01-01 $his UTC");

        $begin = new DateTime( $start_date );
        $end   = new DateTime( $end_date);
        //$dis=array();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $date_val=  $i->format("Y-m-d");
            $check_day= date('N', strtotime($date_val)  );

            if(  in_array($check_day, $date_arr ) ){

                //create meeting
                $data1=array();
                $data1['title'] = html_escape($this->input->post('title'));
                $data1['start_date'] = strtotime($date_val)+ $start_time;
                $data1['start_time'] =strtotime($date_val)+ $start_time;
                $data1['duration'] = $this->input->post('duration');
                $data1['timezone'] = $this->input->post('time_zone');
                $data1['meeting_id'] =$this->input->post('meeting_id');
                $data1['status'] = 'confirmed';
                $data1['password'] = $this->input->post('password');
                $data1['join_url'] = $this->input->post('join_url');
                $data1['host_id'] = $this->input->post('host_id');
                $data1['batch_id'] = $this->input->post('batch_id');
                $data1['course_id'] = $batch_detail['course_id'];
                $data1['created_at'] = strtotime(date('D, d-M-Y'));
                $data1['updated_at'] = strtotime(date('D, d-M-Y'));

                $json= array();
                $json['start_url']=$this->input->post('join_url');
                $json['join_url']=$this->input->post('join_url');
                $json['password']=$this->input->post('password');
                $json['timezone']=$this->input->post('time_zone');
                $data1['meeting_detail'] =json_encode($json);

                //$dis[]= $data1;
                $this->db->insert('batch_schedules', $data1);
               // echo $this->db->last_query();die;
            }
        }

        //echo '<pre>'; print_r($dis);echo '<pre>'; print_r($this->input->post()); die;

        $this->session->set_flashdata('flash_message', get_phrase('schedule_has_been_added_successfully'));
        return ;
    }


    /*
       public function add_schedule($param1 = "")
    {

        $data = array();
        $data['title'] = html_escape($this->input->post('title'));
        $data['start_date'] = strtotime($this->input->post('start_date'));
        $data['start_time'] = strtotime($this->input->post('start_time'));
        $data['duration'] = $this->input->post('duration');
        $data['timezone'] = $this->input->post('time_zone');
        $data['recurring'] = $this->input->post('recurring');
        $data['recurence_type'] = $this->input->post('recurence_type');
        // $data['occurs_on'] = $this->input->post('occurs_on');

        $weekdaymon = $this->input->post('weekday-mon');
        $weekdaytue = $this->input->post('weekday-tue');
        $weekdaywed = $this->input->post('weekday-wed');
        $weekdaythu = $this->input->post('weekday-thu');
        $weekdayfri = $this->input->post('weekday-fri');
        $weekdaysat = $this->input->post('weekday-sat');
        $weekdaysun = $this->input->post('weekday-sun');

        $weekday_array = array();

        if($weekdaymon=='on')
        {
            array_push($weekday_array,2);
        }

        if($weekdaytue=='on')
        {
            array_push($weekday_array,3);
        }

        if($weekdaywed=='on')
        {
            array_push($weekday_array,4);
        }

        if($weekdaythu=='on')
        {
            array_push($weekday_array,5);
        }

        if($weekdayfri=='on')
        {
            array_push($weekday_array,6);
        }

        if($weekdaysat=='on')
        {
            array_push($weekday_array,7);
        }

        if($weekdaysun=='on')
        {
            array_push($weekday_array,1);
        }

        $data['weekday_array'] = $weekday_array;

        $data['end_date'] = strtotime($this->input->post('end_date'));
        //$data['end_date'] = $this->input->post('end_date');
        $data['password'] = $this->input->post('password');
        $data['course_id'] = $this->input->post('course_id');
        $data['host_id'] = $this->input->post('host_id');
        $data['alternative_hosts'] = $this->input->post('alternative_hosts');
        $data['batch_id'] = $this->input->post('batch_id');
        $data['created_at'] = strtotime(date('D, d-M-Y'));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));

        // check if any meeting exists for the user at same date and time

        if($this->is_already_engaged($data['host_id'],$data['start_date'],$data['start_time']))
        {
            $this->session->set_flashdata('error_message', get_phrase('User is already engaged at selected date and time'));
            return ;
        }

        $userDetail = $this->user_model->get_all_user($data['host_id'])->row_array();

        $meeting = $this->Zoom_model->createMeeting($data, $userDetail['email']);

        foreach ($meeting->meetings as $meeting_detail)
        {
            print_r($meeting_detail);
            print '-------------------------------------------------------------------------------------';
            $data2 = array();
            $data2['uuid'] = $meeting_detail->uuid;
            $data2['id'] = $meeting_detail->id;
            $data2['host_id'] = $meeting_detail->host_id;
            $data2['topic'] = $meeting_detail->topic;

            //Meeting Type :
            // 1 : Instant Meeting
            // 2 : Scheduled Meeting
            // 3 : Recurring Meeting with no fixed time
            // 8 : Recurring Meeting with fixed time

            $data2['recurring_type'] = $meeting_detail->type;
            $data2['start_time'] = $meeting_detail->start_time;
            $data2['duration'] = $meeting_detail->duration;
            $data2['timezone'] = $meeting_detail->timezone;
            $data2['agenda'] = $meeting_detail->agenda;
            $data2['created_at'] =  $meeting_detail->created_at;
            $data2['join_url'] = $meeting_detail->join_url;


           // print_r($meeting_detail);die;

//            [uuid] => koqLdkM6SXyzSMhouEuj7w==
//        [id] => 82041065359
//            [host_id] => R-ug5SdHTX2UuP-nQiG_9g
//        [topic] => Chess Class - Advanced I
//        [type] => 8
//            [start_time] => 2020-12-25T10:15:00Z
//        [duration] => 60
//            [timezone] => Asia/Calcutta
//        [agenda] => Friday - 3:45pm to 4:45pm Sunday - 4:45pm to 5:45pm
//        [created_at] => 2020-11-06T09:41:14Z
//        [join_url] => https://us02web.zoom.us/j/82041065359?pwd=ajhpODVReGVtZjJKVnVCczlnR2I0QT09 )
        }

        if($meeting->message && $meeting->message!='')
        {
            $this->session->set_flashdata('error_message', $meeting->message);
            return;
        }else{
            if($data['recurring'] == 'on')
            {
                foreach ($meeting->occurrences as $occurrence)
                {
                    $data1['title'] = html_escape($this->input->post('title'));
                    $data1['start_date'] = strtotime($occurrence->start_time);
                    $data1['start_time'] = $data['start_time'];
                    $data1['duration'] = $this->input->post('duration');
                    $data1['meeting_id'] = $meeting->id;
                    $data1['occurrence_id'] = $occurrence->occurrence_id;
                    $data1['password'] = $meeting->password;
                    $data1['status'] = $meeting->status;
                    $data1['meeting_detail'] = json_encode($meeting);
                    $data1['password'] = $this->input->post('password');
                    $data1['host_id'] = $this->input->post('host_id');
                    $data1['batch_id'] = $this->input->post('batch_id');
                    $data1['created_at'] = strtotime(date('D, d-M-Y'));
                    $data1['updated_at'] = strtotime(date('D, d-M-Y'));
                    $batch_detail = $this->get_course_by_Batchid($data1['batch_id'])->row_array();
                    $data1['course_id'] = $batch_detail['course_id'];
                    $this->db->insert('batch_schedules', $data1);
                }
            }else {

                $data1['title'] = html_escape($this->input->post('title'));
                $data1['start_date'] = $data['start_date'];
                $data1['start_time'] = $data['start_time'];
                $data1['duration'] = $this->input->post('duration');
                $data1['meeting_id'] = $meeting->id;
                $data1['password'] = $meeting->password;
                $data1['status'] = $meeting->status;
                $data1['meeting_detail'] = json_encode($meeting);
                $data1['password'] = $this->input->post('password');
                $data1['host_id'] = $this->input->post('host_id');
                $data1['batch_id'] = $this->input->post('batch_id');
                $data1['created_at'] = strtotime(date('D, d-M-Y'));
                $data1['updated_at'] = strtotime(date('D, d-M-Y'));
                $batch_detail = $this->get_course_by_Batchid($data1['batch_id'])->row_array();
                $data1['course_id'] = $batch_detail['course_id'];
                $this->db->insert('batch_schedules', $data1);
            }
            $this->session->set_flashdata('flash_message', get_phrase('schedule_has_been_added_successfully'));
            return ;
        }
    }
    */

    public function add_batch($param1 = "")
    {
        $data['title'] = html_escape($this->input->post('title'));
        $data['description'] = $this->input->post('description');
        $data['hours'] = $this->input->post('hours');
        $data['max_strength'] = $this->input->post('max_strength');
        $data['min_age'] = $this->input->post('min_age');
        $data['max_age'] = $this->input->post('max_age');
        $data['course_id'] = $this->input->post('course_id');
        $data['host_id'] = $this->input->post('host_id');
        $data['instructor_id'] = $this->input->post('instructor_id');
        $data['start_date'] = strtotime($this->input->post('start_date'));
        $data['created_at'] = strtotime(date('D, d-M-Y'));
        $data['total_number_of_sessions'] = $this->input->post('total_number_of_sessions');

        //$data['language'] = $this->input->post('language_made_in');

        if ($param1 == "save_to_draft") {
            $data['status'] = 'draft';
        } else {
            if ($this->session->userdata('admin_login')) {
                $data['status'] = 'active';
            } else {
                $data['status'] = 'pending';
            }
        }

        $data['batch_price'] = $this->input->post('batch_price');
        $data['discount_flag'] = $this->input->post('discount_flag');
        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['is_free_batch'] = $this->input->post('is_free_batch');
        $data['number_of_sessions'] = $this->input->post('number_of_sessions');

        $this->db->insert('batches', $data);
        $batch_id = $this->db->insert_id();

        if ($data['status'] == 'active') {
            $this->session->set_flashdata('flash_message', get_phrase('batch_added_successfully'));
        } elseif ($data['status'] == 'pending') {
            $this->session->set_flashdata('flash_message', get_phrase('batch_added_successfully') . '. ' . get_phrase('please_wait_untill_Admin_approves_it'));
        } elseif ($data['status'] == 'draft') {
            $this->session->set_flashdata('flash_message', get_phrase('your_batch_has_been_added_to_draft'));
        }

        $this->session->set_flashdata('flash_message', get_phrase('batch_has_been_added_successfully'));
        return $batch_id;
    }

    public function update_batch($batch_id, $type = "")
    {
        $batch_details = $this->get_batch_by_id($batch_id)->row_array();
        $data['title'] = html_escape($this->input->post('title'));
        $data['description'] = $this->input->post('description');
        $data['hours'] = $this->input->post('hours');
        $data['max_strength'] = $this->input->post('max_strength');
        $data['min_age'] = $this->input->post('min_age');
        $data['max_age'] = $this->input->post('max_age');
        $data['course_id'] = $this->input->post('course_id');
        $data['host_id'] = $this->input->post('host_id');
        $data['instructor_id'] = $this->input->post('instructor_id');
        $data['start_date'] = strtotime($this->input->post('start_date'));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $data['total_number_of_sessions'] = $this->input->post('total_number_of_sessions');

        if ($type == "save_to_draft") {
            $data['status'] = 'draft';
        } else {
            if ($this->session->userdata('admin_login')) {
                $data['status'] = $this->input->post('status');
            } else {
                $data['status'] = $this->input->post('status');
            }
        }
        $data['number_of_sessions'] = $this->input->post('number_of_sessions');
        $data['batch_price'] = $this->input->post('batch_price');
        $data['discount_flag'] = $this->input->post('discount_flag');
        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['is_free_batch'] = $this->input->post('is_free_batch');

        $this->db->where('id', $batch_id);
        $this->db->update('batches', $data);

        if ($data['status'] == 'active') {
            $this->session->set_flashdata('flash_message', get_phrase('batch_updated_successfully'));
        } elseif ($data['status'] == 'pending') {
            $this->session->set_flashdata('flash_message', get_phrase('batch_updated_successfully') . '. ' . get_phrase('please_wait_untill_Admin_approves_it'));
        } elseif ($data['status'] == 'draft') {
            $this->session->set_flashdata('flash_message', get_phrase('your_batch_has_been_added_to_draft'));
        }
    }

    public function get_schedules_by_batch_id($batch_id='')
    {
        return $this->db->get_where('batch_schedules', array('batch_id' => $batch_id));
    }

    public function delete_batch($batch_id)
    {
        $this->db->where('id', $batch_id);
        $this->db->delete('batches');

        // DELETE ALL THE BATCH_SCHEDULES OF THIS BATCH FROM BATCH_SCHEDULES TABLE
        $batch_schedules = array('batch_id' => $batch_id);
        $this->db->delete('batch_schedules', $batch_schedules);

        // DELETE ALL THE ENROL OF THIS BATCH FROM ENROL TABLE
        $enrol = array('batch_id' => $batch_id);
        $this->db->delete('enrol', $enrol);

        $this->session->set_flashdata('flash_message', get_phrase('Batch has been deleted successfully.'));
    }

    public function get_batch_by_id($batch_id = "")
    {
        return $this->db->get_where('batches', array('id' => $batch_id));
    }

    public function get_schedule_by_batch_id($batch_id="", $today_date="")
    {
	 $this->db->where('batch_id',$batch_id);
	 $this->db->where('start_date',$today_date);
	return $this->db->get('batch_schedules')->result_array();
    }

    public function get_student_batch_by_userid($user_id = "")
    {
        return $this->db->get_where('payment', array('user_id' => $user_id));
    }

    public function get_course_payment_details($payment_id = "")
    {
        return $this->db->get_where('payment', array('id' => $payment_id));
    }

    public function get_schedules($param1='', $param2='', $param3='' , $param4='')
    {
        if($param1!='' && $param1!='all')
        {
            $this->db->where('status',$param1);
        }
        if($param2!='' && $param2!='all')
        {
            $this->db->where('batch_id',$param2);
        }
        if($param3!='' && $param3!='all')
        {
            $this->db->where('host_id',$param3);
        }
        if($param4!='')
        {
            $this->db->where('start_date>=',$param4);
        }

        return $this->db->get('batch_schedules')->result_array();
    }

    public function get_schedule_by_id($schedule_id = "")
    {
        return $this->db->get_where('batch_schedules', array('id' => $schedule_id));
    }

    public function attendance($schedule_id = "",$user_id = "",$today_date = "",$batch_id = "")
    {
	$this->db->where('schedule_id',$schedule_id);
	$this->db->where('user_id',$user_id);
	$this->db->where('batch_id>=',$batch_id);
	$this->db->where('meeting_date>=',$today_date);
	
        $this->db->delete('student_attendance');

        $data = array();
        $data['schedule_id'] = $schedule_id;
        $data['user_id'] = $user_id;
        $data['batch_id'] = $batch_id;
        $data['meeting_date'] = $today_date;

        $this->db->insert('student_attendance', $data);
    }

    public function batch_attendance($batch_id = "",$user_id = "")
    {
        $data = array();
        $data['schedule_id'] = $batch_id;
        $data['user_id'] = $user_id;
        $this->db->insert('student_attendance', $data);
    }

    public function update_schedule($batch_id,$schedule_id)
    {
        //create meeting
        $data=array();
        $data['title'] = html_escape($this->input->post('title'));
        $data['duration'] = $this->input->post('duration');
        $data['start_date'] = strtotime($this->input->post('start_date'));
        $data['start_time'] = strtotime($this->input->post('start_time'));
        $data['timezone'] = $this->input->post('time_zone');
        $data['meeting_id'] =$this->input->post('meeting_id');
        $data['status'] = $this->input->post('status');
        $data['password'] = $this->input->post('password');
        $data['join_url'] = $this->input->post('join_url');
        $data['host_id'] = $this->input->post('host_id');
       // $data['batch_id'] = $this->input->post('batch_id');
        $data['updated_at'] = strtotime(date('D, d-M-Y'));


        $this->db->where('id',$schedule_id);
        $this->db->update('batch_schedules', $data);

        // echo '<pre>';print_r($data); die;
     //    echo $this->db->last_query();die;
        $this->session->set_flashdata('flash_message', get_phrase('schedule_has_been_updated_successfully'));
        return ;
    }

    /*
         public function update_schedule($schedule_id, $type = "")
    {
        $data = array();
        $data['title'] = html_escape($this->input->post('title'));
        $data['start_date'] = strtotime($this->input->post('start_date'));
        $data['start_time'] = strtotime($this->input->post('start_time'));
        $data['duration'] = $this->input->post('duration');
        $data['timezone'] = $this->input->post('time_zone');
        $data['recurring'] = $this->input->post('recurring');
        $data['recurence_type'] = $this->input->post('recurence_type');
        $data['occurs_on'] = $this->input->post('occurs_on');
        $data['end_date'] = strtotime($this->input->post('end_date'));

        //$data['end_date'] = $this->input->post('end_date');
        $data['password'] = $this->input->post('password');
        $data['course_id'] = $this->input->post('course_id');
        $data['host_id'] = $this->input->post('host_id');
        $data['alternative_hosts'] = $this->input->post('alternative_hosts');
        $data['batch_id'] = $this->input->post('batch_id');
        $data['created_at'] = strtotime(date('D, d-M-Y'));
        $data['updated_at'] = strtotime(date('D, d-M-Y'));
        $data['occurrence_id'] = html_escape($this->input->post('occurrence_id'));
        $data['meeting_id'] = html_escape($this->input->post('meeting_id'));
        // check if any meeting exists for the user at same date and time

        if($this->is_already_engaged_update($data['host_id'],$data['start_date'],$data['start_time'], $data['meeting_id'], $data['occurrence_id']))
        {
            $this->session->set_flashdata('error_message', get_phrase('User is already engaged at selected date and time'));
            return ;
        }

        $userDetail = $this->user_model->get_all_user($data['host_id'])->row_array();

        $response_code = $this->Zoom_model->updateMeeting($data, $userDetail['email']);

        $meeting = $this->Zoom_model->getMeetingDetails($data['meeting_id']);

        if($response_code['status']!=204)
        {

            $this->session->set_flashdata('error_message', 'Schedule could not be updated due to some error.');
            return;
        }else{
            if($data['occurrence_id']==0 || is_null($data['occurrence_id']) || $data['occurrence_id']== -1 )
            {
                $data1['title'] = html_escape($this->input->post('title'));
                $data1['start_date'] = $data['start_date'];
                $data1['start_time'] = $data['start_time'];
                $data1['duration'] = $this->input->post('duration');
                $data1['meeting_id'] = $meeting->id;
                $data1['password'] = $meeting->password;
                $data1['status'] = $meeting->status;
                $data1['meeting_detail'] = json_encode($meeting);
                $data1['password'] = $this->input->post('password');
                $data1['course_id'] = $this->input->post('course_id');
                $data1['host_id'] = $this->input->post('host_id');
                $data1['batch_id'] = $this->input->post('batch_id');
                $data1['created_at'] = strtotime(date('D, d-M-Y'));
                $data1['updated_at'] = strtotime(date('D, d-M-Y'));

                $this->db->where('meeting_id',$data1['meeting_id']);
                $this->db->delete('batch_schedules');
                $this->db->insert('batch_schedules', $data1);

                $schedule_id = $this->db->insert_id();
            }else{
                $data1['start_date'] = $data['start_date'];;
                $data1['start_time'] = $data['start_time'];
                $data1['duration'] = $this->input->post('duration');
                $data1['meeting_id'] = $meeting->id;
                $data1['occurrence_id'] = $data['occurrence_id'];

                $this->db->where('meeting_id',$data1['meeting_id']);
                $this->db->where('occurrence_id', $data1['occurrence_id']);
                $this->db->update('batch_schedules', $data1);

            }

        }
        $this->session->set_flashdata('flash_message', get_phrase('schedule_has_been_updated_successfully'));
        return ;
    }
     */

    public function delete_schedule($schedule_id){

        $this->db->where('id', $schedule_id);
        $record = $this->db->get('batch_schedules')->row_array();

        if(!empty($record)){
            $this->db->where('id', $schedule_id);
            $this->db->delete('batch_schedules');
            $this->session->set_flashdata('flash_message', get_phrase('all_scheduled_deleted_successfully') );
            return;

        }else{
            $this->session->set_flashdata('error_message', get_phrase('invalid_schedule_id') );
        }
    }


    public function delete_all_schedule($schedule_id){

        $this->db->where('id', $schedule_id);
        $record = $this->db->get('batch_schedules')->row_array();

        if(!empty($record)){
            $this->db->where('meeting_id', $record['meeting_id']);
            $this->db->delete('batch_schedules');
            $this->session->set_flashdata('flash_message', get_phrase('schedule_deleted_successfully') );
            return;

        }else{
            $this->session->set_flashdata('error_message', get_phrase('invalid_schedule_id') );
        }
    }

    /*
         public function delete_schedule($schedule_id)
    {
        $this->db->where('id', $schedule_id);
        $record = $this->db->get('batch_schedules')->row_array();

        if(!empty($record))
        {

            $data = array();

            if($record['occurrence_id']!=null)
            {
                $data['occurrence_id'] =  $record['occurrence_id'];
                $data['schedule_for_reminder'] =  true;
            }


            $result = $this->Zoom_model->deleteMeeting($data,$record['meeting_id'] );


            if($result->code && $result->code!=3001)
            {
                $this->session->set_flashdata('error_message', $result->message);
                return;
            }else{
                $this->db->where('id', $schedule_id);
                $this->db->delete('batch_schedules');

                $this->session->set_flashdata('flash_message', get_phrase('schedule_deleted_successfully') );
                return;
            }
        }else{
            $this->session->set_flashdata('error_message', get_phrase('invalid_schedule_id') );
        }
    }
     */



    public function is_already_engaged($host_id,$start_date,$start_time)
    {
        $this->db->where('host_id',$host_id);
        $this->db->where('start_date',$start_date);
        $this->db->where('start_time',$start_time);
        $this->db->where('status','waiting');
        $data = $this->db->get('batch_schedules')->row_array();

        if(!empty($data))
            return true;
        else return false;

    }
    public function is_already_engaged_update($host_id,$start_date,$start_time,$meeting_id,$occurrence_id)
    {
        $this->db->where('host_id',$host_id);
        $this->db->where('start_date',$start_date);
        $this->db->where('start_time',$start_time);
        $this->db->where('status','waiting');
        $this->db->where_not_in('meeting_id',$meeting_id);
        if(!empty($occurrence_id) || $occurrence_id!=0)
        {
            $this->db->where_not_in('occurrence_id',$occurrence_id);
        }
        $data = $this->db->get('batch_schedules')->row_array();

        if(!empty($data))
            return true;
        else return false;
    }

    public function student_courses_update($payment_id = "",$start_date = "",$schedule_expiry_date = "",$schedule_last_date = "",$unpaid_schedule_date="")
    {
        $data['start_date'] = $start_date;
        $data['schedule_expiry_date'] = $schedule_expiry_date;
        $data['schedule_last_date'] = $schedule_last_date;
        $data['unpaid_schedule_date'] = $unpaid_schedule_date;
        $this->db->where('id', $payment_id);
        $this->db->update('payment', $data);
    }


    public function get_course_by_Batchid($batch_id = "")
    {
        return $this->db->get_where('batches', array('id' => $batch_id));
    }

    public function admin_revenue_report($student_id="",$batch_id="",$start_date="",$end_date="")
    {
        $sql="select u.student_first_name,u.student_last_name,
        b.title as batch_title,c.title as course_title,p.amount as amount,
        p.start_date as enroll_date,p.schedule_last_date as expiry_date from payment p,users u,batches b,course c  where p.user_id=u.id and 
        p.batch_id=b.id and p.course_id = c.id";

        if($student_id!='all')
        {
            $sql=$sql." and p.user_id=".$student_id;
        }

        if($batch_id!='all')
        {
            $sql=$sql." and p.batch_id=".$batch_id;
        }

        if($start_date>0)
        {
            $sql=$sql." and p.start_date>=".$start_date;
        }

        if($end_date>0)
        {
            $sql=$sql." and p.schedule_last_date<=".$end_date;
        }
        
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function batch_schedule_report($course_id="",$batch_id="",$start_date="",$end_date="")
    {
        $sql="select bs.title as schedule_title,bs.start_date as start_date,bs.start_time as start_time,bs.join_url as join_url,
        b.title as batch,c.title as course from batch_schedules bs,batches b,course c where
         bs.batch_id = b.id and bs.course_id = c.id";

        if($course_id!='all')
        {
            $sql=$sql." and bs.course_id=".$course_id;
        }

        if($batch_id!='all')
        {
            $sql=$sql." and bs.batch_id=".$batch_id;
        }

        if($start_date>0)
        {
            $sql=$sql." and bs.start_date>=".$start_date;
        }

        if($end_date>0)
        {
            $sql=$sql." and bs.start_date<=".$end_date;
        }
     
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function student_attendance_report($student_id="",$batch_id="",$start_date="",$end_date="")
    {
        $sql="select bs.title as 'schedule',b.title as 'batch',u.student_first_name as 'student_first_name',
              u.student_last_name as 'student_last_name',sa.meeting_date  from student_attendance sa,batch_schedules bs,batches b,users u 
              where sa.schedule_id = bs.id and sa.batch_id = b.id and sa.user_id = u.id ";

        if($student_id!='all')
        {
            $sql=$sql." and sa.user_id=".$student_id;
        }

        if($batch_id!='all')
        {
            $sql=$sql." and sa.batch_id=".$batch_id;
        }

        if($start_date>0)
        {
            $sql=$sql." and sa.meeting_date >=".$start_date;
        }

        if($end_date>0)
        {
            $sql=$sql." and sa.meeting_date<=".$end_date;
        }
     
        $query = $this->db->query($sql);
        return $query->result_array();
    }

     public function batch_schedule_expirydate($batch_id="",$qty = "")
    {
        $sql="SELECT  start_time FROM (select start_time from batch_schedules where batch_id =".$batch_id." 
        and start_time >= UNIX_TIMESTAMP() ORDER BY start_time DESC LIMIT ".$qty.") AS sch ORDER BY start_time ASC LIMIT 1";

        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    public function batch_schedule_lastdate($batch_id="")
    {
        $sql="SELECT  start_time FROM (select start_time from batch_schedules where batch_id =".$batch_id." 
        and start_time >= UNIX_TIMESTAMP() ORDER BY start_time DESC ) AS sch ORDER BY start_time ASC LIMIT 1";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}