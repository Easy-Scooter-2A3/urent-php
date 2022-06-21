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
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->default(now()); // ALTER TABLE weather CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
            $table->double('temp');
            $table->double('temp_min');
            $table->double('temp_max');
            $table->double('pressure');
            $table->integer('humidity');
            $table->integer('feels_like');
            $table->double('wind_speed');
            $table->integer('wind_deg');
            $table->double('wind_gust');
            $table->unsignedInteger('visibility');
            $table->unsignedInteger('clouds_all');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather');
    }
};
