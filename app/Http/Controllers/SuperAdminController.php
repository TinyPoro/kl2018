<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function approve() {
        $users = User::where('type', User::NONE_TYPE)->get();

        return view('superadmin.approve', ['users'=>$users]);
    }

    public function accept($id) {
        $user = User::find($id);
        $user->type = User::USER_TYPE;
        $user->save();

        return $id;
    }

    public function deny($id) {
        $user = User::find($id);
        $user->delete();

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
}
