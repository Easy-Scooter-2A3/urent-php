<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Scooter;
use App\Models\ScooterStatus;
use App\Models\Maintenance;

use function PHPUnit\Framework\isNull;

class ScooterController extends Controller
{
    public function details(Request $request) {
        $scooter = Scooter::find($request->input('scooter'));

        $res = Maintenance::where('scooter_id', $scooter->id)->orderBy('created_at', 'desc')->first();
        $scooter->status = ScooterStatus::getStatus($scooter->status);
        $scooter->date_last_maintenance = $res ? $res->created_at : 'Never';

        return response()->json(['success' => true, 'data' => $scooter]);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'model' => ['required', 'string', 'max:255'],
            // 'status' => ['string', 'max:255', 'default:available'],
        ])->validate();

        Scooter::create([
            'model' => $request->input('model'),
            'status' => 0, //TODO: use enum
            // 'status' => $request->input('status') ?? 'available',
        ]);
        return response()->json(['success' => true]);
    }

    public function list(Request $request) { 
        //TODO: pagination
        $scooters = Scooter::all();
        foreach ($scooters as $s) {
            $s->status = ScooterStatus::getStatus($s->status);

            $res = Maintenance::where('scooter_id', $s->id)->orderBy('created_at', 'desc')->first();
            $s->date_last_maintenance = $res ? $res->created_at : 'Never';
        }
        return response()->json(['data' => $scooters]);
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
