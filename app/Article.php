<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const NEGATIVE_TYPE = -1;
    const NONE_TYPE = 0;
    const POSITIVE_TYPE = 1;
    const NO_TYPE = 2;

    protected $type_array = [
        -1 => "Tiêu cực",
        0 => "Không liên quan",
        1 => "Tích cực",
        2 => "Chưa phân loại",
    ];

    public function keywords(){
        return $this->belongsToMany('App\Keyword');
    }

    public function words(){
        return $this->belongsToMany('App\Word');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function getTypeTextAttribute(){
        return array_get($this->type_array, $this->type, 'Chưa phân loại');
    }
}
