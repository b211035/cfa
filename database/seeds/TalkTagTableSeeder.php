<?php

use Illuminate\Database\Seeder;

class TalkTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('talktagtype')->insert(
            [
                'protcol_name' => '表情',
                'protcol' => '\s',
            ]
        );
    }
}
