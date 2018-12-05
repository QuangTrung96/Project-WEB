<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table    = 'points';
    protected $fillable = [
    	'subject_code',
    	'student_code',
    	'point',
    	'exam_day'
    ];
    
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_code', 'subject_code');
    }

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_code', 'student_code');
    }
}
