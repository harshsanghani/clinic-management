<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Dosage extends Model {
    protected $table    = 'angel_dosage';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
