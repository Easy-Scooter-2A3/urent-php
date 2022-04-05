<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        return view('auth.register');
    }
}
