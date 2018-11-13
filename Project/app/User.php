<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    public function subject()
    {
    	return $this->hasMany('App\Subject', 'user_id');
    }
}
