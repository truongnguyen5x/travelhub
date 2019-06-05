<?php

namespace App;
use App\User;
use App\Plan;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table='follows';

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
