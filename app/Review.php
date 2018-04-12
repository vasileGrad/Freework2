<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    
    protected $fillable = ['contractId', 'reviewClient', 'reviewFreelancer', 'rateClient','rateFreelancer','created_at', 'updated_at'];
}
