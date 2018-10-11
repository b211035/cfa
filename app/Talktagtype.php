<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talktagtype extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'protcol_name', 'protcol'
    ];

}
