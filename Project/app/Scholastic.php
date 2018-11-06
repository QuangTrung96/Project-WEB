<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholastic extends Model
{
    protected $table    = 'scholastics';
    protected $fillable = ['year'];
}
