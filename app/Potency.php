<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Potency extends Model {
    protected $table    = 'angel_potency';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
