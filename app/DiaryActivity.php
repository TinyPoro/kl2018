<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaryActivity extends Model
{
    protected $table="diary_activities";

    const Login = 0;
    const Single_Summarizing=1;
    const Multiple_Summarizing=2;
    const Update_Information=3;
    const Change_Account_type=4;
    const Delete_Account =5;
    const Approve_Account=6;
    const Find_Keyword=7;
    const Change_Url_Crawl=8;
    const Change_Intervel_Option=9;

    protected $activities_array = [
        0 => "Đăng nhập",
        1 => "Tóm tắt đơn văn bản",
        2 => "Tóm tắt đa văn bản",
        3 => "Cập nhật thông tin người dùng",
        4 => "Cập nhật loại tài khoản",
        5 => "Xóa tài khoản",
        6 => "Xác thực tài khoản",
        7 => "Tìm kiếm từ khóa",
        8 => "Thay đổi url crawl",
        9 => "Thay đổi cài đặt chu kỳ",

    ];

    public function getActivityTextAttribute(){
        return array_get($this->activities_array, $this->activity, 'Không có hoạt động');
    }

    public function getActivityValueAttribute($activity_text){
        return array_keys($this->activities_array, $activity_text);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
