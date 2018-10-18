<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bot extends Model
{
    use SoftDeletes;
    //
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bot_id', 'bot_name', 'teacher_id', 'api_key'
    ];

    public function Avatars()
    {
        return $this->hasMany('App\BotAvatar');
    }

    public function Replusers()
    {
        return $this->hasMany('App\Repluser');
    }

    public function Scenarios()
    {
        return $this->hasMany('App\Scenario');
    }

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
