<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scenario extends Model
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
        'scenario_id', 'scenario_name', 'bot_id', 'times', 'stage_id', 'teacher_id'
    ];

    public function Bot()
    {
        return $this->belongsTo('App\Bot');
    }

    public function Stage()
    {
        return $this->belongsTo('App\Stage');
    }

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
