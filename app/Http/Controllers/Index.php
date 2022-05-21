<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Package\GetCurrentPackage;
use App\Models\Package;
use App\Actions\Partnership\GetUserPartnerships;

class Index extends Controller
{
    public function index(Request $request)
    {
        $currentPackage = GetCurrentPackage::run($request->user());
        $package = Package::where('id', $currentPackage)->first();
        $packages = Package::all();
        // TODO: translate package name

        $partner = GetUserPartnerships::run($request->user()->id);

        return view('index', [
            'current_package' => $package->type,
            'packages' => $packages,
        ]);
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
