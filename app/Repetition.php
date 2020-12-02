<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Repetition extends Model {
    protected $table    = 'angel_repetition';
    protected $fillable = ['name'];
    public $timestamps  = false;
}
