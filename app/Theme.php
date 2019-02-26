<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
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
        'teacher_id', 'theme_name'
    ];

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function Stages()
    {
        return $this->hasMany('App\Stage');
    }

    public function Questions()
    {
        return $this->hasMany('App\Question');
    }
}
