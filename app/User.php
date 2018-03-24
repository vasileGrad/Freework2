<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isRole(){
        return $this->role_id;
    }

    // One User has many Skills
    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'freelancer_skill', 'freelancer_id', 'skill_id');
    }

    // One User belongs to one Level
    public function levels()
    {
        return $this->belongsTo('App\Level');
    }

    // One User belongs to many saved Jobs
    public function jobs() 
    {
        return $this->belongsToMany('App\Job', 'job_saved', 'user_id', 'job_id'); 
                //user_id - is the column that represents the User Model
                //job_id  - is the column that represents the foreign key
    }
}
