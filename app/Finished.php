<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finished extends Model
{
    //
    public $timestamps = false;

    protected $primaryKey = ['user_id', 'scenario_id'];

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'scenario_id'
    ];
}
