<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpectedDuration extends Model
{
    protected $guard = 'client';
	protected $table = 'expected_duration';
	
    // One Category has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }
}
