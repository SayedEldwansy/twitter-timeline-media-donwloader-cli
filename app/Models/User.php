<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'phone', 'name', 't_id', 'email', 'password', 'token', 'token_secret', 'avatar'
    ];
    protected $appends = ['followers'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFollowersAttribute()
    {
        if ($this->DaleyFollowers()->count()) {
            return count($this->DaleyFollowers()->latest()->first()->followers);
        }
        return '-';

    }

    public function DaleyFollowers()
    {
        return $this->hasMany(DaleyUserFollwers::class);
    }
}
