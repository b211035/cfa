<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StageChains extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prev_stage_id', 'next_stage_id', 'level'
    ];
}
