<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Weather extends Controller
{
    public function list(Request $request) { 
        $weathersvc = config('app.weathersvc');

        $arr = [];

        if ($weathersvc == "") {
            $path = config('app.openweathermap');
            $res = exec("$path get", $output, $retval);
        } else {
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
                    $json = json_decode($line);
                    if ($json) {
                        array_push($arr, $json);
                    }
                }
                fclose($fp);
                return response()->json($arr);
            }
        }

        if ($retval != 0) {
            return response()->json(['error' => 'Error getting weather'], 500);
        }

        $cnt = count($output);
        for ($i=0; $i < $cnt; $i++) { 
            $json = json_decode($output[$i]);
            array_push($arr, $json);
        }
        return response()->json($arr);
    }
}
