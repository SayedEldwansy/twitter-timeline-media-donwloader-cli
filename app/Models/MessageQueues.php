<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageQueues extends Model
{
    protected $fillable = ['user_id','message','send'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
