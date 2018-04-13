<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Client as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    // One Client has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    } 
}
