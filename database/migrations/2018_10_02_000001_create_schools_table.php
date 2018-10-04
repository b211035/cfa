<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_name');
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedInteger('school_id')->nullable($value = true);
            $table->foreign('school_id')->references('id')->on('schools');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('school_id')->nullable($value = true);
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('school_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('school_id');
        });
        Schema::dropIfExists('schools');
    }
}
