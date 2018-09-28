<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scenario_id', 'scenario_name', 'bot_id', 'times', 'stage_id', 'teacher_id'
    ];
}
