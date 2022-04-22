<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Scooter;

use function PHPUnit\Framework\isNull;

class ScooterController extends Controller
{
    public function list(Request $request) { 
        return response()->json(['data' => Scooter::all()]);
    }

    public function get(Request $request) { 
        return response()->json(['data' => Scooter::find($request->id)]);
    }

    public function insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'model' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'status' => ['string', 'max:255', 'default:available'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $scooter = new Scooter([
            'model' => $request->model,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        if (!isNull($request->status)) {
            $scooter->status = 'available';
        }

        return response()->json(['success' => $scooter->save()]);
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
