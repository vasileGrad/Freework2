<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // One Job belongs to one Client and
    public function client()
    {
    	return $this->belongsTo('App\Client');
    }
}
