<?php

namespace App\Http\Controllers;
use App\Actions\Package\GetCurrentPackage;
use App\Actions\Partnership\GetPartnerships;
use App\Actions\Partnership\GetUserPartnerships;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scooter;
use App\Models\Package;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\users_packages;
use App\Models\Product;

class Dashboard extends Controller
{
    private $collection = [
        ['dashboard', "Account"],
        ['dashboard', "History"],
        ['dashboard', "Fidelity"],
        ['dashboard', "Invoices"],
        ['dashboard', "Statistics"],
        ['user.orders', "Orders"],
        ['dashboard_weather', "Weather"],
        ['user.packages', "Packages"],
        ['dashboard', "Travels"],
        ['admin.accounts', "Accounts (admin)"],
        ['admin.scooters', "Scooters (admin)"],
        ['admin.products', "Products (admin)"],
        ['admin.partnerships', "Partnerships (admin)"],
    ];

    public function index(Request $request) {
        $currentPackage = GetCurrentPackage::run($request->user());
        $package = Package::where('id', $currentPackage)->first();
        // TODO: translate package name

        $partner = GetUserPartnerships::run($request->user()->id);

        return view('dashboard', [
            'view' => 'user.dashboard-account',
            'collection' => $this->collection,
            'current_package' => $package->type,
            'partnerships' => $partner['partnerships'],
            'userPartnerships' => $partner['userPartnerships'],
        ]);
    }

    public function orders(Request $request) {
        $orders = Order::where('user_id', $request->user()->id)->get();
        $cols = ['Status', 'Transporter', 'Total', 'Commandée le', 'Livraison le'];

        return view('dashboard', [
            'view' => 'user.dashboard-orders',
            'collection' => $this->collection,
            'orders' => $orders,
            'cols' => $cols
        ]);
    }

    public function partnerships(Request $request) {
        $cols = ['Company', 'From', 'To', 'Voucher', 'Max', 'Active'];
        $cols2 = ['User', 'Partnership with', 'Since'];

        // $partnerships = GetUserPartnerships::run(auth()->user()->id);

        return view('dashboard', [
            'view' => 'user.dashboard-partnerships',
            'collection' => $this->collection,
            'cols' => $cols,
            'cols2' => $cols2,
            'partnerships' => GetPartnerships::run(),
            'products' => Product::all(),
        ]);
    }

    public function packages(Request $request) {
        $packages = Package::all();
        $currentPackage = GetCurrentPackage::run($request->user());

        return view('dashboard', [
            'view' => 'user.dashboard-packages',
            'collection' => $this->collection,
            'current_package' => $currentPackage,
            'packages' => $packages,
        ]);
    }

    public function products(Request $request) {
        $cols = ['Name', 'Price', 'Nb. Achats', 'Desc', 'Stock', 'Achats', 'Available'];
        $products = Product::all();

        // TODO: pagination -> action
        $attributes = Attribute::all();

        return view('dashboard', [
            'view' => 'admin.products',
            'collection' => $this->collection,
            'products' => $products,
            'cols' => $cols,
            'attributes' => $attributes,
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

    public function accounts(Request $request) {
        $cols = ['Status', 'Name', 'Date', 'Dern. Connection', 'ID', 'Admin'];

        $users = User::all();
        return view('dashboard', [
            'view' => 'admin.users',
            'collection' => $this->collection,
            'users' => $users,
            'cols' => $cols
        ]);
    }

    public function action(Request $request) {
        $action = $request->input('action');
        $data = $request->input('data');

        switch ($action) {
            case 'toggleAdmin':
                foreach ($data['users'] as $user) {
                    $user = User::find($user);
                    $user->isAdmin = !$user->isAdmin;
                    $user->save();
                }
                break;
            case 'toggleActivationUser':
                foreach ($data['users'] as $user) {
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
            $users = User::whereIn('id', $input)->get();
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

    public function scooter(Request $request) {
        $cols = ['Status', 'Date', 'Dern. Maintenance', 'Model', 'ID', 'Used by'];

        $scooter = Scooter::all();
        return view('dashboard', [
            'view' => 'admin.scooters',
            'collection' => $this->collection,
            'scooters' => $scooter,
            'cols' => $cols
        ]);
    }
}
