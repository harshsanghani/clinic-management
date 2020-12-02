<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Investigation extends Model {
    protected $table    = 'angel_investigation';
    protected $fillable = ['type','name'];
    public $timestamps  = false;
    
    
    public static function  getInvestigation() {
       return  Investigation::with('typeInfo');
    }

    public function typeInfo() {
      return $this->hasOne('App\Investigation_type', 'type', 'id'); // also create PageInfo model of course
    }

}

