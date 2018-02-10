<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guard = 'client';

    // One Job belongs to one Client
    public function clients()
    {
    	return $this->belongsTo('App\Client');
    }

    // One Job belongs to one Category
    public function categories()
    {
    	return $this->belongsTo('App\Category');
    }

    // One Job belongs to one Complexity
    public function complexity()
    {
        return $this->belongsTo('App\Complexity');
    }

    // One Job belongs to one Expected Duration
    public function expectedDurations()
    {
        return $this->belongsTo('App\ExpectedDuration');
    }

    // One Job belongs to one PaymentType
    public function paymentTypes()
    {
        return $this->belongsTo('App\PaymentType');
    }

    // One Job belongs to one Level
    public function levels()
    {
        return $this->belongsTo('App\Level');
    }

    // One Job has many Skills
    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'job_skill');
    }

    // Search jobs
    public function search($query, $search)
    {
        return $query->where('title', 'LIKE', "%$search%");
    }

    // One Job belongs to many Users - One Job may be saved by many Freelancers
    public function users() 
    {
        return $this->belongsToMany('App\User', 'job_saved', 'job_id', 'user_id');
                //job_id - is the column that represents the Job Model
                //user_id  - is the column that represents the foreign key
    }
}
