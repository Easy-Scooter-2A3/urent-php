<?php

namespace Database\Seeders;

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
        // $dat = {
        //     "start_latitude": 486699823,
        //     "start_longitude": 23327127,
        //     "end_latitude": 486757610,
        //     "end_longitude": 23143784,
        //     "start_timestamp": "2022-05-11T16:04:48.501Z",
        //     "end_timestamp": "2022-05-11T16:14:46.911Z",
        //     "waypoints": [
        //         {
        //             "latitude": 486699823,
        //             "longitude": 23327127,
        //             "timestamp": "2022-05-11T16:04:48.501Z"
        //         },
        //         {
        //             "latitude": 486728191,
        //             "longitude": 23279574,
        //             "timestamp": "2022-05-11T16:07:48.645Z"
        //         },
        //         {
        //             "latitude": 486748232,
        //             "longitude": 23181246,
        //             "timestamp": "2022-05-11T16:11:14.221Z"
        //         }
        //     ],
        //     "distance_meters": 1404.3273141646996
        // }

        $fp = fopen('./waypoints.csv', 'r');
        if (!$fp) {
            echo "Error opening file";
            exit;
        }

        $objs = []; // array of Waypoint objects

        foreach ($objs as $key => $obj) {
            $dat = [
                'start_latitude' => $obj['start_latitude'],
                'start_timestamp' => date('Y-m-d H:i:s', strtotime($obj['start_timestamp'])),
                'distance_meters' => $obj['distance_meters'],
                'waypoints' => json_encode($obj['waypoints']),
            ];
            Waypoint::create($dat);
        }
    }
}
