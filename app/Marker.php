<?php

namespace App;
use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $table='markers';

    public $timestamps = false;

    public function comment()
    {
        return $this->hasOne('App\Comment','location_id','id');
    }
}
