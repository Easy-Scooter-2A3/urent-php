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
        Schema::create('waypoints', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('start_latitude');
            $table->bigInteger('start_longitude');
            $table->bigInteger('end_latitude');
            $table->bigInteger('end_longitude');
            $table->timestamp('start_timestamp');
            $table->timestamp('end_timestamp');
            $table->json('waypoints');
            $table->double('distance_meters');
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
