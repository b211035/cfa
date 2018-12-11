<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('next_scenario_id')->nullable($value = true);;
            $table->unsignedInteger('next_stage')->nullable($value = true);;
            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('stage_chains', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prev_stage_id');
            $table->unsignedInteger('next_stage_id');
            $table->unsignedInteger('level');
            $table->foreign('prev_stage_id')->references('id')->on('stages');
            $table->foreign('next_stage_id')->references('id')->on('stages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stops');
    }
}
