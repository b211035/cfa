<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('bot_id');
            $table->unsignedInteger('scenario_id');
            $table->smallInteger('sender_flg');
            $table->text('contents');
            $table->dateTime('send_date');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bot_id')->references('id')->on('bots');
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
        Schema::dropIfExists('logs');
    }
}
