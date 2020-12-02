<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Patient extends Model
{
    protected $table    = 'angel_patient';
    protected $fillable = ['title', 'firstname', 'middlename', 'lastname', 'email', 'phone', 'alternate_phone', 'birthdate', 'age', 'gender', 'blood_group', 'religion', 'refereace','added_by'];
    public $timestamps  = false;
    public static function  getRecords() {
            $return = Patient::query()
            ->select('angel_patient.*','a.path');
            $return->leftjoin("angel_attachment  as a", 'a.id', '=', 'angel_patient.image');
            $patient_data = $return->paginate(30);
            return $patient_data;
    }

    
    public static function  getPatient($patient_id = 0) {
       $return = array();
       if($patient_id > 0) {
            $return = Patient::with('bloodInfo', 'addressInfo', 'imageInfo')->find($patient_id);
       }
       return  $return ;
    }

    public function addressInfo() {
      return $this->hasOne('App\Patient_address', 'patient_id', 'id'); // also create PageInfo model of course
    }

    public function imageInfo() {
      return $this->hasOne('App\Attachment', 'id', 'image'); // also create PageInfo model of course
    }

    public function bloodInfo() {
      return $this->hasOne('App\Blood','id', 'blood_group'); // also create PageInfo model of course
    }
}
