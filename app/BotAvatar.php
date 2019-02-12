<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BotAvatar extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id', 'filename', 'protcol', 'emotion'
    ];

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
