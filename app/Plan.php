<?php

namespace App;
use App\Follow;
use App\Comment;
use App\Request;
use App\Participant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table='plans';  

    public function requests()
    {
        return $this->hasMany('App\UserRequest','plan_id','id')->where('state', '>', '-1');
    }

    public function follows()
    {
        return $this->hasMany('App\Follow','plan_id','id');
    }

    public function participants()
    {
        return $this->hasMany('App\Participant','plan_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','plan_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function markers()
    {
        return $this->hasMany('App\Marker','plan_id','id');
    }
}
