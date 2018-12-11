<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    //
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'progress';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'next_scenario_id', 'next_stage'
    ];
}
