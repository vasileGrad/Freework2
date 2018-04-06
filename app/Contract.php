<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    
    protected $fillable = ['proposalId', 'clientId', 'freelancerId', 'startTime', 'endTime', 'paymentTypeId', 'paymentAmount', 'created_at', 'updated_at'];
}
