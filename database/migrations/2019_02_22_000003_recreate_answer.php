<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateAnswer extends Migration
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
        Schema::drop('questions');
        Schema::drop('answers');
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropColumn('answer_scenario_id');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('theme_id');
            $table->integer('question_type');
            $table->text('question_name');
            $table->text('protcol')->nullable($value = true);
            $table->softDeletes();
        });
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('user_id');
            $table->text('answer');
            $table->softDeletes();
        });
        Schema::table('themes', function (Blueprint $table) {
            $table->string('answer_scenario_id')->nullable($value = true);
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
