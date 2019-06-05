<?php

namespace App;
use App\User;
use App\Plan;
use App\Image;
use App\Marker;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table='comments';

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan','plan_id','id');
    }

    public function images()
    {
        return $this->hasMany('App\Image','comment_id','id');
    }

    public function marker()
    {
        return $this->belongsTo('App\Marker','location_id','id');
    }

    public function replycomments()
    {
        return $this->hasMany('App\Comment', 'parent_comment_id', 'id')->orderBy('date_created', 'desc');
    }
}
