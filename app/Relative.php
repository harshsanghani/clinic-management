<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Relative extends Model {
    protected $table    = 'angel_relative';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
