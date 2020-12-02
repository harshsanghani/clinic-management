<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Prognosis extends Model {
    protected $table    = 'angel_prognosis';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
