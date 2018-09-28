<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherUserRelation extends Model
{
    //
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id', 'user_id'
    ];
}
