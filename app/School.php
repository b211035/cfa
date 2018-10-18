<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
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
        'school_name'
    ];

    public function Teachers()
    {
        return $this->hasMany('App\Teacher');
    }

    public function Users()
    {
        return $this->hasMany('App\User');
    }
}
