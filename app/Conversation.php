<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = ['user_one', 'user_two', 'proposal_id', 'created_at', 'updated_at'];
}
