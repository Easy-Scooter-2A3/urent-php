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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('scooter_id')->constrained('scooters');
            $table->string('description');
            $table->string('notes')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('finished_at')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users');
        });

        Schema::table('scooters', function (Blueprint $table) {
            if (Schema::hasColumn('scooters', 'status')) {
                $table->dropColumn('status');
            } else {
                $table->integer('status')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance');
        Schema::table('scooters', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
