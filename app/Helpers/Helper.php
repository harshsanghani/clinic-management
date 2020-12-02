<?php

if (!function_exists('p')) {
    function p($data , $die = false) {
       echo "<pre>";print_r($data); 
       if($die == false) {
           die;
       } 
    }
}
if (!function_exists('doc_ext_array')) {
    function doc_ext_array() {
        $doc  = array(
                        0   => '.pdf',
                        1   => '.PDF',
                        );
        return $doc;
    }
}
if (!function_exists('video_ext_array')) {
   function video_ext_array() {
        $video  = array(
                        0   => '.mp4',
                        1   => '.MP4',
                        );
        return $video;
    }
}
if (!function_exists('base_url')) {
   function base_url() {
        $url = url('/');
        return $url;
    }
}
if (!function_exists('portal_url')) {
   function portal_url() {
        $url = url('/portal');
        return $url;
    }
}
if (!function_exists('getReports')) {
   function getReports() {
        $report_type = \App\Report_type::all();
        return $report_type;
    }
}
if (!function_exists('getLoginUser')) {
   function getLoginUser() {
        return auth()->user();
    }
}
if (!function_exists('send_sms')) {

    function send_sms($mobile, $message) {
        if ($mobile != "" && $message != '') {
            $return = true;
            $message = urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://sms.globalbulksms.com/sendsmsv2.asp?user=dr_dipaksoni&password=152692630&sender=DipakS&text=' . $message . '&PhoneNumber=' . $mobile . '&track=1');
            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);
            $error = curl_error($ch);

            if ($result == false) {
                $return = false;
            }

            curl_close($ch);
            return $return;
        }
    }

}
?>
