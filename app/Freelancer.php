<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Freelancer as Authenticatable;

class Freelancer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'freelancer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /*// One Client has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }*/
}
