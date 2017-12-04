<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $guard = 'client';
	protected $table = 'category';
	
    // One Category has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }
}
