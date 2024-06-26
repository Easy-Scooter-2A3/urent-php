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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('github_id')->nullable();
            $table->string('github_token')->nullable();
            $table->string('github_refresh_token')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();

            $table->string('oauth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('github_token');
            $table->dropColumn('github_refresh_token');
            $table->dropColumn('google_id');
            $table->dropColumn('google_token');
            $table->dropColumn('oauth');
        });
    }
};
