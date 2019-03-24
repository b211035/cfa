<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    //
    public $timestamps = true;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'user_id', 'answer'
    ];

    public function Question()
    {
        return $this->belongsTo('App\Question');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

}
