<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Report_type extends Model {
    protected $table    = 'angel_report_type';
    protected $fillable = ['name'];
    public $timestamps  = false;
    
    public static function get_report_name($report_type = 0) {
        $return = array();
        
        if($report_type > 0) {
            $return = Report_type::where('id',$report_type)->first();
        }
        return  $return ;
    }
    
}
