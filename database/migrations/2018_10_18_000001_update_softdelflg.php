<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSoftdelflg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('stages', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
