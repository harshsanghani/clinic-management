<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient_notes extends Model
{
    protected $table    = 'angel_patient_notes';
    protected $fillable = ['patient_id','appointment_id','notes','diet','diagnosis','consulting_amount','medicine_amount','amount','received_amount','payment_mode','medicines','extra_payment_reason','created_date','modify_date'];
    public $timestamps  = false;
    
    public function Appointment() {
      return $this->hasOne('App\Appointment','id', 'appointment_id'); // also create PageInfo model of course
    }
}
