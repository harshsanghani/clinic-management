<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attachment;
class Attachment extends Model
{
    protected $table    = 'angel_attachment';
    protected $fillable = ['path', 'type'];
    public $timestamps  = false;

    public static function getRecord($id) {
        $return = array();
        
        if ($id != '') {
           $return = Attachment::where('id' ,$id)->get();
        }
        return $return;
    }
}
