<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSaved extends Model
{
    protected $table = 'job_saved';

    protected $fillable = ['freelancer_id', 'job_id'];
}
