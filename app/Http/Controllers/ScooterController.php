<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Scooter;

use function PHPUnit\Framework\isNull;

class ScooterController extends Controller
{
    public function details(Request $request) {
        $input = $request->input('scooters');
        $users = [];
        if (count($input) > 0) {
            $users = Scooter::whereIn('id', $input)->get();
        };

        return response()->json(['success' => true, 'data' => $users]);
    }

    public function action(Request $request) {
        $action = $request->input('action');
        $data = $request->input('data');

        switch ($action) {
            case 'delete':
                Scooter::destroy($data['scooters']);
                break;
            case 'create':
                $validator = Validator::make($data, [
                    'model' => ['required', 'string', 'max:255'],
                    'status' => ['required', 'string', 'max:255'],
                ])->validate();

                $scooter = new Scooter([
                    'model' => $data['model'],
                    'status' => $data['status'],
                ]);

                if (!isNull($request->status)) {
                    $scooter->status = 'available';
                }
                $scooter->save();
                break;
            default:
                break;
        }

        return response()->json(['success' => true, 'action' => $action]);
    }

    public function list(Request $request) { 
        return response()->json(['data' => Scooter::all()]);
    }

    public function get(Request $request) { 
        return response()->json(['data' => Scooter::find($request->id)]);
    }

    public function delete(Request $request) {
        $status = Scooter::destroy($request->id);
        return response()->json(['success' => boolval($status)]);
    }

    public function setUser(Request $request) {
        $scooter = Scooter::find($request->id);
        $scooter->used_by = $request->userID;
        return response()->json(['success' => $scooter->save()]);
    }
}
