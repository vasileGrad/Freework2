<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['user_from', 'user_to', 'job_id', 'msg', 'link', 'status', 'created_at', 'updated_at'];
}
