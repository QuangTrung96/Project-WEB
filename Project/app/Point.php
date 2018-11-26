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
}
