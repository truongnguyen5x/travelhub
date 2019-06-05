<?php

namespace App;
use App\Request;
use App\Notification;
use App\Plan;
use App\Follow;
use App\Participant;
use App\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public $timestamps = false;

    public function requests()
    {
        return $this->hasMany('App\UserRequest','user_id','id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification','user_id','id');
    }

    public function follows()
    {
        return $this->hasMany('App\Follow','user_id','id');
    }

    public function participants()
    {
        return $this->hasMany('App\Participant','user_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','user_id','id');
    }

    public function plans()
    {
        return $this->hasMany('App\Plan','user_id','id');
    }
}
