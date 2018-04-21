<?php
/**
 * Created by PhpStorm.
 * User: ngoph
 * Date: 4/21/2018
 * Time: 2:11 PM
 */

namespace App\Report;


use App\DiaryActivity;
use Carbon\Carbon;

class ReportManager
{
    public static function saveReport($user_id, $activity, $content, $impact = ''){
        $diary = new DiaryActivity;

        $diary->user_id = $user_id;
        $diary->activity = $activity;
        $diary->datetime = now();
        $diary->content = $content;
        $diary->database_impact = $impact;

        $diary->save();
    }
}