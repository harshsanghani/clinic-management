<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra_notes extends Model
{
    protected $table    = 'angel_extra_notes';
    protected $fillable = ['patient_id','note','created_date'];
    public $timestamps  = false;
}
