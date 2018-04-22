<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSearchHistory extends Model
{
    protected $table = 'job_search_history';

    protected $fillable = ['jobTitle', 'created_at', 'updated_at'];
}
