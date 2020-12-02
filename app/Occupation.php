<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Occupation extends Model {
    protected $table    = 'angel_occupation';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
