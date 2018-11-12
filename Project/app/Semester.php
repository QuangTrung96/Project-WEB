<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table    = 'semesters';
    protected $fillable = ['semester_name', 'scholastic_id'];

    public function scholastic()
    {
    	return $this->belongsTo('App\Scholastic', 'scholastic_id');
    }
}
