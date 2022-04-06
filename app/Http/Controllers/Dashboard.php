<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(Request $request) {
        $collection = [
            ['dashboard', "Account"],
            ['dashboard', "History"],
            ['dashboard', "Fidelity"],
            ['dashboard', "Invoices"],
            ['dashboard', "Statistics"],
            ['dashboard', "Weather"],
            ['dashboard', "Packages"],
            ['dashboard', "Travels"],
        ];

        return view('user.dashboard', ['collection' => $collection]);
    }
}
