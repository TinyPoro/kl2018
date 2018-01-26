<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const NONE_TYPE = -1;
    const USER_TYPE = 0;
    const ADMIN_TYPE = 1;
    const SUPER_ADMIN_TYPE = 2;


    protected $type_array = [
        -1 => "Chưa xác thực",
        0 => "Người dùng thường",
        1 => "Admin",
        2 => "Super Admin",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getTypeTextAttribute(){
        return array_get($this->type_array, $this->type, 'Người dùng thường');
    }

    public function getTypeValueAttribute($type_text){
        return array_keys($this->type_array, $type_text);
    }

    public function activities(){
        return $this->hasMany('App\DiaryActivity');
    }
}
