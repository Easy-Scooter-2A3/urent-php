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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->double('unlock_price');
            $table->boolean('active')->default(true);
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable()->default(null);
        });

        Schema::create('users_packages', function (Blueprint $table) {
            $table->timestamp('date')->useCurrent();
            $table->foreignId('user')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('package')->nullable()->constrained('packages')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_packages');
        Schema::dropIfExists('packages');
    }
};
