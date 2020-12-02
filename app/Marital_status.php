<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Marital_status extends Model {
    protected $table    = 'angel_marital_status';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
