<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mail;

class Controller extends BaseController
{
    public $pagination = 10;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function send_mail($data = array()) {
        if (!empty($data)) {

            $send = Mail::send($data['message'] , $data, function ($message) use ($data) {
                $message->to($data['to']);
                if (isset($data['from'])) {
                    $message->from($data['from']);
                } else {
                    $message->from('harsh.angelinfotech@gmail.com');
                }
                if (isset($data['subject'])) {
                    $message->subject($data['subject']);
                }
                if (isset($data['attachement'])) {
                    foreach ($data['attachement'] as $att) {
                        $message->attach($att);
                    }
                }
            });
            $return  = true;
            if( count(Mail::failures()) > 0 ) {
                $return  = false;
            }
            return $return;
            
        }
    }

}
