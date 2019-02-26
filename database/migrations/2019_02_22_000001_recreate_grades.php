<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateGrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
// Avatar
        Schema::drop('grades');
        Schema::drop('classes');

        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->text('grade_name');
            $table->softDeletes();
        });
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->text('class_name');
            $table->softDeletes();
        });

        Schema::create('user_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('class_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
