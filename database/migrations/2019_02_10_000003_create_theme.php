<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheme extends Migration
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
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->text('theme_name');
            $table->softDeletes();
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->unsignedInteger('theme_id')->nullable($value = true);
            $table->foreign('theme_id')->references('id')->on('themes');
        });
        Schema::table('progress', function (Blueprint $table) {
            $table->unsignedInteger('theme_id')->nullable($value = true);
            $table->foreign('theme_id')->references('id')->on('themes');
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
