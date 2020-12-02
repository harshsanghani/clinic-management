<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Diet extends Model {
    protected $table    = 'angel_diet';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
