<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaleyUserFollwers extends Model
{
    protected $fillable = ['user_id', 'followers'];

    protected $casts =[
        'followers'=>'array',
    ];
}
