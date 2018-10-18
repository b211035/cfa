<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talktag extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'talktagtype_id', 'protcol_name', 'protcol'
    ];

    public function Talktagtype()
    {
        return $this->belongsTo('App\Talktagtype');
    }
}
