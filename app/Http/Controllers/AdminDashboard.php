<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class AdminDashboard extends Controller
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

        $users = User::all();
        return view('admin.dashboard', ['collection' => $collection, 'users' => $users]);
    }

    private function changeAdmin(Request $request) {
        $user = User::find()->first();

        if (!$user) {
            $json = ['status' => 'error', 'message' => 'User not found'];
            return response()->json($json);
        }

        $user->admin = $user->admin ? 1 : 0;
        $user->save();
        $response = ['status' => 'success', 'message' => 'User admin status changed'];
        $user->save() ? $response : $response = ['status' => 'error', 'message' => 'User admin status not changed'];
    }
}