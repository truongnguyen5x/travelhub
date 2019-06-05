<?php

namespace App;
use App\User;
use App\Plan;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $table='requests';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan','plan_id','id');
    }
}
