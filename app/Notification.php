<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notifications';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
