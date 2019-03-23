<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
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
        'theme_id', 'question_type', 'question_name', 'protcol'
    ];

    public function Theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function Answers()
    {
        return $this->hasMany('App\Answer');
    }
}
