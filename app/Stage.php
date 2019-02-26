<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
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
        'teacher_id', 'stage_name', 'theme_id'
    ];

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function Scenarios()
    {
        return $this->hasMany('App\Scenario');
    }

    public function Theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function NextStages()
    {
        return $this->belongsToMany('App\Stage', 'stage_chains', 'prev_stage_id', 'next_stage_id')->withPivot('level');;
    }

    public function PrevStages()
    {
        return $this->belongsToMany('App\Stage', 'stage_chains', 'next_stage_id', 'prev_stage_id')->withPivot('level');;
    }

}
