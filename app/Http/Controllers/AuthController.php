<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        if (! Auth::attempt($credentials)) {
            return redirect()->back();
        }

        return redirect()->intended(route('index'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
