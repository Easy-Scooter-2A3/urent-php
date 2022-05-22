<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Scooter;

use function PHPUnit\Framework\isNull;

class ScooterController extends Controller
{
    public function details(Request $request) {
        $scooter = Scooter::find($request->input('scooter'));

        return response()->json(['success' => true, 'data' => $scooter]);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'model' => ['required', 'string', 'max:255'],
            'status' => ['string', 'max:255', 'default:available'],
        ])->validate();

        Scooter::create([
            'model' => $request->input('model'),
            'status' => $request->input('status') ?? 'available',
        ]);
        return response()->json(['success' => true]);
    }

    public function action(Request $request) {
        $action = $request->input('action');
        $data = $request->input('data');

        switch ($action) {
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
        $status = Scooter::destroy($request->input('scooters'));
        return response()->json(['success' => boolval($status)]);
    }

    public function setUser(Request $request) {
        $scooter = Scooter::find($request->id);
        $scooter->used_by = $request->userID;
        return response()->json(['success' => $scooter->save()]);
    }
}
