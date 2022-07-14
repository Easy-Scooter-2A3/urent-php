<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class Weather extends Controller
{
    public function list(Request $request, int $day) { 
        $weathersvc = env('WEATHER_SVC', '');

        $arr = [];
        $address = sprintf("tcp://%s:5600", $weathersvc);
        $fp = NULL;
        try {
            $fp = stream_socket_client($address, $errno, $errstr, 30);
        } catch (\Throwable $th) {
            Log::error("Weather: $address: $errstr");
        }
        if (!$fp) {
            $retval = 1;
        } else {
            $retval = 0;
            while (!feof($fp)) {
                $line = stream_get_line($fp, 1024, "\n");
                Log::debug($line);
                $json = json_decode($line);
                if (is_null($json)) {
                    continue;
                }
                $rowDay = date("N", strtotime($json->main->created_at));
                if ($rowDay == $day) {
                    array_push($arr, $json);
                }
            }
            fclose($fp);
            return response()->json($arr);
        }

        if ($retval != 0) {
            return response()->json(['error' => 'Error getting weather'], 500);
        }
    }
}
