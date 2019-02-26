<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserClass extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'grade_id', 'class_id'
    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
