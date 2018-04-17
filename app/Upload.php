<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';

    protected $fillable = ['job_id', 'finaName', 'created_at', 'updated_at'];

    // One Upload belongs to one Job
    public function jobs()
    {
        return $this->belongsTo('App\Job');
    }
}
