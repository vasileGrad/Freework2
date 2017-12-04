<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
	protected $table = 'payment_type';
	
    // One Payment Type has many jobs
    public function jobs()
    {
        return $this->hasMany('\App\Job');
    }
}
