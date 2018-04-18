<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public function articles(){
        return $this->belongsToMany('App\Article');
    }

    public function comments(){
        return $this->belongsToMany('App\Comment');
    }
}
