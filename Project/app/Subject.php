<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table    = 'subjects';
    protected $fillable = ['subject_code', 'subject_name', 'user_id', 'number_of_credits', 'semester_id'];
    
    public function semester()
    {
    	return $this->belongsTo('App\Semester', 'semester_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function point()
    {
        return $this->hasMany('App\Point', 'subject_code', 'subject_code');
    }
}
