<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repluser extends Model
{
    //
    public $timestamps = false;

    protected $primaryKey = ['user_id', 'bot_id'];

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bot_id','repl_user_id'
    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Bot()
    {
        return $this->belongsTo('App\Bot');
    }
}
