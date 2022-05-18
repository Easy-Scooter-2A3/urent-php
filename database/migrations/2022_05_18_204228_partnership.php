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
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamp("from_date");
            $table->timestamp("to_date");
            $table->float("voucher");
            $table->integer("max_people");
            $table->boolean("active");
            $table->timestamps();
        });

        Schema::create('partnership_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId("partnership_id")->constrained();
            $table->foreignId("user_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partnership_users');
        Schema::dropIfExists('partnerships');
    }
};
