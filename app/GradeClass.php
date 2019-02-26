<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeClass extends Model
{
    use SoftDeletes;

    //
    public $timestamps = false;
    protected $table = 'classes';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id', 'class_name'
    ];

    public function Teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
