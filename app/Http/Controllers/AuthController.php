<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
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
            return redirect()->back()->with('error', 'Đăng nhập thất bại. Sai thông tin đăng nhập.')->withInput();
        }

        return redirect()->intended(route('index'))->with('success', 'Đăng nhập thành công!');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function signup(RegisterRequest $request)
    {
        try {
            $credentials = $request->getCredentials();
            User::create($credentials);

            return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đăng ký thất bại.')->withInput();
        }
    }
}
