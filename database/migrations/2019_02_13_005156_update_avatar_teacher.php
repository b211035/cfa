<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAvatarTeacher extends Migration
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
        Schema::table('bot_avatars', function (Blueprint $table) {
            $table->dropForeign('bot_avatars_bot_id_foreign');
            $table->dropColumn('bot_id');
            $table->string('emotion')->nullable($value = true);
            $table->unsignedInteger('teacher_id')->nullable($value = true);
            $table->foreign('teacher_id')->references('id')->on('teachers');
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
