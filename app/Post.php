<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];  

    public function path(){
        return "/posts/".$this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
