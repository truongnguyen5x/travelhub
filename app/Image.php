<?php

namespace App;
use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table='images';

    public $timestamps = false;

    public function comment()
    {
        return $this->belongsTo('App\Comment','comment_id','id');
    }
}
