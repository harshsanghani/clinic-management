<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Patient_address extends Model {
    protected $table    = 'angel_patient_address';
    protected $fillable = array('patient_id',
                            'address', 
                            'city', 
                            'state', 
                            'country', 
                            'zipcode', 
                            'permanent_address', 
                            'permanent_city', 
                            'permanent_state', 
                            'permanent_country', 
                            'permanent_zipcode',
                            'created_date');
    public $timestamps  = false;
}
