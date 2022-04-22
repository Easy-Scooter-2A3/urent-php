<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Weather extends Controller
{
    public function list(Request $request) { 
        $path = config('app.openweathermap');
        $res = exec("$path get", $output, $retval);

        if ($retval != 0) {
            return response()->json(['error' => 'Error getting weather'], 500);
        }

        $arr = [];
        $cnt = count($output);
        for ($i=0; $i < $cnt; $i++) { 
            $json = json_decode($output[$i]);
            array_push($arr, $json);
        }
        return response()->json($arr);
    }
}
