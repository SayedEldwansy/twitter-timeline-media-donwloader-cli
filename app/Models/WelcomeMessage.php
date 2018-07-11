<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeMessage extends Model
{
    protected $fillable = ['message', 'user_id'];
}
