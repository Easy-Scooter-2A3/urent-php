<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Waypoint;

class WaypointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_name = "move_data.json";

        $fp = fopen($file_name, 'r');
        if (!$fp) {
            echo "Error opening file";
            exit;
        }

        $json = fread($fp, filesize($file_name));
        $data = json_decode($json, true);
        fclose($fp);

        foreach ($data as $obj) {
            $dat = [
                'start_latitude' => $obj['start_latitude'],
                'start_longitude' => $obj['start_longitude'],
                'end_latitude' => $obj['end_latitude'],
                'end_longitude' => $obj['end_longitude'],
                'start_timestamp' => date('Y-m-d H:i:s', strtotime($obj['start_timestamp'])),
                'end_timestamp' => date('Y-m-d H:i:s', strtotime($obj['end_timestamp'])),
                'waypoints' => json_encode($obj['waypoints']),
                'distance_meters' => $obj['distance_meters'],
            ];
            Waypoint::create($dat);
        }
    }
}
