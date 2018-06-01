<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterUsers extends Model
{
    protected $fillable = ['last_downloaded_id','username'];
}
