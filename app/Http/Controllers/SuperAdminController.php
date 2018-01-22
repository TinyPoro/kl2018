<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function approve() {
        $users = User::where('type', User::NONE_TYPE)->get();

        return view('superadmin.approve', ['users'=>$users]);
    }

    public function accept($id) {
        return "a";
    }
}
