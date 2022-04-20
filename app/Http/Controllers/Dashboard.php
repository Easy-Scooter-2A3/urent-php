<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    private $collection = [
        ['dashboard', "Account"],
        ['dashboard', "History"],
        ['dashboard', "Fidelity"],
        ['dashboard', "Invoices"],
        ['dashboard', "Statistics"],
        ['weather', "Weather"],
        ['dashboard', "Packages"],
        ['dashboard', "Travels"],
    ];

    public function index(Request $request) {
        return view('user.dashboard', ['collection' => $this->collection]);
    }

    public function weather(Request $request) {
        return view('user.weather', ['collection' => $this->collection]);
    }
}
