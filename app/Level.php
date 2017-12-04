<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
	protected $table = 'levels';
	
    // One Level has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }

    // One Level has many users
    public function users()
    {
        return $this->hasMany('\App\User');
    }
}
