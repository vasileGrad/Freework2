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
        'firstName', 'lastName', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // One User has many Skills
    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'job_skill');
    }

    // One User belongs to one Level
    public function levels()
    {
        return $this->belongsTo('App\Level');
    }
}
