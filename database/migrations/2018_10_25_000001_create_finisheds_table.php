<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finisheds', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('scenario_id');
            $table->primary(['user_id', 'scenario_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('scenario_id')->references('id')->on('scenarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finisheds');
    }
}
