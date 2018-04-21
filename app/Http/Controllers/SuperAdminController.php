<?php

namespace App\Http\Controllers;

use App\DiaryActivity;
use App\Report\ReportManager;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function approve() {
        $users = User::where('type', User::NONE_TYPE)->get();

        return view('SuperAdmin.approve', ['users'=>$users]);
    }

    public function accept($id) {
        $user = User::find($id);
        $user->type = User::USER_TYPE;
        $user->save();

        $cur_user = Auth::user();
        ReportManager::saveReport($cur_user->id, DiaryActivity::Approve_Account, "$cur_user->name duyệt người dùng $user->name");

        return $id;
    }

    public function deny($id) {
        $user = User::find($id);
        $user->delete();

        $cur_user = Auth::user();
        ReportManager::saveReport($cur_user->id, DiaryActivity::Delete_Account, "$cur_user->name xóa người dùng $user->name");

        return $id;
    }

    public function manage(Request $request) {
        $cur_user = Auth::user();

        $users_builder = User::where('type', '<', $cur_user->type)->where('type', '>', -1);

        if($name = $request->get('name')){
            $users_builder->where('name', 'like', "%$name%");
        }

        if($department = $request->get('department')){
            $users_builder->where('department', $department);
        }

        if($position = $request->get('position')){
            $users_builder->where('name', $position);
        }

        if($address = $request->get('address')){
            $users_builder->where('name', 'like', "%$address%");
        }

        if($type = $request->get('type')){
            $users_builder->where('type', $cur_user->getTypeValueAttribute($type));
        }

        $users = $users_builder->get();

        return view('SuperAdmin.manage', ['users' => $users]);
    }

    public function update($id, Request $request) {
        $user = User::find($id);

        $type = $request->get('type');
        $user->type = $type;
        $user->save();

        return $id;
    }

    public function delete($id) {
        $user = User::find($id);
        $user->delete();

        return $id;
    }

    public function diary(Request $request){
        $cur_user = Auth::user();

        $activities_builder = DiaryActivity::with('user')
        ->whereHas('user', function ($query) use ($cur_user){
           $query->where('type', '<=', $cur_user->type);
           $query->where('type', '>', -1);
        });


        if($id = $request->get('id')){
            $activities_builder->where('user_id', $id);
        }

        if($name = $request->get('name')){
            $activities_builder->whereHas('user', function ($query) use ($name){
                $query->where('name', 'like', "%$name%");
            });
        }

        if($activity = $request->get('activity')){
            $diary = new DiaryActivity();
            $activity_value = $diary->getActivityValueAttribute($activity);
            $activities_builder->where('activity', $activity_value);
        }
//
//        if($datetime = $request->get('datetime')){
//            $users_builder->where('name', 'like', "%$address%");
//        }

        $activities = $activities_builder->orderBy('id', 'desc')->get();
        foreach ($activities as $key => $activity){
            $user = $activity->user();
        }

        return view('SuperAdmin.diary', ['activities' => $activities]);
    }
}
