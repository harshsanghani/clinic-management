<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Certificates extends Model {
    
    protected $table    = 'angel_certificate';
    protected $fillable = ['date','patient_id','report_type','certificate_detail','created_date','modify_date'];
    public $timestamps  = false;
    
    public static function  getRecords($report_type = "") {
       return $return = Certificates::query()
            ->select('angel_certificate.*', 'ap.firstname','ap.middlename','ap.lastname')
            ->join("angel_patient as ap", 'ap.id', '=', 'angel_certificate.patient_id')
            ->where("angel_certificate.report_type",$report_type)
            ->orderBy('angel_certificate.id', 'desc')
            ->paginate(30);
    }
    
    public static function  getCertificates($certificates_id = 0) {
       $return = array();
       if($certificates_id > 0) {
            $return = Certificates::query()->find($certificates_id);
       }
       return  $return ;
    }
    
}
