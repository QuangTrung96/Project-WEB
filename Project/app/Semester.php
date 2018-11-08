<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table    = 'semesters';
    protected $fillable = ['semester_name', 'scholastic_id'];
}
