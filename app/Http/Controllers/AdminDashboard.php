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

        $cols = ['Status', 'Name', 'Date', 'Dern. Connection', 'ID', 'Admin'];

        $users = User::all();
        return view('dashboard', [
            'view' => 'admin.users',
            'collection' => $collection,
            'users' => $users,
            'cols' => $cols
        ]);
    }

    public function action(Request $request) {
        $action = $request->input('action');
        $users = $request->input('users');

        switch ($action) {
            case 'toggleAdmin':
                foreach ($users as $user) {
                    $user = User::find($user);
                    $user->isAdmin = !$user->isAdmin;
                    $user->save();
                }
                break;
            case 'toggleActivationUser':
                foreach ($users as $user) {
                    $user = User::find($user);
                    $user->isActive = !$user->isActive;
                    $user->save();
                }
                break;
            
            default:
                break;
        }

        return response()->json(['success' => true, 'action' => $action]);
    }

    public function details(Request $request) {
        $input = $request->input('users');
        $users = [];
        if (count($input) > 0) {
            $users = User::whereIn('id', $request->input('users'))->get();
        };

        return response()->json(['success' => true, 'data' => $users]);
    }

    public function changeAdmin() {
        $user = User::find(2);

        if (!$user) {
            $json = ['status' => 'error', 'message' => 'User not found'];
            return response()->json($json);
        }

        $user->admin = $user->admin ? 1 : 0;
        $response = ['status' => 'success', 'message' => 'User admin status changed'];
        $user->save() ? $response : $response = ['status' => 'error', 'message' => 'User admin status not changed'];
    }
}