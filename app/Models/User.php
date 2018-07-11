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
    protected $appends = ['followers', 'friends'];
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

    public function getFriendsAttribute()
    {
        if ($this->DaleyFriends()->count()) {
            return count($this->DaleyFriends()->latest()->first()->friends);
        }
        return '-';
    }

    public function DaleyFriends()
    {
        return $this->hasMany(DaleyUserFriends::class);
    }

    public function NotFollowBack()
    {
        return $this->hasMany(NotFollowBack::class, 'user_id');
    }

    public function WelcomeMessage()
    {
        return $this->belongsTo(WelcomeMessage::class);
    }
}
