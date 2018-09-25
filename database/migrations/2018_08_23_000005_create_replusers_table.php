<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replusers', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('bot_id');
            $table->string('repl_user_id');
            $table->primary(['user_id', 'bot_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bot_id')->references('id')->on('bots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replusers');
    }
}
