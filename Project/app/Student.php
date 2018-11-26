<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table    = 'students';
    protected $fillable = [
    	'student_code',
    	'first_name',
    	'last_name',
    	'birthday',
    	'gender',
    	'address',
    	'attributes'
    ];
}
