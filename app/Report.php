<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table    = 'angel_report';
    public $timestamps  = false;
    protected $fillable = ['patient_id', 'report','created_date','modify_date'];

    public function imageInfo() {
      return $this->hasOne('App\Attachment', 'id', 'report'); // also create PageInfo model of course
    }
}   
