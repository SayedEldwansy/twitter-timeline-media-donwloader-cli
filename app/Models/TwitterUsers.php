<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterUsers extends Model
{
    protected $fillable = ['last_downloaded_id','username'];
}
