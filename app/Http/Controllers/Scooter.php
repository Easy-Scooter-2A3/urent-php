<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Scooter as ScooterModel;
use App\Models\ScooterStatus;
use App\Models\Maintenance;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Scooter extends Controller
{
    public function details(Request $request) {
        $scooter = ScooterModel::find($request->input('scooter'));

        $res = Maintenance::where('scooter_id', $scooter->id)->orderBy('created_at', 'desc')->first();
        $scooter->status = ScooterStatus::getStatus($scooter->status);
        $scooter->date_last_maintenance = $res ? $res->created_at : 'Never';

        return response()->json(['success' => true, 'data' => $scooter]);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'model' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', "between:1,50"],
        ])->validate();

        $quantity = $request->input('quantity');

        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Quantity must be greater than 0']);
        }

        if ($quantity > 0) {
            for ($i = 0; $i < $quantity; $i++) {
                ScooterModel::create([
                    'model' => $request->input('model'),
                    'status' => ScooterStatus::SCOOTER_STATUS_UNSPECIFIED, //TODO: use enum
                    'uuid' => UuidV4::uuid4(), //serial number of the scooter
                ]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function list(Request $request) { 
        //TODO: pagination
        $scooters = ScooterModel::all();
        foreach ($scooters as $s) {
            $s->status = ScooterStatus::getStatus($s->status);

            $res = Maintenance::where('scooter_id', $s->id)->orderBy('created_at', 'desc')->first();
            $s->date_last_maintenance = $res ? $res->created_at : 'Never';
        }
        return response()->json(['data' => $scooters]);
    }

    public function get(Request $request) { 
        return response()->json(['data' => ScooterModel::find($request->id)]);
    }

    public function delete(Request $request) {
        $status = ScooterModel::destroy($request->input('scooters'));
        return response()->json(['success' => boolval($status)]);
    }

    public function setUser(Request $request) {
        $scooter = ScooterModel::find($request->id);
        $scooter->used_by = $request->userID;
        return response()->json(['success' => $scooter->save()]);
    }
}
