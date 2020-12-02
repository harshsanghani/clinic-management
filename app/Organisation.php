<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Organisation extends Model {
    protected $table    = 'angel_organisation';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
