<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Invoice extends Model {
    protected $table    = 'angel_invoice';
    protected $fillable = ['patient_id','appointment_id','created_date'];
    public $timestamps  = false;
    
    public static function getInvoice($invoice_id = 0) {
        return $return = Invoice::query()
            ->select('angel_invoice.id as invoice_id','p.*','a.*','n.*','address.*')
            ->leftjoin("angel_appointment  as a", 'a.id', '=', 'angel_invoice.appointment_id','p.id as patient_id')
            ->leftjoin("angel_patient  as p", 'p.id', '=', 'angel_invoice.patient_id')
            ->leftjoin("angel_patient_notes  as n", 'n.appointment_id', '=', 'a.id')
            ->leftjoin("angel_patient_address  as address", 'address.patient_id', '=', 'angel_invoice.id')
            ->where('angel_invoice.id', $invoice_id)->first()->toArray();
    }
}
