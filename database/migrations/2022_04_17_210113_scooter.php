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
        Schema::create('scooters', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('available');
            $table->string('model');
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->timestamp('date_last_maintenance')->nullable()->default(null);
            $table->timestamp('date_next_maintenance')->nullable()->default(date('Y-m-d H:i:s', strtotime('+1 week')));
            $table->double('longitude')->default(0.0);
            $table->double('latitude')->default(0.0);
            $table->foreignId('used_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scooters');
    }
};
