<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complexity extends Model
{
    protected $guard = 'client';
	protected $table = 'complexity';
	
    // One Complexity has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }
}
