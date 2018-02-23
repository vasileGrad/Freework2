<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['user_from', 'user_to', 'conversation_id', 'msg', 'status'];
}
