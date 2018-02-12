<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    // One Skill has many Jobs
    public function jobs()
    {
        return $this->belongsToMany('App\Job', 'job_skill');
    }

    // One Skill has many Freelancers
    public function users()
    {
        return $this->belongsToMany('App\User', 'freelancer_skill', 'skill_id', 'freelancer_id');
    }
}
