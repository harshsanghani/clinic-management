<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Appointment extends Model {
    protected $table    = 'angel_appointment';
    protected $fillable = ['type','patient_id','appointment_date','appointment_time','sms_notification','email_notification','attend','created_date','doctor_id'];
    public $timestamps  = false;

    public static function getTimeSlot() {
      return array(
            0   => '10:00 AM',
            1   => '10:30 AM',
            2   => '11:00 AM',
            3   => '11:30 AM',
            4   => '12:00 PM',
            5   => '12:30 PM',
            6   => '01:00 PM',
            7   => '01:30 PM',
            8   => '02:00 PM',
            9   => '02:30 PM',
            10  => '03:00 PM',
            11  => '03:30 PM',
            12  => '04:00 PM',
            13  => '04:30 PM',
            14  => '05:00 PM',
            15  => '05:30 PM',
            16  => '06:00 PM',
            17  => '06:30 PM',
            18  => '07:00 PM',
            19  => '07:30 PM',
            20  => '08:00 PM'
        );
    }
    public static function  getRecords($filter = array()) {
        
       $where = array();
       if(isset($filter['doctor_id'])) {
          $where['angel_appointment.doctor_id'] =  $filter['doctor_id'];
       }
       $appointments = Appointment::query()
            ->select('angel_appointment.*','p.firstname', 'p.lastname')
            ->leftjoin("angel_patient  as p", 'p.id', '=', 'angel_appointment.patient_id');
       if( isset($filter['startdate']) && $filter['startdate'] != "" && isset($filter['enddate']) && $filter['enddate'] != "" ) {
             $appointments->where([['angel_appointment.appointment_date', '>=', $filter['startdate']],
                                    ['angel_appointment.appointment_date', '<', $filter['enddate']]]);
       }
       if(!empty($where)) {
          $appointments->where($where);
       }
       $appointments = $appointments->get();
       $events = array();
       if ( !empty($appointments)) {
            foreach ($appointments as $list) {
                $type       = "";
                $color      = "";
                if ($list->type == 1) {
                    $type   = "New";
                    $color  = "bg-cyan";
                } else if ($list->type == 2) {
                    $type   = "Follow Up";
                    $color  = "bg-amber";
                } else if ($list->type == 3) {
                    $type   = "Emergency";
                    $color  = "bg-red";
                }
                $Time       = strtotime("+30 minutes", strtotime($list->appointment_time));
                $endtime    = date('H:i:s', $Time);
                $patient_name   = array();

                if ($list->firstname != '') {
                    $patient_name[] = $list->firstname;
                }
                if ($list->middlename != '') {
                    $patient_name[] = $list->middlename;
                }
                if ($list->lastname != '') {
                    $patient_name[] = $list->lastname;
                }
                $events[] = array(
                    'id'          => $list->id,
                    'title'       => $type.' - '.implode(' ', $patient_name),
                    'start'       => $list->appointment_date . 'T' .$list->appointment_time,
                    'end'         => $list->appointment_date . 'T' .$endtime,
                    'patient_id'  => $list->patient_id,
                    'className'   => $color
                );
            }
        }
       return  $events;
    }
    public static function getTodayAppointment($patient_id = 0) {

        $id = 0;
        if ($patient_id > 0) {
            $appointment    = Appointment::where(array('appointment_date' => date('Y-m-d'),'patient_id' => $patient_id))->first();
            if (! empty($appointment) && isset($appointment->id)) {
                $id = $appointment->id;
            }
        }
        return $id;
    }
}
