<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // {
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

        Schema::create('waypoints', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('start_latitude');
            $table->timestamp('start_timestamp');
            $table->double('distance_meters');
            $table->timestamps();
            $table->json('waypoints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waypoints');
    }
};
