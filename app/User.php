<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'angel_admin';
    public $timestamps  = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password','visiblePassword','phone', 'username', 'isActive','type','createdDate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function get_doctors($filter = array(), $onlyCount = false) {
        $where = array('type' => 0);
        if(!empty($filter)) {
            $where = array_merge($where,$filter);
        }
        if ($onlyCount) {
            $return         = User::where($where)->count();
        } else {
            $return         = User::where($where)->get()->toArray();
        }
        return $return;
    }
}
