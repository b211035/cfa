<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_id', 'password', 'user_name', 'school_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function Bots()
    {
        return $this->hasMany('App\Bot');
    }

    public function Stages()
    {
        return $this->hasMany('App\Stage');
    }

    public function Scenarios()
    {
        return $this->hasMany('App\Scenario');
    }

    public function School()
    {
        return $this->belongsTo('App\School');
    }

    public function Users()
    {
        return $this->belongsToMany('App\User', 'teacher_user_relations', 'teacher_id', 'user_id');
    }
}
