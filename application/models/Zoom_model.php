<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 25-09-2020
 * Time: 15:16
 */

require APPPATH . '/libraries/JWT.php';
defined('BASEPATH') or exit('No direct script access allowed');
class Zoom_model extends CI_Model
{
    protected $redirect_uri = 'http://localhost/young-achievers/';
    protected $baseurl = 'https://zoom.us/v2';
    function __construct()
    {
        parent::__construct();
    }

    public function getZoomCredentials()
    {
        $apiKey = get_settings('zoom_api_key');
        $apiSecret = get_settings('zoom_secret_key');

        $data = array(
            'api_key' => $apiKey,
            'api_secret' => $apiSecret
        );

        return $data;
    }

    public function generateJWT () {
       $creds = $this->getZoomCredentials();
        $token = array(
            "iss" => $creds['api_key'],
            // The benefit of JWT is expiry tokens, we'll set this one to expire in 1 minute
            "exp" => time() + 60
        );
        return JWT::encode($token, $creds['api_secret']);
    }


    public function createMeeting($data, $email) {

        $post_time  = date("Y-m-d", $data['start_date']);
        $time = date("H:i:s", $data['start_time']);
        $start_time = $post_time.'T'.$time;

        $effectiveDate = date('Y-m-d', strtotime($post_time . "+3 months"));

        $createAMeetingArray = array();

        if (isset($data['alternative_hosts']) && !empty($data['alternative_hosts'])) {
//            if (count($data['alternative_hosts']) > 1) {
//                $alternative_host_ids = implode(",", $data['alternative_hosts']);
//            } else {
//                $alternative_host_ids = $data['alternative_hosts'][0];
//            }

            $alternative_host_ids = $data['alternative_hosts'];
        }

        $createAMeetingArray['topic']      = $data['title'];
        $createAMeetingArray['type']       = !empty($data['recurring']) ? 8 : 2; //Scheduled
        $createAMeetingArray['start_time'] = $start_time;
        $createAMeetingArray['timezone']   = $data['timezone'];
        $createAMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
        $createAMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;

        if(!empty($data['recurring']) && $data['recurring']=='on')
        {
            $batch_details = $this->Batch_model->get_batch_by_id($data['batch_id'])->row_array();

            $hours = $batch_details['hours'];

            $total_number_of_sessions = $batch_details['total_number_of_sessions'];

            $batch_end_date = '';
            $session_count = 0;

            for($counter = 1; $counter <= 1000; $counter++)
            {
                $number = 86400 * $counter;

                $tomorrow = strtotime('tomorrow');

                $new_date = $data['start_date'] +  $number;

                $day = date('D', $new_date);

                if($data['recurence_type']==1)
                {
                    if($session_count == $total_number_of_sessions)
                    {
                        $batch_end_date  = date("Y-m-d", $new_date);
                        break;
                    }
                    $session_count++;
                }
                else if($data['recurence_type']==2)
                {
                    $l = $this->getDay($day);

                    if (in_array($l, $data['weekday_array']))
                    {
                         if($session_count == $total_number_of_sessions)
                        {
                            $batch_end_date  = date("Y-m-d", $new_date);
                            break;
                        }
                        $session_count++;
                    }
                }
            }
            $createAMeetingArray['recurrence']['type'] = $data['recurence_type'];
//$data['weekday_array']
            if($data['recurence_type']==1)
            $createAMeetingArray['recurrence']['repeat_interval']=1;
            if($data['recurence_type']==2)
            {
               // print implode(',',$data['weekday_array']);
                $createAMeetingArray['recurrence']['weekly_days'] = "\"".implode(',',$data['weekday_array'])."\"";
             //   $createAMeetingArray['recurrence']['weekly_days'] = "\""."1,2,4,6"."\"";
            }
            if($effectiveDate<$batch_end_date)
            {
                $batch_end_date = $effectiveDate;
            }
            $createAMeetingArray['recurrence']['end_date_time'] = $batch_end_date.'T'.$time;
        }

      //  print  $createAMeetingArray['recurrence']['weekly_days']; die;

        $createAMeetingArray['settings']   = array(
            'join_before_host'  => !empty($data['join_before_host']) ? true : false,
            'host_video'        => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : "",
            "registrants_email_notification" => false
        );
       // $request_url = "https://api.zoom.us/v2/users/".$email."/meetings";

      //  print_r($createAMeetingArray); die;
        $email = 'Youngachievers54@gmail.com';
        $request_url = "https://api.zoom.us/v2/users/".$email."/meetings";
        print $this->generateJWT();die;

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //    CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_CUSTOMREQUEST => "GET",
           // CURLOPT_POSTFIELDS => json_encode($createAMeetingArray),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->generateJWT(),
                "content-type: application/json",
                "Accept: application/json",
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public function deleteMeeting($data, $meetingId) {

        if(!empty($data))
        {
            $str = http_build_query($data);
            $request_url = "https://api.zoom.us/v2/meetings/".$meetingId.'?'.$str;
        }else{
            $request_url = "https://api.zoom.us/v2/meetings/".$meetingId;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->generateJWT(),
                "Accept: application/json",
            ),
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }

    public function updateMeeting($data, $email) {

        $post_time  = date("Y-m-d", $data['start_date']);
        $time = date("H:i:s", $data['start_time']);
        $start_time = $post_time.'T'.$time;

        //print date("Y-m-d H:i:s", $data['end_date']); die;
        $createAMeetingArray = array();
        if (isset($data['alternative_hosts']) && !empty($data['alternative_hosts'])) {
//            if (count($data['alternative_hosts']) > 1) {
//                $alternative_host_ids = implode(",", $data['alternative_hosts']);
//            } else {
//                $alternative_host_ids = $data['alternative_hosts'][0];
//            }

            $alternative_host_ids = $data['alternative_hosts'];
        }


      $createAMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;
        $createAMeetingArray['start_time'] = $start_time;
       // print_r($createAMeetingArray);die;
        //print  $createAMeetingArray['recurrence']['end_date_time']; die;


        if($data['occurrence_id']==0 || is_null($data['occurrence_id']) || $data['occurrence_id']== -1 )
        {
               $createAMeetingArray['topic']      = $data['title'];
                $createAMeetingArray['type']       = !empty($data['recurring']) ? 8 : 2; //Scheduled

              $createAMeetingArray['timezone']   = $data['timezone'];
               $createAMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
            $request_url = "https://api.zoom.us/v2/meetings/".$data['meeting_id'];
          // print $data['occurrence_id'];die;
            if(!empty($data['recurring']) && $data['recurring']=='on')
            {
                // print  $createAMeetingArray['recurrence']['type'];die;
                $createAMeetingArray['recurrence']['type'] = $data['recurence_type'];
                if($data['recurence_type']==1)
                    $createAMeetingArray['recurrence']['repeat_interval']=1;
                if($data['recurence_type']==2)
                    $createAMeetingArray['recurrence']['weekly_days'] = implode(',',$data['occurs_on']);
                $createAMeetingArray['recurrence']['end_date_time'] = date("Y-m-d", $data['end_date']).'T'.date("H:i:s", $data['end_date']).'Z';
            }
                    $createAMeetingArray['settings']   = array(
            'join_before_host'  => !empty($data['join_before_host']) ? true : false,
            'host_video'        => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : "",
            "registrants_email_notification" => false
        );
        }
        else{

            $request_url = "https://api.zoom.us/v2/meetings/".$data['meeting_id']."?occurrence_id=".$data['occurrence_id'];

        }
//print json_encode($createAMeetingArray);die;
//print $request_url;die;
       //print_r($createAMeetingArray);die;
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => json_encode($createAMeetingArray),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->generateJWT(),
                "content-type: application/json",
                "Accept: application/json",
            ),
        ));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       // var_dump($httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE));die;
        curl_close($ch);

        return array('status' => $httpcode);


    }

    public function getMeetingDetails($meetingId)
    {
        $request_url = "https://api.zoom.us/v2/meetings/".$meetingId;

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->generateJWT(),
                "content-type: application/json",
                "Accept: application/json",
            ),
        ));
        $response = curl_exec($ch);

        curl_close($ch);

      //  print json_decode($response);die;

        return json_decode($response);

    }

    public function getDay($day="")
    {
        if($day == 'Sun')
        {
            return 1;
        }

        if($day == 'Mon')
        {
            return 2;
        }

        if($day == 'Tue')
        {
            return 3;
        }

        if($day == 'Wed')
        {
            return 4;
        }

        if($day == 'Thu')
        {
            return 5;
        }

        if($day == 'Fri')
        {
            return 6;
        }

        if($day == 'Sat')
        {
            return 7;
        }

    }
}