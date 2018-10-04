<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_name'
    ];
}
