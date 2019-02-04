<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bot_id','scenario_id', 'sender_flg', 'contents', 'contents_org', 'send_date', 'avater_image'
    ];
}
