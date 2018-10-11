<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalktagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talktagtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('protcol_name');
            $table->string('protcol');
        });

        Schema::create('talktags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('talktagtype_id');
            $table->string('protcol_name');
            $table->string('protcol');
            $table->foreign('talktagtype_id')->references('id')->on('talktagtypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talktags');
        Schema::dropIfExists('talktagtypes');
    }
}
