<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
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
        'login_id', 'password', 'user_name', 'cfa_flg', 'school_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function Avatar()
    {
        return $this->hasOne('App\UserAvatar');
    }

    public function Progress()
    {
        return $this->hasOne('App\Progress');
    }

    public function Replusers()
    {
        return $this->hasMany('App\Repluser');
    }

    public function School()
    {
        return $this->belongsTo('App\School');
    }

    public function Teachers()
    {
        return $this->belongsToMany('App\Teacher', 'teacher_user_relations', 'user_id', 'teacher_id');
    }
}
