<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Blood extends Model {
    protected $table    = 'angel_blood';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
