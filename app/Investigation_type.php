<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Investigation_type extends Model {
    protected $table    = 'angel_investigation_type';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
