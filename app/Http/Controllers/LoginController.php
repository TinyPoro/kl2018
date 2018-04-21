<?php

namespace App\Http\Controllers;

use App\DiaryActivity;
use App\Report\ReportManager;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            if($user->type == User::NONE_TYPE) {
                return redirect()->route('_logout');
            }

            ReportManager::saveReport($user->id, DiaryActivity::Login, "$user->name đăng nhập");

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }
}
