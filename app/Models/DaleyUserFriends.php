<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaleyUserFriends extends Model
{
    protected $fillable = ['friends', 'user_id'];

    protected $casts = [
        'friends' => 'array',
    ];
}
