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
    const Change_Account_tyoe=4;
    const Delete_Account =5;
    const Approve_Account=6;
    const Find_Keyword=7;
    const Change_Url_Crawl=8;
    const Change_Intervel_Option=9;
}
