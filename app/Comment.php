<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function words(){
        return $this->belongsToMany('App\Word');
    }

    public function article() {
        return $this->belongsTo('App\Article');
    }
}
