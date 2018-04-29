<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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

    public function words(){
        return $this->belongsToMany('App\Word');
    }

    public function article() {
        return $this->belongsTo('App\Article');
    }

    public function getTypeTextAttribute(){
        return array_get($this->type_array, $this->type, 'Chưa phân loại');
    }
}
