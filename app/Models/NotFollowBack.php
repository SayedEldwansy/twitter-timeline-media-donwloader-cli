<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotFollowBack extends Model
{
    protected $fillable = ['not_follow_back', 'user_id'];
    protected $casts = [
        'not_follow_back' => 'array'
    ];
}
