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
        Schema::table('packages', function (Blueprint $table) {
            $table->float('option1_price')->nullable();
            $table->float('option2_price')->nullable();
            $table->float('option3_price')->nullable();
            $table->integer('option1_nb')->default(0);
            $table->integer('option2_nb')->default(0);
            $table->integer('option3_nb')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('option1_price');
            $table->dropColumn('option2_price');
            $table->dropColumn('option3_price');
            $table->dropColumn('option1_nb');
            $table->dropColumn('option2_nb');
            $table->dropColumn('option3_nb');
        });
    }
};
