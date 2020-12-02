<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Medicine extends Model {
    protected $table    = 'angel_medicine';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
