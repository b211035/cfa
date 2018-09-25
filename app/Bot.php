<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bot_id', 'bot_name'
    ];

}
