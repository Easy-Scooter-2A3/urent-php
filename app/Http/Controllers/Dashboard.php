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
        ['dashboard_weather', "Weather"],
        ['dashboard', "Packages"],
        ['dashboard', "Travels"],
    ];

    public function index(Request $request) {
        return view('dashboard', [
            'view' => 'user.dashboard-account',
            'collection' => $this->collection
        ]);
    }

    public function weather(Request $request) {
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Europe/Paris'));
        $currentDay = $date->format('N'); // 1-7
        $currentHour = $date->format('G'); // 0-23
        return view('dashboard', [
            'view' => 'user.dashboard-weather',
            'collection' => $this->collection,
            'days' => $days,
            'currentDay' => $currentDay,
            'currentHour' => $currentHour,
        ]);
    }
}
