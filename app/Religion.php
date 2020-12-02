<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Religion extends Model {
    protected $table    = 'angel_religion';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
