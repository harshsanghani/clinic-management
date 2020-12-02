<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Payment_mode extends Model {
    protected $table    = 'angel_payment_mode';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
