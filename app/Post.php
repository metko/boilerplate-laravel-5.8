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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($attributes)
    {
        return $this->comments()->create([
            'body' => $attributes['body'],
            'owner_id' => auth()->user()->id
        ]);
    }

    public function createPost($attributes)
    {   
        return $this->create([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
            'owner_id' => auth()->user()->id,
        ]);
    }
}
