<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const NEGATIVE_TYPE = -1;
    const NONE_TYPE = 0;
    const POSITIVE_TYPE = 1;
    const UNRELATIVE_TYPE = 2;

    public function keywords(){
        return $this->belongsToMany('App\Keyword');
    }

    public function words(){
        return $this->belongsToMany('App\Word');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
