<?php

namespace App\Http\Controllers;

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
            return redirect()->route('home');
        }

        return redirect()->route('home');
    }
}
