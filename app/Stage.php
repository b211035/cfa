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
        'teacher_id', 'stage_name'
    ];

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function Scenarios()
    {
        return $this->hasMany('App\Scenario');
    }
}
